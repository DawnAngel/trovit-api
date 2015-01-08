<?php

namespace DawnAngel\TrovitApi;

use \Exception;

/**
 * Trovit Api Class
 *
 * @author Eric Pinto <ericpinto1985@gmail.com>
 */
class TrovitApi
{
    /**
     * Api URI value
     * @var string
     */
    protected static $API_URI = 'https://api.trovit.com/v2/{vertical}/{resource}';

    /**
     * Api token value
     * @var string
     */
    protected static $TOKEN;

    /**
     * Request options cache
     * @var array
     */
    protected static $REQUEST_OPTIONS_CACHE;

    const RESOURCE_ADS = 'ads';

    const VERTICAL_HOMES = 'homes';
    const VERTICAL_CARS  = 'cars';
    const VERTICAL_JOBS  = 'jobs';


    /**
     * Setter for Api token
     *
     * @param string $token The new Api token
     */
    public static function setToken($token)
    {
        self::$TOKEN = $token;

        /** Reset the REQUEST OPTIONS when new apikey is setted */
        if (isset(self::$REQUEST_OPTIONS_CACHE)) {
            self::$REQUEST_OPTIONS_CACHE = null;
        }
    }

    /**
     * Setter for Api URI
     * (This could be used for testing purposes)
     *
     * @param string $apiUri The new Api URI
     */
    public static function setApiUri($apiUri)
    {
        self::$API_URI = $apiUri;
    }

    /**
     * Configure the inner request options
     * (Lazy loaded)
     *
     * @return array Request options
     */
    protected static function getRequestOptions()
    {
        if (!isset(self::$REQUEST_OPTIONS_CACHE)) {
            self::$REQUEST_OPTIONS_CACHE = array(
                'http' => array(
                    'method'  => 'GET',
                    'header'  => "X-Client-ID: " . self::$TOKEN . "\r\n",
                )
            );
        }

        return self::$REQUEST_OPTIONS_CACHE;
    }

    /**
     * Handle all the data collection
     *
     * @param  string $url Request url
     *
     * @return string
     */
    protected static function getUrlData($url)
    {
        $context = stream_context_create(self::getRequestOptions());

        return @file_get_contents($url, false, $context);
    }


    /**
     * Do the request against the ApiUri and return the Api response
     *
     * @param  string  $vertical Vertical from the class constants
     * @param  array   $params   Request params
     * @param  string  $resource Resource from the class constants
     * @param  boolean $debug    Send debug information to the standard output
     *
     * @return string  Response as JSON string
     */
    public static function doRequestJson($vertical, $params, $resource = self::RESOURCE_ADS, $debug = false)
    {
        $requestUrl = str_replace(
            array('{vertical}', '{resource}'),
            array($vertical, $resource),
            self::$API_URI
        );
        $requestUrl .= '?' . http_build_query($params);

        if ($debug) {
            printf("API url: %s\n", $requestUrl);
        }

        try {
            $result = self::getUrlData($requestUrl);
        } catch (Exception $e) {
            $result = false;
        }

        if ($debug) {
            printf("Request status: %s\n", $result === false ? 'Fail' : 'OK!');
        }

        return $result;
    }

    /**
     * Do the request against the ApiUri and return the Api response
     *
     * @param  string  $vertical Vertical from the class constants
     * @param  array   $params   Request params
     * @param  string  $resource Resource from the class constants
     * @param  boolean $debug    Send debug information to the standard output
     *
     * @return array   Response
     */
    public static function doRequest($vertical, $params, $resource = self::RESOURCE_ADS, $debug = false)
    {
        $responseJson = self::doRequestJson($vertical, $params, $resource, $debug);

        return ($responseJson !== false) ? json_decode($responseJson, true) : false;
    }
}
