<?php
/**
 * Plugin Name: ASSIE IV - Pameran Digital
 * Plugin URI: https://pasinbis.unair.ac.id
 * Description: Pameran digital ASSIE IV 2026. Shortcode [assie4_pameran] dan [assie4_berita].
 * Version: 2.10.1
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
define( 'ASSIE4_PAMERAN_VER',  '2.10.1' );
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

// Use the official UNAIR blue logo as the browser tab icon.
add_action( 'wp', function() {
    global $post;
    if ( ! is_a( $post, 'WP_Post' ) || ! has_shortcode( $post->post_content, 'assie4_pameran' ) ) return;
    remove_action( 'wp_head', 'wp_site_icon', 99 );
    add_action( 'wp_head', function() {
        $icon = 'https://fst.unair.ac.id/wp-content/uploads/2024/03/Logo-Branding-UNAIR-biru-1024x1024.png?ver=' . ASSIE4_PAMERAN_VER;
        echo '<link rel="icon" href="' . esc_url( $icon ) . '" type="image/png">' . "\n";
        echo '<link rel="apple-touch-icon" href="' . esc_url( $icon ) . '">' . "\n";
    }, 2 );
});

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

    // Selalu gunakan versi plugin agar perubahan aset frontend tidak tertahan cache lama.
    $ver = ASSIE4_PAMERAN_VER;

    wp_enqueue_style(  'assie4-fonts',
        'https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap',
        [], null );
    wp_enqueue_style(  'assie4-pameran-css',
        ASSIE4_PAMERAN_URL . 'assets/assie4-pameran.css', ['assie4-fonts'], $ver );
    wp_enqueue_script( 'assie4-pameran-js',
        ASSIE4_PAMERAN_URL . 'assets/assie4-pameran.js', [], $ver, true );

    $tenants = assie4_get_tenants();
    $slides  = get_option( ASSIE4_OPT_SLIDES, assie4_default_slides() );
    if ( ! is_array( $slides ) ) {
        $slides = assie4_default_slides();
    }

    $db  = wp_json_encode([
        'info'    => get_option( 'assie4_pameran_info',    assie4_default_info() ),
        'slides'  => $slides,
        'ticker'  => get_option( 'assie4_pameran_ticker',  assie4_default_ticker() ),
        'rundown' => get_option( 'assie4_pameran_rundown', assie4_default_rundown() ),
        'tenants' => $tenants,
        'denah'   => get_option( 'assie4_pameran_denah', [] ),
        'denahBaseImage'    => esc_url_raw( get_option( 'assie4_pameran_denah_base_image', '' ) ),
        'denahDefaultImage' => ASSIE4_PAMERAN_URL . 'assets/denah-assie-iv-reference.png',
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
   Hanya mengambil berita & gambar asli dari pasinbis.unair.ac.id (TANPA AI)
   Disimpan di temporary RAM laptop / cache runtime (tidak disimpan di database)
   ══════════════════════════════════════════════════════ */
function assie4_get_berita_items( $limit = 9, $cache_minutes = 30 ) {
    // 1. Cek runtime RAM cache di memory PHP
    if ( isset( $GLOBALS['assie4_news_memory_cache'] ) && is_array( $GLOBALS['assie4_news_memory_cache'] ) && ! empty( $GLOBALS['assie4_news_memory_cache'] ) ) {
        return array_slice( $GLOBALS['assie4_news_memory_cache'], 0, $limit );
    }

    // 2. Cek cache RAM laptop di direktori temporary OS (tidak masuk database)
    $temp_dir       = function_exists( 'get_temp_dir' ) ? get_temp_dir() : sys_get_temp_dir();
    $cache_file     = rtrim( $temp_dir, '/\\' ) . DIRECTORY_SEPARATOR . 'assie4_news_ram_cache_v2.json';
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

    // 3. Auto-Scraping Berita Asli dari pasinbis.unair.ac.id (Setiap 30 Menit Sekali)
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

    // 6. Simpan ke Cache RAM Laptop (File temporary & Global variable, TANPA menyentuh database)
    @file_put_contents( $cache_file, json_encode( $items, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) );
    $GLOBALS['assie4_news_memory_cache'] = $items;

    return array_slice( $items, 0, $limit );
}

/**
 * Auto-scraper berita asli khusus dari pasinbis.unair.ac.id (30 Menit Sekali)
 * Menggunakan link asli, tanggal asli, dan gambar asli upload PASINBIS (Tanpa Gambar AI)
 */
function assie4_auto_scrape_pasinbis_news() {
    $scraped_items = [];
    $endpoints = [
        'https://pasinbis.unair.ac.id/wp-json/wp/v2/posts?_embed=1&categories=30&per_page=6',
        'https://pasinbis.unair.ac.id/wp-json/wp/v2/posts?_embed=1&per_page=8'
    ];

    $seen_links = [];

    foreach ( $endpoints as $url ) {
        $response = wp_remote_get( $url, [
            'timeout'    => 6,
            'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36',
            'headers'    => [
                'Accept' => 'application/json, text/plain, */*',
            ],
        ]);

        if ( ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200 ) {
            $body  = wp_remote_retrieve_body( $response );
            $posts = json_decode( $body, true );

            if ( is_array( $posts ) ) {
                foreach ( $posts as $p ) {
                    $link = ! empty( $p['link'] ) ? esc_url_raw( $p['link'] ) : '';
                    if ( empty( $link ) || isset( $seen_links[ $link ] ) ) continue;
                    $seen_links[ $link ] = true;

                    $title = ! empty( $p['title']['rendered'] ) ? html_entity_decode( wp_strip_all_tags( $p['title']['rendered'] ), ENT_QUOTES | ENT_HTML5, 'UTF-8' ) : '';
                    $date  = ! empty( $p['date'] ) ? $p['date'] : date( 'c' );

                    // Excerpt asli dari pasinbis
                    $desc = '';
                    if ( ! empty( $p['uagb_excerpt'] ) ) {
                        $desc = wp_strip_all_tags( $p['uagb_excerpt'] );
                    } elseif ( ! empty( $p['excerpt']['rendered'] ) ) {
                        $desc = wp_strip_all_tags( $p['excerpt']['rendered'] );
                    }
                    $desc = mb_strimwidth( $desc, 0, 160, '...' );

                    // Gambar thumbnail asli upload PASINBIS (bukan AI)
                    $thumb = '';
                    if ( ! empty( $p['_embedded']['wp:featuredmedia'][0]['source_url'] ) ) {
                        $thumb = esc_url_raw( $p['_embedded']['wp:featuredmedia'][0]['source_url'] );
                    } elseif ( ! empty( $p['uagb_featured_image_src'] ) && is_array( $p['uagb_featured_image_src'] ) ) {
                        foreach ( [ 'large', 'medium_large', 'full' ] as $sz ) {
                            if ( ! empty( $p['uagb_featured_image_src'][ $sz ][0] ) ) {
                                $thumb = esc_url_raw( $p['uagb_featured_image_src'][ $sz ][0] );
                                break;
                            }
                        }
                    }

                    if ( $title && $link ) {
                        $scraped_items[] = [
                            'title' => $title,
                            'link'  => $link,
                            'date'  => $date,
                            'desc'  => $desc,
                            'thumb' => $thumb,
                        ];
                    }
                }
            }
        }
    }

    // Dataset berita asli 100% pasinbis.unair.ac.id jika server eksternal offline / terblokir firewall
    if ( empty( $scraped_items ) ) {
        $scraped_items = [
            [
                'title' => 'Inkubator Bisnis PASINBIS UNAIR Terima Kunjungan INWINOV BRIDA Jawa Tengah, Bahas Penguatan Tata Kelola dan Kolaborasi Inkubasi Startup',
                'link'  => 'https://pasinbis.unair.ac.id/2026/09/15/inkubator-bisnis-pasinbis-unair-terima-kunjungan-inwinov-brida-jawa-tengah-bahas-penguatan-tata-kelola-dan-kolaborasi-inkubasi-startup/',
                'date'  => '2026-09-15T04:13:20',
                'desc'  => 'Inkubator Bisnis PASINBIS UNAIR menerima kunjungan kerja dari INWINOV BRIDA Jawa Tengah untuk memperkuat tata kelola serta kerja sama inkubasi tenant inovasi...',
                'thumb' => 'https://pasinbis.unair.ac.id/wp-content/uploads/2026/09/INWINOV-BRIDA-Jateng-3.jpg',
            ],
            [
                'title' => 'PASINBIS UNAIR Dorong Hilirisasi Inovasi melalui Surabaya Great Expo 2026',
                'link'  => 'https://pasinbis.unair.ac.id/2026/09/01/pasinbis-unair-dorong-hilirisasi-inovasi-melalui-surabaya-great-expo-2026/',
                'date'  => '2026-09-01T08:45:33',
                'desc'  => 'PASINBIS UNAIR aktif memperkenalkan berbagai produk inovasi hasil riset unggulan sivitas akademika UNAIR kepada masyarakat di Surabaya Great Expo 2026...',
                'thumb' => 'https://pasinbis.unair.ac.id/wp-content/uploads/2026/09/SGE-2026-2.png',
            ],
            [
                'title' => 'Airlangga Startup Bootcamp 2026 Bekali Tenant dengan Strategi Membangun Startup Inovatif',
                'link'  => 'https://pasinbis.unair.ac.id/2026/07/30/airlangga-startup-bootcamp-2026-bekali-tenant-dengan-strategi-membangun-startup-yang-inovatif-dan-berkelanjutan/',
                'date'  => '2026-07-30T01:42:37',
                'desc'  => 'Airlangga Startup Bootcamp 2026 membekali puluhan tenant inovasi dengan strategi validasi produk, manajemen tim, dan kesiapan pasar berkelanjutan...',
                'thumb' => 'https://pasinbis.unair.ac.id/wp-content/uploads/2026/07/Bootcamp-10-10.jpg',
            ],
            [
                'title' => 'ASSIE IV 2026: Hadirkan Satu Ruang untuk Ribuan Inovasi dan Kolaborasi',
                'link'  => 'https://pasinbis.unair.ac.id/2026/07/08/assie-iv-2026-hadirkan-satu-ruang-untuk-ribuan-inovasi-dan-kolaborasi/',
                'date'  => '2026-07-08T04:07:58',
                'desc'  => 'Airlangga StartUp Summit and Innovation Expo (ASSIE IV 2026) kembali hadir mempertemukan ratusan inovasi kampus, startup potensial, dan mitra industri...',
                'thumb' => 'https://pasinbis.unair.ac.id/wp-content/uploads/2026/07/poster-e-flyer-ASSIE-IV-2.png',
            ],
            [
                'title' => 'BRINOVASI Vol 4 Resmi Membuka Kontribusi: Kirim Karyamu Sekarang!',
                'link'  => 'https://pasinbis.unair.ac.id/2026/05/21/brinovasi-vol-4-resmi-membuka-kontribusi-kirim-karyamu-sekarang/',
                'date'  => '2026-05-21T07:52:05',
                'desc'  => 'Pusat Akselerasi Inovasi dan Bisnis Universitas Airlangga (PASINBIS Unair) kembali menghadirkan edisi terbaru majalah inovasinya BRINOVASI Vol 4...',
                'thumb' => 'https://pasinbis.unair.ac.id/wp-content/uploads/2026/05/Blue-Green-and-White-Modern-Earth-Day-Instagram-Post.png',
            ],
            [
                'title' => 'ASSIE III 2025 Resmi Dibuka: Hadirkan 120 Booth Inovasi dan Kolaborasi Perguruan Tinggi di Atrium Grand City',
                'link'  => 'https://pasinbis.unair.ac.id/2025/11/18/1305/',
                'date'  => '2025-11-18T09:39:57',
                'desc'  => 'ASSIE III 2025 Resmi Dibuka: Hadirkan 120 Booth Inovasi dan Kolaborasi Perguruan Tinggi di Atrium Grand City Surabaya, Tiga hari gelaran Airlangga...',
                'thumb' => 'https://pasinbis.unair.ac.id/wp-content/uploads/2025/11/DSC02319.jpg',
            ],
            [
                'title' => 'Airlangga StartUp Summit and Innovation Expo (ASSIE III) 2025: Wadah Kolaborasi Inovasi dan Startup Jawa Timur',
                'link'  => 'https://pasinbis.unair.ac.id/2025/11/04/airlangga-startup-summit-and-innovation-expo-assie-iii-2025-wadah-kolaborasi-inovasi-dan-startup-jawa-timur/',
                'date'  => '2025-11-04T08:51:33',
                'desc'  => 'Airlangga StartUp Summit and Innovation Expo (ASSIE III 2025) menjadi wadah bertemunya para inovator kampus, startup, dan industri Jawa Timur...',
                'thumb' => 'https://pasinbis.unair.ac.id/wp-content/uploads/2025/11/IMG_0655.jpg',
            ],
            [
                'title' => 'PASINBIS Bersama Warek EEPB Lakukan Peninjauan Produk Inovasi UNAIR untuk Percepatan Komersialisasi dan Hilirisasi',
                'link'  => 'https://pasinbis.unair.ac.id/2026/08/21/pasinbis-bersama-warek-eepb-lakukan-peninjauan-produk-inovasi-unair-untuk-percepatan-komersialisasi-dan-hilirisasi/',
                'date'  => '2026-08-21T05:21:26',
                'desc'  => 'PASINBIS bersama Wakil Rektor Bidang Riset, Inovasi, dan Community Development melakukan peninjauan produk inovasi untuk percepatan hilirisasi riset...',
                'thumb' => 'https://pasinbis.unair.ac.id/wp-content/uploads/2026/08/Kunjungan-Fakultas-Hilirisasi-3.jpg',
            ],
        ];
    }

    return $scraped_items;
}

/* ══════════════════════════════════════════════════════
   AJAX — endpoint untuk page pameran
   ══════════════════════════════════════════════════════ */
/* ══════════════════════════════════════════════════════
   AUTO-SCRAPING WP-CRON (Setiap 30 Menit Sekali)
   Menjaga cache RAM laptop selalu fresh tanpa sentuh DB
   ══════════════════════════════════════════════════════ */
add_filter( 'cron_schedules', function( $schedules ) {
    $schedules['assie4_every_30_mins'] = [
        'interval' => 30 * MINUTE_IN_SECONDS,
        'display'  => 'Setiap 30 Menit (ASSIE Auto-Scrape)',
    ];
    return $schedules;
});

if ( ! wp_next_scheduled( 'assie4_auto_scrape_cron_hook' ) ) {
    wp_schedule_event( time(), 'assie4_every_30_mins', 'assie4_auto_scrape_cron_hook' );
}

add_action( 'assie4_auto_scrape_cron_hook', function() {
    $items = assie4_auto_scrape_pasinbis_news();
    if ( ! empty( $items ) ) {
        $temp_dir   = function_exists( 'get_temp_dir' ) ? get_temp_dir() : sys_get_temp_dir();
        $cache_file = rtrim( $temp_dir, '/\\' ) . DIRECTORY_SEPARATOR . 'assie4_news_ram_cache_v2.json';
        @file_put_contents( $cache_file, json_encode( $items, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) );
        $GLOBALS['assie4_news_memory_cache'] = $items;
    }
});

add_action('wp_ajax_nopriv_assie4_news', 'assie4_ajax_news');
add_action('wp_ajax_assie4_news',        'assie4_ajax_news');
function assie4_ajax_news() {
    wp_send_json( assie4_get_berita_items(9, 30) );
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
