<?php
namespace Authentication\Event;

use Zend\EventManager\Event;

/**
 * User Created
 */
class UserCreated extends Event
{
    const NAME = 'user.created';

    /**
     * {@inheritDoc}
     */
    public function __construct(
        string $name = null,
        string $target = null,
        array $params = null
    ) {
        parent::__construct($name, $target, $params);
        $this->setName(self::NAME);
    }
}
