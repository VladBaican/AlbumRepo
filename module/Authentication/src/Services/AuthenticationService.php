<?php
namespace Authentication\Services;

use Zend\Authentication\AuthenticationService as ZendAuthenticationService;
use Zend\Authentication\Storage\StorageInterface;
use Zend\InputFilter\InputFilter;
use Zend\EventManager\EventManager;
use Authentication\Model\AuthenticationAdapter;
use Authentication\Model\UserTable;
use Authentication\Event\UserCreated;
use Authentication\Model\User;

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
     * @var EventManager
     */
    protected $eventManager;

    /**
     * Constructor.
     *
     * @param StorageInterface      $storage
     * @param AuthenticationAdapter $adapter
     * @param UserTable             $userTable
     * @param EventManager          $eventManager
     */
    public function __construct(
        StorageInterface $storage = null,
        AuthenticationAdapter $adapter = null,
        UserTable $userTable,
        EventManager $eventManager
    ) {
        parent::__construct($storage, $adapter);
        $this->userTable = $userTable;
        $this->eventManager = $eventManager;
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
     * @param User $user
     */
    public function saveUser(User $user)
    {
        $user = $this->userTable->saveUser($user);
        $this->eventManager->triggerEvent(
            new UserCreated(null, null, ['user' => $user])
        );
    }
}
