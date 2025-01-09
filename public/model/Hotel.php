<?php 
 require_once("../config/grobals.php");

class Hotel
{
// get all hotels
public static function all($cond="",$column="*"){
    global $database;
    return $database->fetch(" SELECT $column FROM a_hotels  $cond ");
}
public static function findById($id):object{
    global $database;
    return $database->get("*","a_hotels","where id=$id");
}
}
?>