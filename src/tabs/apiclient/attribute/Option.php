<?php

namespace tabs\apiclient\attribute;

use tabs\apiclient\Builder;

/**
 * Tabs Rest API Option object.
 *
 * @category  Tabs_Client
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2016 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: 1
 * @link      http://www.carltonsoftware.co.uk
 *
 * @method string getOption() Returns the option
 * @method Option setOption(string $var) Sets the option
 * 
 * @method integer getOptionorder() Returns the optionorder
 * @method Option setOptionorder(integer $var) Sets the optionorder
 */
class Option extends Builder
{
    /**
     * Option
     *
     * @var string
     */
    protected $option;

    /**
     * Optionorder
     *
     * @var integer
     */
    protected $optionorder;

    // -------------------- Public Functions -------------------- //

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array(
            'option' => $this->getOption(),
            'optionorder' => $this->getOptionorder(),
            'attributeid' => $this->getParent()->getId()
        );
    }
}