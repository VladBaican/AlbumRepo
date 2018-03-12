<?php
namespace Authentication\Services;

use Zend\Authentication\AuthenticationService as ZendAuthenticationService;
use Authentication\Model\AuthenticationAdapter;
use Zend\Authentication\Storage\StorageInterface;
use Zend\InputFilter\InputFilter;
use Authentication\Model\UserTable;
use Authentication\Model\UserRoleTable;

/**
 * Authentication Service
 */
class AuthenticationService extends ZendAuthenticationService
{
    /**
     * @const LOGIN_FAIL
     */
    const LOGIN_FAIL = -1;

    /**
     * @const LOGIN_SUCCES
     */
    const LOGIN_SUCCESS = 1;

    /**
     * @var InputFilter
     */
    protected $inputFilter;

    /**
     * @var UserTable
     */
    protected $userTable;

    /**
     * @var UsersRolesTable
     */
    protected $userRoleTable;

    /**
     * Constructor.
     *
     * @param StorageInterface      $storage
     * @param AuthenticationAdapter $adapter
     * @param UserTable             $userTable
     * @param UserRoleTable         $userRoleTable
     */
    public function __construct(
        StorageInterface $storage = null,
        AuthenticationAdapter $adapter = null,
        UserTable $userTable,
        UserRoleTable $userRoleTable
    ) {
        parent::__construct($storage, $adapter);
        $this->userTable = $userTable;
        $this->userRoleTable = $userRoleTable;
    }

    /**
     * Get input filler.
     *
     * @return [type] [description]
     */
    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'username',
            'required' => true,
        ]);

        $inputFilter->add([
            'name' => 'password',
            'required' => true,
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }

    /**
     * Get roles for user.
     *
     * @param  string $username
     * @return array
     */
    public function getRoles($username)
    {
        return $this->userTable->getRoles($username);
    }

    /**
     * Add a new user.
     *
     * @param  array  $credentials
     */
    public function saveUser($credentials)
    {
        $id = $this->userTable->saveUser($credentials);
        $this->userRoleTable->saveUserRoles([
            'userId' => $id,
            'roleId' => 1
        ]);
    }
}
