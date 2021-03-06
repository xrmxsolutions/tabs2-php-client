<?php

/**
 * Tabs Rest API Base object.
 *
 * PHP Version 5.4
 *
 * @category  API_Client
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2014 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.carltonsoftware.co.uk
 */

namespace tabs\apiclient;

/**
 * Tabs Rest API Base object.
 *
 * Provides setter/getter methods for all child classes.
 *
 * PHP Version 5.5
 *
 * @category  API_Client
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2014 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.carltonsoftware.co.uk
 * 
 * @method integer getId()            Returns the object id
 * @method Base    setId(integer $id) Sets the object id
 * 
 * @method Base      setResponsedata(\stdClass $data) Set the response data
 * @method \stdClass getResponsedata()                Get the response data from
 *                                                    the get() method
 */
abstract class Base
{
    use StateTrait;
    use FactoryTrait;
    
    /**
     * Id
     * 
     * @var integer
     */
    protected $id;
    
    /**
     * Parent element
     *
     * @var Base
     */
    protected $parent;

    /**
     * Data returned from the get request
     * 
     * @var \stdClass
     */
    protected $responsedata;

    // ------------------ Static Functions --------------------- //

    /**
     * Get an object from a given route
     *
     * @param string $route GET route
     *
     * @return mixed
     */
    public static function _get($route)
    {
        return self::factory(
            self::getJson(
                \tabs\apiclient\client\Client::getClient()->get($route)
            )
        );
    }
    
    /**
     * Get data from the response data object
     * 
     * Uses func_get_args to get the steps to navigate the json. I.e:
     * 
     * $this->getDataFromResponse('price', 'total', 'brochureprice')
     * 
     * Would return the brochure price on a booking object if found.
     * 
-     * @return null|mixed
     */
    public function getDataFromResponse()
    {
        return $this->_getDataFromObject(
            func_get_args(),
            $this->responsedata
        );
    }
    
    /**
     * One way recursive function to navigate through the responsedata from
     * a get request
     * 
     * @param array     $steps  Steps to nagivate through
     * @param \stdClass $object Object to look at
     * 
     * @return null|mixed
     */
    private function _getDataFromObject($steps, $object)
    {
        if (count($steps) > 0) {
            $step = array_shift($steps);
            if ($object instanceof \stdClass 
                && property_exists($object, $step)
                && count($steps) == 0
            ) {
                return $object->$step;
            }
            
            if ($object instanceof \stdClass 
                && property_exists($object, $step)
                && count($steps) > 0
            ) {
                return $this->_getDataFromObject($steps, $object->$step);
            }
        }
        
        return;
    }

    /**
     * Return the ID from a content-location header
     *
     * @param \Psr\Http\Message\ResponseInterface $req Guzzle response
     *
     * @return string|void
     */
    public static function getRequestId($req)
    {
        if ($req->getHeader('content-location')) {
            if (is_array($req->getHeader('content-location'))) {
                $arr = $req->getHeader('content-location');
                return self::getIdFromString(reset($arr));
            } else {
                return self::getIdFromString($req->getHeader('content-location'));
            }
        } else {
            return;
        }
    }

    /**
     * Return an id from a url string
     *
     * @param string $str String
     *
     * @return string
     */
    public static function getIdFromString($str)
    {
        $location = explode('/', $str);

        return $location[count($location) - 1];
    }

    // -------------------------- Public Functions -------------------------- //
    
    /**
     * Constructor
     * 
     * @param integer $id ID
     * 
     * @return void
     */
    public function __construct($id = null)
    {
        $this->id = $id;
    }
    
    /**
     * Get the object the non static extra
     * 
     * @return self
     */
    public function get()
    {
        $this->responsedata = self::getJson(
            \tabs\apiclient\client\Client::getClient()->get(
                $this->getUpdateUrl()
            )
        );
        
        self::setObjectProperties(
            $this,
            $this->responsedata
        );
        
        return $this;
    }

    /**
     * Generate a url string for a create url
     *
     * @return string
     */
    public function getCreateUrl()
    {
        return implode('/', $this->createUrl());
    }

    /**
     * Generate a url string for a update url
     *
     * @return string
     */
    public function getUpdateUrl()
    {
        return implode('/', $this->updateUrl());
    }

    /**
     * @inheritDoc
     */
    public function getUrlStub()
    {
        return strtolower($this->getClass());
    }

    /**
     * Set the parent element
     *
     * @param Base $element Parent element
     *
     * @return Base
     */
    public function setParent(&$element)
    {
        $this->parent = $element;

        return $this;
    }
    
    /**
     * Remove the parent
     * 
     * @return \tabs\apiclient\Base
     */
    public function removeParent()
    {
        $this->parent = null;

        return $this;
    }
    
    /**
     * Enforce parent type.  Method should be overriden with a class name string
     * that will be evaluated with the instanceof operand.
     * 
     * @return string
     */
    public function isParentInstanceType()
    {
        return '\tabs\apiclient\Base';
    }

    /**
     * Return the builder parent element
     *
     * @return Base
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Recursive finder function.  Traverses up the tree to try to
     * find a perent object with a matching class.
     *
     * @param string $type Class type
     *
     * @return Base|null
     */
    public function findParentByType($type)
    {
        if ($this->getParent() && $type == $this->getParent()->getClass()) {
            return $this->getParent();
        } else if ($this->getParent()) {
            return $this->getParent()->findParentByType($type);
        } else {
            return;
        }
    }
    
    /**
     * ToString magic method
     * 
     * @return string
     */
    public function __toString()
    {
        return implode(
            ' ',
            $this->toArray()
        );
    }

    // ------------------------- Protected Functions ------------------------ //

    /**
     * Generate the url segments for an array
     *
     * @param array $segments Prefix
     *
     * @return array
     */
    protected function createUrl($segments = array())
    {
        if ($this->getParent()) {
            $segments = $this->getParent()->updateUrl($segments);
        }
        return array_merge(
            $segments,
            array(
                $this->getUrlStub()
            )
        );
    }

    /**
     * Generate the url segments for an array
     *
     * @param array $segments Prefix
     *
     * @return array
     */
    protected function updateUrl($segments = array())
    {
        if ($this->getParent()) {
            $segments = $this->getParent()->updateUrl($segments);
        }
        
        if (!$this->getId()) {
            throw new exception\Exception(
                null,
                'Parent ' . $this->getClass() . ' not intialised.'
            );
        } 
        
        return array_merge(
            $segments,
            array(
                $this->getUrlStub(),
                $this->getId()
            )
        );
    }
}