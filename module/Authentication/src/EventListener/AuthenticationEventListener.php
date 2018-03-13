<?php
namespace Authentication\EventListener;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Authentication\Event\UserCreated;
use Authentication\Model\UserRoleTable;

/*
 * Authentication Event Listener
 */
class AuthenticationEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * @var UsersRolesTable
     */
    protected $userRoleTable;

    /**
     * Constructor.
     *
     * @param UserRoleTable $userRoleTable
     */
    public function __construct(
        UserRoleTable $userRoleTable
    ) {
        $this->userRoleTable = $userRoleTable;
    }

    /**
     * Register the listeners.
     *
     * @param  EventManagerInterface $events
     * @param  integer               $priority
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            UserCreated::NAME,
            [$this, 'onUserCreated']
        );
    }

    /**
     * User created event handler.
     *
     * @param UserCreated $event
     */
    public function onUserCreated(UserCreated $event)
    {
        $params = $event->getParams();
        $userId = $params['userId'];

        $this->userRoleTable->saveUserRoles([
            'userId' => $userId,
            'roleId' => 1
        ]);
    }
}
