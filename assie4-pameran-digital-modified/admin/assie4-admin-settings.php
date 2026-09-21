<?php
/**
 * Admin Settings — ASSIE IV Pameran Digital v2.7
 * Semua halaman admin bersih, konsisten, CSS dari file eksternal
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* ═══ OPTION KEYS ═══════════════════════════════════════ */
define( 'ASSIE4_OPT_INFO',    'assie4_pameran_info'    );
define( 'ASSIE4_OPT_SLIDES',  'assie4_pameran_slides'  );
define( 'ASSIE4_OPT_TICKER',  'assie4_pameran_ticker'  );
define( 'ASSIE4_OPT_RUNDOWN', 'assie4_pameran_rundown' );
define( 'ASSIE4_OPT_TENANTS', 'assie4_pameran_tenants' );

/* ═══ NORMALIZE TENANT ══════════════════════════════════ */
function assie4_normalize_tenant( $t ) {
    $t = (array) $t;
    return [
        'id'        => sanitize_key( trim( $t['id']        ?? '' ) ),
        'area'      => strtoupper( sanitize_text_field( trim( $t['area'] ?? 'A' ) ) ),
        'name'      => sanitize_text_field( trim( $t['name']      ?? '' ) ),
        'cat'       => sanitize_text_field( trim( $t['cat']       ?? '' ) ),
        'desc'      => sanitize_textarea_field( trim( $t['desc']  ?? '' ) ),
        'tags'      => is_array( $t['tags']  ?? null )
                        ? array_map('sanitize_text_field', $t['tags'])
                        : array_values( array_filter( array_map( 'trim', explode( ',', sanitize_text_field($t['tags'] ?? '') ) ) ) ),
        'logo'      => esc_url_raw( trim( $t['logo']      ?? '' ) ),
        'contact'   => sanitize_email( trim( $t['contact']   ?? '' ) ),
        'web'       => esc_url_raw( trim( $t['web']       ?? '' ) ),
        'instagram' => sanitize_text_field( trim( $t['instagram'] ?? '' ) ),
        'facebook'  => esc_url_raw( trim( $t['facebook']  ?? '' ) ),
        'twitter'   => sanitize_text_field( trim( $t['twitter']   ?? '' ) ),
    ];
}

/* ═══ DEFAULT DATA ══════════════════════════════════════ */
function assie4_default_info() {
    return [ 'date'=>'14–16 Mei 2026', 'location'=>'Grand City Convention Hall, Surabaya', 'org'=>'PASINBIS Universitas Airlangga', 'timeOpen'=>'08:00', 'timeClose'=>'20:00' ];
}
function assie4_default_slides() {
    return [
        [
            'title'    => 'ASSIE IV 2026',
            'subtitle' => 'Airlangga Startup Summit & Innovation Expo',
            'desc'     => 'Ajang pameran startup & inovasi terbesar di Jawa Timur.',
            'cta'      => 'Jelajahi Pameran',
            'link'     => '#denah',
            'bg'       => ASSIE4_PAMERAN_URL . 'assets/kegiatan-assie-1.jpg',
        ],
        [
            'title'    => 'Inovasi Tanpa Batas',
            'subtitle' => 'Grand City Convention Hall · Surabaya',
            'desc'     => 'Temui inovator muda dan ekosistem startup Jawa Timur.',
            'cta'      => 'Lihat Denah Booth',
            'link'     => '#denah',
            'bg'       => ASSIE4_PAMERAN_URL . 'assets/kegiatan-assie-4.jpg',
        ],
        [
            'title'    => 'Dukung Startup Lokal',
            'subtitle' => 'TokoUA · tokoua.unair.ac.id',
            'desc'     => 'Beli produk tenant pameran secara online melalui TokoUA.',
            'cta'      => 'Kunjungi TokoUA',
            'link'     => 'https://tokoua.unair.ac.id/',
            'bg'       => ASSIE4_PAMERAN_URL . 'assets/kegiatan-assie-3.jpg',
        ],
        [
            'title'    => 'Kompetisi & Talenta Digital',
            'subtitle' => 'Roblox & E-Sport Competition · Grand City',
            'desc'     => 'Wadah kreativitas talenta digital dan generasi inovator masa depan.',
            'cta'      => 'Lihat Rundown Acara',
            'link'     => '#rundown',
            'bg'       => ASSIE4_PAMERAN_URL . 'assets/kegiatan-assie-2.jpg',
        ],
        [
            'title'    => 'Industry Matching',
            'subtitle' => 'ASSIE IV 2026',
            'desc'     => '',
            'cta'      => '',
            'link'     => '#denah',
            'bg'       => 'linear-gradient(135deg,#03050e 0%,#0c1a40 100%)',
            'logo'     => ASSIE4_PAMERAN_URL . 'assets/logo-assie4.png',
            'is_logo'  => true,
        ],
    ];
}
function assie4_default_ticker() {
    return ['Selamat datang di ASSIE IV 2026','14–16 Mei 2026 · Grand City Convention Hall Surabaya','Booth startup & inovasi','Belanja produk tenant online di tokoua.unair.ac.id','Presensi digital tersedia di setiap booth','PASINBIS Universitas Airlangga'];
}
function assie4_default_rundown() {
    return [
        'days'   => [['label'=>"Jum'at, 14 Nov"],['label'=>'Sabtu, 15 Nov'],['label'=>'Minggu, 16 Nov']],
        'events' => [
            ['day'=>0,'time'=>'13.00','end'=>'15.30','name'=>'Airlangga Business Matching 2025',  'type'=>'keynote',   'loc'=>'Ruang Business Matching'],
            ['day'=>0,'time'=>'15.30','end'=>'17.00','name'=>'Opening Ceremony + Launching Produk','type'=>'keynote',  'loc'=>'Main Stage'],
            ['day'=>0,'time'=>'17.00','end'=>'17.30','name'=>'Break',                              'type'=>'break',    'loc'=>'—'],
            ['day'=>0,'time'=>'17.30','end'=>'19.30','name'=>'Roblox Competition',                 'type'=>'workshop', 'loc'=>'Hall'],
            ['day'=>0,'time'=>'19.45','end'=>'20.45','name'=>'Acoustic Band Performance',          'type'=>'networking','loc'=>'Main Stage'],
            ['day'=>0,'time'=>'21.00','end'=>'21.30','name'=>'Closing Day 1',                      'type'=>'award',    'loc'=>'Main Stage'],
            ['day'=>1,'time'=>'10.00','end'=>'10.30','name'=>'Opening',                            'type'=>'keynote',  'loc'=>'Main Stage'],
            ['day'=>1,'time'=>'10.30','end'=>'13.40','name'=>'Workshop Beregu Startup ATAVI',      'type'=>'workshop', 'loc'=>'Hall'],
            ['day'=>1,'time'=>'13.50','end'=>'18.00','name'=>'Mozilla Legend E-Sport Competition', 'type'=>'workshop', 'loc'=>'Hall'],
            ['day'=>1,'time'=>'19.40','end'=>'20.40','name'=>'Acoustic Band Perform',              'type'=>'networking','loc'=>'Main Stage'],
            ['day'=>1,'time'=>'20.40','end'=>'21.10','name'=>'Closing Day 2',                      'type'=>'award',    'loc'=>'Main Stage'],
            ['day'=>2,'time'=>'10.00','end'=>'10.05','name'=>'Opening',                            'type'=>'keynote',  'loc'=>'Main Stage'],
            ['day'=>2,'time'=>'10.05','end'=>'12.35','name'=>'ASSIE El Got Talent',                'type'=>'networking','loc'=>'Main Stage'],
            ['day'=>2,'time'=>'13.05','end'=>'15.05','name'=>'Talkshow Science Behind Glowing Skin','type'=>'panel',  'loc'=>'Main Stage'],
            ['day'=>2,'time'=>'15.35','end'=>'16.35','name'=>'El Got Talent',                      'type'=>'networking','loc'=>'Main Stage'],
            ['day'=>2,'time'=>'16.35','end'=>'18.55','name'=>'Acoustic Band Perform',              'type'=>'networking','loc'=>'Main Stage'],
            ['day'=>2,'time'=>'18.55','end'=>'20.00','name'=>'Closing Ceremony',                   'type'=>'award',    'loc'=>'Main Stage'],
        ],
    ];
}

/* ═══ HELPERS ═══════════════════════════════════════════ */
function assie4_get_tenants() {
    $raw = get_option( ASSIE4_OPT_TENANTS, [] );
    if ( ! is_array($raw) ) return [];
    return array_values( array_map( 'assie4_normalize_tenant', $raw ) );
}
function assie4_save_tenants( $tenants ) {
    $tenants = array_values( array_map( 'assie4_normalize_tenant', $tenants ) );
    usort( $tenants, fn($a,$b) => strcmp($a['id'], $b['id']) );
    update_option( ASSIE4_OPT_TENANTS, $tenants, false );
    assie4_rebuild_js_data();
    return $tenants;
}
function assie4_rebuild_js_data() {
    update_option( 'assie4_pameran_cache_ver', time() );
}

/* ── Render notice ── */
function a4_notice( $msg, $cls = 'ok' ) {
    echo '<div class="a4-notice a4-' . esc_attr($cls) . '">' . esc_html($msg) . '</div>';
}

/* ── Page header helper ── */
function a4_header( $title, $sub = '' ) {
    $p   = get_page_by_path( ASSIE4_PAMERAN_SLUG );
    $url = $p ? get_permalink($p) : home_url('/'.ASSIE4_PAMERAN_SLUG.'/');
    echo '<div class="a4-wrap">';
    echo '<div class="a4-nav-bar">';
    echo '<a href="' . admin_url('admin.php?page=assie4-pameran') . '">🎪 ASSIE IV</a>';
    echo '<span>›</span>';
    echo '<span>' . esc_html($title) . '</span>';
    echo '</div>';
    echo '<div class="a4-page-header">';
    echo '<h1>' . esc_html($title);
    if ($sub) echo ' <span class="a4-badge a4-badge-gold">' . esc_html($sub) . '</span>';
    echo '</h1>';
    echo '<a href="' . esc_url($url) . '" target="_blank" class="a4-btn-gold u-text-xs u-whitespace-nowrap" style="padding:7px 14px">🔗 Lihat Halaman Pameran</a>';
    echo '</div>';
    // a4-wrap ditutup di akhir setiap fungsi
}

/* ═══ ADMIN MENU ════════════════════════════════════════ */
if ( is_admin() ) {
    add_action( 'admin_menu', 'assie4_register_admin_menus' );
}
function assie4_register_admin_menus() {
    add_menu_page( 'ASSIE IV Pameran','ASSIE IV Pameran','manage_options','assie4-pameran','assie4_admin_dashboard','dashicons-store',56 );
    add_submenu_page('assie4-pameran','Dashboard',     'Dashboard',     'manage_options','assie4-pameran',  'assie4_admin_dashboard');
    add_submenu_page('assie4-pameran','Info Acara',    'Info Acara',    'manage_options','assie4-info',     'assie4_admin_info');
    add_submenu_page('assie4-pameran','Hero Slider',   'Hero Slider',   'manage_options','assie4-slides',   'assie4_admin_slides');
    add_submenu_page('assie4-pameran','Ticker',        'Ticker',        'manage_options','assie4-ticker',   'assie4_admin_ticker');
    add_submenu_page('assie4-pameran','Rundown',       'Rundown',       'manage_options','assie4-rundown',  'assie4_admin_rundown');
    add_submenu_page('assie4-pameran','Kelola Tenant', 'Kelola Tenant', 'manage_options','assie4-tenants',  'assie4_admin_tenants');
    add_submenu_page('assie4-pameran','Denah & Galeri','Denah & Galeri','manage_options','assie4-denah',    'assie4_admin_denah');
    add_submenu_page('assie4-pameran','Booth PASINBIS','Booth PASINBIS','manage_options','assie4-pasinbis', 'assie4_admin_pasinbis');
    add_submenu_page('assie4-pameran','Export/Reset',  'Export/Reset',  'manage_options','assie4-export',   'assie4_admin_export');
    add_submenu_page('assie4-pameran','Berita Eksternal','Berita Eksternal','manage_options','assie4-berita-ext','assie4_admin_berita_ext');
}

/* ═══ ENQUEUE ═══════════════════════════════════════════ */
if ( is_admin() ) {
    add_action( 'admin_enqueue_scripts', 'assie4_admin_enqueue_scripts' );
}
function assie4_admin_enqueue_scripts( $hook ) {
    $our = [
        'toplevel_page_assie4-pameran',
        'assie4-pameran_page_assie4-info',
        'assie4-pameran_page_assie4-slides',
        'assie4-pameran_page_assie4-ticker',
        'assie4-pameran_page_assie4-rundown',
        'assie4-pameran_page_assie4-tenants',
        'assie4-pameran_page_assie4-denah',
        'assie4-pameran_page_assie4-pasinbis',
        'assie4-pameran_page_assie4-export',
    ];
    if ( ! in_array( $hook, $our, true ) ) return;

    wp_enqueue_style( 'assie4-admin-css', ASSIE4_PAMERAN_URL . 'assets/assie4-admin.css', [], ASSIE4_PAMERAN_VER );
    if ( $hook === 'assie4-pameran_page_assie4-denah' ) {
        wp_enqueue_media();
    }
}

/* ═══ 1. DASHBOARD ══════════════════════════════════════ */
function assie4_admin_dashboard() {
    $tenants = assie4_get_tenants();
    $rd      = get_option( ASSIE4_OPT_RUNDOWN, assie4_default_rundown() );
    $p       = get_page_by_path( ASSIE4_PAMERAN_SLUG );
    $url     = $p ? get_permalink($p) : home_url('/'.ASSIE4_PAMERAN_SLUG.'/');

    echo '<div class="a4-wrap wrap">';
    echo '<div class="a4-page-header">';
    echo '<h1>🎪 ASSIE IV Pameran Digital <span class="a4-badge a4-badge-gold">v2.8</span></h1>';
    echo '<a href="' . esc_url($url) . '" target="_blank" class="a4-btn-gold u-text-xs u-whitespace-nowrap" style="padding:7px 14px">🔗 Lihat Halaman Pameran</a>';
    echo '</div>';

    // Stats
    echo '<div class="a4-stat-box">';
    echo '<div class="a4-stat"><span class="a4-stat-n">' . count($tenants) . '</span><span class="a4-stat-l">Tenant</span></div>';
    echo '<div class="a4-stat"><span class="a4-stat-n">' . count(get_option(ASSIE4_OPT_SLIDES,assie4_default_slides())) . '</span><span class="a4-stat-l">Slide Hero</span></div>';
    echo '<div class="a4-stat"><span class="a4-stat-n">' . count($rd['events']??[]) . '</span><span class="a4-stat-l">Event Rundown</span></div>';
    echo '<div class="a4-stat"><span class="a4-stat-n">' . count(get_option(ASSIE4_OPT_TICKER,assie4_default_ticker())) . '</span><span class="a4-stat-l">Ticker</span></div>';
    echo '<div class="a4-stat"><span class="a4-stat-n">' . count(get_option('assie4_pameran_denah',[])) . '</span><span class="a4-stat-l">Foto Denah</span></div>';
    echo '</div>';

    // Menu grid
    $menus = [
        ['assie4-info',    '📅','Info Acara',    'Tanggal, lokasi, jam operasional'],
        ['assie4-slides',  '🖼️','Hero Slider',   'Slide, gambar, dan CTA'],
        ['assie4-ticker',  '📢','Ticker',         'Teks berjalan bawah hero'],
        ['assie4-rundown', '🗓️','Rundown',        'Jadwal acara 3 hari'],
        ['assie4-tenants', '🏪','Kelola Tenant',  'Tambah, edit, hapus booth'],
        ['assie4-denah',   '🗺️','Denah & Galeri', 'Upload foto denah booth'],
        ['assie4-pasinbis','🏢','Booth PASINBIS', 'URL dan info booth PASINBIS'],
        ['assie4-export',  '💾','Export/Reset',   'Backup JSON & reset data'],
    ];
    echo '<div class="a4-card">';
    echo '<div class="a4-card-head">Menu Pengaturan</div>';
    echo '<div class="a4-menu-grid">';
    foreach ( $menus as [$sl, $ico, $lb, $dc] ) {
        echo '<a href="' . admin_url('admin.php?page='.$sl) . '" class="a4-menu-item">';
        echo '<span class="a4-menu-icon">' . $ico . '</span>';
        echo '<span class="a4-menu-label">' . esc_html($lb) . '</span>';
        echo '<span class="a4-menu-desc">' . esc_html($dc) . '</span>';
        echo '</a>';
    }
    echo '</div></div>';

    // Info
    echo '<div class="a4-card">';
    echo '<div class="a4-card-head">Info Plugin</div>';
    echo '<table class="a4-info-table">';
    echo '<tr><th>URL Halaman Pameran</th><td><a href="'.esc_url($url).'" target="_blank">'.esc_url($url).'</a></td></tr>';
    echo '<tr><th>Shortcode</th><td><code>[assie4_pameran]</code></td></tr>';
    echo '<tr><th>Status Halaman</th><td>' . ($p ? '<span class="a4-badge a4-badge-green">Published</span>' : '<span class="a4-badge a4-badge-red">Belum dibuat</span>') . '</td></tr>';
    echo '<tr><th>Versi</th><td>2.8.1</td></tr>';
    echo '<tr><th>PHP Version</th><td>'.esc_html(PHP_VERSION).'</td></tr>';
    echo '<tr><th>WordPress Version</th><td>'.esc_html($GLOBALS['wp_version']).'</td></tr>';
    echo '</table></div>';
    echo '</div>';
}

/* ═══ 2. INFO ACARA ═════════════════════════════════════ */
function assie4_admin_info() {
    if ( ! current_user_can('manage_options') ) return;
    if ( isset($_POST['_n']) && wp_verify_nonce($_POST['_n'],'a4_info') ) {
        update_option( ASSIE4_OPT_INFO, [
            'logo'      => esc_url_raw($_POST['logo']      ?? ''),
            'date'      => sanitize_text_field($_POST['date']      ?? ''),
            'location'  => sanitize_text_field($_POST['location']  ?? ''),
            'org'       => sanitize_text_field($_POST['org']       ?? ''),
            'timeOpen'  => sanitize_text_field($_POST['timeOpen']  ?? '08:00'),
            'timeClose' => sanitize_text_field($_POST['timeClose'] ?? '20:00'),
        ] );
        assie4_rebuild_js_data();
        a4_notice('✅ Info acara berhasil disimpan!');
    }
    $i = get_option( ASSIE4_OPT_INFO, assie4_default_info() );
    a4_header('Info Acara');
    ?>
    <div class="a4-card">
        <div class="a4-card-head">Informasi Acara</div>
        <form method="post"><?php wp_nonce_field('a4_info','_n'); ?>
        <div class="a4-field" style="margin-bottom:14px">
            <label>Logo Kegiatan <small>(URL gambar atau path aset)</small></label>
            <div style="display:flex;gap:12px;align-items:center">
                <input name="logo" value="<?php echo esc_attr(!empty($i['logo']) ? $i['logo'] : (ASSIE4_PAMERAN_URL . 'assets/logo-assie4.png')); ?>" style="flex:1">
                <?php 
                $cur_logo = !empty($i['logo']) ? $i['logo'] : (ASSIE4_PAMERAN_URL . 'assets/logo-assie4.png');
                ?>
                <img src="<?php echo esc_url($cur_logo); ?>" style="height:36px;background:#fff;padding:3px 8px;border-radius:6px;border:1px solid #ddd;box-shadow:0 1px 3px rgba(0,0,0,0.1)" alt="Preview Logo">
            </div>
            <small style="color:#666">Logo default: <code>assets/logo-assie4.png</code> (Industry Matching ASSIE IV 2026)</small>
        </div>
        <div class="a4-row">
            <div class="a4-field"><label>Tanggal Acara</label><input name="date" value="<?php echo esc_attr($i['date']); ?>" placeholder="14–16 Mei 2026"></div>
            <div class="a4-field"><label>Penyelenggara</label><input name="org" value="<?php echo esc_attr($i['org']); ?>"></div>
        </div>
            <div class="a4-field" style="margin-bottom:14px"><label>Lokasi / Venue</label><input name="location" value="<?php echo esc_attr($i['location']); ?>"></div>
        <div class="a4-row">
            <div class="a4-field"><label>Jam Buka</label><input type="time" name="timeOpen" value="<?php echo esc_attr($i['timeOpen']); ?>"></div>
            <div class="a4-field"><label>Jam Tutup</label><input type="time" name="timeClose" value="<?php echo esc_attr($i['timeClose']); ?>"></div>
        </div>
        <button type="submit" class="a4-btn-primary">💾 Simpan Info Acara</button>
        </form>
    </div>
    </div>
    <?php
}

/* ═══ 3. SLIDES ═════════════════════════════════════════ */
function assie4_admin_slides() {
    if ( ! current_user_can('manage_options') ) return;
    if ( isset($_POST['_n']) && wp_verify_nonce($_POST['_n'],'a4_slides') ) {
        $sl = [];
        foreach ( ($_POST['s_title'] ?? []) as $i => $t ) {
            $sl[] = ['title'=>sanitize_text_field($t),'subtitle'=>sanitize_text_field($_POST['s_subtitle'][$i]??''),'desc'=>sanitize_textarea_field($_POST['s_desc'][$i]??''),'cta'=>sanitize_text_field($_POST['s_cta'][$i]??''),'link'=>esc_url_raw($_POST['s_link'][$i]??''),'bg'=>sanitize_text_field($_POST['s_bg'][$i]??'')];
        }
        update_option( ASSIE4_OPT_SLIDES, $sl );
        assie4_rebuild_js_data();
        a4_notice('✅ Hero slider disimpan!');
    }
    $slides = get_option( ASSIE4_OPT_SLIDES, assie4_default_slides() );
    a4_header('Hero Slider', count($slides).' slide');
    ?>
    <form method="post"><?php wp_nonce_field('a4_slides','_n'); ?>
    <div id="a4SW">
    <?php foreach ( $slides as $i => $s ) : ?>
    <div class="a4-item-box">
        <div class="a4-item-header">
            <span class="a4-item-num">🖼 Slide <?php echo $i+1 ?></span>
            <button type="button" class="a4-btn-del" onclick="this.closest('.a4-item-box').remove()">✕ Hapus</button>
        </div>
        <div class="a4-row">
            <div class="a4-field"><label>Judul Besar</label><input name="s_title[]" value="<?php echo esc_attr($s['title']); ?>"></div>
            <div class="a4-field"><label>Sub Judul</label><input name="s_subtitle[]" value="<?php echo esc_attr($s['subtitle']); ?>"></div>
        </div>
        <div class="a4-field u-mb-md"><label>Deskripsi</label><textarea name="s_desc[]" rows="2"><?php echo esc_textarea($s['desc']); ?></textarea></div>
        <div class="a4-row">
            <div class="a4-field"><label>Teks Tombol CTA</label><input name="s_cta[]" value="<?php echo esc_attr($s['cta']); ?>"></div>
            <div class="a4-field"><label>Link Tombol</label><input name="s_link[]" value="<?php echo esc_attr($s['link']); ?>"></div>
        </div>
        <div class="a4-field"><label>Background <small>(URL gambar https://... atau CSS gradient)</small></label><input name="s_bg[]" value="<?php echo esc_attr($s['bg']); ?>" placeholder="https://domain.com/foto.jpg atau linear-gradient(...)"></div>
    </div>
    <?php endforeach; ?>
    </div>
    <button type="button" class="a4-btn-add" onclick="a4AS()">＋ Tambah Slide</button><br><br>
    <button type="submit" class="a4-btn-primary">💾 Simpan Semua Slide</button>
    </form>
    </div>
    <script>
    function a4AS(){document.getElementById('a4SW').insertAdjacentHTML('beforeend','<div class="a4-item-box"><div class="a4-item-header"><span class="a4-item-num">🖼 Slide Baru</span><button type="button" class="a4-btn-del" onclick="this.closest(\'.a4-item-box\').remove()">✕ Hapus</button></div><div class="a4-row"><div class="a4-field"><label>Judul</label><input name="s_title[]" value=""></div><div class="a4-field"><label>Sub Judul</label><input name="s_subtitle[]" value="ASSIE IV 2026"></div></div><div class="a4-field" style="margin-bottom:12px"><label>Deskripsi</label><textarea name="s_desc[]" rows="2"></textarea></div><div class="a4-row"><div class="a4-field"><label>Teks Tombol</label><input name="s_cta[]" value="Selengkapnya"></div><div class="a4-field"><label>Link</label><input name="s_link[]" value="#denah"></div></div><div class="a4-field"><label>Background (URL gambar atau CSS)</label><input name="s_bg[]" value="linear-gradient(135deg,#03050e,#0c1a40)"></div></div>');}
    </script>
    <?php
}

/* ═══ 4. TICKER ═════════════════════════════════════════ */
function assie4_admin_ticker() {
    if ( ! current_user_can('manage_options') ) return;
    if ( isset($_POST['_n']) && wp_verify_nonce($_POST['_n'],'a4_ticker') ) {
        $items = array_values( array_filter( array_map( 'sanitize_text_field', explode("\n", $_POST['ticker'] ?? '') ) ) );
        update_option( ASSIE4_OPT_TICKER, $items );
        assie4_rebuild_js_data();
        a4_notice('✅ Ticker disimpan!');
    }
    $t = get_option( ASSIE4_OPT_TICKER, assie4_default_ticker() );
    a4_header('Ticker', count($t).' item');
    ?>
    <div class="a4-card">
        <div class="a4-card-head">Teks Berjalan <span style="font-size:12px;font-weight:400;color:#64748b">— satu baris = satu item</span></div>
        <form method="post"><?php wp_nonce_field('a4_ticker','_n'); ?>
        <div class="a4-field u-mb-lg">
            <textarea name="ticker" rows="10" style="font-family:monospace;font-size:12px"><?php echo esc_textarea(implode("\n",$t)); ?></textarea>
        </div>
        <button type="submit" class="a4-btn-primary">💾 Simpan Ticker</button>
        </form>
    </div>
    </div>
    <?php
}

/* ═══ 5. RUNDOWN ════════════════════════════════════════ */
function assie4_admin_rundown() {
    if ( ! current_user_can('manage_options') ) return;
    if ( isset($_POST['_n']) && wp_verify_nonce($_POST['_n'],'a4_rundown') ) {
        $days = array_map( fn($l) => ['label'=>sanitize_text_field($l)], ($_POST['dl']??[]) );
        $evs  = [];
        foreach ( ($_POST['en']??[]) as $i => $name ) {
            if (!trim($name)) continue;
            $evs[] = ['day'=>intval($_POST['ed'][$i]??0),'time'=>sanitize_text_field($_POST['et'][$i]??''),'end'=>sanitize_text_field($_POST['ee'][$i]??''),'name'=>sanitize_text_field($name),'type'=>sanitize_text_field($_POST['ety'][$i]??'keynote'),'loc'=>sanitize_text_field($_POST['el'][$i]??'')];
        }
        usort( $evs, fn($a,$b) => $a['day']<=>$b['day'] ?: strcmp($a['time'],$b['time']) );
        update_option( ASSIE4_OPT_RUNDOWN, ['days'=>$days,'events'=>$evs] );
        assie4_rebuild_js_data();
        a4_notice('✅ Rundown disimpan!');
    }
    $rd   = get_option( ASSIE4_OPT_RUNDOWN, assie4_default_rundown() );
    $days = $rd['days']   ?? [];
    $evs  = $rd['events'] ?? [];
    $types = ['keynote'=>'Keynote','panel'=>'Panel','workshop'=>'Workshop','networking'=>'Hiburan','break'=>'Break','award'=>'Penutupan'];
    a4_header('Rundown Acara', count($evs).' event');
    ?>
    <form method="post"><?php wp_nonce_field('a4_rundown','_n'); ?>
    <div class="a4-card">
        <div class="a4-card-head">Label Hari</div>
        <div class="a4-row a4-row-3">
        <?php foreach ($days as $i => $d) : ?>
            <div class="a4-field"><label>Hari <?php echo $i+1 ?></label><input name="dl[]" value="<?php echo esc_attr($d['label']); ?>"></div>
        <?php endforeach; ?>
        </div>
    </div>
    <div class="a4-card">
        <div class="a4-card-head">Daftar Event</div>
        <div id="a4EW">
        <?php foreach ($evs as $e) : ?>
        <div class="a4-item-box">
            <div class="a4-item-header">
                <span class="a4-item-num">Hari <?php echo $e['day']+1 ?> · <?php echo esc_html($e['time']) ?></span>
                <button type="button" class="a4-btn-del" onclick="this.closest('.a4-item-box').remove()">✕</button>
            </div>
            <div class="a4-row a4-row-3">
                <div class="a4-field"><label>Hari</label><select name="ed[]"><?php for($d=0;$d<count($days);$d++) echo '<option value="'.$d.'"'.($e['day']==$d?' selected':'').'>Hari '.($d+1).'</option>'; ?></select></div>
                <div class="a4-field"><label>Mulai</label><input name="et[]" value="<?php echo esc_attr($e['time']); ?>"></div>
                <div class="a4-field"><label>Selesai</label><input name="ee[]" value="<?php echo esc_attr($e['end']); ?>"></div>
            </div>
            <div class="a4-row">
                <div class="a4-field"><label>Nama Event</label><input name="en[]" value="<?php echo esc_attr($e['name']); ?>"></div>
                <div class="a4-field"><label>Tipe</label><select name="ety[]"><?php foreach($types as $k=>$v) echo '<option value="'.$k.'"'.($e['type']===$k?' selected':'').'>'.$v.'</option>'; ?></select></div>
            </div>
            <div class="a4-field"><label>Lokasi</label><input name="el[]" value="<?php echo esc_attr($e['loc']); ?>"></div>
        </div>
        <?php endforeach; ?>
        </div>
        <button type="button" class="a4-btn-add" onclick="a4AE()">＋ Tambah Event</button>
    </div>
    <button type="submit" class="a4-btn-primary">💾 Simpan Rundown</button>
    </form>
    </div>
    <script>
    var a4DC=<?php echo count($days); ?>;
    function a4AE(){var o='',t='<option value="keynote">Keynote</option><option value="panel">Panel</option><option value="workshop">Workshop</option><option value="networking">Hiburan</option><option value="break">Break</option><option value="award">Penutupan</option>';for(var i=0;i<a4DC;i++) o+='<option value="'+i+'">Hari '+(i+1)+'</option>';document.getElementById('a4EW').insertAdjacentHTML('beforeend','<div class="a4-item-box"><div class="a4-item-header"><span class="a4-item-num">Event Baru</span><button type="button" class="a4-btn-del" onclick="this.closest(\'.a4-item-box\').remove()">✕</button></div><div class="a4-row a4-row-3"><div class="a4-field"><label>Hari</label><select name="ed[]">'+o+'</select></div><div class="a4-field"><label>Mulai</label><input name="et[]" value="08.00"></div><div class="a4-field"><label>Selesai</label><input name="ee[]" value="09.00"></div></div><div class="a4-row"><div class="a4-field"><label>Nama</label><input name="en[]" value=""></div><div class="a4-field"><label>Tipe</label><select name="ety[]">'+t+'</select></div></div><div class="a4-field"><label>Lokasi</label><input name="el[]" value="Main Stage"></div></div>');}
    </script>
    <?php
}

/* ═══ 6. KELOLA TENANT ══════════════════════════════════ */
function assie4_admin_tenants() {
    if ( ! current_user_can('manage_options') ) return;

    $page_url = admin_url('admin.php?page=assie4-tenants');

    /* Hapus tenant */
    if ( isset($_GET['del_t'], $_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'del_t_'.$_GET['del_t']) ) {
        $del_id  = sanitize_text_field($_GET['del_t']);
        $tenants = assie4_get_tenants();
        $tenants = array_values( array_filter($tenants, fn($t) => $t['id'] !== $del_id) );
        assie4_save_tenants($tenants);
        a4_notice('✅ Tenant '.esc_html($del_id).' dihapus. Halaman pameran terupdate.');
    }

    /* Simpan (tambah/edit) */
    if ( isset($_POST['_nt']) && wp_verify_nonce($_POST['_nt'], 'a4_tenant') ) {
        $edit_id = sanitize_text_field($_POST['original_id'] ?? '');
        $new_id  = strtoupper(sanitize_text_field($_POST['t_id'] ?? ''));
        if ( empty($new_id) ) {
            a4_notice('❌ Kode Booth tidak boleh kosong.','err');
        } else {
            $tags = array_values( array_filter( array_map('trim', explode(',', sanitize_text_field($_POST['t_tags']??''))) ) );
            $new_tenant = assie4_normalize_tenant([
                'id'        => $new_id,
                'area'      => strtoupper(sanitize_text_field($_POST['t_area']      ?? 'A')),
                'name'      => sanitize_text_field($_POST['t_name']      ?? ''),
                'cat'       => sanitize_text_field($_POST['t_cat']       ?? ''),
                'desc'      => sanitize_textarea_field($_POST['t_desc']  ?? ''),
                'tags'      => $tags,
                'logo'      => esc_url_raw($_POST['t_logo']              ?? ''),
                'contact'   => sanitize_text_field($_POST['t_contact']   ?? ''),
                'web'       => esc_url_raw($_POST['t_web']               ?? ''),
                'instagram' => sanitize_text_field($_POST['t_instagram'] ?? ''),
                'facebook'  => esc_url_raw($_POST['t_facebook']          ?? ''),
                'twitter'   => sanitize_text_field($_POST['t_twitter']   ?? ''),
            ]);
            $tenants = assie4_get_tenants();
            if ( $edit_id ) {
                $found = false;
                foreach ($tenants as $k => $t) { if ($t['id']===$edit_id){$tenants[$k]=$new_tenant;$found=true;break;} }
                if (!$found) $tenants[] = $new_tenant;
            } else {
                if ( in_array($new_id, array_column($tenants,'id'), true) ) {
                    a4_notice('❌ Kode Booth "'.$new_id.'" sudah ada.','err');
                    $new_tenant = null;
                } else {
                    $tenants[] = $new_tenant;
                }
            }
            if ( isset($new_tenant) && $new_tenant ) {
                assie4_save_tenants($tenants);
                $mode = $edit_id ? 'diupdate' : 'ditambahkan';
                a4_notice('✅ Tenant '.$new_id.' berhasil '.$mode.'! Halaman pameran sudah terupdate.');
                echo '<script>setTimeout(function(){window.location.href="'.esc_url($page_url).'"},1200);</script>';
            }
        }
    }

    $tenants   = assie4_get_tenants();
    $editId    = $_GET['edit'] ?? null;
    $fa        = $_GET['fa']   ?? 'all';
    $search    = strtolower(trim($_GET['s'] ?? ''));
    $apc       = ['A'=>'ap-A','B'=>'ap-B','C'=>'ap-C','D'=>'ap-D','E'=>'ap-E'];

    a4_header('Kelola Tenant', count($tenants).' tenant');

    // Preview bar
    $p = get_page_by_path(ASSIE4_PAMERAN_SLUG);
    if ($p) echo '<div class="a4-preview-bar">✅ Perubahan tenant <strong>langsung tampil</strong> di <a href="'.esc_url(get_permalink($p)).'" target="_blank">halaman pameran</a>.</div>';

    /* Form tambah / edit */
    if ( $editId !== null ) {
        $t      = null;
        $is_new = ($editId === 'new');
        if ( !$is_new ) { foreach ($tenants as $item) { if ($item['id']===$editId){$t=$item;break;} } }
        if ( !$t ) $t = assie4_normalize_tenant([]);
        ?>
        <div class="a4-card">
        <div class="a4-card-head"><?php echo $is_new ? '➕ Tambah Tenant Baru' : '✏️ Edit Tenant — '.esc_html($editId); ?></div>
        <form method="post" action="<?php echo esc_url($page_url); ?>">
            <?php wp_nonce_field('a4_tenant','_nt'); ?>
            <input type="hidden" name="original_id" value="<?php echo $is_new ? '' : esc_attr($editId); ?>">

            <span class="a4-sect">📋 Identitas Booth</span>
            <div class="a4-row">
                <div class="a4-field"><label>1. Kode Booth</label><input name="t_id" value="<?php echo esc_attr($t['id']); ?>" placeholder="mis: A1, B12" required></div>
                <div class="a4-field"><label>2. Area</label>
                    <select name="t_area">
                        <?php foreach (['A'=>'Area A — UNAIR','B'=>'Area B — Mitra','C'=>'Area C — Eksternal','D'=>'Area D — Startup','E'=>'Area E — Institusi'] as $ar=>$lbl)
                            echo '<option value="'.$ar.'"'.($t['area']===$ar?' selected':'').'>'.esc_html($lbl).'</option>'; ?>
                    </select>
                </div>
            </div>
            <div class="a4-row">
                <div class="a4-field"><label>3. Nama Tenant / Booth</label><input name="t_name" value="<?php echo esc_attr($t['name']); ?>" placeholder="Nama lengkap booth" required></div>
                <div class="a4-field"><label>4. Kategori</label><input name="t_cat" value="<?php echo esc_attr($t['cat']); ?>" placeholder="mis: Startup, Kuliner, Pendidikan"></div>
            </div>
            <div class="a4-field u-mb-md"><label>5. Deskripsi Singkat</label><textarea name="t_desc" rows="3" placeholder="Deskripsi tentang tenant ini…"><?php echo esc_textarea($t['desc']); ?></textarea></div>
            <div class="a4-row">
                <div class="a4-field"><label>6. Tags <small>(pisah koma)</small></label><input name="t_tags" value="<?php echo esc_attr(implode(', ',$t['tags'])); ?>" placeholder="Startup, Teknologi, Inovasi"></div>
                <div class="a4-field"><label>7. Logo <small>(URL gambar)</small></label><input type="url" name="t_logo" value="<?php echo esc_attr($t['logo']); ?>" placeholder="https://..."></div>
            </div>

            <span class="a4-sect">📱 Kontak & Media Sosial</span>
            <div class="a4-row">
                <div class="a4-field"><label>8. Email Kontak</label><input type="email" name="t_contact" value="<?php echo esc_attr($t['contact']); ?>" placeholder="email@domain.com"></div>
                <div class="a4-field"><label>9. Website / URL</label><input type="url" name="t_web" value="<?php echo esc_attr($t['web']); ?>" placeholder="https://..."></div>
            </div>
            <div class="a4-row a4-row-3">
                <div class="a4-field"><label>10. Instagram</label><input name="t_instagram" value="<?php echo esc_attr($t['instagram']); ?>" placeholder="@namaakun"></div>
                <div class="a4-field"><label>11. Facebook</label><input name="t_facebook" value="<?php echo esc_attr($t['facebook']); ?>" placeholder="https://facebook.com/..."></div>
                <div class="a4-field"><label>12. X / Twitter</label><input name="t_twitter" value="<?php echo esc_attr($t['twitter']); ?>" placeholder="@namaakun"></div>
            </div>

            <div class="u-flex u-items-center u-gap-md" style="margin-top:20px;padding-top:16px;border-top:1px solid #e5e7eb">
                <button type="submit" class="a4-btn-primary"><?php echo $is_new ? '➕ Tambah Tenant' : '💾 Simpan Perubahan'; ?></button>
                <a href="<?php echo esc_url($page_url); ?>" class="u-text-light u-text-xs u-text-semibold" style="text-decoration:none">← Batal</a>
            </div>
        </form>
        </div>
        <?php
    }

    /* Tabel daftar tenant */
    $filtered = array_filter($tenants, function($t) use($fa,$search){
        return ($fa==='all'||$t['area']===$fa) && (!$search || stripos($t['id'].$t['name'].$t['cat'],$search)!==false);
    });
    ?>
    <div class="a4-card">
        <div class="a4-card-head">
            <span>Daftar Tenant (<?php echo count($filtered); ?>/<?php echo count($tenants); ?>)</span>
            <a href="<?php echo esc_url(add_query_arg('edit','new',$page_url)); ?>" class="a4-btn-gold" style="font-size:12px;padding:7px 16px;margin-top:0">＋ Tambah Tenant</a>
        </div>
        <div class="a4-filter-bar">
            <form method="get" id="a4SF" style="display:contents">
                <input type="hidden" name="page" value="assie4-tenants">
                <select name="fa" onchange="this.form.submit()">
                    <option value="all">Semua Area</option>
                    <?php foreach (['A'=>'Area A','B'=>'Area B','C'=>'Area C','D'=>'Area D','E'=>'Area E'] as $ar=>$lbl)
                        echo '<option value="'.$ar.'"'.($fa===$ar?' selected':'').'>'.esc_html($lbl).'</option>'; ?>
                </select>
                <input type="text" name="s" id="a4SI" value="<?php echo esc_attr($search); ?>" placeholder="Cari kode / nama…"
                       onkeyup="clearTimeout(window._a4t);window._a4t=setTimeout(function(){document.getElementById('a4SF').submit()},500)">
            </form>
        </div>
        <?php if ( empty($filtered) ) : ?>
        <div class="a4-empty-state">
            <span class="a4-es-ico">🏪</span>
            <h3><?php echo count($tenants)===0 ? 'Belum ada tenant' : 'Tidak ditemukan'; ?></h3>
            <p><?php echo count($tenants)===0 ? 'Mulai tambahkan tenant pertama untuk ditampilkan di halaman pameran.' : 'Ubah filter atau kata kunci.'; ?></p>
            <?php if (count($tenants)===0) : ?>
            <a href="<?php echo esc_url(add_query_arg('edit','new',$page_url)); ?>" class="a4-btn-gold">➕ Tambah Tenant Pertama</a>
            <?php endif; ?>
        </div>
        <?php else : ?>
        <table class="a4-table">
            <thead><tr><th>Kode</th><th>Area</th><th>Nama Tenant</th><th>Kategori</th><th>Tags</th><th>Sosmed</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($filtered as $t) :
                $eu = esc_url(add_query_arg('edit', urlencode($t['id']), $page_url));
                $du = esc_url(wp_nonce_url(add_query_arg(['del_t'=>$t['id']],$page_url),'del_t_'.$t['id']));
            ?>
            <tr>
                <td><strong><?php echo esc_html($t['id']); ?></strong></td>
                <td><span class="a4-ap <?php echo $apc[$t['area']]??''; ?>"><?php echo esc_html($t['area']); ?></span></td>
                <td>
                    <?php if($t['logo']) : ?><img src="<?php echo esc_url($t['logo']); ?>" style="height:20px;margin-right:6px;vertical-align:middle;border-radius:3px"><?php endif; ?>
                    <?php echo esc_html($t['name']); ?>
                    <?php if($t['desc']) : ?><div style="font-size:11px;color:#94a3b8;margin-top:2px"><?php echo esc_html(mb_strimwidth($t['desc'],0,55,'…')); ?></div><?php endif; ?>
                </td>
                <td style="font-size:12px;color:#64748b"><?php echo esc_html($t['cat']); ?></td>
                <td style="font-size:11px;color:#64748b"><?php echo esc_html(implode(', ',array_slice($t['tags'],0,3))); ?><?php echo count($t['tags'])>3?' …':''; ?></td>
                <td class="a4-ic">
                    <?php if($t['contact']) echo '<a href="mailto:'.esc_attr($t['contact']).'" title="'.esc_attr($t['contact']).'">📧</a>'; ?>
                    <?php if($t['web'])     echo '<a href="'.esc_url($t['web']).'" target="_blank" title="'.esc_attr($t['web']).'">🌐</a>'; ?>
                    <?php if($t['instagram']){$u=strpos($t['instagram'],'http')===0?$t['instagram']:'https://instagram.com/'.ltrim($t['instagram'],'@');echo '<a href="'.esc_url($u).'" target="_blank">📷</a>';}?>
                    <?php if($t['facebook'])echo '<a href="'.esc_url($t['facebook']).'" target="_blank">👍</a>'; ?>
                    <?php if($t['twitter']){$u=strpos($t['twitter'],'http')===0?$t['twitter']:'https://x.com/'.ltrim($t['twitter'],'@');echo '<a href="'.esc_url($u).'" target="_blank">🐦</a>';}?>
                </td>
                <td style="white-space:nowrap">
                    <a href="<?php echo $eu; ?>" style="font-size:12px;font-weight:700;color:#1e40af;text-decoration:none;margin-right:8px">✏️ Edit</a>
                    <a href="<?php echo $du; ?>" onclick="return confirm('Hapus <?php echo esc_js($t['id'].': '.$t['name']); ?>?')" style="font-size:12px;font-weight:700;color:#dc2626;text-decoration:none">✕ Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
    </div>
    <?php
}

/* ═══ 7. DENAH & GALERI ═════════════════════════════════ */
function assie4_admin_denah() {
    if ( ! current_user_can('manage_options') ) return;
    if ( isset($_POST['_nd']) && wp_verify_nonce($_POST['_nd'],'a4_denah') ) {
        $imgs = [];
        foreach ( ($_POST['d_url']??[]) as $i => $url ) {
            $url = esc_url_raw(trim($url));
            if (!$url) continue;
            $imgs[] = ['url'=>$url,'caption'=>sanitize_text_field($_POST['d_cap'][$i]??'')];
        }
        update_option('assie4_pameran_denah', $imgs);
        assie4_rebuild_js_data();
        a4_notice('✅ Gambar denah disimpan! Halaman pameran terupdate.');
    }
    $imgs = get_option('assie4_pameran_denah', []);
    a4_header('Denah & Galeri Foto', count($imgs).' gambar');
    ?>
    <div class="a4-card">
        <div class="a4-card-head">Upload Gambar Denah</div>
        <p class="u-text-sm u-text-muted u-mb-md">Gambar ditampilkan di bawah SVG denah di halaman pameran. Klik untuk perbesar (lightbox). Gunakan tombol <strong>📁 Pilih dari Media</strong> untuk upload dari Library WordPress.</p>
        <form method="post"><?php wp_nonce_field('a4_denah','_nd'); ?>
        <div id="a4DW">
        <?php if (empty($imgs)) : ?>
        <div class="a4-item-box" id="a4di_0">
            <div class="a4-denah-preview" id="a4dp_0"><span style="color:#94a3b8;font-size:13px">📷 Belum ada gambar</span></div>
            <div class="a4-row" style="margin-top:10px">
                <div class="a4-field"><label>URL Gambar</label><input type="url" name="d_url[]" id="a4du_0" placeholder="https://..." onchange="a4PrevImg(0)"></div>
                <div class="a4-field"><label>Keterangan (opsional)</label><input type="text" name="d_cap[]" placeholder="mis: Denah Lantai 1"></div>
            </div>
            <div class="u-flex u-gap-sm" style="margin-top:8px">
                <button type="button" class="a4-btn-gold u-text-xs u-whitespace-nowrap" style="padding:7px 14px;background:#0073aa" onclick="a4Pick(0)">📁 Pilih dari Media</button>
                <button type="button" class="a4-btn-del" onclick="this.closest('.a4-item-box').remove()">✕ Hapus</button>
            </div>
        </div>
        <?php else : foreach ($imgs as $i => $img) : ?>
        <div class="a4-item-box" id="a4di_<?php echo $i; ?>">
            <div class="a4-denah-preview" id="a4dp_<?php echo $i; ?>">
                <?php if ($img['url']) : ?><img src="<?php echo esc_url($img['url']); ?>" style="max-width:100%;max-height:180px;border-radius:6px;object-fit:contain">
                <?php else : ?><span style="color:#94a3b8;font-size:13px">📷 Belum ada gambar</span><?php endif; ?>
            </div>
            <div class="a4-row" style="margin-top:10px">
                <div class="a4-field"><label>URL Gambar</label><input type="url" name="d_url[]" id="a4du_<?php echo $i; ?>" value="<?php echo esc_attr($img['url']); ?>" placeholder="https://..." onchange="a4PrevImg(<?php echo $i; ?>)"></div>
                <div class="a4-field"><label>Keterangan</label><input type="text" name="d_cap[]" value="<?php echo esc_attr($img['caption']??''); ?>"></div>
            </div>
            <div class="u-flex u-gap-sm" style="margin-top:8px">
                <button type="button" class="a4-btn-gold u-text-xs u-whitespace-nowrap" style="padding:7px 14px;background:#0073aa" onclick="a4Pick(<?php echo $i; ?>)">📁 Pilih dari Media</button>
                <button type="button" class="a4-btn-del" onclick="this.closest('.a4-item-box').remove()">✕ Hapus</button>
            </div>
        </div>
        <?php endforeach; endif; ?>
        </div>
        <div class="u-flex u-gap-md u-mb-lg">
            <button type="button" class="a4-btn-add" onclick="a4AddImg()">＋ Tambah Gambar</button>
            <button type="submit" class="a4-btn-primary">💾 Simpan Semua Gambar</button>
        </div>
        </form>
    </div>
    </div>
    <script>
    var a4DI=<?php echo max(count($imgs),1); ?>,a4MF=null,a4MT=null;
    function a4PrevImg(i){var u=document.getElementById('a4du_'+i).value,p=document.getElementById('a4dp_'+i);p.innerHTML=u?'<img src="'+u+'" style="max-width:100%;max-height:180px;border-radius:6px;object-fit:contain" onerror="this.parentNode.innerHTML=\'<span style=color:#94a3b8>❌ URL tidak valid</span>\'">':'<span style="color:#94a3b8;font-size:13px">📷 Belum ada gambar</span>';}
    function a4AddImg(){var i=a4DI++;document.getElementById('a4DW').insertAdjacentHTML('beforeend','<div class="a4-item-box" id="a4di_'+i+'"><div class="a4-denah-preview" id="a4dp_'+i+'"><span style="color:#94a3b8;font-size:13px">📷 Belum ada gambar</span></div><div class="a4-row" style="margin-top:10px"><div class="a4-field"><label>URL Gambar</label><input type="url" name="d_url[]" id="a4du_'+i+'" placeholder="https://..." onchange="a4PrevImg('+i+')"></div><div class="a4-field"><label>Keterangan</label><input type="text" name="d_cap[]"></div></div><div style="margin-top:8px;display:flex;gap:8px"><button type="button" class="a4-btn-gold" style="font-size:12px;padding:7px 14px;margin-top:0;background:#0073aa" onclick="a4Pick('+i+')">📁 Pilih dari Media</button><button type="button" class="a4-btn-del" onclick="this.closest(\'.a4-item-box\').remove()">✕</button></div></div>');}
    function a4Pick(i){a4MT=i;if(a4MF){a4MF.open();return;}a4MF=wp.media({title:'Pilih Gambar Denah',button:{text:'Gunakan Gambar'},multiple:false,library:{type:'image'}});a4MF.on('select',function(){var att=a4MF.state().get('selection').first().toJSON();document.getElementById('a4du_'+a4MT).value=att.url||'';a4PrevImg(a4MT);});a4MF.open();}
    </script>
    <?php
}

/* ═══ 8. BOOTH PASINBIS ═════════════════════════════════ */
function assie4_admin_pasinbis() {
    if ( ! current_user_can('manage_options') ) return;
    if ( isset($_POST['_np']) && wp_verify_nonce($_POST['_np'],'a4_pasinbis') ) {
        update_option('assie4_pasinbis_url',  esc_url_raw($_POST['pasinbis_url']  ?? ''));
        update_option('assie4_pasinbis_nama', sanitize_text_field($_POST['pasinbis_nama'] ?? ''));
        update_option('assie4_pasinbis_desk', sanitize_textarea_field($_POST['pasinbis_desk'] ?? ''));
        update_option('assie4_pasinbis_logo', esc_url_raw($_POST['pasinbis_logo'] ?? ''));
        update_option('assie4_pasinbis_ig',   sanitize_text_field($_POST['pasinbis_ig']   ?? ''));
        update_option('assie4_pasinbis_web',  esc_url_raw($_POST['pasinbis_web']  ?? ''));
        assie4_rebuild_js_data();
        a4_notice('✅ Informasi Booth PASINBIS disimpan!');
    }
    a4_header('Booth PASINBIS', 'Pengaturan');
    ?>
    <div class="a4-card">
        <div class="a4-card-head">Informasi Booth PASINBIS</div>
        <p style="font-size:13px;color:#64748b;margin-bottom:16px">Booth PASINBIS tampil di denah dengan border emas, terpisah dari area A–E. Klik di halaman pameran membuka URL di bawah ini. Data ini juga tampil di modal popup saat diklik.</p>
        <form method="post"><?php wp_nonce_field('a4_pasinbis','_np'); ?>
        <div class="a4-row">
            <div class="a4-field"><label>Nama Booth</label><input name="pasinbis_nama" value="<?php echo esc_attr(get_option('assie4_pasinbis_nama','PASINBIS UNAIR')); ?>" placeholder="PASINBIS Universitas Airlangga"></div>
            <div class="a4-field"><label>URL Klik di Denah</label><input type="url" name="pasinbis_url" value="<?php echo esc_attr(get_option('assie4_pasinbis_url','https://pasinbis.unair.ac.id')); ?>" placeholder="https://pasinbis.unair.ac.id"></div>
        </div>
        <div class="a4-field u-mb-md"><label>Deskripsi Singkat</label><textarea name="pasinbis_desk" rows="2"><?php echo esc_textarea(get_option('assie4_pasinbis_desk','Pusat Akselerasi Inovasi dan Bisnis Universitas Airlangga')); ?></textarea></div>
        <div class="a4-row">
            <div class="a4-field"><label>URL Logo</label><input type="url" name="pasinbis_logo" value="<?php echo esc_attr(get_option('assie4_pasinbis_logo','')); ?>" placeholder="https://..."></div>
            <div class="a4-field"><label>Instagram</label><input name="pasinbis_ig" value="<?php echo esc_attr(get_option('assie4_pasinbis_ig','@paib_unair')); ?>" placeholder="@paib_unair"></div>
        </div>
        <div class="a4-field u-mb-lg"><label>Website / TokoUA</label><input type="url" name="pasinbis_web" value="<?php echo esc_attr(get_option('assie4_pasinbis_web','https://tokoua.unair.ac.id')); ?>" placeholder="https://tokoua.unair.ac.id"></div>
        <button type="submit" class="a4-btn-primary">💾 Simpan Booth PASINBIS</button>
        </form>
    </div>
    <div class="a4-card" style="background:#fffbeb;border-color:#fde68a">
        <div class="a4-card-head" style="border-color:#f59e0b">Preview di Denah</div>
        <p class="u-text-sm" style="color:#92400e">Booth PASINBIS tampil dengan warna emas (border #d4a843) dan label nama yang diisi di atas. Sub-label menggunakan deskripsi singkat (28 karakter pertama). Klik → buka URL di tab baru.</p>
    </div>
    </div>
    <?php
}

/* ═══ 9. EXPORT / RESET ═════════════════════════════════ */
function assie4_admin_export() {
    if ( ! current_user_can('manage_options') ) return;
    if ( isset($_POST['_nr']) && wp_verify_nonce($_POST['_nr'],'a4_reset') ) {
        if (isset($_POST['ri'])) { delete_option(ASSIE4_OPT_INFO);    a4_notice('✅ Info acara direset ke default.'); }
        if (isset($_POST['rs'])) { delete_option(ASSIE4_OPT_SLIDES);  a4_notice('✅ Slides direset ke default.'); }
        if (isset($_POST['rk'])) { delete_option(ASSIE4_OPT_TICKER);  a4_notice('✅ Ticker direset ke default.'); }
        if (isset($_POST['rr'])) { delete_option(ASSIE4_OPT_RUNDOWN); a4_notice('✅ Rundown direset ke default.'); }
        if (isset($_POST['rt'])) {
            delete_option(ASSIE4_OPT_TENANTS);
            delete_option('assie4_tenants_seeded');
            delete_option('assie4_seed_ver');
            a4_notice('✅ Semua tenant dihapus. Tambahkan tenant baru dari menu Kelola Tenant.');
        }
        if (isset($_POST['rn'])) {
            delete_transient('assie4_news_cache');
            a4_notice('✅ Cache berita dihapus. Berita akan di-refresh saat halaman pameran dibuka.');
        }
        assie4_rebuild_js_data();
    }
    a4_header('Export & Reset');
    ?>
    <div class="a4-card">
        <div class="a4-card-head">Export Backup JSON</div>
        <p class="u-text-sm u-text-light u-mb-md">Download semua data plugin (info, slides, ticker, rundown, tenant, denah) dalam format JSON.</p>
        <a href="<?php echo esc_url(admin_url('admin-ajax.php?action=assie4_export&_wpnonce='.wp_create_nonce('a4_export'))); ?>" class="a4-btn-primary">⬇️ Download Backup JSON</a>
    </div>
    <div class="a4-card" style="border-color:#fecaca">
        <div class="a4-card-head" style="color:#dc2626;border-color:#f87171">⚠️ Reset Data</div>
        <p class="u-text-sm u-text-light u-mb-lg">Data yang direset <strong>tidak dapat dikembalikan</strong>. Pastikan sudah backup dulu.</p>
        <form method="post" onsubmit="return confirm('Yakin ingin mereset data yang dipilih?')">
            <?php wp_nonce_field('a4_reset','_nr'); ?>
            <div class="u-flex u-flex-col u-gap-md u-mb-lg u-text-sm">
                <label><input type="checkbox" name="ri"> Reset Info Acara ke default</label>
                <label><input type="checkbox" name="rs"> Reset Hero Slides ke default</label>
                <label><input type="checkbox" name="rk"> Reset Ticker ke default</label>
                <label><input type="checkbox" name="rr"> Reset Rundown ke default</label>
                <label class="u-text-bold" style="color:#dc2626"><input type="checkbox" name="rt"> 🗑 HAPUS SEMUA TENANT (database dikosongkan)</label>
                <label><input type="checkbox" name="rn"> 🔄 Hapus cache berita (refresh dari pasinbis)</label>
            </div>
            <button type="submit" class="a4-btn-danger">Lakukan Reset</button>
        </form>
    </div>
    </div>
    <?php
}

/* ═══ AJAX ══════════════════════════════════════════════ */
add_action('wp_ajax_assie4_export', function() {
    if (!current_user_can('manage_options')||!wp_verify_nonce($_GET['_wpnonce']??'','a4_export')) wp_die('Unauthorized');
    header('Content-Type: application/json; charset=utf-8');
    header('Content-Disposition: attachment; filename="assie4-backup-'.date('Y-m-d').'.json"');
    echo wp_json_encode([
        'exported_at' => date('Y-m-d H:i:s'),
        'info'        => get_option(ASSIE4_OPT_INFO,    assie4_default_info()),
        'slides'      => get_option(ASSIE4_OPT_SLIDES,  assie4_default_slides()),
        'ticker'      => get_option(ASSIE4_OPT_TICKER,  assie4_default_ticker()),
        'rundown'     => get_option(ASSIE4_OPT_RUNDOWN, assie4_default_rundown()),
        'tenants'     => assie4_get_tenants(),
        'denah'       => get_option('assie4_pameran_denah',[]),
        'pasinbis'    => [
            'url'  => get_option('assie4_pasinbis_url',''),
            'nama' => get_option('assie4_pasinbis_nama',''),
            'desk' => get_option('assie4_pasinbis_desk',''),
            'logo' => get_option('assie4_pasinbis_logo',''),
            'ig'   => get_option('assie4_pasinbis_ig',''),
            'web'  => get_option('assie4_pasinbis_web',''),
        ],
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
});

// AJAX stats dihandle di assie4-pameran-digital.php

/* ══════════════════════════════════════════════════════
   BERITA EKSTERNAL — admin page & save handler
   ══════════════════════════════════════════════════════ */
define( 'ASSIE4_OPT_BERITA_EXT', 'assie4_berita_eksternal' );

function assie4_normalize_berita_ext( $b ) {
    $b = (array) $b;
    return [
        'id'    => sanitize_key( $b['id'] ?? uniqid('ext_') ),
        'title' => sanitize_text_field( trim( $b['title'] ?? '' ) ),
        'link'  => esc_url_raw( trim( $b['link'] ?? '' ) ),
        'date'  => sanitize_text_field( trim( $b['date'] ?? '' ) ),
        'desc'  => sanitize_textarea_field( trim( $b['desc'] ?? '' ) ),
        'thumb' => esc_url_raw( trim( $b['thumb'] ?? '' ) ),
    ];
}

function assie4_save_berita_ext() {
    if ( ! isset( $_POST['assie4_berita_ext_nonce'] ) ) return;
    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['assie4_berita_ext_nonce'] ) ), 'assie4_berita_ext_save' ) ) return;
    if ( ! current_user_can( 'manage_options' ) ) return;

    $raw   = isset( $_POST['berita_ext'] ) ? (array) wp_unslash( $_POST['berita_ext'] ) : [];
    $items = [];
    foreach ( $raw as $b ) {
        $n = assie4_normalize_berita_ext( $b );
        if ( $n['title'] && $n['link'] ) $items[] = $n;
    }
    // Re-index IDs
    foreach ( $items as &$item ) {
        if ( empty( $item['id'] ) ) $item['id'] = uniqid('ext_');
    }
    update_option( ASSIE4_OPT_BERITA_EXT, $items );
    delete_transient( 'assie4_news_cache' );
    add_settings_error( 'assie4_berita_ext', 'saved', '✅ Berita eksternal disimpan & cache diperbarui.', 'success' );
}
add_action( 'admin_init', 'assie4_save_berita_ext' );

function assie4_admin_berita_ext() {
    $items = get_option( ASSIE4_OPT_BERITA_EXT, [] );
    settings_errors( 'assie4_berita_ext' );
    a4_header( '📰 Berita Eksternal' );
    ?>
    <p class="u-text-sm u-text-muted u-mb-lg">Tambahkan berita dari situs luar. Akan digabung &amp; diurutkan bersama berita PASINBIS di grid halaman pameran.</p>

    <form method="post" id="a4-ext-form">
    <?php wp_nonce_field( 'assie4_berita_ext_save', 'assie4_berita_ext_nonce' ); ?>

    <div class="a4-card">
        <div class="a4-card-head">
            Daftar Berita Eksternal
            <span class="a4-badge a4-badge-blue"><?php echo count($items); ?> berita</span>
        </div>

        <div id="a4-ext-list">
        <?php if ( empty($items) ): ?>
        <div class="a4-ext-empty" id="a4-ext-empty">📭 Belum ada berita eksternal. Klik "+ Tambah Berita" untuk mulai.</div>
        <?php else: ?>
        <?php foreach ( $items as $i => $b ): ?>
        <div class="a4-ext-item">
            <div class="a4-ext-item-head">
                <span class="a4-ext-item-num">📰 Berita #<?php echo $i + 1; ?></span>
                <button type="button" onclick="a4ExtRemove(this)" class="a4-btn-danger">✕ Hapus</button>
            </div>
            <input type="hidden" name="berita_ext[<?php echo $i; ?>][id]" value="<?php echo esc_attr($b['id']); ?>">
            <div class="a4-row">
                <div class="a4-field">
                    <label>Judul Berita <span style="color:#dc2626">*</span></label>
                    <input type="text" name="berita_ext[<?php echo $i; ?>][title]" value="<?php echo esc_attr($b['title']); ?>" placeholder="Judul artikel..." required>
                </div>
                <div class="a4-field">
                    <label>Link URL <span style="color:#dc2626">*</span></label>
                    <input type="url" name="berita_ext[<?php echo $i; ?>][link]" value="<?php echo esc_attr($b['link']); ?>" placeholder="https://..." required>
                </div>
            </div>
            <div class="a4-row">
                <div class="a4-field">
                    <label>Tanggal Tayang</label>
                    <input type="date" name="berita_ext[<?php echo $i; ?>][date]" value="<?php echo esc_attr($b['date']); ?>">
                </div>
                <div class="a4-field">
                    <label>URL Gambar <small>opsional</small></label>
                    <input type="url" name="berita_ext[<?php echo $i; ?>][thumb]" value="<?php echo esc_attr($b['thumb'] ?? ''); ?>" placeholder="https://...gambar.jpg">
                </div>
            </div>
            <div class="a4-field">
                <label>Deskripsi Singkat <small>opsional · maks 160 karakter</small></label>
                <textarea name="berita_ext[<?php echo $i; ?>][desc]" rows="2" placeholder="Ringkasan singkat artikel..." maxlength="160"><?php echo esc_textarea($b['desc'] ?? ''); ?></textarea>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
        </div>

        <button type="button" id="a4-ext-add" class="a4-btn-gold u-mt-md">+ Tambah Berita</button>
    </div>

    <button type="submit" class="a4-btn-primary">💾 Simpan Semua Berita</button>
    </form>
    </div>

    <script>
    var a4ExtIdx = <?php echo count($items); ?>;

    function a4ExtRemove(btn) {
        var item = btn.closest('.a4-ext-item');
        item.style.opacity = '0';
        item.style.transition = 'opacity .2s';
        setTimeout(function(){ item.remove(); a4ExtRenum(); }, 200);
    }

    function a4ExtRenum() {
        document.querySelectorAll('.a4-ext-item').forEach(function(el, idx) {
            var num = el.querySelector('.a4-ext-item-num');
            if (num) num.textContent = '📰 Berita #' + (idx + 1);
        });
        var empty = document.getElementById('a4-ext-empty');
        var list  = document.getElementById('a4-ext-list');
        if (list && !list.querySelector('.a4-ext-item')) {
            if (!empty) {
                var d = document.createElement('div');
                d.className = 'a4-ext-empty'; d.id = 'a4-ext-empty';
                d.textContent = '📭 Belum ada berita eksternal. Klik "+ Tambah Berita" untuk mulai.';
                list.appendChild(d);
            }
        }
    }

    document.getElementById('a4-ext-add').addEventListener('click', function(){
        var emptyEl = document.getElementById('a4-ext-empty');
        if (emptyEl) emptyEl.remove();
        var i = a4ExtIdx++;
        var div = document.createElement('div');
        div.className = 'a4-ext-item';
        div.innerHTML =
            '<div class="a4-ext-item-head">'
            + '<span class="a4-ext-item-num">📰 Berita #' + (document.querySelectorAll('.a4-ext-item').length + 1) + '</span>'
            + '<button type="button" onclick="a4ExtRemove(this)" class="a4-btn-danger">✕ Hapus</button>'
            + '</div>'
            + '<input type="hidden" name="berita_ext[' + i + '][id]" value="">'
            + '<div class="a4-row">'
            +   '<div class="a4-field"><label>Judul Berita <span style="color:#dc2626">*</span></label>'
            +   '<input type="text" name="berita_ext[' + i + '][title]" placeholder="Judul artikel..." required></div>'
            +   '<div class="a4-field"><label>Link URL <span style="color:#dc2626">*</span></label>'
            +   '<input type="url" name="berita_ext[' + i + '][link]" placeholder="https://..." required></div>'
            + '</div>'
            + '<div class="a4-row">'
            +   '<div class="a4-field"><label>Tanggal Tayang</label>'
            +   '<input type="date" name="berita_ext[' + i + '][date]"></div>'
            +   '<div class="a4-field"><label>URL Gambar <small>opsional</small></label>'
            +   '<input type="url" name="berita_ext[' + i + '][thumb]" placeholder="https://...gambar.jpg"></div>'
            + '</div>'
            + '<div class="a4-field"><label>Deskripsi Singkat <small>opsional · maks 160 karakter</small></label>'
            + '<textarea name="berita_ext[' + i + '][desc]" rows="2" placeholder="Ringkasan singkat artikel..." maxlength="160"></textarea></div>';
        document.getElementById('a4-ext-list').appendChild(div);
        div.style.opacity = '0'; div.style.transition = 'opacity .25s';
        requestAnimationFrame(function(){ div.style.opacity = '1'; });
        div.querySelector('input[type=text]').focus();
    });
    </script>
    <?php
}


