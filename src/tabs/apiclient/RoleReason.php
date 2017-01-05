<?php

namespace tabs\apiclient;

use tabs\apiclient\Builder;

/**
 * Tabs Rest API Role Reason object.
 *
 * @category  Tabs_Client
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2017 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: 1
 * @link      http://www.carltonsoftware.co.uk
 *
 * @method Role getRole() Returns the role
 * @method Reason getReason() Returns the reason
 * @method boolean getDonotdelete() Returns the donotdelete
 * @method RoleReason setDonotdelete(boolean $var) Sets the donotdelete
 * 
 * @method boolean getRequired() Returns the required
 * @method RoleReason setRequired(boolean $var) Sets the required
 */
class RoleReason extends Builder
{
    /**
     * Role
     *
     * @var Role
     */
    protected $role;

    /**
     * Reason
     *
     * @var Reason
     */
    protected $reason;

    /**
     * Donotdelete
     *
     * @var boolean
     */
    protected $donotdelete;

    /**
     * Required
     *
     * @var boolean
     */
    protected $required;

    // -------------------- Public Functions -------------------- //

    /**
     * Set the role
     *
     * @param stdclass|array|Role $role The Role
     *
     * @return RoleReason
     */
    public function setRole($role)
    {
        $this->role = Role::factory($role);

        return $this;
    }

    /**
     * Set the reason
     *
     * @param stdclass|array|Reason $reason The Reason
     *
     * @return RoleReason
     */
    public function setReason($reason)
    {
        $this->reason = Reason::factory($reason);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array(
            'roleid' => $this->getRole()->getId(),
            'reasonid' => $this->getReason()->getId(),
            'donotdelete' => $this->boolToStr($this->getDonotdelete()),
            'required' => $this->boolToStr($this->getRequired()),
        );
    }
}