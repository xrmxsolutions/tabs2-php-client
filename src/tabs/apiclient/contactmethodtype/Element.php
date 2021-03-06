<?php

namespace tabs\apiclient\contactmethodtype;

use tabs\apiclient\Builder;

/**
 * Tabs Rest API Element object.
 *
 * @category  Tabs_Client
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2017 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: 1
 * @link      http://www.carltonsoftware.co.uk
 *
 * @method string getContactmethodelement() Returns the contactmethodelement
 * @method Element setContactmethodelement(string $var) Sets the contactmethodelement
 * 
 * @method string getDescription() Returns the description
 * @method Element setDescription(string $var) Sets the description
 */
class Element extends Builder
{
    /**
     * Contactmethodelement
     *
     * @var string
     */
    protected $contactmethodelement;

    /**
     * Description
     *
     * @var string
     */
    protected $description;

    // -------------------- Public Functions -------------------- //

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array(
            'contactmethodelement' => $this->getContactmethodelement(),
            'description' => $this->getDescription(),
        );
    }
}