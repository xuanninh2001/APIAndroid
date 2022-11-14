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

    public function listAllRoomTypes(){
        $result = $this -> select()
            -> from('room_types')
            -> execute()
            -> fetch();
        return $result;
    }

    public function listAllReviewsOfRoom($roomId) {
        $result = $this -> select()
            -> from('reviews')
            -> where('room_id = :roomId')
            -> execute(array(
                'roomId' => $roomId
            ))
            -> fetch();
        return $result;
    }

    public function addRoom() {
        $table = 'rooms';
        $structure = 'thumbnail, address, price, description, latitude, longitude, status, area, max_renters, current_renters, has_parking, has_bathroom, has_security, has_elevator, has_wifi, landlord_user_id, room_type_id';
        $valueBinding = ':thumbnail, :address, :price, :description, :latitude, :longitude, :status, :area, :max_renters, :current_renters, :has_parking, :has_bathroom, :has_security, :has_elevator, :has_wifi, :landlord_user_id, :room_type_id';

        $result = $this -> insert($table, $structure, $valueBinding)
            -> execute(array(
                'thumbnail' => $thumbnail,
                'address' => $address,
                'price' => $price,
                'description' => $description,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'status' => $status,
                'area' => $area,
                'max_renters' => $maxRenters,
                'current_renters' => $currentRenters,
                'has_parking' => $hasParking,
                'has_bathroom' => $hasBathroom,
                'has_security' => $hasSecurity,
                'has_elevator' => $hasElevator,
                'has_wifi' => $hasWifi,
                'landlord_user_id' => $landlordUserId
                'room_type_id' => $roomTypeId
            ));
    }
}