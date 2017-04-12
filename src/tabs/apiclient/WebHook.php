<?php

namespace tabs\apiclient;
use tabs\apiclient\Builder;
use tabs\apiclient\exception\Exception;

/**
 * Tabs Rest API Website section object.
 *
 * @category  Tabs_Client
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2014 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: 1
 * @link      http://www.carltonsoftware.co.uk
 * 
 * @method string         getSection()            Returns the section name
 * @method WebsiteSection setSection(string $str) Sets the section name
 */
class WebHook extends Base
{
    /**
     * Send a subscription request to the webhook endpoint
     * 
     * @param string $url  URL you want to send the web hook responses too
     * @param string $type Type of web hook.  Can be property, actor or booking.
     * 
     * @throws Exception
     * 
     * @return void
     */
    public static function subscribe($url, $type = 'property')
    {
        $req = \tabs\apiclient\client\Client::getClient()->get(
            'webhook/subscribe/' . strtolower($type),
            array(
                'url' => $url
            )
        );
        
        if ($req->getStatusCode() != 200) {
            throw new Exception($req->getBody());
        }
    }
    
    /**
     * Get the request body from the webhook notification
     * 
     * @return array
     * 
     * @throws Exception
     */
    public static function detectRequestBody()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (JSON_ERROR_NONE !== json_last_error() || !is_array($data)) {
            throw new Exception('Invalid POST data.');
        }

        return $data;
    }
}