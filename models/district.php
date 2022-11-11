<?php
require_once('../core/db.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class District extends Database
{
    public function __construct() 
    {
        parent::__construct(require('../config/config.php'));
    }

    public function listAllDistricts() {
        $result = $this -> select()
            -> from('districts')
            -> execute()
            -> fetch();
        return $result;
    }
}