<?php

namespace Authentication\Model;

/**
 * User
 */
class User
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * Constructor.
     *
     * @param int    $id
     * @param string $username
     * @param string $password
     */
    public function __construct(
        string $username,
        string $password,
        int $id = null
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->id = $id;
    }

    /**
     * Get the user id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the user name.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
