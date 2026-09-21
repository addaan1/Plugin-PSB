<?php
/**
 * Plugin Name: ASSIE IV - Pameran Digital
 * Plugin URI: https://pasinbis.unair.ac.id
 * Description: Pameran digital ASSIE IV 2026. Shortcode [assie4_pameran] dan [assie4_berita].
 * Version: 2.8.7
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
define( 'ASSIE4_PAMERAN_VER',  '2.8.7' );
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

    $db  = wp_json_encode([
        'info'    => get_option( 'assie4_pameran_info',    assie4_default_info() ),
        'slides'  => get_option( 'assie4_pameran_slides',  assie4_default_slides() ),
        'ticker'  => get_option( 'assie4_pameran_ticker',  assie4_default_ticker() ),
        'rundown' => get_option( 'assie4_pameran_rundown', assie4_default_rundown() ),
        'tenants' => $tenants,
        'denah'   => get_option( 'assie4_pameran_denah', [] ),
    ], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT );

    $cfg = wp_json_encode([
        'presensiUrl' => home_url('/presensi-booth-assie4/'),
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
   FUNGSI FETCH BERITA — dipakai shortcode + AJAX
   ══════════════════════════════════════════════════════ */
function assie4_get_berita_items( $limit = 9, $cache_minutes = 15 ) {
    $cache_key = 'assie4_news_cache';
    $cached    = get_transient( $cache_key );
    if ( $cached !== false ) return array_slice( $cached, 0, $limit );

    $items = [];

    /* ── Metode 1: WP_Query langsung (paling cepat & akurat) ── */
    $cat = get_category_by_slug( 'assie-4-tahun-2026' );
    if ( $cat && ! is_wp_error( $cat ) ) {
        $q = new WP_Query([
            'cat'            => $cat->term_id,
            'posts_per_page' => ( $limit === -1 ? -1 : intval($limit) ),
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
            'no_found_rows'  => true,
        ]);
        if ( $q->have_posts() ) {
            while ( $q->have_posts() ) {
                $q->the_post();
                $pid   = get_the_ID();
                $thumb = '';
                if ( has_post_thumbnail( $pid ) ) {
                    $thumb = get_the_post_thumbnail_url( $pid, 'medium' );
                }
                $items[] = [
                    'title' => html_entity_decode( get_the_title(), ENT_QUOTES | ENT_HTML5, 'UTF-8' ),
                    'link'  => get_permalink(),
                    'date'  => get_the_date( 'c' ),
                    'desc'  => mb_strimwidth( wp_strip_all_tags( get_the_excerpt() ), 0, 160, '…' ),
                    'thumb' => $thumb ?: '',
                ];
            }
            wp_reset_postdata();
        }
    }

    /* ── Metode 2: Fallback WP REST API (jika WP_Query gagal) ── */
    if ( empty( $items ) ) {
        $cat_obj = get_category_by_slug( 'assie-4-tahun-2026' );
        $cat_id  = $cat_obj ? $cat_obj->term_id : 0;
        if ( $cat_id ) {
            $api_url = rest_url( 'wp/v2/posts' );
            $url     = add_query_arg([
                'categories' => $cat_id,
                'per_page'   => $limit,
                'orderby'    => 'date',
                'order'      => 'desc',
                '_fields'    => 'id,title,link,date,excerpt,_links',
            ], $api_url );
            $r = wp_remote_get( $url, [ 'timeout' => 10 ] );
            if ( ! is_wp_error( $r ) && wp_remote_retrieve_response_code( $r ) === 200 ) {
                $posts = json_decode( wp_remote_retrieve_body( $r ), true );
                if ( is_array( $posts ) ) {
                    foreach ( $posts as $p ) {
                        $thumb = '';
                        if ( isset( $p['_links']['wp:featuredmedia'][0]['href'] ) ) {
                            $mr = wp_remote_get( $p['_links']['wp:featuredmedia'][0]['href'] . '?_fields=source_url', [ 'timeout' => 5 ] );
                            if ( ! is_wp_error( $mr ) ) {
                                $md = json_decode( wp_remote_retrieve_body( $mr ), true );
                                $thumb = $md['source_url'] ?? '';
                            }
                        }
                        $items[] = [
                            'title' => html_entity_decode( $p['title']['rendered'] ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8' ),
                            'link'  => $p['link'] ?? '',
                            'date'  => $p['date'] ?? '',
                            'desc'  => mb_strimwidth( wp_strip_all_tags( $p['excerpt']['rendered'] ?? '' ), 0, 160, '…' ),
                            'thumb' => $thumb,
                        ];
                    }
                }
            }
        }
    }


    /* ── Merge berita eksternal (input manual admin) ── */
    $ext_items = get_option( 'assie4_berita_eksternal', [] );
    foreach ( (array) $ext_items as $e ) {
        if ( empty($e['title']) || empty($e['link']) ) continue;
        $items[] = [
            'title' => $e['title'],
            'link'  => $e['link'],
            'date'  => ! empty($e['date']) ? $e['date'] . 'T00:00:00+07:00' : '',
            'desc'  => $e['desc'] ?? '',
            'thumb' => $e['thumb'] ?? '',
        ];
    }

    /* ── Urutkan semua berita by tanggal terbaru ── */
    usort( $items, function( $a, $b ) {
        $da = strtotime( $a['date'] ?? '' ) ?: 0;
        $db = strtotime( $b['date'] ?? '' ) ?: 0;
        return $db - $da;
    });

    set_transient( $cache_key, $items, $cache_minutes * MINUTE_IN_SECONDS );
    return array_slice( $items, 0, $limit );
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
