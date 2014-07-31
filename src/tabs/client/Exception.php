<?php

/**
 * Tabs PHP Client Exception object.
 *
 * PHP Version 5.4
 * 
 * @category  Client
 * @package   Tabs
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2014 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.carltonsoftware.co.uk
 */
 
namespace tabs\client;

/**
 * Tabs PHP Client Exception object.
 *
 * @category  Client
 * @package   Tabs
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2014 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.carltonsoftware.co.uk
 */
class Exception extends \RuntimeException
{
    /**
     * Exception message 
     * 
     * @var string
     */
    protected $apiExceptionDescription = '';
    
    /**
     * Exception code 
     * 
     * @var integer
     */
    protected $apiExceptionCode = 0;


    // ------------------ Public Functions --------------------- //
    
    /**
     * Constructor
     * 
     * @param object     $response Api Response
     * @param string     $message  Exception message
     * @param integer    $code     Optional Exception code
     * @param \Exception $previous Optional previous exception
     */
    public function __construct(
        $response,
        $message, 
        $code = 0, 
        \Exception $previous = null
    ) {
        // Set overide params
        $this->setMessageFromResponse($response, $message);
        $this->setCodeFromResponse($response, $code);
        
        parent::__construct(
            $this->getApiDescription(), 
            $this->getApiCode(), 
            $previous
        );
    }

    /**
     * Custom string representation of object
     * 
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s: [%s]: %s',
            __CLASS__,
            $this->code,
            $this->message
        );
    }
    
    /**
     * Set the message of exception to be the response from API
     * 
     * @param object $response Object from the json response
     * @param string $message  Default client error message
     * 
     * @return \tabs\client\Exception
     */
    public function setDescriptionFromResponse($response, $message)
    {
        $this->apiExceptionDescription = $this->_getErrorResponseFromObject(
            $response,
            'errorDescription',
            $message
        );
        
        return $this;
    }
    
    /**
     * Set the code of exception to be the response from API
     * 
     * @param object  $response Object from the json response
     * @param integer $code     Default client error code
     * 
     * @return \tabs\client\Exception
     */
    public function setCodeFromResponse($response, $code)
    {
        $this->apiExceptionCode = $this->_getErrorResponseFromObject(
            $response,
            'errorCode',
            $code
        );
        
        return $this;
    }
    
    /**
     * Return the api exception code
     * 
     * @return integer
     */
    public function getApiCode()
    {
        return $this->apiExceptionCode;
    }
    
    /**
     * Return the api exception message
     * 
     * @return string
     */
    public function getApiDescription()
    {
        return $this->apiExceptionDescription;
    }
    
    // ------------------ Private Functions --------------------- //
    
    /**
     * Checks the API response from the object
     * 
     * @param object $response Object from the json response
     * @param string $key      Object key to return
     * @param string $default  Default property
     * 
     * @return mixed 
     */
    private function _getErrorResponseFromObject($response, $key, $default = '')
    {
        $value = false;
        if ($response 
            && property_exists($response, 'response')
            && property_exists($response->response, $key)
        ) {
            $value = $response->response->$key;
        }
        
        if (!$value) {
            return $default;
        } else {
            return $value;
        }
    }
}
