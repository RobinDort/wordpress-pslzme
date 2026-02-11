<?php

/**
 * Class that handles all requests to the pslzme routes.
 */
class PslzmePublicRouteController {

    public function __construct() {}

    /**
     * This function handles all request for the pslzme/v1 route.
     * @request Object containing data that is needed to handle the request. Object always contains both requestData and requestFunction.
     * @requestData contains all data needed for the request.
     * @requestFunction contains the operation key that is requested to handle.
     * @return REST_Response with the handled request server message.
     */
    public function handleRoutes($request) {
        $requestData = $request->get_param('data');
        $requestFunction = $request->get_param("request");

         if (!$requestData || !$requestFunction) {
            return new WP_REST_Response(['error' => 'data or request not set'], 400);
        }

        // init API here
        $api = new PslzmePublicAPI();

        switch ($requestFunction) {
            case 'query-acception':
                $response = $api->handle_query_acception($requestData);
                break;

            case 'query-lock-check':
                $response = $api->handle_query_lock_check($requestData);
                break;

            case 'extract-greeting-data':
                $response = $api->handle_greeting_data_extraction($requestData);
                break;

            case 'compare-link-owner':
                $response = $api->handle_compare_link_owner($requestData);
                break;

            default:
                return new WP_REST_Response(['error' => 'Unknown request'], 400);
        }

        return new WP_REST_Response([$response]);
    }
}
?>