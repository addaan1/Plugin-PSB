<?php
/**
 * Plugin Name: ASSIE IV - Pameran Digital
 * Plugin URI: https://pasinbis.unair.ac.id
 * Description: Pameran digital ASSIE IV 2026. Shortcode [assie4_pameran] dan [assie4_berita].
 * Version: 2.9.5
 * Author: PASINBIS Universitas Airlangga
 * Author URI: https://pasinbis.unair.ac.id
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: assie4-pameran
 * Domain Path: /languages
 * Requires WordPress: 5.9
 * Requires PHP: 7.4
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ══════════════════════════════════════════════════════
   ENQUEUE wp-pointer PADA HALAMAN PLUGINS
   Memastikan jQuery UI Pointer tersedia saat WordPress
   menampilkan notifikasi aktivasi plugin.
   ══════════════════════════════════════════════════════ */
add_action( 'admin_enqueue_scripts', function( $hook ) {
    if ( $hook === 'plugins.php' ) {
        wp_enqueue_style( 'wp-pointer' );
        wp_enqueue_script( 'wp-pointer' );
    }
});

/* ══════════════════════════════════════════════════════
   DEFINE CONSTANTS
   ══════════════════════════════════════════════════════ */
define( 'ASSIE4_PAMERAN_VER',  '2.9.5' );
define( 'ASSIE4_PAMERAN_DIR',  plugin_dir_path( __FILE__ ) );
define( 'ASSIE4_PAMERAN_URL',  plugin_dir_url( __FILE__ ) );
define( 'ASSIE4_PAMERAN_SLUG', 'pameran-assie4' );

// Load admin functions (always needed for frontend too)
require_once ASSIE4_PAMERAN_DIR . 'admin/assie4-admin-settings.php';

/* ══════════════════════════════════════════════════════
   AKTIVASI
   ══════════════════════════════════════════════════════ */
register_activation_hook( __FILE__, 'assie4_pameran_activate' );
function assie4_pameran_activate() {
    if ( ! get_page_by_path( ASSIE4_PAMERAN_SLUG ) ) {
        wp_insert_post([
            'post_title'   => 'Pameran Digital — ASSIE IV 2026',
            'post_name'    => ASSIE4_PAMERAN_SLUG,
            'post_content' => '[assie4_pameran]',
            'post_status'  => 'publish',
            'post_type'    => 'page',
        ]);
    }
    flush_rewrite_rules();
    // Set transient agar admin notice muncul sekali setelah aktivasi
    set_transient( 'assie4_activation_notice', true, 30 );
}

/* ══════════════════════════════════════════════════════
   ADMIN NOTICE setelah aktivasi (pengganti wp-pointer)
   ══════════════════════════════════════════════════════ */
add_action( 'admin_notices', function() {
    if ( ! get_transient( 'assie4_activation_notice' ) ) return;
    delete_transient( 'assie4_activation_notice' );
    $p   = get_page_by_path( ASSIE4_PAMERAN_SLUG );
    $url = $p ? get_permalink( $p ) : home_url( '/' . ASSIE4_PAMERAN_SLUG . '/' );
    echo '<div class="notice notice-success is-dismissible">'
       . '<p><strong>ASSIE IV &mdash; Pameran Digital</strong> berhasil diaktifkan! '
       . '<a href="' . esc_url( $url ) . '" target="_blank">Lihat Halaman Pameran &rarr;</a></p>'
       . '</div>';
});

/* ══════════════════════════════════════════════════════
   SHORTCODE [assie4_pameran] — halaman pameran penuh
   ══════════════════════════════════════════════════════ */
add_shortcode( 'assie4_pameran', 'assie4_sc_pameran' );
function assie4_sc_pameran() {
    ob_start();
    include ASSIE4_PAMERAN_DIR . 'templates/assie4-pameran-template.php';
    return ob_get_clean();
}

/* ══════════════════════════════════════════════════════
   ENQUEUE halaman pameran
   ══════════════════════════════════════════════════════ */
add_action( 'wp_enqueue_scripts', 'assie4_pameran_enqueue' );
function assie4_pameran_enqueue() {
    // Skip during admin/upload pages
    if ( is_admin() || ( isset($_GET['action']) && $_GET['action'] === 'upload-plugin' ) ) {
        return;
    }

    global $post;
    if ( ! is_a( $post, 'WP_Post' ) || ! has_shortcode( $post->post_content, 'assie4_pameran' ) ) return;

    $ver = get_option( 'assie4_pameran_cache_ver', ASSIE4_PAMERAN_VER );

    wp_enqueue_style(  'assie4-fonts',
        'https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap',
        [], null );
    wp_enqueue_style(  'assie4-pameran-css',
        ASSIE4_PAMERAN_URL . 'assets/assie4-pameran.css', ['assie4-fonts'], $ver );
    wp_enqueue_script( 'assie4-pameran-js',
        ASSIE4_PAMERAN_URL . 'assets/assie4-pameran.js', [], $ver, true );

    $tenants = get_option( 'assie4_pameran_tenants', [] );
    $tenants = is_array($tenants) ? array_map( 'assie4_normalize_tenant', $tenants ) : [];

        $a4_slides = [
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
            'bg'       => ASSIE4_PAMERAN_URL . 'assets/kegiatan-assie-5.jpg',
            'logo'     => ASSIE4_PAMERAN_URL . 'assets/logo-assie4.png',
            'is_logo'  => true,
        ],
    ];
    update_option( 'assie4_pameran_slides', $a4_slides );

    $db  = wp_json_encode([
        'info'    => get_option( 'assie4_pameran_info',    assie4_default_info() ),
        'slides'  => $a4_slides,
        'ticker'  => get_option( 'assie4_pameran_ticker',  assie4_default_ticker() ),
        'rundown' => get_option( 'assie4_pameran_rundown', assie4_default_rundown() ),
        'tenants' => $tenants,
        'denah'   => get_option( 'assie4_pameran_denah', [] ),
    ], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT );

    $cfg = wp_json_encode([
        'presensiUrl' => home_url('/presensi-booth-assie4/'),
        'pluginUrl'   => ASSIE4_PAMERAN_URL,
        'ajaxUrl'     => admin_url('admin-ajax.php'),
        'nonce'       => wp_create_nonce('assie4_pameran_nonce'),
        'pasinbis'    => [
            'url'  => get_option('assie4_pasinbis_url',  'https://pasinbis.unair.ac.id'),
            'nama' => get_option('assie4_pasinbis_nama', 'PASINBIS UNAIR'),
            'desk' => get_option('assie4_pasinbis_desk', 'Pusat Akselerasi Inovasi dan Bisnis Universitas Airlangga'),
            'logo' => get_option('assie4_pasinbis_logo', ''),
            'ig'   => get_option('assie4_pasinbis_ig',   '@pasinbis.unair'),
            'web'  => get_option('assie4_pasinbis_web',  'https://tokoua.unair.ac.id'),
        ],
    ], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT );

    if ( $db && $cfg && json_last_error() === JSON_ERROR_NONE ) {
        wp_add_inline_script( 'assie4-pameran-js',
            'if(typeof window!=="undefined"){try{window.ASSIE4_DB=' . $db . ';window.ASSIE4_CFG=' . $cfg . ';}catch(e){if(console&&console.error){console.error("ASSIE4 config error:",e);}}}',
            'before'
        );
    }
}

/* ══════════════════════════════════════════════════════
   FULL-PAGE TEMPLATE
   ══════════════════════════════════════════════════════ */
add_filter( 'template_include', function( $tpl ) {
    global $post;
    if ( is_a($post,'WP_Post') && has_shortcode($post->post_content,'assie4_pameran') ) {
        $f = ASSIE4_PAMERAN_DIR . 'templates/assie4-pameran-fullpage.php';
        if ( file_exists($f) ) return $f;
    }
    return $tpl;
});

/* ══════════════════════════════════════════════════════
   SHORTCODE [assie4_berita] — server-side render berita
   Contoh: [assie4_berita jumlah="9" kolom="3" judul="Berita" cache="15"]
   ══════════════════════════════════════════════════════ */
add_shortcode( 'assie4_berita', 'assie4_sc_berita' );
function assie4_sc_berita( $atts ) {
    $a = shortcode_atts([
        'jumlah' => 9,
        'kolom'  => 3,
        'judul'  => 'Berita ASSIE IV 2026',
        'cache'  => 15,
    ], $atts, 'assie4_berita' );

    $jumlah = max(1, min(20, intval($a['jumlah'])));
    $kolom  = max(1, min(4,  intval($a['kolom'])));
    $cache  = max(1, intval($a['cache']));
    $items  = assie4_get_berita_items( $jumlah, $cache );

    /* CSS — inject sekali via wp_head jika belum ada */
    if ( ! wp_style_is('assie4-berita-css','done') ) {
        add_action( 'wp_head', 'assie4_berita_print_css', 20 );
    }

    $source_url = 'https://pasinbis.unair.ac.id/category/assie-4-tahun-2026/';
    $html       = '<div class="a4b-wrap">';

    /* Header */
    if ( $a['judul'] ) {
        $html .= '<div class="a4b-header">';
        $html .= '<h2 class="a4b-judul">' . esc_html($a['judul']) . '</h2>';
        $html .= '<a href="' . esc_url($source_url) . '" target="_blank" rel="noopener" class="a4b-more">Lihat Semua &rarr;</a>';
        $html .= '</div>';
    }

    /* Empty state */
    if ( empty($items) ) {
        $html .= '<div class="a4b-empty">';
        $html .= '<p>&#9200; Berita tidak tersedia saat ini.</p>';
        $html .= '<a href="' . esc_url($source_url) . '" target="_blank" rel="noopener">Buka langsung di pasinbis.unair.ac.id &rarr;</a>';
        $html .= '</div>';
    } else {
        /* Grid */
        $html .= '<div class="a4b-grid" style="--a4b-col:' . $kolom . '">';
        foreach ( array_slice($items, 0, $jumlah) as $item ) {
            $date_fmt = '';
            if ( ! empty($item['date']) ) {
                $ts = strtotime($item['date']);
                if ($ts) $date_fmt = date_i18n('j F Y', $ts);
            }

            $thumb_html = '';
            if ( ! empty($item['thumb']) ) {
                $thumb_html = '<div class="a4b-thumb"><img src="' . esc_url($item['thumb']) . '" alt="' . esc_attr($item['title']) . '" loading="lazy" onerror="this.parentNode.className+=\' a4b-nothumb\';this.remove()"></div>';
            } else {
                $thumb_html = '<div class="a4b-thumb a4b-nothumb"><span>&#128240;</span></div>';
            }

            $html .= '<a href="' . esc_url($item['link']) . '" target="_blank" rel="noopener" class="a4b-card">';
            $html .= $thumb_html;
            $html .= '<div class="a4b-body">';
            if ($date_fmt)       $html .= '<div class="a4b-date">' . esc_html($date_fmt) . '</div>';
            $html .= '<div class="a4b-title">' . esc_html($item['title']) . '</div>';
            if ($item['desc'])   $html .= '<div class="a4b-desc">' . esc_html($item['desc']) . '</div>';
            $html .= '<span class="a4b-read">Baca selengkapnya &rarr;</span>';
            $html .= '</div></a>';
        }
        $html .= '</div>';
    }

    $html .= '</div>';
    return $html;
}

/* ── Print CSS shortcode berita ── */
function assie4_berita_print_css() {
    static $printed = false;
    if ($printed) return;
    $printed = true;
    echo '<style id="assie4-berita-css">
.a4b-wrap{font-family:inherit;margin:0 0 32px}
.a4b-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px}
.a4b-judul{font-size:22px;font-weight:700;margin:0;color:#111827}
.a4b-more{font-size:13px;color:#1e40af;text-decoration:none;font-weight:600}
.a4b-more:hover{text-decoration:underline}
.a4b-empty{padding:32px;text-align:center;background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;color:#64748b}
.a4b-grid{display:grid;grid-template-columns:repeat(var(--a4b-col,3),1fr);gap:20px}
@media(max-width:768px){.a4b-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:480px){.a4b-grid{grid-template-columns:1fr}}
.a4b-card{display:flex;flex-direction:column;background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;text-decoration:none;color:inherit;transition:box-shadow .2s,transform .2s}
.a4b-card:hover{box-shadow:0 8px 24px rgba(0,0,0,.1);transform:translateY(-3px)}
.a4b-thumb{aspect-ratio:16/9;overflow:hidden;background:#f3f4f6;display:flex;align-items:center;justify-content:center}
.a4b-thumb img{width:100%;height:100%;object-fit:cover;transition:transform .3s}
.a4b-card:hover .a4b-thumb img{transform:scale(1.05)}
.a4b-nothumb{font-size:36px;color:#94a3b8}
.a4b-body{padding:14px 16px;display:flex;flex-direction:column;gap:6px;flex:1}
.a4b-date{font-size:11px;text-transform:uppercase;letter-spacing:1px;color:#d4a843;font-weight:700}
.a4b-title{font-size:14px;font-weight:700;color:#111827;line-height:1.4}
.a4b-desc{font-size:12px;color:#64748b;line-height:1.55;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
.a4b-read{font-size:12px;color:#1e40af;font-weight:600;margin-top:auto;padding-top:8px}
</style>' . "\n";
}

/* ══════════════════════════════════════════════════════
   FUNGSI FETCH BERITA — AUTO-SCRAPING & RAM CACHE (30 Menit)
   Tidak menyimpan data berita ke dalam database MySQL
   Disimpan di temporary RAM / cache runtime (30 menit sekali)
   ══════════════════════════════════════════════════════ */
function assie4_get_berita_items( $limit = 9, $cache_minutes = 30 ) {
    // 1. Cek runtime RAM cache di global PHP
    if ( isset( $GLOBALS['assie4_news_memory_cache'] ) && is_array( $GLOBALS['assie4_news_memory_cache'] ) && ! empty( $GLOBALS['assie4_news_memory_cache'] ) ) {
        return array_slice( $GLOBALS['assie4_news_memory_cache'], 0, $limit );
    }

    // 2. Cek cache RAM laptop di sistem temporary folder (bebas DB)
    $cache_file     = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'assie4_news_ram_cache.json';
    $cache_lifetime = (int) $cache_minutes * 60; // 30 menit = 1800 detik
    $cached_data    = null;

    if ( file_exists( $cache_file ) && ( time() - filemtime( $cache_file ) ) < $cache_lifetime ) {
        $raw = @file_get_contents( $cache_file );
        if ( ! empty( $raw ) ) {
            $decoded = json_decode( $raw, true );
            if ( is_array( $decoded ) && ! empty( $decoded ) ) {
                $cached_data = $decoded;
            }
        }
    }

    if ( $cached_data !== null ) {
        $GLOBALS['assie4_news_memory_cache'] = $cached_data;
        return array_slice( $cached_data, 0, $limit );
    }

    // 3. Jalankan Auto Scraping (Setiap 30 Menit Sekali)
    $items = assie4_auto_scrape_pasinbis_news();

    // 4. Merge jika ada input berita eksternal admin (opsional)
    $ext_items = get_option( 'assie4_berita_eksternal', [] );
    if ( ! empty( $ext_items ) && is_array( $ext_items ) ) {
        foreach ( $ext_items as $e ) {
            if ( empty($e['title']) || empty($e['link']) ) continue;
            $items[] = [
                'title' => $e['title'],
                'link'  => $e['link'],
                'date'  => ! empty($e['date']) ? $e['date'] . 'T00:00:00+07:00' : '',
                'desc'  => $e['desc'] ?? '',
                'thumb' => $e['thumb'] ?? '',
            ];
        }
    }

    // 5. Urutkan tanggal terbaru
    usort( $items, function( $a, $b ) {
        $da = strtotime( $a['date'] ?? '' ) ?: 0;
        $db = strtotime( $b['date'] ?? '' ) ?: 0;
        return $db - $da;
    });

    // 6. Simpan hasil scrape ke file cache RAM sistem (TIDAK disimpan ke database)
    @file_put_contents( $cache_file, json_encode( $items, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) );
    $GLOBALS['assie4_news_memory_cache'] = $items;

    return array_slice( $items, 0, $limit );
}

/**
 * Auto-scraper berita PASINBIS UNAIR (30 Menit Sekali)
 * Menggunakan browser headers lengkap, dengan dataset fallback resmi ASSIE IV jika terhalang WAF
 */
function assie4_auto_scrape_pasinbis_news() {
    $scraped_items = [];
    $target_url    = 'https://pasinbis.unair.ac.id/';

    // HTTP Request dengan simulasi browser modern
    $response = wp_remote_get( $target_url, [
        'timeout'    => 5,
        'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36',
        'headers'    => [
            'Accept'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language' => 'id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
        ],
    ]);

    if ( ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200 ) {
        $html = wp_remote_retrieve_body( $response );
        // Periksa apakah halaman berhasil didapat tanpa terblokir WAF
        if ( stripos( $html, 'Request Rejected' ) === false && ! empty( $html ) ) {
            if ( preg_match_all( '#<article[^>]*>(.*?)</article>#is', $html, $matches ) ) {
                foreach ( $matches[1] as $art ) {
                    $title = ''; $link = ''; $thumb = ''; $desc = '';
                    if ( preg_match( '#<h[23][^>]*><a[^>]*href="([^"]*)"[^>]*>(.*?)</a>#is', $art, $tm ) || preg_match( "#<h[23][^>]*><a[^>]*href='([^']*)'[^>]*>(.*?)</a>#is", $art, $tm ) ) {
                        $link  = esc_url_raw( $tm[1] );
                        $title = wp_strip_all_tags( $tm[2] );
                    }
                    if ( preg_match( '#<img[^>]*src="([^"]*)"#is', $art, $im ) || preg_match( "#<img[^>]*src='([^']*)'#is", $art, $im ) ) {
                        $thumb = esc_url_raw( $im[1] );
                    }
                    if ( preg_match( '#<div[^>]*class="[^"]*entry-summary[^"]*"[^>]*>(.*?)</div>#is', $art, $sm ) ) {
                        $desc = mb_strimwidth( wp_strip_all_tags( $sm[1] ), 0, 160, '...' );
                    }
                    if ( $title && $link ) {
                        $scraped_items[] = [
                            'title' => html_entity_decode( $title, ENT_QUOTES | ENT_HTML5, 'UTF-8' ),
                            'link'  => $link,
                            'date'  => date( 'c' ),
                            'desc'  => $desc,
                            'thumb' => $thumb,
                        ];
                    }
                }
            }
        }
    }

    // Dataset berita resmi & liputan ASSIE UNAIR sesuai tampilan gambar
    if ( empty( $scraped_items ) ) {
        $base_url = ASSIE4_PAMERAN_URL . 'assets/';
        $scraped_items = [
            [
                'title' => 'BRINOVASI Vol 4 Resmi Membuka Kontribusi: Kirim Karyamu Sekarang!',
                'link'  => 'https://pasinbis.unair.ac.id/',
                'date'  => '2026-05-21T08:00:00+07:00',
                'desc'  => 'Pusat Akselerasi Inovasi dan Bisnis Universitas Airlangga (PASINBIS Unair) kembali menghadirkan edisi terbaru majalah inovasinya ..',
                'thumb' => $base_url . 'berita-brinovasi.jpg',
            ],
            [
                'title' => 'ASSIE III 2025 Resmi Dibuka: Hadirkan 120 Booth Inovasi dan Kolaborasi Perguruan Tinggi di Atrium Grand City',
                'link'  => 'https://pasinbis.unair.ac.id/',
                'date'  => '2025-11-18T09:00:00+07:00',
                'desc'  => 'ASSIE III 2025 Resmi Dibuka: Hadirkan 120 Booth Inovasi dan Kolaborasi Perguruan Tinggi di Atrium Grand City Surabaya, Tiga hari gelaran Airlangga..',
                'thumb' => $base_url . 'kegiatan-assie-3.jpg',
            ],
            [
                'title' => 'ASSIE 2025 Hadirkan Karya Inovasi FTMM',
                'link'  => 'https://ftmm.unair.ac.id/',
                'date'  => '2025-11-14T10:00:00+07:00',
                'desc'  => 'FTMM NEWS - Airlangga StartUp Summit and Innovation Expo (ASSIE) kembali hadir untuk kali ketiga. Tahun ini, ASSIE berlangsung di Main..',
                'thumb' => $base_url . 'berita-ftmm.jpg',
            ],
            [
                'title' => 'FEB UNAIR TURUT MERIAHKAN PAMERAN INOVASI DAN STARTUP DI ASSIE III 2025',
                'link'  => 'https://feb.unair.ac.id/',
                'date'  => '2025-11-14T11:00:00+07:00',
                'desc'  => '(FEB NEWS) Surabaya - Hari pertama pelaksanaan Airlangga StartUp Summit and Innovation Expo (ASSIE III 2025) yang dibuka..',
                'thumb' => $base_url . 'kegiatan-assie-2.jpg',
            ],
            [
                'title' => 'Keseruan Pameran Inovasi & Startup ASSIE di Atrium Grand City Surabaya',
                'link'  => 'https://pasinbis.unair.ac.id/',
                'date'  => '2025-11-14T14:00:00+07:00',
                'desc'  => 'Kemeriahan suasana pameran startup dan inovasi ASSIE yang mempertemukan ratusan inovator kampus dengan ribuan pengunjung dan calon investor..',
                'thumb' => $base_url . 'kegiatan-assie-4.jpg',
            ],
            [
                'title' => 'Pameran Produk Inovasi Unggulan & Tenant Binaan PASINBIS UNAIR',
                'link'  => 'https://pasinbis.unair.ac.id/',
                'date'  => '2025-11-15T10:30:00+07:00',
                'desc'  => 'Produk-produk inovasi unggulan mulai dari bidang kesehatan, teknologi terbarukan, hingga pangan fungsional unjuk gigi di hadapan industri..',
                'thumb' => $base_url . 'kegiatan-assie-1.jpg',
            ],
        ];
    }

    return $scraped_items;
}

/* ══════════════════════════════════════════════════════
   AJAX — endpoint untuk page pameran
   ══════════════════════════════════════════════════════ */
add_action('wp_ajax_nopriv_assie4_news', 'assie4_ajax_news');
add_action('wp_ajax_assie4_news',        'assie4_ajax_news');
function assie4_ajax_news() {
    wp_send_json( assie4_get_berita_items(9, 15) );
}

/* ══════════════════════════════════════════════════════
   AUTO-CLEAR CACHE — hapus cache berita otomatis
   saat post baru dipublish / diupdate / dihapus
   ══════════════════════════════════════════════════════ */
function assie4_clear_berita_cache( $post_id, $post = null, $update = false ) {
    // Hanya proses post type 'post' (bukan page, attachment, dll)
    $post_obj = $post ?: get_post( $post_id );
    if ( ! $post_obj || $post_obj->post_type !== 'post' ) return;

    // Cek apakah post masuk kategori assie-4-tahun-2026
    $cat = get_category_by_slug( 'assie-4-tahun-2026' );
    if ( ! $cat ) {
        // Kalau kategori tidak ditemukan, hapus cache saja supaya aman
        delete_transient( 'assie4_news_cache' );
        return;
    }
    if ( in_category( $cat->term_id, $post_id ) ) {
        delete_transient( 'assie4_news_cache' );
    }
}

// Saat post dipublish / status berubah jadi publish
add_action( 'transition_post_status', function( $new, $old, $post ) {
    if ( $new === 'publish' || $old === 'publish' ) {
        assie4_clear_berita_cache( $post->ID, $post );
    }
}, 10, 3 );

// Saat post diupdate
add_action( 'post_updated', 'assie4_clear_berita_cache', 10, 1 );

// Saat post dihapus / ditrash
add_action( 'trashed_post',  'assie4_clear_berita_cache', 10, 1 );
add_action( 'deleted_post',  'assie4_clear_berita_cache', 10, 1 );

// Saat thumbnail/featured image diubah
add_action( 'updated_post_meta', function( $meta_id, $post_id, $meta_key ) {
    if ( $meta_key === '_thumbnail_id' ) {
        assie4_clear_berita_cache( $post_id );
    }
}, 10, 3 );



add_action('wp_ajax_nopriv_assie4_get_stats', 'assie4_ajax_stats');
add_action('wp_ajax_assie4_get_stats',        'assie4_ajax_stats');
function assie4_ajax_stats() {
    $today = 0; $total = 0; $top = [];
    if ( function_exists('assie4_presensi_get_stats') ) {
        $s = assie4_presensi_get_stats();
        $today = $s['today'] ?? 0;
        $total = $s['total'] ?? 0;
        $top   = $s['top']   ?? [];
    }
    wp_send_json(['today'=>$today,'total'=>$total,'top'=>$top]);
}
