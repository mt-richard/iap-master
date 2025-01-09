<?php 
require("../../config/grobals.php");
// include input and validate
require("../../util/input.php");
include("../../util/validate.php");
include("../../util/upload.php");
$action=input::get("action");
if(!isset($_SESSION)){
    session_start();
}
switch ($action) {
    case 'GET_SUPPERVISIORS_PARTNERS':
        // get hote code,Ymd
        if(!isset($_SESSION['ht_userId'])){
            echo json_encode(["isOk"=>false,"data"=>"Access denied"]); 
            exit();
        }
    echo json_encode(["isOk"=>true,
    "data"=>["suppervisiors"=>$database->fetch("SELECT * from a_suppervisior_tb where status='active'"),
    "partners"=>$database->fetch("SELECT * from a_partner_tb where is_active='yes'")]]); 
    break;
    case 'ASSSIGN_SUPPERVISIOR_PARTNER_TO_STUDENT':
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
        // check internaship date
        $today=date('Y-m-d');
        $iDate=date("Y-m-d",strtotime(input::get("idate")));
        $partner=input::get("p");
        $oldPartner=input::get("op");
        $student=input::get("student");
        $suppervisior=input::get("s");
        $major=input::get("major");
        $inter=input::get("inter");
        $cardId=input::get("card_id");
        if(!is_numeric($partner) && !is_numeric($suppervisior)){
            echo json_encode(["isOk"=>false,"data"=>" partner or suppervisior is invalid"]);
            exit(0);
        }
        // $formData= ["partner_id"=>$partner,"suppervisior_id"=>$suppervisior,"updated_at"=>date('Y-m-d h:i:s')];
        if(!is_numeric($partner)){
            // unset($formData["partner_id"]);
            $partner='NULL';
        }
        if(!is_numeric($suppervisior)){
            // unset($formData["suppervisior_id"]);
            $suppervisior='NULL';
        }
        if($today>=$iDate){
            echo json_encode(["isOk"=>false,"data"=>"you are not allowed to change partner or suppervisior because internaship date was expired"]);
            exit(0);
        }
        $database->beginTransaction();
        try {
        //    $isUpdated=$database->update("a_student_tb","id=$student",$formData);
        $query1="UPDATE a_student_tb SET partner_id =$partner,suppervisior_id =$suppervisior,updated_at = NOW() WHERE id=$student";
        $query2="";
        $query3=""; 
                    // update partern request
                    if(is_numeric($partner) && $partner!=$oldPartner){
                        // activate user account
                        $database->query("UPDATE a_users set status='active' WHERE username='$cardId' LIMIT 1");
                        // update 1
                        $query2="UPDATE a_partner_student_request SET given_student_number=given_student_number+1 WHERE internaship_id=$inter AND partner_id=$partner AND major_in='$major'";
                        $database->query($query2);
                        // update totals
                        $database->query("UPDATE a_partner_student_request_totals SET given_student=given_student+1 WHERE internaship_id=$inter AND partner_id=$partner");
                    }
                    if(is_numeric($oldPartner) &&  $partner!=$oldPartner){
                         // remove from old
                         $query3="UPDATE a_partner_student_request SET given_student_number=given_student_number-1 WHERE internaship_id=$inter AND partner_id=$oldPartner AND major_in='$major' AND given_student_number>0 ";
                         $database->query($query3);
                         $database->query("UPDATE a_partner_student_request_totals SET given_student=given_student-1 WHERE internaship_id=$inter AND partner_id=$oldPartner AND given_student>0");
                    }
        $database->query($query1);
        $database->commit();
        echo json_encode(["isOk"=>true,"data"=>true,"q1"=>$query1,"q2"=>$query2,"q3"=>$query3]);
         
        } catch (\Exception $e) {
            $database->rollBack();
            echo json_encode(["isOk"=>false,"data"=>$e->getMessage()]);
        }
        break;

        case 'ADD_SUPERVISOR':
            $val=new validate();
            $val->check($_GET,[
                "department"=>['required'=>true],
                "phone"=>['required'=>true],
                "email"=>['required'=>true],
                "name"=>['required'=>true],
                "gender"=>['required'=>true],
                "password"=>['required'=>true],
                "username"=>['required'=>true]
            ]);
            if(!$val->passed()){
                echo json_encode(["isOk"=>false,"data"=>implode(',',$val->errors())]);
                exit(0);
            }
            $name=input::get("name");
            $department=input::get("department");
            $email=input::get("email");
            $phone=input::get("phone");
            $gender=input::get("gender");
            $password=input::getHash(input::get('password'));
            $username=input::get("username");
            $userId=$_SESSION['ht_userId'];
            $usercheck=$database->count_all("a_users where username=' $username'");
                if ($usercheck>0) {
                    echo json_encode(["isOk"=>true,"data"=>"Username Taken"]);
                    exit(0);
                }
                // }else {
                    $supquery="INSERT INTO `a_suppervisior_tb` (`names`, `gender`, `department`, `email`, `phone`) VALUES ('{$name}', '{$gender}', '{$department}', '{$email}', '{$phone}')";
                    $iscreated=$database->query($supquery);
                    $insertedid=$database->inset_id();
                    // $database->beginTransaction();
                    try {
                        $userquery="INSERT INTO `a_users` (`names`, `username`, `phone`, `secret`, `level`,`status`,institition_id) VALUES ('{$name}', '{$username}', '{$phone}', '{$password}', 'SUPERVISIOR','active', $insertedid)";
                        $usercreated=$database->query($userquery);
                        $database->commit();
                        echo json_encode(["isOk"=>true,"data"=>"Suppervisior added"]);
                    } catch (\Throwable $th) {
                        // $database->rollBack();
                        echo json_encode(["isOk"=>false,"data"=>"Suppervisior not Saved" . $th->getMessage()]);
                    }
        
        break;

      
    default:
        echo json_encode(["isOk"=>false,"data"=>"action".$action.'  not found']);
        break;
}
// 
