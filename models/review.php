<?php
require_once('../core/db.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Review extends Database
{
    public function __construct()
    {
        parent::__construct(require('../config/config.php'));
    }

    public function listAllRoomReviews($roomId) {
        $result = $this -> select()
            -> from('reviews')
            -> where('room_id = :roomId')
            -> execute(array(
                'roomId' => $roomId
            ))
            -> fetch();
        return $result;
    }
}
