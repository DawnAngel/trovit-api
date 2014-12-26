<?php

/**
 * Test for the TrovitApi Class
 *
 * @author Eric Pinto <ericpinto1985@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DawnAngel\TrovitApi {

// This allow us to configure the behavior of the "global mock"
$getContentsException = false;

function file_get_contents($url, $bool, $context)
{
    global $getContentsException;

    if ($getContentsException) {
        throw new \Exception("Error", 1);

    } else {
        return '{"result":"ok"}';
    }
}

function printf($format, $arg)
{
    return true;
}

}

namespace DawnAngel\TrovitApi\Tests {

use DawnAngel\TrovitApi\TrovitApi as SUT;

/**
 * Test class for TrovitApi.
 */
class TrovitApi extends \PHPUnit_Framework_TestCase
{
    const DEBUG_ACTIVE    = true;
    const FAKE_API_TOKEN  = '<API-TOKEN>';
    const FAKE_API_URI    = 'http://localhost/';
    const EXPECTED_HEADER = "X-Client-ID: <API-TOKEN>\r\n";

    private static $EXPECTED_URL_DATA_JSON  = '{"result":"ok"}';
    private static $EXPECTED_URL_DATA_ARRAY = array("result" => "ok");

    public function setUp()
    {
        global $getContentsException;
        $getContentsException = false;
    }

    public function testSetApiUri()
    {
        TrovitApiExtended::setApiUri(self::FAKE_API_URI);
        $this->assertEquals(self::FAKE_API_URI, TrovitApiExtended::getApiUri());
    }

    public function testGetRequestOptionsHeader()
    {
        TrovitApiExtended::setToken(self::FAKE_API_TOKEN);

        $requestOptions = TrovitApiExtended::getRequestOptionsPassthru();
        $this->assertEquals(self::EXPECTED_HEADER, $requestOptions['http']['header']);
    }

    public function testSetToken()
    {
        TrovitApiExtended::setToken(self::FAKE_API_TOKEN);
        $this->assertEquals(self::FAKE_API_TOKEN, TrovitApiExtended::getToken());
    }

    public function testDoRequestJsonWhenGetUrlDataCalledReturnJson()
    {
        $result = TrovitApiExtended::doRequestJson(SUT::VERTICAL_HOMES, array(), SUT::RESOURCE_ADS, self::DEBUG_ACTIVE);
        $this->assertEquals(self::$EXPECTED_URL_DATA_JSON, $result);
    }

    public function testDoRequestWhenGetUrlDataCalledReturnJson()
    {
        $result = TrovitApiExtended::doRequest(SUT::VERTICAL_HOMES, array(), SUT::RESOURCE_ADS, self::DEBUG_ACTIVE);
        $this->assertEquals(self::$EXPECTED_URL_DATA_ARRAY, $result);
    }

    public function testDoRequestJsonWhenGetUrlDataCalledRaiseException()
    {
        global $getContentsException;
        $getContentsException = true;

        $result = TrovitApiExtended::doRequestJson(SUT::VERTICAL_HOMES, array(), SUT::RESOURCE_ADS, self::DEBUG_ACTIVE);
        $this->assertFalse($result);
    }

    public function testDoRequestWhenGetUrlDataCalledRaiseException()
    {
        global $getContentsException;
        $getContentsException = true;

        $result = TrovitApiExtended::doRequest(SUT::VERTICAL_HOMES, array(), SUT::RESOURCE_ADS, self::DEBUG_ACTIVE);
        $this->assertFalse($result);
    }
}

/**
* Extend TrovitApi Class
*/
class TrovitApiExtended extends SUT
{
    public static function getToken()
    {
        return self::$TOKEN;
    }

    public static function getApiUri()
    {
        return self::$API_URI;
    }

    public static function getRequestOptionsPassthru()
    {
        return self::getRequestOptions();
    }
}

}
