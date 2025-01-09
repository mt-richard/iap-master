<?php 
require("../../../config/grobals.php");
// include input and validate
require("../../../util/input.php");
include("../../../util/validate.php");
$action=input::enc_dec("d",input::get("faction"));
if(!isset($_SESSION)){
    session_start();
}
switch ($action) {
case 'EDIT_USER_INFO':
           
            if(!isset($_SESSION['ht_userId'])){
                echo json_encode(["isOk"=>false,"data"=>"Access denied"]); 
                exit();
            }
           
            if(!in_array($_SESSION['ht_level'],['ADMIN']) ){
                echo json_encode(["isOk"=>false,"data"=>"Access denied; please contact  admin"]); 
                exit(); 
            }
            $val=new validate();
            $val->check($_POST,[
             "names"=>['required'=>true],
             "user_level"=>['required'=>true],
             "user_status"=>['required'=>true],
             "phone"=>['required'=>true,"number"=>true,"max"=>16],
             ]);
             if(!$val->passed()){
                 echo json_encode(["isOk"=>false,"data"=>implode(',',$val->errors())]); 
                 exit();
             }
             $login_level=$_SESSION['ht_level'];
             $userData=[
             "names"=>$database->escape_value($_POST['names']),
             "level"=>$_POST['user_level'],
             "status"=>$_POST['user_status'],
             "phone"=>$_POST['phone']
         ];
        $userId=input::get("user_id");
        $isUserInserted=$database->update("a_users","id=$userId",$userData);
        if($isUserInserted){
            echo json_encode(["isOk"=>true,"data"=>input::get("names") ." Account has been changed"]); 
        }else{
            echo json_encode(["isOk"=>false,"data"=>input::get("names") ." Failed to be changed please try again"]);
        }
    break;
    case 'CREATE_NEW_USER':
        if(!isset($_SESSION['ht_userId'])){
            echo json_encode(["isOk"=>false,"data"=>"Access denied"]); 
            exit();
        }
        if(!in_array($_SESSION['ht_level'],['ADMIN','INST_ADMIN']) ){
            echo json_encode(["isOk"=>false,"data"=>"Access denied; please contact  admin"]); 
            exit(); 
        }
        $val=new validate();
       $val->check($_POST,[
        "user_name"=>["required"=>true,"unique"=>["table"=>"a_users","column"=>'username']],
        "names"=>['required'=>true],
        "pswd"=>['required'=>true,"min"=>4],
        "user_level"=>['required'=>true],
        "user_status"=>['required'=>true],
        "phone"=>['required'=>true,"number"=>true,"max"=>16],
        ]);
        if(!$val->passed()){
            echo json_encode(["isOk"=>false,"data"=>implode(',',$val->errors())]); 
            exit();
        }
        $login_level=$_SESSION['ht_level'];
        $userData=[
        "names"=>$database->escape_value($_POST['names']),
        "username"=>$database->escape_value($_POST['user_name']),
        "level"=>$_POST['user_level'],
        "secret"=>input::getHash($_POST['pswd']),
        "status"=>$_POST['user_status'],
        "phone"=>$_POST['phone']
    ];
    $isUserInserted=$database->insert("a_users",$userData);
    if($isUserInserted){
        echo json_encode(["isOk"=>true,"data"=>input::get("names") ." Account has been created"]); 
    }else{
        echo json_encode(["isOk"=>false,"data"=>input::get("names") ." Failed to be created please try again"]);
    }
       
        break;
    default:
        echo json_encode(["isOk"=>false,"data"=>"action".$action.'  not found']);
        break;
}
?>