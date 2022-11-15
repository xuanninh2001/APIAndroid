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

    // Liệt kê phòng trọ theo khoảng cách
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

    // Xem chi tiết phòng trọ
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

    // Liệt kê các loại phòng trọ
    public function listAllRoomTypes()
    {
        $result = $this -> select()
            -> from('room_types')
            -> execute()
            -> fetch();
        return $result;
    }

    // Liệt kê nhận xét của phòng trọ
    public function listAllReviewsOfRoom($roomId) 
    {
        $result = $this -> select()
            -> from('reviews')
            -> where('room_id = :roomId')
            -> execute(array(
                'roomId' => $roomId
            ))
            -> fetch();
        return $result;
    }

    // Thêm phòng trọ
    public function addRoom($thumbnail, $address, $price, $description, $latitude, $longitude, $status, $area, $maxRenters, $currentRenters, $hasParking, $hasBathroom, $hasSecurity, $hasElevator, $hasWifi, $landlordUserId, $roomTypeId) 
    {
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

    // Thêm lịch sử thuê trọ
    public function addRenting($roomId, $studentUserId, $isRenting, $deposit) 
    {
        $table = 'rentings';
        $structure = 'room_id, student_user_id, is_renting, deposit';
        $valueBinding = ':room_id, :student_user_id, :is_renting, :deposit';

        $result = $this -> insert($table, $structure, $valueBinding)
            -> execute(array(
                'room_id' => $roomId,
                'student_user_id' => $studentUserId,
                'is_renting' => $isRenting,
                'deposit' => $deposit
            ));
    }
}