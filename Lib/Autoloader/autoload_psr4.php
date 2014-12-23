<?php

/**
 * Autoloader PSR-4 class configuration file
 *
 * @author Eric Pinto <ericpinto1985@gmail.com>
 */

$vendorDir = dirname(dirname(__FILE__));
$baseDir   = dirname($vendorDir);

return array(
    'Lib\\Trovit\\' => array($vendorDir . '/Trovit'),
);
