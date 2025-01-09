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
    case 'ADD_GRADE_TO_STUDENT':
        try {
            $level=$_SESSION['ht_level'];
            if($level!="PARTNER" && $level!="SUPERVISIOR"){
                echo json_encode(["isOk"=>false,"data"=>"Access denied $level"]);
                exit(0);
            }
        $val=new validate();
            $formRule = [
                "student_id" => ['required' => true],
                "supervisior_id" => ['required' => true],
                "internaship_id" => ['required' => true],
                "relationship" => ['required' => true, "maxnum" => 10, "minnum" => 0],
                "responsibility" => ['required' => true, "maxnum" => 10, "minnum" => 0],
                "personal_qualities" => ['required' => true, "maxnum" => 10, "minnum" => 0],
                "professional_qualities" => ['required' => true, "maxnum" => 10, "minnum" => 0],
                "professional_knowledge" => ['required' => true, "maxnum" => 10, "minnum" => 0],
                "attachment" => ['required' => true, "type" => "jpg,png,jpeg"],
            ];
            if ($level== "SUPERVISIOR") {
                $formRule = ["student_marks" => ['required' => true, "maxnum" => 20, "minnum" => 0],];
            }
        $val->check($_POST,$formRule);
        if(!$val->passed()){
            echo json_encode(["isOk"=>false,"data"=>implode(',',$val->errors())]);
            exit(0);
        }
        $intern=input::get("internaship_id");
        $studentId=input::get("student_id");
        $userID=$_SESSION["ht_hotel"];
        // check if internaship is allowed to upload
        $isAllowed=$database->count_all("a_internaship_periode where id=$intern AND upload_grade='yes'");
        if($isAllowed==0){
            echo json_encode(["isOk"=>false,"data"=>"Currently to upload student internaship grade is not allowed please contact IPRC KIGALI administraction"]);
            exit(0);
        }
        // check if data already exists
            $cond = "";
            if($level=="SUPERVISIOR"){
                $cond = " AND s_marks IS NOT NULL";
            }
        $hasExists=$database->count_all("a_student_grade where student_id=$studentId  AND internaship_id=$intern $cond ");
        if($hasExists>0){
            echo json_encode(["isOk"=>false,"data"=>"Student Internaship Grade already exists"]);
            exit(0);
        }
        if($level=="SUPERVISIOR"){
            $in=input::get("internaship_id");
            $marks=input::get("student_marks");
            $isUpdated=$database->update("a_student_grade","student_id=$studentId AND internaship_id=$in",
            ["s_marks"=>$marks]);
            if($isUpdated){
                echo json_encode(["isOk"=>true,"data"=>"success"]);
            }else{
                echo json_encode(["isOk"=>false,"data"=>"unable to upload student grade please check if student was given marks from partener"]);
                // exit(0);
            }
                exit(0);
        }
        $pt=upload::Image($_FILES,"attachment","../uploads/")['sqlValue'];
        $pk=input::get("professional_knowledge");
        $rel=input::get("relationship");
        $resp=input::get("responsibility");
        $peq=input::get("personal_qualities");
        $pq=input::get("professional_qualities");
        $creteria="Professional knowledge:$pk,Professional qualities:$pq,Personal qualities:$peq,Responsibility:$resp,Relationship:$resp";

        $isCreated=$database->insert("a_student_grade",
        ["evaluation_criteria"=>$creteria,
        "marks"=>($pk+$rel+$resp+$peq+$pq),
        "attachment"=>$pt,
        "student_id"=>$studentId,
        "partner_id"=>$userID,
        "supervisior_id"=>input::get("supervisior_id"),
        "internaship_id"=>input::get("internaship_id")]);
        if(!$isCreated){
            echo json_encode(["isOk"=>false,"data"=>"unable to upload student grade"]);
            exit(0);
        }
        echo json_encode(["isOk"=>true,"data"=>"success"]);
                    # code...
                } catch (\Throwable $e) {
                    echo json_encode(["isOk"=>false,"data"=>$e->getMessage()]);
                }
        break;
    case 'CREATE_NEW_INTERNASHIP_PERIODE':
        try {
            $val=new validate();
            $val->check($_POST,[
                "end_date"=>['required'=>true],
                "start_date"=>['required'=>true],
                "status"=>['required'=>true],
                "upload_grade"=>['required'=>true],
            ]);
            if(!$val->passed()){
                echo json_encode(["isOk"=>false,"data"=>implode(',',$val->errors())]);
                exit(0);
            }
                 // check start date and last date
        $startDate=input::get("start_date");
        $endDate=input::get("end_date");
        $status=input::get("status");
        $isGraded=input::get("upload_grade");
        if($startDate>$endDate){
            echo json_encode(["isOk"=>false,"data"=>"Please check start date and end date"]);
            exit(0);
        }
          // is update or insert
          $isUpdate=(int)input::get("id");
          $userID=$_SESSION['ht_userId'];
          if($isUpdate==0){
              // insert new update
              $info=["start_date"=>$startDate,"end_date"=>$endDate,
              "status"=>$status,"upload_grade"=>$isGraded,"user_id"=>$userID];
              $isInserted=$database->insert("a_internaship_periode",$info);
              if(!$isInserted){
                  echo json_encode(["isOk"=>false,"data"=>"New Internaship is not " + $status]);
                  exit(0);
              }
              echo json_encode(["isOk"=>true,"data"=>"IPRC KIGALI internaship(Start:$startDate End:$endDate,status:$status,upload Marks:$isGraded)","i"=>$inserted,"o"=>"create"]);
              exit(0);
          }
          
        // update
        $info=["start_date"=>$startDate,"end_date"=>$endDate,
        "status"=>$status,"upload_grade"=>$isGraded,"user_id"=>$userID];
        $isUpdated=$database->update("a_internaship_periode","id=$isUpdate",$info);
            if(!$isUpdated){
                echo json_encode(["isOk"=>false,"data"=>"Internaship not changed try again"]);
                exit(0);
            }
            echo json_encode(["isOk"=>true,"data"=>" New Update Internaship(End:$endDate,status:$status,upload Marks:$isGraded)","i"=>$isUpdate,"o"=>"update"]);
        } catch (\Throwable $th) {
            echo json_encode(["isOk"=>false,"data"=>$th->getMessage()]);
            exit(0);
        }

   
      
        break;
    case 'GET_PARTNER_FOR_MAJOR_IN':
        $userID=$_SESSION['ht_userId'];
        $intern=input::get("inter");
        $major=input::get("major");
        // get all partners whose requested major and number
        $allP=$database->fetch("SELECT request_student_number,partner_id,given_student_number FROM a_partner_student_request WHERE internaship_id=$intern AND major_in='$major' GROUP BY partner_id");
        $partnerIds=[];
        foreach ($allP as $key => $p) {
            if($p["request_student_number"]>$p["given_student_number"]){
                $partnerIds=array_merge($partnerIds,[$p["partner_id"]]);
            }
        }
        // get parteners
        $lists=[];
        if(count($partnerIds)>0){
            $ids=implode(",",$partnerIds);
            $lists=$database->fetch("SELECT * from a_partner_tb where id IN($ids)");
        }
        echo json_encode(["data"=>$lists]);
        break;
    case 'PARTNER_REQUEST_STUDENT':
        try {
        $major=rtrim(input::get("major"),",");
        $major_value=rtrim(input::get("major_value"),",");
        $major=explode(",",$major);
        $major_value=explode(",",$major_value);
        $userID=$_SESSION['ht_userId'];
        $levelId=$_SESSION['ht_hotel'];
        $intern=input::get("inter");
         // remove all previsious recourd
        $database->query("DELETE  FROM a_partner_student_request where internaship_id= $intern AND partner_id=$levelId");
        $allStudent=0;
        $today=date('Y-m-d');
        $counts=count($major);
        $sql='';
        for ($i=0; $i <$counts; $i++) { 
            $allStudent+=$major_value[$i];
            $sql.="({$major_value[$i]},'{$major[$i]}',$levelId,$intern,'$today'),";
        }
        $sql=trim($sql,",");
        $sqlQuery="INSERT INTO a_partner_student_request(request_student_number,major_in,partner_id,internaship_id,created_at) VALUES $sql";
        // echo json_encode(["status"=>$sqlQuery]);
        // notify College
        $msg=$_SESSION['ht_name'] . " We are requesting ". $allStudent ." Student from your COllege";
        $notifyQuery="INSERT INTO notifications_tb(message,link,level,level_id,done_by) value('$msg','a_student_request_admin?id=$userId','ADMIN',1,$levelId)"; 
        $database->query($notifyQuery);
         // update requested student
         $database->query("DELETE from a_partner_student_request_totals WHERE internaship_id=$intern AND partner_id =$levelId");
         $database->insert("a_partner_student_request_totals",["requested_student"=>$allStudent,"internaship_id"=>$intern,"partner_id"=>$levelId]);
        if($database->query($sqlQuery)){
            // get level name
            echo json_encode(
            ["status"=>"ok",
            "students"=>$allStudent,
            "myId"=>$levelId,
            "from"=>$_SESSION['ht_name']]);
        }else{
        echo json_encode(["status"=>"Unable to request students"]);
        }
            } catch (\Throwable $e) {
                echo json_encode(["status"=>"Error |".$e->getMessage()]);
            }
 break;
 case 'SEND_EMAIL':
        $message = input::sanitize("message");
        $names = input::sanitize("names");
        $to = 'mbanzatrichard@gmail.com';
        $from = input::sanitize("email");
        $subject = input::sanitize("subject");
        $headers = "From: $from";
        $message .= "\n Written by $names";
        mail($to,$subject,$message,$headers);
        // header('Content-Type: application/json');
        echo json_encode(['status' => 'success']);
        break;
    default:
        echo json_encode(["isOk"=>false,"data"=>"action".$action.'  not found']);
        break;
}
?>