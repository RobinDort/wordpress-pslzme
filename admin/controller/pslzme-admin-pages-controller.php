<?php

/**
 * Class that is used to create special pslzme pages for handling cookie acception and locked pslzme queries.
 */
class PslzmeAdminPagesController {

    private const ACCEPTION_PAGE_OPTION = "pslzme_accept_page_id";
    private const DECLINE_PAGE_OPTION = "pslzme_decline_page_id";


    /**
     * 
     * constructor.
     * 
     */
    public function __construct() {}

    /**
     * 
     * This function creates a new page called pslzme-accept.
     * The page is displayed as a intermediate step during the pslzme cookiebanner process until the user entered the right credentials and accepted the cookie.
     * @return The newly created page ID. 
     * 
     */
    public function create_pslzme_acception_page() {
        $pageTitle = "Pslzme-Accept";
        $pageSlug = "pslzme-accept";

        $pageContent = 
        "<h1 style='text-align: left;'>Dear visitor,</h1>
        <p style='text-align: left;'>You visited our website via a revolutionary pslz<strong>me</strong> link.</p>
        <p style='text-align: left;'>With pslz<strong>me</strong> we are able to <strong>personalize</strong> our website for you <strong>in compliance with GDPR</strong>, if you allow us to do so.</p>
        <p style='text-align: left;'>Please let us know via the pslz<strong>me</strong> pop-up whether we may personalize our website for you or whether you do not wish us to do so.</p>
        <p style='text-align: left;'><strong>Don't worry</strong>: pslz<strong>me</strong> runs exclusively on our servers in Germany and there is no data exchange with other servers.</p>
        <p style='text-align: left;'>If you object to the pslz<strong>me</strong> function, we will simply redirect you to our standard website and your data will not be used in any way.</p>
        <p style='text-align: left;'>However, if you agree, you will experience a <strong>veritable firework </strong>display of almost <strong>limitless possibilities</strong> that are available via our <strong>sophisticated system</strong> in the areas of <strong>programmatic web</strong> and even <strong>programmatic print</strong> and which we would also like to offer you for use <strong>on your own websites</strong>.</p>
        ";

        $existing_page = get_page_by_title($pageTitle);
        if ($existing_page && $existing_page->post_status !== 'trash') {
            return $existing_page->ID; // page already exists
        }

        // 2. Build the post array per wp_insert_post requirement
        $post_data = [
            'post_title'   => wp_strip_all_tags( $pageTitle ),
            'post_name'    => $pageSlug,
            'post_content' => $pageContent,
            'post_status'  => 'publish',
            'post_type'    => 'page',
        ];

        // 3. Insert the post into the database
        $pageID = wp_insert_post( $post_data );

        // 4. Check for WP_Error or failure
        if ( is_wp_error( $pageID ) || $pageID === 0 ) {
            error_log( 'PSLZME: Failed to create accept page: ' . print_r( $pageID, true ) );
            return 0;
        }

        // 5. Save the page ID for later use
        update_option( self::ACCEPTION_PAGE_OPTION, $pageID );

        return $pageID;
    }



    /**
     * 
     * This function creates a new page called pslzme-decline.
     * The page is displayed whenever a plszme link has been locked because the user enter credentials wrong three times in a row.
     * @return The newly created page ID. 
     * 
     */
    public function create_pslzme_decline_page() {
        $pageTitle = "Pslzme-Decline";
        $pageSlug = "pslzme-decline";

        $pageContent = 
        "<h1 style='text-align: left;'><strong>Dear visitor,</strong></h1>
        <p style='text-align: left;'>For your security, the pslz<strong>me</strong> link you used was blocked after entering incorrect initials three or more times.</p>
        <p style='text-align: left;'>If this was not your fault and you wish to continue using our pslz<strong>me</strong> personalization link, please contact us and we will send you a new link.</p>
        <p style='text-align: left;'><strong>Of course, you can continue to use our non-personalized website without any restrictions.</strong></p>";

        $existing_page = get_page_by_title($pageTitle);
        if ($existing_page && $existing_page->post_status !== 'trash') {
            return $existing_page->ID; // page already exists
        }

        $post_data = [
            'post_title'   => wp_strip_all_tags( $pageTitle ),
            'post_name'    => $pageSlug,
            'post_content' => $pageContent,
            'post_status'  => 'publish',
            'post_type'    => 'page',
        ];

        // 3. Insert the post into the database
        $pageID = wp_insert_post( $post_data );

        // 4. Check for WP_Error or failure
        if ( is_wp_error( $pageID ) || $pageID === 0 ) {
            error_log( 'PSLZME: Failed to create decline page: ' . print_r( $pageID, true ) );
            return 0;
        }

        // 5. Save the page ID for later use
        update_option( self::DECLINE_PAGE_OPTION, $pageID );

        return $pageID;
    }

    /**
     * 
     * This function removes the pslzme acception page again is called during the deactivation of the plugin.
     * 
     */
    public function remove_pslzme_acception_page() {
        $acceptionPageID = get_option(self::ACCEPTION_PAGE_OPTION);

        // nothing to remove when the page does not exist anymore.
        if (!$acceptionPageID) return;

        wp_delete_post($acceptionPageID, true);
        // remove the option
        delete_option(self::ACCEPTION_PAGE_OPTION);

    }


    /**
     * 
     * This function removes the pslzme decline page again is called during the deactivation of the plugin.
     * 
     */
    public function remove_pslzme_decline_page() {
        $declinePageID = get_option(self::DECLINE_PAGE_OPTION);

        // nothing to remove when the page does not exist anymore.
        if (!$declinePageID) return;

        wp_delete_post($declinePageID, true);
        // remove the option
        delete_option(self::DECLINE_PAGE_OPTION);
        
    }

}
?>