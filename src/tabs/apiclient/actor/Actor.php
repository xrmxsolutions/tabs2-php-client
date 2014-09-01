<?php

/**
 * Tabs Rest API Actor object.
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

namespace tabs\apiclient\actor;

/**
 * Tabs Rest API Actor object.
 *
 * @category  Tabs_Client
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2014 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: 1
 * @link      http://www.carltonsoftware.co.uk
 *
 * @method integer                     getId()            Return the Id
 * @method string                      getFirstname()     Return the firstname
 * @method string                      getSurname()       Return the surname
 * @method string                      getTitle()         Return the title
 * @method string                      getSalutation()    Return the saulation
 * @method string                      getTabscode()      Return the tabs code
 * @method string                      getLanguage()      Return the language
 * @method boolean                     getInactive()      Return the inactive state
 * @method string                      getPassword()      Return the password
 * @method string                      getCompanyname()   Return the company name
 * @method string                      getVatnumber()     Return the vat number
 * @method string                      getCompanynumber() Return the company number
 * @method \tabs\apiclient\actor\ContactEntity[] getContacts()      Return the array of contacts
 * @method \tabs\apiclient\actor\BankAccount[]   getBankaccounts()  Return the array of bank account objects
 *
 * @method \tabs\apiclient\actor\Actor setId(string $id) Set the Id
 * @method \tabs\apiclient\actor\Actor setFirstname(string $firstname) Set the firstname
 * @method \tabs\apiclient\actor\Actor setSurname(string $surname) Set the surname
 * @method \tabs\apiclient\actor\Actor setTitle(string $title) Set the title
 * @method \tabs\apiclient\actor\Actor setSalutation(string $salutation) Set the salutation
 * @method \tabs\apiclient\actor\Actor setTabscode(string $tabscode) Set the tabscode
 * @method \tabs\apiclient\actor\Actor setLanguage(string $language) Set the language
 * @method \tabs\apiclient\actor\Actor setInactive(boolean $inactive) Set the inactive state
 * @method \tabs\apiclient\actor\Actor setPassword(string $password) Set the password
 * @method \tabs\apiclient\actor\Actor setCompanyname(string $companyname) Set the company name
 * @method \tabs\apiclient\actor\Actor setVatnumber(string $vatnumber) Set the vat number
 * @method \tabs\apiclient\actor\Actor setCompanynumber(string $companynumber) Set the company number
 */
abstract class Actor extends \tabs\apiclient\core\Builder
{
    /**
     * Id
     *
     * @var integer
     */
    protected $id;

    /**
     * Firstname
     *
     * @var string
     */
    protected $firstname = '';

    /**
     * Surname
     *
     * @var string
     */
    protected $surname = '';

    /**
     * Title
     *
     * @var string
     */
    protected $title = '';

    /**
     * Salutatino
     *
     * @var string
     */
    protected $salutation = '';

    /**
     * Tabscode
     *
     * @var string
     */
    protected $tabscode = '';

    /**
     * Language
     *
     * @var string
     */
    protected $language = '';

    /**
     * Inactive
     *
     * @var boolean
     */
    protected $inactive = false;

    /**
     * Password
     *
     * @var string
     */
    protected $password = '';

    /**
     * Companyname
     *
     * @var string
     */
    protected $companyname = '';

    /**
     * VatNumber
     *
     * @var string
     */
    protected $vatnumber = '';

    /**
     * CompanyNumber
     *
     * @var string
     */
    protected $companynumber = '';

    /**
     * ContactEntities
     *
     * Array of ContactEntity
     *
     * @var array()
     */
    protected $contacts = array();

    /**
     * BankAccount
     *
     * Array of BankAccount
     *
     * @var array()
     */
    protected $bankaccounts = array();

    // -------------------------- Static Functions -------------------------- //

    /**
     * Create a Actor object from a given customer reference
     *
     * @param string $reference Actor reference
     *
     * @return \tabs\apiclient\actor\Actor
     */
    public static function get($reference)
    {
        return parent::get('/customer/' . $reference);
    }

    // -------------------------- Public Functions -------------------------- //
    
    /**
     * Add a contact detail
     *
     * @param \tabs\apiclient\actor\ContactAddress|\tabs\apiclient\actor\ContactDetail $contact Contact detail object
     *
     * @return \tabs\apiclient\actor\Actor
     */
    public function addContact(&$contact)
    {
        $contact->setParent($this);
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * Set the contacts for the Actor
     *
     * @param array $contacts Array of contact objects
     *
     * @return \tabs\apiclient\actor\Actor
     */
    public function setContacts($contacts)
    {
        foreach ($contacts as $contact) {
            if ($contact->type == 'P') {
                $detail = \tabs\apiclient\actor\ContactAddress::factory($contact);
            } else {
                $detail = \tabs\apiclient\actor\ContactDetail::factory($contact);
            }

            $this->addContact($detail);
        }

        return $this;
    }

    /**
     * Return all of the Contact addresses object
     *
     * @return array
     */
    public function getContactAddresses()
    {
        return $this->getContactFilter('ContactAddress');
    }

    /**
     * Return all of the Contact Detail objects that are email addresses
     *
     * @return array
     */
    public function getEmailAddresses()
    {
        return array_filter(
            $this->getContactFilter(),
            function ($ele) {
                return ($ele->getContactmethod() == 'Email');
            }
        );
    }

    /**
     * Return all of the Contact Detail objects that are phone numbers
     *
     * @return array
     */
    public function getPhoneNumbers()
    {
        return array_filter(
            $this->getContactFilter(),
            function ($ele) {
                return ($ele->getContactmethod() == 'Phone');
            }
        );
    }

    /**
     * Return a filtered contacts array
     *
     * @param string $type Contact entity type
     *
     * @return array
     */
    public function getContactFilter($type = 'ContactDetail')
    {
        return array_filter(
            $this->contacts,
            function ($ele) use ($type) {
                return ($ele->getClass() == $type);
            }
        );
    }

    /**
     * Add a bank account
     *
     * @param \tabs\apiclient\actor\BankAccount $bankAccount Bank account object
     *
     * @return \tabs\apiclient\actor\Actor
     */
    public function addBankAccount(&$bankAccount)
    {
        $bankAccount->setParent($this);
        $this->bankaccounts[] = $bankAccount;

        return $this;
    }

    /**
     * Set the bank account objects
     *
     * @param account $bankAccounts Bank accounts array
     *
     * @return \tabs\apiclient\actor\Actor
     */
    public function setBankaccounts($bankAccounts)
    {
        foreach ($bankAccounts as $account) {
            $bankAccount = BankAccount::factory($account);
            $this->addBankAccount($bankAccount);
        }

        return $this;
    }

    /**
     * Set the language object
     *
     * @param array $array Language array
     *
     * @return \tabs\apiclient\core\Language
     */
    public function setLanguage($array)
    {
        if (is_string($array)) {
            $array = array('name' => $array);
        }

        $this->language = Language::factory($array);

        return $this;
    }

    /**
     * Return if a customer is active or not
     *
     * @return boolean
     */
    public function isActive()
    {
        return !$this->inactive;
    }

    /**
     * Delete function
     *
     * @return \tabs\apiclient\actor\Actor
     */
    public function delete()
    {
        throw new \tabs\apiclient\client\Exception(
            null,
            sprintf(
                'Deleting a %s is not permitted',
                $this->getClass()
            )
        );
    }

    /**
     * ToString magic method
     *
     * @return string
     */
    public function __toString()
    {
        return implode(
            ' ',
            array_filter(
                array(
                    $this->getTitle(),
                    $this->getFirstname(),
                    $this->getSurname()
                )
            )
        );
    }

    /**
     * Array representation of the object
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'title' => $this->getTitle(),
            'firstname' => $this->getFirstname(),
            'surname' => $this->getSurname(),
            'salutation' => $this->getSalutation(),
            'tabscode' => $this->getTabscode(),
            'language' => $this->getLanguage(),
            'companyname' => $this->getCompanyname(),
            'vatnumber' => $this->getVatnumber(),
            'companynumber' => $this->getCompanynumber()
        );
    }
}