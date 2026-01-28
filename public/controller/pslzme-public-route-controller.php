<?php
class PslzmePublicRouteController {

    public function __construct() {}

    public function handleRoutes($request) {
        // $requestData = $request->get_param('data');
        // $requestFunction = $request->get_param("request");

        //  if (!$requestData || !$requestFunction) {
        //     return new WP_REST_Response(['error' => 'data or request not set'], 400);
        // }

        // // init API here
        // $api = new PslzmePublicAPI();

        $response = "Test";

        // switch ($requestFunction) {
        //     // case 'query-acception':
        //     //     $response = $api->handle_query_acception($requestData);
        //     //     break;

        //     // case 'query-lock-check':
        //     //     $response = $api->handle_query_lock_check($requestData);
        //     //     break;

        //     // case 'extract-greeting-data':
        //     //     $response = $api->handle_greeting_data_extraction($requestData);
        //     //     break;

        //     // case 'compare-link-owner':
        //     //     $response = $api->handle_compare_link_owner($requestData);
        //     //     break;

        //     default:
        //         return new WP_REST_Response(['error' => 'Unknown request'], 400);
        // }

        return new WP_REST_Response(['msg' => $response]);
    }
}
?>