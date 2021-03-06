<?php

namespace tabs\apiclient;

/**
 * Tabs Rest API Facet object.
 *
 * @category  Tabs_Client
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2017 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: 1
 * @link      http://www.carltonsoftware.co.uk
 *
 * @method integer getAmount() Returns the amount integer
 * @method Facet setAmount(integer $var) Sets the amount
 * 
 * @method string getContext() Returns the context string
 * @method Facet setContext(string $var) Sets the context
 * 
 * @method integer getValue() Returns the value integer
 * @method Facet setValue(integer $var) Sets the value
 * 
 * @method string getType() Returns the type string
 * @method Facet setType(string $var) Sets the type
 * 
 * @method mixed getEntity() Returns the entity
 */
class Facet
{
    use FactoryTrait;
    
    /**
     * Amount
     *
     * @var integer
     */
    protected $amount = 0;

    /**
     * Context
     *
     * @var string
     */
    protected $context = '';

    /**
     * Value
     *
     * @var integer
     */
    protected $value = 0;

    /**
     * Type
     *
     * @var string
     */
    protected $type = '';
    
    /**
     * Entity
     * 
     * @var mixed
     */
    protected $entity;
    
    /**
     * Set the entity object
     * 
     * @param mixed $entity Entity
     * 
     * @return \tabs\apiclient\Facet
     */
    public function setEntity($entity)
    {
        if ($this->context == 'Attribute') {
            switch ($entity->type) {
            case 'Boolean':
                $this->entity = AttributeBoolean::factory($entity);
                break;
            case 'String':
                $this->entity = AttributeString::factory($entity);
                break;
            case 'Number':
                $this->entity = AttributeNumber::factory($entity);
                break;
            }
        }
        
        return $this;
    }
}