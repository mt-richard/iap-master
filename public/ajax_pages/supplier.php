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
    case 'UPDATE_SUPPLIER_PROFILE':
        // get hote code,Ymd
        if(!isset($_SESSION['ht_userId'])){
            echo json_encode(["isOk"=>false,"data"=>"Access denied"]); 
            exit();
        }
        $id=input::get("sup");
        $pro=$database->escape_value($_POST['editordata']);
        $isUpdated=$database->update("a_partner_tb","id=$id",['c_profile'=>"$pro"]);
        if($isUpdated){
            echo json_encode(["isOk"=>true,"data"=>'success']); 
            exit(0);
        }
        echo json_encode(["isOk"=>false,"data"=>'Unable to update the profile try again']); 
    break;
    case 'APPROVE_SUPPLIER_REQUEST':
                // get hote code,Ymd
                if(!isset($_SESSION['ht_userId'])){
                    echo json_encode(["isOk"=>false,"data"=>"Access denied"]); 
                    exit();
                }
        $id=input::get("sup");
        $status=input::get('st');
        $isUpdated=$database->update("a_partner_tb","id=$id",['is_active'=>"$status"]);
        if($isUpdated){
            echo json_encode(["isOk"=>true,"data"=>'success']); 
            exit(0);
        }
        echo json_encode(["isOk"=>false,"data"=>'failed to approve the supplier try again' .$status]); 
        break;
    case 'SUPPLIER_REGISTRATION':
        $val=new validate();
        $val->check($_POST,[
         "email"=>['required'=>true,"max"=>100],
         "person"=>['required'=>true,"max"=>100],
         "company"=>['required'=>true,"max"=>100],
         "phone"=>['required'=>true,"min"=>10],
         "place"=>['required'=>true,"max"=>100],
         "user_name"=>["required"=>true,"max"=>30,"unique"=>["table"=>"a_users","column"=>'username']],
         "password"=>['required'=>true,"min"=>4],
         ]);
         if(!$val->passed()){
             echo json_encode(["isOk"=>false,"data"=>implode(',',$val->errors())]); 
             exit();
         }
         $supData=[
            "name"=>$database->escape_value($_POST['company']),
            "email"=>$database->escape_value($_POST['email']),
            "phone"=>$database->escape_value($_POST['phone']),
            "tin"=>00000,
            "place"=>$database->escape_value($_POST['place']),
            "major_in"=>$database->escape_value($_POST['major_in']),
            "user_id"=>NULL,
            "is_active"=>"no"
        ];
        $isSupInserted=$database->insert("a_partner_tb",$supData);
        $userData=[
            "names"=>$database->escape_value($_POST['person']),
            "username"=>$database->escape_value($_POST['user_name']),
            "level"=>"PARTNER",
            "secret"=>input::getHash($_POST['password']),
            "status"=>'active',
            "phone"=>$_POST['phone'],
            "a_ip"=>input::getClientIp()
        ];
        if($isSupInserted){
          $userData['institition_id']=$isSupInserted;
          $isUserCreated=$database->insert("a_users",$userData);
          if($isUserCreated){
            // set sessions
            $_SESSION['ht_userId']=$isUserCreated;
            $_SESSION['ht_level']="PARTNER";
            $_SESSION['sup_is_active']="no";
            $_SESSION['ht_hotel']=$isSupInserted;
            $_SESSION['ht_name']=$_POST['person'];
            $_SESSION['ht_ben']=0;
            $_SESSION['ht_ip']=input::getClientIp();
            $msg=$_POST['company']." request to be approved as IPRC KIGALI partner please review the profile";
            $notifyQuery="INSERT INTO notifications_tb(message,link,level,level_id,done_by) value('$msg','supplier?d=$isSupInserted','ADMIN',1,$isUserCreated)"; 
            $database->query($notifyQuery);
            echo json_encode(["isOk"=>true,"data"=>'success']); 
          }else{
            echo json_encode(["isOk"=>false,"data"=>'unable to create account try again']); 
            $database->query("delete from a_partner_tb where id=$isSupInserted");
          }
        }else{
            echo json_encode(["isOk"=>true,"data"=>'unable to create account try again']); 
        }

        break;
    case 'CREATE_NEW_SUPPLIER':
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
        "tin"=>["required"=>true,"max"=>30,"unique"=>["table"=>"a_partner_tb","column"=>'tin']],
        "email"=>['required'=>true,"max"=>100],
        "name"=>['required'=>true,"max"=>100],
        "phone"=>['required'=>true,"min"=>10],
        "place"=>['required'=>true,"max"=>100],
        ]);
        if(!$val->passed()){
            echo json_encode(["isOk"=>false,"data"=>implode(',',$val->errors())]); 
            exit();
        }
        if(!input::valid_email($_POST['email'])){
            echo json_encode(["isOk"=>false,"data"=>"Invalide Email"]); 
            exit();   
        }
    $userData=[
        "name"=>$database->escape_value($_POST['name']),
        "email"=>$database->escape_value($_POST['email']),
        "phone"=>$database->escape_value($_POST['phone']),
        "tin"=>$database->escape_value($_POST['tin']),
        "place"=>$database->escape_value($_POST['place']),
        "user_id"=>$_SESSION['ht_userId'],
    ];
    $isUserInserted=$database->insert("a_partner_tb",$userData);
    if($isUserInserted){
      
        echo json_encode(["isOk"=>true,"data"=>input::get("name") ."  has been saved"]); 
    }else{
        echo json_encode(["isOk"=>false,"data"=>input::get("name") ." Failed to be saved please try again"]);
    }
       
        break;
    default:
        echo json_encode(["isOk"=>false,"data"=>"action".$action.'  not found']);
        break;
}
// 
