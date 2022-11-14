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

    public function login($email, $password){
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

    public function register($fullName, $phone, $email, $password) 
    {
        $result = $this->insert()
            ->execute();
    }

    public function listAllDistricts() {
        $result = $this->select()
            ->from('districts')
            ->execute(null)
            ->fetch();
        return $result;
    }

    public function listUniversitiesByDistrict($districtId) {
        $result = $this->select()
            ->from('universities')
            ->where('district_id = :districtId')
            ->execute(array(
                'districtId' => $districtId
            ))
            ->fetch();
        return $result;
    }
}