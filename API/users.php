
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');
session_start();

require('../models/user.php');
$userModel = new User();

$api = $_SERVER['REQUEST_METHOD'];

$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

if ($api == 'GET') {
    try {
        $result = $userModel->listAllDistricts();
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
                'error' => 'Internal Server Error'
            ));
        }
    } catch (Exception $e) {
        echo json_encode(array(
            'status' => 'failed',
            'error' => $e->getMessage()
        ));
    }
}