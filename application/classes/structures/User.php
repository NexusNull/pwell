<?php

/**
 * Created by PhpStorm.
 * User: patric
 * Date: 10/15/16
 * Time: 11:22 PM
 */
class User
{
    /**
     * @var integer
     */
    private $id;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password_hash;
    /**
     * @var string
     */
    private $password_salt;
    /**
     * @var string
     */
    private $email;

    /**
     * User constructor.
     * @param $id
     * @param $username
     * @param $password_hash
     * @param $password_salt
     * @param $email
     */
    public function __construct($id, $username, $password_hash, $password_salt, $email)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password_hash = $password_hash;
        $this->password_salt = $password_salt;
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPasswordHash()
    {
        return $this->password_hash;
    }

    /**
     * @param string $password_hash
     */
    public function setPasswordHash($password_hash)
    {
        $this->password_hash = $password_hash;
    }

    /**
     * @return string
     */
    public function getPasswordSalt()
    {
        return $this->password_salt;
    }

    /**
     * @param string $password_salt
     */
    public function setPasswordSalt($password_salt)
    {
        $this->password_salt = $password_salt;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
}