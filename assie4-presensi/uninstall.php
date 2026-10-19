<?php
/**
 * Fired when ASSIE IV Presensi is uninstalled.
 * Menghapus tabel database dan post/page jika plugin dihapus dari WordPress.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

global $wpdb;

// Hapus tabel presensi
$table = $wpdb->prefix . 'assie4_presensi';
$wpdb->query( "DROP TABLE IF EXISTS {$table}" );

// Hapus opsi versi database
delete_option( 'assie4_db_version' );

// Hapus halaman presensi otomatis jika masih ada
$page = get_page_by_path( 'presensi-booth-assie4' );
if ( $page && isset( $page->ID ) ) {
    wp_delete_post( $page->ID, true );
}
