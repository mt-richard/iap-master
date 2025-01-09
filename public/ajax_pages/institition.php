<?php 
require("../../config/grobals.php");
// include input and validate
require("../../util/input.php");
include("../../util/validate.php");
$action=input::get("action");
if(!isset($_SESSION)){
    session_start();
}
switch ($action) {
    case 'CREATE_NEW_INSTI':
        // get hote code,Ymd
        if(!isset($_SESSION['ht_userId'])){
            echo json_encode(["isOk"=>false,"data"=>"Access denied"]); 
            exit();
        }
        // check if it is system,manager
        if($_SESSION['ht_level']!="ADMIN"){
            echo json_encode(["isOk"=>false,"data"=>"Access denied; please contact system admin"]); 
            exit(); 
        }
        $val=new validate();
       $val->check($_POST,[
        "name"=>["required"=>true,"max"=>30,"unique"=>["table"=>"institition_tb","column"=>'name']],
        "email"=>['required'=>true,"max"=>100]
        ]);
        if(!$val->passed()){
            echo json_encode(["isOk"=>false,"data"=>implode(',',$val->errors())]); 
            exit();
        }
    $userData=[
        "name"=>$database->escape_value($_POST['name']),
        "email"=>$database->escape_value($_POST['email']),
        "user_id"=>$_SESSION['ht_userId'],
    ];
    $isUserInserted=$database->insert("institition_tb",$userData);
    if($isUserInserted){
        echo json_encode(["isOk"=>true,"data"=>input::get("name") ."  has been saved"]); 
    }else{
        echo json_encode(["isOk"=>false,"data"=>input::get("name") ." Failed to be created please try again"]);
    }
       
        break;
    default:
        echo json_encode(["isOk"=>false,"data"=>"action".$action.'  not found']);
        break;
}
?>