<?php

use Lib\Trovit\TrovitApi;

require 'Lib/Trovit/TrovitApi.php';

/**
 * TrovitApi Token:
 *
 * Get your Token by signing up in the following url with your details
 *
 * https://publishers.trovit.com/
 */
define('TROVIT_API_TOKEN', '<YOUR-TOKEN-ID>');

// Set TrovitApi Token
TrovitApi::setToken(TROVIT_API_TOKEN);

$apiParams = array(
    // Main params for the request
    'country' => 'es',
    'what'    => 'piso',
    'where'   => '',
    'type'    => '2', /* 1 -> Homes for sale, 2 -> Homes for rent */

    // Filter params for the request
    'region' => 'barcelona',
    'city'   => 'barcelona',

    // Params for API configuration
    'page'     => '1',
    'per_page' => '10',
    'order'    => 'relevance',
);


$ads = TrovitApi::doRequest(TrovitApi::VERTICAL_HOMES, $apiParams);

if ($ads === false) {
    echo "The HTTP request failed!\n";

} else {
    echo "The API Request was successful!\n";
    print_r($ads);
}
