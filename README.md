trovit-api
==========

[![Latest Stable Version](https://poser.pugx.org/dawnangel/trovit-api/v/stable.svg)](https://packagist.org/packages/dawnangel/trovit-api) [![Total Downloads](https://poser.pugx.org/dawnangel/trovit-api/downloads.svg)](https://packagist.org/packages/dawnangel/trovit-api) [![License](https://poser.pugx.org/dawnangel/trovit-api/license.svg)](https://packagist.org/packages/dawnangel/trovit-api)

A simple PHP implementation of Trovit Affiliates API

Tests Status [![Build Status](https://travis-ci.org/DawnAngel/trovit-api.svg?branch=master)](https://travis-ci.org/DawnAngel/trovit-api)

Configuration
-------------

Before using this implementation you need to get a API token from the main Trovit Affiliates website:

https://publishers.trovit.com/

First you need to signup as a Trovit Affiliate providing your business details and website.

After their acceptance of your signup, you have to go to the "API Feed" section and provide some information about how you will use this API service for, accept the terms and conditions and in a short time they will provide you with the API token you need.

Usage
-----

First in your code depending if you are using the composer autoload integration or a direct "require" method you need some lines of code.

* For composer autoload.php:

```php
use DawnAngel\TrovitApi\TrovitApi;

require_once '<VENDOR_DIR>/autoload.php';
```

* For direct require:

```php
use DawnAngel\TrovitApi\TrovitApi;

require_once '<TROVIT_API_LIB_DIR>/TrovitApi.php';
```

You'll need to replace the following "\<YOUR-TOKEN-ID\>" in the code with your real API token key:

```php
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
```

Then on the point you want to use the API request code:

```php
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
```

Thanks for using this library, I hope you enjoy it.
