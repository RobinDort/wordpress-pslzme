<?php
class PslzmePublicRouteController {

    public function __construct() {}

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
                $response = $api->handleQueryAcception($requestData);
                break;

            case 'query-lock-check':
                $response = $api->handleQueryLockCheck($requestData);
                break;

            case 'extract-greeting-data':
                $response = $api->handleGreetingDataExtraction($requestData);
                break;

            case 'compare-link-owner':
                $response = $api->handleCompareLinkOwner($requestData);
                break;

            default:
                return new WP_REST_Response(['error' => 'Unknown request'], 400);
        }

        return new WP_REST_Response($response);
    }
}
?>