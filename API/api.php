
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');
session_start();

require('../models/user.php');
$userModel = new User();

if(isset($_POST['email'])){
    try {
        $username = $_POST['email'];
        $password = $_POST['password'];
        $result = $userModel->login($username, $password);
        if($result)
        {
            echo json_encode(array(
                'status' => 'success',
                'data' => $result
            ));
        }
        else
        {
            echo json_encode(array(
                'status' => 'failed',
                'error' => 'Tài khoản hoặc mật khẩu không chính xác!'
            ));
        }
    } catch (Exception $e) {
        echo json_encode(array(
            'status' => 'failed',
            'error' => $e->getMessage()
        ));
    }
}
