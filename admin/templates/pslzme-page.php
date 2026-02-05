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
if ( ! is_admin() && ! defined( 'REST_REQUEST' ) && ! $dc->vars_set() ) {
    wp_redirect( home_url() );
    exit;
}


get_header();
the_content();
get_footer();