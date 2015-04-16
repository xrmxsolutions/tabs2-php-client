<?php

/**
 * Tabs Rest API Language object.
 *
 * PHP Version 5.4
 *
 * @category  Core
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2014 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: 1
 * @link      http://www.carltonsoftware.co.uk
 */

namespace tabs\apiclient\core;

/**
 * Tabs Rest API Language object.
 *
 * @category  Core
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2014 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: 1
 * @link      http://www.carltonsoftware.co.uk
 *
 * @method string getCode() Return the language code
 * @method string getName() Return the language name
 *
 * @method Language setCode(string $alpha2)   Set the Language code
 * @method Language setLanguage(string $name) Set the language name
 */
class Language extends Base
{
    /**
     * Language code
     *
     * @var string
     */
    protected $code = 'EN';

    /**
     * Language name
     *
     * @var type
     */
    protected $name = 'English';

    // ------------------ Public Functions --------------------- //

    /**
     * ToString magic method
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

}