<?php

/**
 * Created by PhpStorm.
 * User: patric
 * Date: 10/12/16
 * Time: 7:55 PM
 */

/**
 * Class DB_Users interacts with the database table users.
 */
class Users_model extends CI_Model
{
    public $input_errors = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Returns a user object via login credentials. If the login credentials are not valid DB_Users->auth_errors contains
     * the reasons why they where rejected.
     * @return User On success, returns a User Object otherwise NULL.
     * @param string $username The username
     * @param string $password The password
     */
    public function getUserByLogin($username, $password)
    {
        $this->input_errors = array();
        if (isset($username) && isset($password)) {

            if (!$this->validUsername($username))
                $this->input_errors[] = "The username has to consist of characters and numbers, with a length between 4 and 32.";
            if (!$this->validPassword($password))
                $this->input_errors[] = "The password has to consist of characters and numbers, with a length between 8 and 64.";

            if (sizeof($this->input_errors) === 0) {
                $sql = "SELECT * FROM users WHERE users.username = ?;";
                $query = $this->db->query($sql, array($username));

                if ($query->num_rows() > 0) {
                    $row = $query->result_array()[0];
                    if (isset($row)) {

                        if ($row['password'] === hash("sha512", $row['password_salt'] . $password)) {
                            $user = new User($row['id'], $row['username'], $row['password'], $row['password_salt'], $row['email']);

                            return $user;
                        }
                    }
                }
            }
        }

        return NULL;
    }

    private function validUsername($username)
    {
        return preg_match("/^[a-zA-Z0-9]{4,32}$/", $username);
    }

    private function validPassword($password)
    {
        return preg_match("/^.{8,64}$/", $password);
    }

    /**
     * Returns a user object with a specific id.
     * @return User The user with the valid id or NULL when user doesn't exist.
     */
    //TODO implement
    public function getUserById($userId)
    {

        return NULL;
    }

    /**
     * Adds a new User with a random id to the Database. On wrong parameters, returns an array containing reasons.
     * @return User Array of errors.
     * @param string $username
     * @param string $password
     * @param string $email
     */
    public function addUser($username, $password, $email)
    {
        $this->input_errors = [];
        if (isset($username) && isset($password) && isset($email)) {

            if (!$this->validUsername($username))
                $this->input_errors[] = "The username has to consist of characters and numbers, with a length between 4 and 32.<br>";
            if (!$this->validPassword($password))
                $this->input_errors[] = "The password has to consist of characters and numbers, with a length between 8 and 64.<br>";
            if (!$this->validEmail($email))
                $this->input_errors[] = "The email is not correct.<br>";
            if ($this->usernameExists($username))
                $this->input_errors[] = "Sorry, but this username is already taken.<br>";
            if ($this->emailExists($email))
                $this->input_errors[] = "Sorry, but this email is already taken.<br>";


            if (sizeof($this->input_errors) === 0) {
                $sql = "INSERT INTO pwell.users (id, username, password, password_salt, email) VALUES (?, ?, ?, ?, ?)";
                $salt = md5(rand(-2147483648, 2147483647));
                $password_hash = hash("sha512", $salt . $password);

                //Generate a random Id for the User
                $idSql = "SELECT id FROM pwell.users WHERE id = ?;";
                do {
                    $id = rand(1000000000, 2147483647);
                    $idQuery = $this->db->query($idSql, array($id));
                } while ($idQuery->num_rows() > 0);

                //TODO check if query was successful
                $userData = array($id, $username, $password_hash, $salt, $email);
                $this->db->query($sql, $userData);

                return new User($id, $username, $password_hash, $salt, $email);
            }
        }

        return NULL;
    }

    private function validEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function usernameExists($username)
    {
        $sql = "SELECT * FROM pwell.users WHERE username = ?";
        $query = $this->db->query($sql, array($username));

        return ($query->num_rows() > 0);
    }

    private function emailExists($email)
    {
        $sql = "SELECT * FROM pwell.users WHERE email = ?";
        $query = $this->db->query($sql, array($email));

        return ($query->num_rows() > 0);
    }
}