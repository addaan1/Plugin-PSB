<?php
/**
 * Full-page template — ASSIE IV Pameran Digital
 * Menggantikan template tema sehingga halaman tampil tanpa header/footer.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

// WordPress head (enqueue CSS/JS tetap dijalankan)
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pameran Digital — ASSIE IV 2026</title>
<?php wp_head(); ?>
</head>
<body <?php body_class('assie4-fullpage'); ?>>
<?php

while ( have_posts() ) :
    the_post();
    the_content();
endwhile;

wp_footer();
?>
</body>
</html>
