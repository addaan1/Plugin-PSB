<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/** Keep numeric IDs for existing presensi records, deriving them from the official booth code. */
function assie4_booth_location( $code ) {
    $ranges = [ 'A'=>[1,21,1], 'D'=>[22,16,2], 'C'=>[38,7,2], 'E'=>[45,6,3], 'F'=>[51,22,4], 'G'=>[73,8,5], 'H'=>[81,16,6], 'B'=>[97,10,7] ];
    if ( ! preg_match( '/^([A-H])([1-9][0-9]*)$/', $code, $matches ) ) return null;
    $range = $ranges[$matches[1]];
    if ( (int) $matches[2] > $range[1] ) return null;
    return [ 'area'=>$matches[1], 'booth_no'=>$range[0] + (int) $matches[2] - 1, 'cluster'=>$range[2] ];
}

function assie4_brand_text( $text ) {
    return preg_replace( '/(?:Industry Matching\s+)?(?:IM\s+)?ASSIE\s+IV\s*(?:[–—-]\s*)?2026/u', 'IM ASSIE IV 2026', (string) $text );
}

function assie4_day_label( $text ) {
    $text = str_replace( '*', '', sanitize_text_field( $text ) );
    return preg_replace( '/\bJum[\x{0027}\x{2019}\x{2018}]?at\b/iu', 'Jumat', $text );
}

function assie4_brand_values( $value ) {
    if ( is_array( $value ) ) return array_map( 'assie4_brand_values', $value );
    return is_string( $value ) ? assie4_brand_text( $value ) : $value;
}

/** Repair only escaped quotes in old options; preserve ordinary path backslashes and line breaks. */
function assie4_repair_stored_text( $value ) {
    if ( is_array( $value ) ) return array_map( 'assie4_repair_stored_text', $value );
    if ( ! is_string( $value ) ) return $value;
    $value = preg_replace_callback( '/\\\\+([\x{0027}\x{0022}])/u', function( $m ) { return $m[1]; }, $value );
    return assie4_brand_text( $value );
}

function assie4_upgrade_stored_content() {
    if ( get_option( 'assie4_content_format_version' ) === '1' ) return;
    foreach ( [ASSIE4_OPT_INFO, ASSIE4_OPT_SLIDES, ASSIE4_OPT_TICKER, ASSIE4_OPT_RUNDOWN, ASSIE4_OPT_TENANTS] as $key ) {
        $old = get_option( $key, null );
        if ( ! is_array( $old ) ) continue;
        $new = assie4_repair_stored_text( $old );
        if ( $key === ASSIE4_OPT_RUNDOWN && isset( $new['days'] ) ) {
            foreach ( $new['days'] as &$day ) $day['label'] = assie4_day_label( $day['label'] ?? '' );
            unset( $day );
        }
        if ( $key === ASSIE4_OPT_TENANTS ) $new = array_values( array_map( 'assie4_normalize_tenant', $new ) );
        if ( $new !== $old ) update_option( $key, $new, false );
        if ( get_option( $key ) !== $new ) return; // Retry next request if the database rejected a write.
    }
    // Update only the two generated default page titles, preserving custom titles.
    foreach ( ['pameran-assie4'=>'Pameran Digital — ASSIE IV 2026', 'presensi-booth-assie4'=>'Presensi Booth — ASSIE IV 2026'] as $slug=>$old_title ) {
        $page = get_page_by_path( $slug );
        if ( $page && $page->post_title === $old_title ) {
            $result = wp_update_post( wp_slash( ['ID'=>$page->ID, 'post_title'=>assie4_brand_text($old_title)] ), true );
            if ( is_wp_error($result) ) return;
        }
    }
    update_option( 'assie4_content_format_version', '1', false );
    assie4_rebuild_js_data();
}
add_action( 'init', 'assie4_upgrade_stored_content' );

function assie4_tenant_flash_key() {
    return 'assie4_tenant_flash_' . get_current_user_id();
}

function assie4_tenant_save_error( $message, $tenant, $original_id ) {
    set_transient( assie4_tenant_flash_key(), [ 'message'=>$message, 'data'=>$tenant ], 300 );
    wp_safe_redirect( add_query_arg( ['page'=>'assie4-tenants', 'edit'=>$original_id ?: 'new'], admin_url( 'admin.php' ) ) );
    exit;
}

/** Process before admin output, with a normal HTTP redirect (also works without JavaScript). */
function assie4_handle_save_tenant() {
    if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Anda tidak memiliki izin mengelola booth.', '', ['response'=>403] );
    if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) wp_die( 'Gunakan formulir booth untuk menyimpan data.', '', ['response'=>405] );
    if ( empty( $_POST ) ) wp_die( 'Data upload melebihi batas server. Pilih gambar yang lebih kecil lalu kirim ulang.', '', ['response'=>413] );
    check_admin_referer( 'a4_tenant', '_nt' );
    $post = assie4_brand_values( wp_unslash( $_POST ) );
    $original_id = sanitize_key( $post['original_id'] ?? '' );
    $tenants = assie4_get_tenants();
    $existing = null;
    foreach ( $tenants as $tenant ) if ( $tenant['id'] === $original_id ) $existing = $tenant;
    $data = $existing ?: [];
    foreach ( ['id','area','name','instansi','pic','cat','tipe_usaha','produk_unggulan','desc','contact','whatsapp','web','instagram','facebook','twitter','tiktok','youtube','tokopedia','shopee','transaksi'] as $field ) {
        $data[$field] = isset( $post['t_'.$field] ) && is_string( $post['t_'.$field] ) ? $post['t_'.$field] : '';
    }
    $data['code'] = strtoupper( trim( $data['id'] ) );
    $data = assie4_normalize_tenant( $data );
    $location = assie4_booth_location( $data['code'] );
    if ( ! $location ) assie4_tenant_save_error( 'Kode booth harus sesuai denah: A1–A21, B1–B10, C1–C7, D1–D16, E1–E6, F1–F22, G1–G8, atau H1–H16.', $data, $original_id );
    if ( $data['area'] !== $location['area'] ) assie4_tenant_save_error( 'Area pameran harus sama dengan huruf pada kode booth.', $data, $original_id );
    if ( ! $data['name'] || ! $data['cat'] ) assie4_tenant_save_error( 'Nama tenant dan kategori booth wajib diisi.', $data, $original_id );
    if ( $original_id && ! $existing ) assie4_tenant_save_error( 'Booth yang diedit sudah tidak ada. Periksa daftar booth sebelum menyimpan ulang.', $data, '' );
    foreach ( $tenants as $tenant ) {
        if ( $tenant['id'] === $data['id'] && $tenant['id'] !== $original_id ) assie4_tenant_save_error( 'Kode booth '.$data['code'].' sudah digunakan. Pilih kode yang belum terisi.', $data, $original_id );
    }
    $data = array_merge( $data, $location );
    $pending_logo = absint( $post['t_logo_id'] ?? 0 );
    if ( $pending_logo && $pending_logo !== ( $existing['logo_id'] ?? 0 ) ) {
        if ( ! wp_attachment_is_image( $pending_logo ) || ! current_user_can( 'edit_post', $pending_logo ) ) {
            assie4_tenant_save_error( 'Logo yang dipilih tidak tersedia. Silakan upload kembali.', $data, $original_id );
        }
        $data['logo_id'] = $pending_logo;
        $data['logo'] = wp_get_attachment_url( $pending_logo );
    }
    if ( ! empty( $post['t_remove_logo'] ) ) { $data['logo'] = ''; $data['logo_id'] = 0; }
    if ( isset( $_FILES['t_logo_file'] ) && (int) $_FILES['t_logo_file']['error'] !== UPLOAD_ERR_NO_FILE ) {
        if ( ! current_user_can( 'upload_files' ) ) assie4_tenant_save_error( 'Akun ini belum memiliki izin upload gambar.', $data, $original_id );
        $max_size = min( 5 * MB_IN_BYTES, wp_max_upload_size() );
        if ( (int) $_FILES['t_logo_file']['size'] > $max_size ) assie4_tenant_save_error( 'Ukuran logo melebihi batas '.size_format($max_size).'. Pilih gambar yang lebih kecil.', $data, $original_id );
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
        $attachment_id = media_handle_upload( 't_logo_file', 0, [], [ 'test_form'=>false, 'mimes'=>['jpg|jpeg|jpe'=>'image/jpeg','png'=>'image/png','gif'=>'image/gif','webp'=>'image/webp'] ] );
        if ( is_wp_error( $attachment_id ) ) assie4_tenant_save_error( 'Logo belum ter-upload: '.$attachment_id->get_error_message(), $data, $original_id );
        $data['logo_id'] = $attachment_id;
        $data['logo'] = wp_get_attachment_url( $attachment_id );
    }
    $new = [];
    foreach ( $tenants as $tenant ) if ( $tenant['id'] !== $original_id ) $new[] = $tenant;
    $new[] = $data;
    $saved = assie4_save_tenants( $new );
    if ( is_wp_error( $saved ) ) assie4_tenant_save_error( $saved->get_error_message(), $data, $original_id );
    set_transient( assie4_tenant_flash_key(), [ 'message'=>'Booth '.$data['code'].' berhasil disimpan dan tampil di pameran.', 'success'=>true ], 300 );
    wp_safe_redirect( admin_url( 'admin.php?page=assie4-tenants' ) );
    exit;
}
add_action( 'admin_post_assie4_save_tenant', 'assie4_handle_save_tenant' );
