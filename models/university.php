<?php
require_once('../core/db.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class University extends Database
{
    public function __construct()
    {
        parent::__construct(require('../config/config.php'));
    }

    public function listUniversitiesByDistrict($districtId) {
        $result = $this -> select()
            -> from('universities')
            -> where('district_id = :districtId')
            -> execute(array(
                'districtId' => $districtId
            ))
            -> fetch();
        return $result;
    }
}