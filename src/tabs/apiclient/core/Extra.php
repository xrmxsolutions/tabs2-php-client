<?php

/**
 * Tabs Rest API Unit object.
 *
 * PHP Version 5.4
 *
 * @category  Tabs_Client
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2015 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.carltonsoftware.co.uk
 */

namespace tabs\apiclient\core;

/**
 * Tabs Rest API Unit object.
 *
 * @category  Tabs_Client
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2015 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: 1
 * @link      http://www.carltonsoftware.co.uk
 * 
 * @method integer  getId()            Returns the ID
 * @method Extra    setId(integer $id) Sets the ID
 * 
 * @method string   getExtracode()     Returns the extracode
 * @method Extra    setExtracode(string $extracode)     Sets the extracode
 * 
 * @method obj      getExtratype()     Returns the extratype
 * @method Extra    setExtratype(obj $extratype)    Sets the extratype 
 * 
 * @method string   getDescription()   Returns the description
 * @method Extra    setDescription(string $desc)    Sets the description
 */
class Extra extends Builder
{
    /**
     * ID
     * 
     * @var integer
     */
    protected $id;
    
    /**
     * Extracode
     * 
     * @var string
     */
    protected $extracode;
    
    /**
     * Extratype
     * 
     * @var obj 
     */
    protected $extratype;
    
    /**
     * Description
     * 
     * @var string
     */
    protected $description;
    
    
    // ------------------ Public Functions --------------------- //
    
    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'extracode' => $this->getExtracode(),
            'extratype' => $this->getExtratype(),
            'description' => $this->getDescription()
        );
    }
    
    /**
     * ToString magic method
     * 
     * @return string
     */
    public function __toString() {
        return (string)$this->getId();
    }
}