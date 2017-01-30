<?php

/**
 * Tabs Rest API Special offer object.
 *
 * PHP Version 5.4
 *
 * @category  Tabs_Client
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2014 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.carltonsoftware.co.uk
 */

namespace tabs\apiclient\core\specialoffer;
use tabs\apiclient\core\PricingPeriod;
use tabs\apiclient\collection\core\BookingPeriod as BookingPeriodCollection;

/**
 * Tabs Rest API Special offer object.
 *
 * @category  Tabs_Client
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2015 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: 1
 * @link      http://www.carltonsoftware.co.uk
 * 
 * @method float        getAmount()           Returns the amount
 * @method Specialoffer setAmount(float $var) Sets the amount
 */
class SetDiscount extends Currency
{
    /**
     * Numerical amount of special offer
     * 
     * @var float
     */
    protected $amount = 0;
    
    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $array = parent::toArray();
        $array['type'] = 'Amount';
        $array['amount'] = $this->getAmount();
        return $array;
    }
}