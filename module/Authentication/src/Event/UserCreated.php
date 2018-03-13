<?php
namespace Authentication\Event;

use Zend\EventManager\Event;

/**
 * User Created
 */
class UserCreated extends Event
{
    const NAME = 'user.created';

    protected $userId;

    /**
     * Constructor.
     *
     * Accept a target and its parameters.
     *
     * @param  string $name Event name
     * @param  string|object $target
     * @param  array|ArrayAccess $params
     */
    public function __construct(string $name = null, string $target = null, array $params = null)
    {
        parent::__construct($name, $target, $params);
        $this->setName(self::NAME);
        $this->userId = $this->getParam('userId');
    }
}
