<?php
/**
 * PSLZME Page Template
 *
 * Fully self-contained: header, content, footer
 * Theme-independent
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Load the decryption controller
$dc = DecryptionController::get_instance();

// Only redirect on frontend if variables are not set
if ( ! is_admin() && ! defined( 'REST_REQUEST' ) && ! isset($_GET['elementor-preview']) && ! $dc->vars_set() ) {
    wp_redirect( home_url() );
    exit;
}


get_header();
while(have_posts()) : the_post();
    the_content();
endwhile;
get_footer();