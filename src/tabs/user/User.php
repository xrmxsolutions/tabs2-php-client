<?php

/**
 * Tabs Rest API User object.
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

namespace tabs\user;

/**
 * Tabs Rest API User object.
 *
 * @category  Tabs_Client
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2014 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: 1
 * @link      http://www.carltonsoftware.co.uk
 * 
 * @method \tabs\user\Role[] getRoles()    Return the user roles
 * @method integer           getId()       Return the user id
 * @method string            getUsername() Return the username
 * @method string            getEmail()    Return the user email
 * @method string            getPassword() Return the user password
 * @method \tabs\user\Group  getGroup()    Return the user group
 * 
 * @method \tabs\user\User setId(integer $id)            Set the user Id
 * @method \tabs\user\User setUsername(string $username) Set the username
 * @method \tabs\user\User setEmail(string $email)       Set the user email
 * @method \tabs\user\User setPassword(string $password) Set the user password
 * @method \tabs\user\User setEnabled(boolean $enabled)  Set the enabled flag
 */
class User extends \tabs\core\Builder
{
    /**
     * User Id
     * 
     * @var integer
     */
    protected $id;
    
    /**
     * Username
     * 
     * @var string
     */
    protected $username;
    
    /**
     * Email Address
     * 
     * @var string
     */
    protected $email;
    
    /**
     * Password
     * 
     * @var string
     */
    protected $password;
    
    /**
     * Enabled?
     * 
     * @var boolean
     */
    protected $enabled = false;
    
    /**
     * Array of assigned roles
     * 
     * @var \tabs\user\Role[] $roles
     */
    protected $roles = array();
    
    /**
     * User Group
     * 
     * @var \tabs\user\Group
     */
    protected $group;

    // -------------------------- Static Functions -------------------------- //

    /**
     * Get a user from a given Id
     *
     * @param string $id User reference
     *
     * @return \tabs\core\User
     */
    public static function get($id)
    {
        // Get the user object
        return parent::get('/auth/user/' . $id);
    }

    /**
     * Get the Users
     *
     * @return \tabs\core\User[]
     */
    public static function fetch()
    {
        // Get the user object
        return parent::get('/auth/user');
    }

    /**
     * Authenticate and return a user object
     *
     * @param string $username Username
     * @param string $password Password
     *
     * @return \tabs\core\User
     */
    public static function authenticate($username, $password)
    {
        // Get the user object
        $request = \tabs\client\Client::getClient()->post(
            '/auth/user/authenticate',
            array(
                'username' => $username,
                'password' => $password
            )
        );

        return self::get(
            self::getRequestId($request)
        );
    }

    // -------------------------- Public Functions -------------------------- //
    
    /**
     * Check if user is active or not
     * 
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->getEnabled();
    }
    
    /**
     * Set the user roles
     * 
     * @param \tabs\user\Role[] $roles Array of roles
     * 
     * @return \tabs\core\User
     */
    public function setRoles($roles)
    {
        foreach ($roles as $role) {
            $_role = Role::factory($role);
            $this->addRole($_role);
        }
        
        return $this;
    }
    
    /**
     * Add a role to the user
     * 
     * @param \tabs\user\Role $role   Role to add
     * @param boolean         $commit Set to true if a create post is to be 
     *                                created
     * 
     * @return \tabs\user\User
     */
    public function addRole(&$role, $commit = false)
    {
        if ($commit) {
            $request = \tabs\client\Client::getClient()->put(
                '/auth/user/' . $this->getId() . '/role/' . $role->getId()
            );

            if (!$request || $request->getStatusCode() !== '204') {
                throw new \tabs\client\Exception(
                    $request,
                    'Unable to add role ' . $role->getRole() . ' user: ' . $this->getId()
                );
            }
        }
        
        $role->setParent($this);
        $this->roles[] = $role;
        
        return $this;
    }
    
    /**
     * Remove a role from a user
     * 
     * @param integer $roleId Role Id
     * 
     * @return \tabs\user\User
     */
    public function removeRole($roleId)
    {
        foreach ($this->getRoles() as $index => $role) {
            if ($role->getId() == $roleId) {
                $role->remove();
                unset($this->roles[$index]);
            }
        }
        
        return $this;
    }
    
    /**
     * Enable the current user
     * 
     * @throws \tabs\client\Exception
     * 
     * @return \tabs\user\User
     */
    public function enable()
    {
        return $this->_toggleUser('enable');
    }
    
    /**
     * Disable the current user
     * 
     * @throws \tabs\client\Exception
     * 
     * @return \tabs\user\User
     */
    public function disable()
    {
        return $this->_toggleUser('disable');
    }
    
    /**
     * Return the array of routes the user has access too.
     * 
     * @return \tabs\user\Route[]
     */
    public function getRoutes()
    {
        $routes = array();
        foreach ($this->getRoles() as $role) {
            $routes = array_merge($routes, $role->getRoutes());
        }
        
        return $routes;
    }
    
    /**
     * Set the usergroup
     * 
     * @param array|\tabs\user\Group $group User group array/object
     * 
     * @return \tabs\user\User
     */
    public function setGroup($group)
    {
        if (is_array($group)) {
            $group = Group::factory($group);
        }
        
        $group->setParent($this);
        $this->group = $group;
        
        return $this;
    }
    
    /**
     * Check if a user has access to a given route or not
     * 
     * @param string $route Route name
     * 
     * @return boolean
     */
    public function hasAccess($route)
    {
        foreach ($this->getRoutes() as $rout) {
            if ($rout->getRoute() === $route) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * @inheritDoc
     */
    public function getCreateUrl()
    {
        return '/auth/user';
    }
    
    /**
     * @inheritDoc
     */
    public function getUpdateUrl()
    {
        return '/auth/user/' . $this->getId();
    }
    
    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $roles = array();
        foreach ($this->getRoles() as $role) {
            array_push($roles, $role->toArray());
        }
        
        return array(
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'roles' => $this->getRoles(),
            'group' => $this->getGroup()->getId()
        );
    }
        
    
    /**
     * Disable/Enable the current user
     * 
     * @throws \tabs\client\Exception
     * 
     * @return \tabs\user\User
     */
    private function _toggleUser($action = 'enable')
    {
        $request = \tabs\client\Client::getClient()->post(
            '/auth/user/' . $this->getId() . '/' . $action
        );
        
        if (!$request || $request->getStatusCode() !== '204') {
            throw new \tabs\client\Exception(
                $request,
                'Unable to ' . $action . ' user: ' . $this->getId()
            );
        }
        
        return $this;
    }
}