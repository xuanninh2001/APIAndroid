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

    // Đăng nhập
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

    // Đăng ký
    public function register($fullName, $phone, $email, $password, $userType) 
    {
        $table = 'users';
        $structure = 'full_name, phone, email, password, user_type';
        $valueBinding = ':full_name, :phone, :email, :pass_word, :user_type';

        $result = $this->insert($table, $structure, $valueBinding)
            ->execute(array(
                'full_name' => $fullName,
                'phone' => $phone,
                'email' => $email,
                'password' => $password,
                'user_type' => $userType
            ));
    }

    // Liệt kê các quận
    public function listAllDistricts() {
        $result = $this->select()
            ->from('districts')
            ->execute(null)
            ->fetch();
        return $result;
    }

    // Liệt kê các trường đại học theo quận
    public function listUniversitiesByDistrict($districtId) {
        $result = $this->select()
            ->from('universities')
            ->where('district_id = :district_id')
            ->execute(array(
                'district_id' => $districtId
            ))
            ->fetch();
        return $result;
    }
}