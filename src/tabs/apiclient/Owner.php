<?php

namespace tabs\apiclient;

/**
 * Tabs Rest Owner object.
 *
 * @category  Tabs_Client
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2016 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: 1
 * @link      http://www.carltonsoftware.co.uk
 * 
 * @method boolean getAroard() Returns the abroad boolean
 * @method Owner   setAbroad(boolean $var) Sets the abroad boolean
 * 
 * @method boolean getEnquirer() Returns the enquirer boolean
 * @method Owner   setEnquirer(boolean $var) Sets the enquirer boolean
 * 
 * @method \tabs\apiclient\Branding getBranding() Returns the owner branding
 * 
 * @method \tabs\apiclient\Source getSource() Returns the source
 */
class Owner extends Actor
{
    /**
     * Branding
     * 
     * @var \tabs\apiclient\Branding
     */
    protected $branding;
    
    /**
     * Source
     * 
     * @var \tabs\apiclient\Source
     */
    protected $source;
    
    /**
     * Abroad
     * 
     * @var boolean
     */
    protected $abroad = false;
    
    /**
     * Enquirer
     * 
     * @var boolean
     */
    protected $enquirer = false;

    // ------------------ Public Functions --------------------- //
    
    /**
     * Set the branding
     * 
     * @param array|\stdClass|\tabs\apiclient\Branding $branding Branding
     * 
     * @return \tabs\apiclient\Owner
     */
    public function setBranding($branding)
    {
        $this->branding = Branding::factory($branding);
        
        return $this;
    }
    
    /**
     * Set the source
     * 
     * @param array|\stdClass|\tabs\apiclient\Source $source Source
     * 
     * @return \tabs\apiclient\Owner
     */
    public function setSource($source)
    {
        $this->source = Source::factory($source);
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $arr = parent::toArray();
        
        if ($this->getBranding()) {
            $arr['brandingid'] = $this->getBranding()->getId();
        }
        
        if ($this->getSource()) {
            $arr['sourceid'] = $this->getSource()->getId();
        }
        
        return $arr;
    }
}