<?php

namespace tabs\apiclient;

use tabs\apiclient\Builder;

/**
 * Tabs Rest API Extra object.
 *
 * @category  Tabs_Client
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2016 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: 1
 * @link      http://www.carltonsoftware.co.uk
 *
 * @method string getExtracode() Returns the extracode
 * @method Extra setExtracode(string $var) Sets the extracode
 * 
 * @method string getExtratype() Returns the extratype
 * @method Extra setExtratype(string $var) Sets the extratype
 * 
 * @method string getDescription() Returns the description
 * @method Extra setDescription(string $var) Sets the description
 * 
 * @method ExtraGroup getExtragroup() Returns the extra group
 * 
 * @method Collection|Branding[] getExtrabrandings() Returns the brandings
 */
class Extra extends Builder
{
    /**
     * Extracode
     *
     * @var string
     */
    protected $extracode;

    /**
     * Extratype
     *
     * @var string
     */
    protected $extratype = 'Booking';

    /**
     * Description
     *
     * @var string
     */
    protected $description;

    /**
     * Brandings
     *
     * @var Collection|Branding[]
     */
    protected $extrabrandings;

    // -------------------- Public Functions -------------------- //

    /**
     * @inheritDoc
     */
    public function __construct($id = null)
    {
        $this->extrabrandings = Collection::factory(
            'branding',
            new extra\Branding,
            $this
        );
        
        parent::__construct($id);
    }
    
    /**
     * Set the extra group object
     * 
     * @param array|stdClass|ExtraGroup $grp Extra group
     * 
     * @return \tabs\apiclient\Extra
     */
    public function setExtragroup($grp)
    {
        $this->extragroup = ExtraGroup::factory($grp);
        
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $arr = array(
            'extracode' => $this->getExtracode(),
            'extratype' => $this->getExtratype(),
            'description' => $this->getDescription()
        );
        
        if ($this->getExtragroup()) {
            $arr['extragroupid'] = $this->getExtragroup()->getId();
        }
        
        return $arr;
    }
}