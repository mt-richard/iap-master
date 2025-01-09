<?php

require("../../config/grobals.php");
// include input and validate
require("../../util/input.php");
include("../../util/validate.php");
include("../../util/upload.php");
$action=input::get("action");



switch ($action) {
    case 'ADD_LOGBOOK':
        try {
        $level=$_SESSION["ht_level"];
        $userId=$_SESSION['ht_userId'];
        if($level!="STUDENT"){
            echo json_encode(["isOk"=>false,"data"=>"Access Denied"]); 
            exit(0);
        }
        $val=new validate();
        $mycheck=[
            "lesson"=>["required"=>true],
            "description"=>["required"=>true],
            "challenge"=>['required'=>true],
            // "photo"=>["type"=>"jpg,png,jpeg"]
        ];
        $isEditable=(boolean)input::get("isEditable");
        $today=date('Y-m-d');
        if(!$isEditable){
        $isThere=$database->get("log_date,screenshoots","a_student_logbook","student_id=$userId AND log_date='$today'");
        if(isset($isThere->log_date)){
           echo json_encode(["isOk"=>false,"data"=>"Daily activity already exists <button onclick='editActivity()'  class='btn btn-success btn-sm' type='button'>Click here to replace it</button>"]); 
           exit(0);  
        } 
    }
        $val->check($_POST,$mycheck);
            if(!$val->passed()){
                echo json_encode(["isOk"=>false,"data"=>implode(',',$val->errors())]); 
                exit(0);
        }
        // check internaship
        $internaship=$database->get("id","a_internaship_periode","status='activated'");
        if(!isset($internaship->id)){
            echo json_encode(["isOk"=>false,"data"=>"No activated IAP available please contact your admin"]); 
            exit(0); 
        }
        //  get student info
        $student=$database->get("internaship_periode_id,partner_id,suppervisior_id","a_student_tb","card_id=$userId");
        if($internaship->id!=$student->internaship_periode_id){
            echo json_encode(["isOk"=>false,"data"=>"You are not included in current IAP periode"]); 
            exit(0); 
        }
        if(!isset($student->partner_id)){
            echo json_encode(["isOk"=>false,"data"=>"Your partner not available please contact IPRC KIGALI administration"]); 
            exit(0);
        }
        if(!isset($student->suppervisior_id)){
            echo json_encode(["isOk"=>false,"data"=>"Your Suppervisior not available please contact IPRC KIGALI administration"]); 
            exit(0);
        }
    
        $name=input::get("description");
        $c=input::get("challenge");
        $l=input::get("lesson");
        $sup=$student->suppervisior_id;
        $partner=$student->partner_id;
        $i=$internaship->id;
        $spcomment=input::get("sp_comment");
        $userId=$_SESSION['ht_userId'];
        $names=$_SESSION['ht_name'];
        // $logdate=input::get("log_date");
         //daily permit
         if(!$isEditable){
       $query="INSERT INTO a_student_logbook(name,objective,challenges,student_id,suppervisor_id,internaship_id,partner_id,suppervisior_comment) 
       values('{$name}','{$l}','{$c}',{$userId},'{$sup}','{$i}','{$partner}','{$spcomment}')";
         }else{
            // $pt=empty($pt)?"":"screenshoots='$pt',";
            $query="UPDATE a_student_logbook SET name='$name',objective='$l',suppervisior_comment='$spcomment',challenges='$c' WHERE student_id=$userId AND log_date='{$today}'";
         }
        $iscreated=$database->query($query);
       if($iscreated){
        echo json_encode(["isOk"=>true,"data"=>"Data Saved","message"=>"Please check $names daily activity",
        "sid"=>$sup,
        "pid"=>$partner,
        "st"=>$userId,
        "today"=>$today
    ]); 
        exit(0);
       }
       echo json_encode(["isOk"=>false,"data"=>"Data Already Exist"]);
    } catch (\Throwable $e) {
        echo json_encode(["isOk"=>false,"data"=>$e->getMessage()]);
    }
        break;
    


        case 'ADD_COMMENT':
            $val=new validate();
            $val->check($_GET,[
                // "lesson"=>["required"=>true],
                "description"=>["required"=>true],
                // "challenge"=>['required'=>true]
                // "internaship_id"=>['required'=>true],
                // "suppervisor_id"=>['required'=>true],
                // "partner_id"=>['required'=>true],
                 "sp_comment"=>['required'=>true],
                "row_id"=>['required'=>true]
            ]);
                if(!$val->passed()){
                    echo json_encode(["isOk"=>false,"data"=>implode(',',$val->errors())]); 
                    exit(0);
            }
    
            // $name=input::get("description");
            $i=input::get("row_id");
            $spcomment=input::get("sp_comment");
    
          
           $updatequery="UPDATE a_student_logbook SET suppervisior_comment= '{$spcomment}' WHERE id = $i";

           $iscommented=$database->query($updatequery);
           if($iscommented){
            echo json_encode(["isOk"=>true,"data"=>"Data Commented","q"=>$updatequery,"id"=>$i,"from"=>$_SESSION['ht_name']]); 
            exit(0);
           }
           echo json_encode(["isOk"=>false,"data"=>"Data Not Commented"]);
           break;

           case 'ADD_PARTNERCOMMENT':
            $val=new validate();
            $val->check($_GET,[
                // "lesson"=>["required"=>true],
                // "description"=>["required"=>true],
                // "challenge"=>['required'=>true]
                // "internaship_id"=>['required'=>true],
                // "suppervisor_id"=>['required'=>true],
                // "partner_id"=>['required'=>true],
                //  "sp_comment"=>['required'=>true],
                 "p_comment"=>['required'=>true],
                "row_id"=>['required'=>true]
            ]);
                if(!$val->passed()){
                    echo json_encode(["isOk"=>false,"data"=>implode(',',$val->errors())]); 
                    exit(0);
            }
    
            // $name=input::get("description");
            $i=input::get("row_id");
            $pcomment=input::get("p_comment");
    
          
           $updatequery="UPDATE a_student_logbook SET partner_comment= '{$pcomment}' WHERE id = $i";

           $iscommented=$database->query($updatequery);
           if($iscommented){
            echo json_encode(["isOk"=>true,"data"=>"Data Commented","q"=>$updatequery,"id"=>$i,"from"=>$_SESSION['ht_name']]); 
            exit(0);
           }
           echo json_encode(["isOk"=>false,"data"=>"Data Not Commented"]);
           break;

    default:
     echo " action Not found";
        break;
}

/*
switch ($action) {
    case 'ADD_LOGBOOK':
        $val=new validate();
        $val->check($_GET,[
         "lesson"=>["required"=>true],
         "description"=>["required"=>true],
         "challenge"=>['required'=>true]]);
         if(!$val->passed()){
             echo json_encode(["isOk"=>false,"data"=>implode(',',$val->errors())]); 
             exit();
         }
        //  echo json_encode(["isOk"=>true,"data"=>$_REQUEST]);
     $formData=[
         "name"=>$_GET['description'],
         "objective"=>$_GET['lesson'],
         "challenges"=>$database->escape_value($_GET['challenge']),
         "student_id"=>$_SESSION['ht_userId'],
         "suppervisor_id"-=>1,
         "internaship_id"=>1,
         "partner_id"=>1
     ];
     $isUserInserted=$database->insert("a_student_logbook",$formData);
     if($isUserInserted){
         echo json_encode(["isOk"=>true,"data"=>"Message here"); 
     }else{
         echo json_encode(["isOk"=>false,"data"=>"Message here"]);
     }

        break;
    
    default:
        # code...
        break;
}
 */