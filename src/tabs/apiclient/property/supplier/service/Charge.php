<?php

namespace tabs\apiclient\property\supplier\service;

use tabs\apiclient\Builder;
use tabs\apiclient\Currency;
use tabs\apiclient\Vatband;
use tabs\apiclient\OwnerChargeCode;

/**
 * Tabs Rest API Charge object.
 *
 * @category  Tabs_Client
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2016 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: 1
 * @link      http://www.carltonsoftware.co.uk
 *
 * @method string getType() Returns the type
 * @method Charge setType(string $var) Sets the type
 * 
 * @method \DateTime getFromdate() Returns the fromdate
 * @method Charge setFromdate(\DateTime $var) Sets the fromdate
 * 
 * @method \DateTime getTodate() Returns the todate
 * @method Charge setTodate(\DateTime $var) Sets the todate
 * 
 * @method float getCharge() Returns the charge
 * @method Charge setCharge(float $var) Sets the charge
 * 
 * @method Currency getCurrency() Returns the currency
 * @method Vatband getVatband() Returns the vatband
 * @method boolean getAutoaddcustomer() Returns the autoaddcustomer
 * @method Charge setAutoaddcustomer(boolean $var) Sets the autoaddcustomer
 * 
 * @method boolean getAutoaddowner() Returns the autoaddowner
 * @method Charge setAutoaddowner(boolean $var) Sets the autoaddowner
 * 
 * @method boolean getIncludesvat() Returns the includesvat
 * @method Charge setIncludesvat(boolean $var) Sets the includesvat
 * 
 * @method OwnerChargeCode getOwnerchargecode() Returns the ownerchargecode
 */
class Charge extends Builder
{
    /**
     * Type
     *
     * @var string
     */
    protected $type;

    /**
     * Fromdate
     *
     * @var \DateTime
     */
    protected $fromdate;

    /**
     * Todate
     *
     * @var \DateTime
     */
    protected $todate;

    /**
     * Charge
     *
     * @var float
     */
    protected $charge;

    /**
     * Currency
     *
     * @var Currency
     */
    protected $currency;

    /**
     * Vatband
     *
     * @var Vatband
     */
    protected $vatband;

    /**
     * Autoaddcustomer
     *
     * @var boolean
     */
    protected $autoaddcustomer;

    /**
     * Autoaddowner
     *
     * @var boolean
     */
    protected $autoaddowner;

    /**
     * Includesvat
     *
     * @var boolean
     */
    protected $includesvat;

    /**
     * Ownerchargecode
     *
     * @var OwnerChargeCode
     */
    protected $ownerchargecode;

    // -------------------- Public Functions -------------------- //

    /**
     * @inheritDoc
     */
    public function __construct($id = null)
    {
        $this->fromdate = new \DateTime();
        $this->todate = new \DateTime();
        
        parent::__construct($id);
    }

    /**
     * Set the currency
     *
     * @param stdclass|array|Currency $currency The Currency
     *
     * @return Charge
     */
    public function setCurrency($currency)
    {
        $this->currency = Currency::factory($currency);

        return $this;
    }

    /**
     * Set the vatband
     *
     * @param stdclass|array|Vatband $vatband The Vatband
     *
     * @return Charge
     */
    public function setVatband($vatband)
    {
        $this->vatband = Vatband::factory($vatband);

        return $this;
    }

    /**
     * Set the ownerchargecode
     *
     * @param stdclass|array|OwnerChargeCode $ownerchargecode The Ownerchargecode
     *
     * @return Charge
     */
    public function setOwnerchargecode($ownerchargecode)
    {
        $this->ownerchargecode = OwnerChargeCode::factory($ownerchargecode);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $arr = array(
            'type' => $this->getType(),
            'fromdate' => $this->getFromdate()->format('Y-m-d'),
            'todate' => $this->getTodate()->format('Y-m-d'),
            'charge' => $this->getCharge(),
            'currencycode' => $this->getCurrency()->getCode(),
            'vatbandid' => $this->getVatband()->getId(),
            'autoaddcustomer' => $this->boolToStr($this->getAutoaddcustomer()),
            'autoaddowner' => $this->boolToStr($this->getAutoaddowner()),
            'includesvat' => $this->boolToStr($this->getIncludesvat())
        );
        
        if ($this->getType() == 'OwnerCharge' && $this->getOwnerchargecode()) {
            $arr['ownerchargecodeid'] = $this->getOwnerchargecode()->getId();
        }
        
        return $arr;
    }
}