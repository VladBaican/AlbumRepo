<?php
namespace Authentication\EventListener;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Authentication\Event\UserCreated;
use Authentication\Model\UserRoleTable;
use Authentication\Model\User;

/*
 * User Event Listener
 */
class UserEventListener implements ListenerAggregateInterface
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
     * {@inheritDoc}
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
        $user = $params['user'];

        $this->userRoleTable->saveUserRoles($user);
    }
}
