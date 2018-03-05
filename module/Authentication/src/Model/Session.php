<?php
namespace Authentication\Model;

use Zend\Authentication\Storage\Session as ZendSession;
use Zend\Session\ManagerInterface as SessionManager;

/**
 * Session
 */
class Session extends ZendSession
{
    public function __construct(
        $namespace = null,
        $member = null,
        SessionManager $manager = null
    ) {
        parent::__construct($namespace, $member, $manager);
    }
}
