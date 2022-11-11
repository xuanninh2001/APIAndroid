<?php
require_once('../core/db.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class User extends Database
{
    public function __construct()
    {
        parent::__construct(require('../config/config.php'));
    }

    public function checkUser($email, $password){
        $result = $this->select()
            ->from('users')
            ->where('email = :email and password = :password')
            ->execute(array(
                'email' => $email,
                'password' => $password
            ))
            ->fetch();
        return $result;
    }
}
