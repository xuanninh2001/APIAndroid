<?php
require_once('../core/db.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Room extends Database
{
    public function __construct()
    {
        parent::__construct(require('../config/config.php'));
    }

    public function listAllRoomsByDistance($latitude, $longitude, $distance) 
    {
        $result = $this -> select()
            -> from('rooms')
            -> where('(((acos(sin((:lat*pi()/180)) * sin((latitude*pi()/180)) + cos((:lat*pi()/180)) * cos((latitude*pi()/180)) * cos((($lng - longitude)*pi()/180))))*180/pi())*60*2.133) <= :distance')
            -> execute(array(
                'lat': $latitude,
                'long': $longitude,
                'distance': $distance       // kilometers
            ))
            -> fetch();
        return $result;
    }

    public function viewRoomDetail($roomId) 
    {
        $result = $this -> select()
            -> from('rooms')
            -> where('id = :roomId')
            -> execute(array(
                'roomId': $roomId
            ))
            -> fetch();
        return $result;
    }
}

class RoomType extends Database
{
    public function __construct()
    {
        parent::__construct(require('../config/config.php'));
    }

    public function listAllRoomTypes(){
        $result = $this -> select()
            -> from('room_types')
            -> execute()
            -> fetch();
        return $result;
    }
}

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
