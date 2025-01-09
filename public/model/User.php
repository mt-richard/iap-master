<?php 
    require_once("../config/grobals.php");
class User
{
// get all hotels
public static function all($cond="",$column="*"){
    // require_once("../../config/grobals.php");
    global $database;
    return $database->fetch(" SELECT $column FROM a_users  $cond ");
}
public static function findById($id):object{
    global $database;
    return $database->get("*","a_users","id=$id");
}
public static function userByPlace($inst_id,$ben_id){
     global $database;
    $id=(int)$inst_id;
    $ben=(int)$ben_id;
    $tb="institition_tb";
    if($ben!=0){
        $tb="beneficiary_tb";
        $id=$ben;
    }
     $h=$database->get("name","$tb","id=$id");
     if(isset($h->name)){
        return $h->name;
     }
     return '-'; 
}
}
?>