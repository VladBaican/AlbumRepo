<?php
namespace Authentication\Event;

use Zend\EventManager\Event;

class UserCreated extends Event
{
    const NAME = 'user.created';

    protected $userId;

    public function __construct($name = null, $target = null, $params = null)
    {
        parent::__construct($name, $target, $params);
        $this->setName(self::NAME);
        $this->userId = $this->getParam('userId');
    }
}
