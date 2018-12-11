<?php


/**
 * Class Request
 */


class Request {


    private static $username = null;
    private static $password = null;
    private static $urlRoot = null;


    /**
     * Ensure the authentication before processing a request.
     *
     * @return null
     * @throws Exception
     */
    private static function ensureInitialized() {

        // If not set:
        if (!isset(Request::$username)) {
            // Verify the config.ini existence.
            if (file_exists(PROABONO_CONFIG)) {

                // Parse ini file on an associative array.
                $authentication = parse_ini_file(PROABONO_CONFIG, true);

                // Setting of ensure properties.
                Request::$username = $authentication['username'];
                Request::$password = $authentication['password'];
                Request::$urlRoot = $authentication['api_endpoint'];

            } else {
                throw new Exception("Create the config.ini first.");
            }

        }
    }


    /**
     * Administration of the api call, using curl to make the request.
     *
     * @param $url
     * @return Response
     * @throws Exception
     */
    public static function get($url) {
        // Initialization of the configuration.
        Request::ensureInitialized();

        // Initialization of curl.
        $ch = curl_init(Request::$urlRoot . $url);

        // Settings of curl.
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        ));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, Request::$username . ":" . Request::$password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Perform the request and return the raw data from the response.
        $rawData = curl_exec($ch);

        // HTTP Code (after perform curl, before closing curl).
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Closing curl.
        curl_close($ch);

        return Request::prepareResponse($rawData, $http_status);
    }


    /**
     * Administration of the api call, using curl to make the request.
     *
     * @param $url
     * @param $input
     * @return Response
     * @throws Exception
     */
    public static function post($url, $input) {
        // Initialisation des paramètres de configuration.
        Request::ensureInitialized();

        $jsonData = json_encode($input);

        // Initialization of curl.
        $ch = curl_init(Request::$urlRoot . $url);

        // Settings of curl.
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData),
            'Accept: application/json'
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, Request::$username . ":" . Request::$password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Perform the request and return the raw data from the response.
        $rawData = curl_exec($ch);

        // HTTP Code (after perform curl, before closing curl).
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Closing curl.
        curl_close($ch);

        return Request::prepareResponse($rawData, $http_status);
    }


    /**
     * Prepare the response after the curl processing.
     *
     * Do the error administration,
     * return a ProAbonoError object if is_succes turn false.
     *
     * @param $rawData
     * @param $http_status
     * @return Response
     */
    private static function prepareResponse($rawData, $http_status) {
    $decoded = json_decode($rawData);

    $response = new Response();
    $response->status = $http_status;

    // Case Success:
    if ($response->is_success()) {
        $response->data = $decoded;
    }

    // Case Code 422:
    else if ($response->status == 422) {

        $response->errors = array();

        foreach ($decoded as $item) {

            $error = new ProAbonoError();

            $error->code = isset($item->Code) ? $item->Code : null;
            $error->target = isset($item->Target) ? $item->Target : null;
            $error->message = isset($item->Message) ? $item->Message : null;
            $error->exception = isset($item->Exception) ? $item->Exception : null;

            array_push($response->errors, $error);
        }
    }

    // Case Single Error:
    else {
        $error = new ProAbonoError();

        $error->code = isset($decoded->Code) ? $decoded->Code : null;
        $error->target = isset($decoded->Target) ? $decoded->Target : null;
        $error->message = isset($decoded->Message) ? $decoded->Message : null;
        $error->exception = isset($decoded->Exception) ? $decoded->Exception : null;

        $response->error = $error;
    }
    return $response;
}


}