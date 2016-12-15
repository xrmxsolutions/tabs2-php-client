<?php

namespace tabs\apiclient\actor;

/**
 * Tabs Rest Agency object.
 *
 * @category  Tabs_Client
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2016 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: 1
 * @link      http://www.carltonsoftware.co.uk
 *
 * @method string getOfficename() Returns the office name
 * @method Actor  setOfficename(string $var) Sets the office name
 */
class Office extends Actor
{
    /**
     * Office name
     *
     * @var string
     */
    protected $officename;

    // -------------------- Public Functions -------------------- //

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array_merge(
            parent::toArray(),
            array(
                'name' => $this->getOfficename()
            )
        );
    }
}