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
    case 'SEND_REPLACED_TO_SUP':
        $serial=input::get("serial");
        $name=input::get("name");
        $id=input::get('dId');
        $userID=$_SESSION['ht_userId'];
        $code=input::get('request_code');
        // inst_requests
        $supAdmin=$database->get("sup_id","inst_requests","r_code='$code'")->sup_id;
        $formData=['c_flow'=>'supToConfirm'];
        $msg="$name with  #".$serial .'  as serial number need to be replaced';
        $isUpdated=$database->update("supplied_devices","id=$id",$formData);
        if($isUpdated){
            $notifyQuery="INSERT INTO notifications_tb(message,link,level,level_id,done_by) value('$msg','status?d=$id&nm=$name','SUP_ADMIN',$supAdmin,$userID)"; 
           $database->query($notifyQuery);
            echo json_encode(["isOk"=>true,"data"=>$id]); 
        }else{
            echo json_encode(["isOk"=>false,"data"=>"Operation failed try again may been you has been made action before"]); 
        }
        break;
    case 'SEND_REPLACED_TO_ADMIN':
        $serial=input::get("serial");
        $name=input::get("name");
        $id=input::get('dId');
        $userID=$_SESSION['ht_userId'];
        $code=input::get('request_code');
        // inst_requests
        // $supAdmin=$database->get("sup_id","inst_requests","request_code='$code'")->sup_id;
        $formData=['c_flow'=>'supToAdmin'];
        $msg="The supplier request device replacement confirmation #$serial";
        $isUpdated=$database->update("supplied_devices","id=$id",$formData);
        if($isUpdated){
            $notifyQuery="INSERT INTO notifications_tb(message,link,level,level_id,done_by) value('$msg','status?d=$id&nm=$name','ADMIN',1,$userID)"; 
           $database->query($notifyQuery);
            echo json_encode(["isOk"=>true,"data"=>$id]); 
        }else{
            echo json_encode(["isOk"=>false,"data"=>"Operation failed try again may been you has been made action before"]); 
        }
        break;
        break;
    case 'GET_BEN':
        $inst=(int)input::get('i');
        $lists=$database->fetch("SELECT * FROM beneficiary_tb where institition_id=$inst order by id desc");
            $i=0;
            echo "<option value='' selected disabled>__select__</option>";
            foreach ($lists as $key => $h) {
                echo "<option value='{$h['id']}'>{$h['name']}</option>";
            }
        break;
    case 'SEND_REPLACED_TO_BEN':
        // send confirmation to ben # done by inst
        $serial=input::get("serial");
        $name=input::get("name");
        $id=input::get('dId');
        $userID=$_SESSION['ht_userId'];
        $code=input::get('request_code');
        $benAdmin=$database->get("ben_id","device_requests","request_code='$code'")->ben_id;
        // $benAdmin=$database->get("institition_id","device_requests","request_code='$code'")->institition_id;
        $msg="The Instistition request device replacement confirmation #$serial";
        $notifyQuery="INSERT INTO notifications_tb(message,link,level,level_id,done_by) value('$msg','status?d=$id&nm=$name','BEN_ADMIN',$benAdmin,$userID)"; 
         if($database->query($notifyQuery)){
            $isUpdated=$database->update("supplied_devices","id=$id",['c_flow'=>'benToConfirm']);
            echo json_encode(["isOk"=>true,"data"=>$id]); 
        }else{
            echo json_encode(["isOk"=>false,"data"=>"Operation failed "]); 
        }
        break;
    case 'CONFIRM_REPLACEMENENT_TO_INST':
        // send confirmation to insti done by ben
        $serial=input::get("serial");
        $id=input::get('dId');
        $userID=$_SESSION['ht_userId'];
        $name=input::get('name');
        $inst=$_SESSION['ht_hotel'];
        $msg="device with  #$serial as serial number has been recieved by BEN";
        $isUpdated=$database->update("supplied_devices","id=$id",['c_flow'=>'instToBen','status'=>'functional']);
        $notifyQuery="INSERT INTO notifications_tb(message,link,level,level_id,done_by) value('$msg','status?d=$id&nm=$name','INST_ADMIN',$inst,$userID)"; 
         if($database->query($notifyQuery)){
            echo json_encode(["isOk"=>true,"data"=>$id]); 
        }else{
            echo json_encode(["isOk"=>false,"data"=>"Operation failed "]); 
        }
            break;
    case 'REPLACE_REPORTED_DEVICE':
        $name=input::get("name");
        $userID=$_SESSION['ht_userId'];
        $serial=input::get('serial');
        $new_serial=input::get('new_serial');
        $new_name=input::get('new_name');
        $new_manufacturer=input::get('new_manufacturer');
        $code=input::get('request_code');
        $id=input::get('dId');
        $description=input::get('old_comment');
        $status=input::get('status');
        if(!input::required(array('new_serial'))){
            echo json_encode(["isOk"=>false,"data"=>'Serial number is required please check your inputs']);
            exit(0);
        }
        $msg="$name with  #".$serial .' has been replaced with  #'.$new_serial;
        $formData=["has_replaced"=>"yes","updated_at"=>date('Y-m-d H:i:s'),"c_flow"=>'adminToInst',"status_date"=>date('Y-m-d'),
        'serial_number'=>$new_serial,"comment"=>$description .'<p>#old serial number:'.$serial.'</p>'];
        $isUpdated=$database->update("supplied_devices","id=$id",$formData);
        if($isUpdated){
            $benAdmin=$database->get("institition_id","device_requests","request_code='$code'")->institition_id;
            // insert new supllied devices
            $notifyQuery="INSERT INTO notifications_tb(message,link,level,level_id,done_by) value('$msg','status?d=$id&nm=$name','INST_ADMIN',$benAdmin,$userID)"; 
            $database->query($notifyQuery);
            echo json_encode(["isOk"=>true,"data"=>$id]); 
        }else{
            echo json_encode(["isOk"=>false,"data"=>"Operation failed try again may been you has been made action before"]); 
        }
        break;
    case 'REJECT_DEVICE_REPORTING':
        $name=input::get("name");
        $userID=$_SESSION['ht_userId'];
        $old_comment=input::get('old_comment');
        $serial=input::get('serial');
        $code=input::get('request_code');
        $id=input::get('dId');
        $description=input::get('description');
        $status=input::get('status');
        if(empty($status)){
            echo json_encode(["isOk"=>false,"data"=>'Status is required']);
            exit(0);
        }
        $msg="$name with  #".$serial .' rejected to be replaced #'.$description;
        $formData=[
        "c_flow"=>"instToReject","status"=>$status,
        "updated_at"=>date('Y-m-d H:i:s'),"comment"=>$old_comment.'<br/>'.$description];
        $isUpdated=$database->update("supplied_devices","id=$id",$formData);
        if($isUpdated){
            $benAdmin=$database->get("ben_id","device_requests","request_code='$code'")->ben_id;
            $notifyQuery="INSERT INTO notifications_tb(message,link,level,level_id,done_by) value('$msg','status?d=$id&nm=$name','BEN_ADMIN',$benAdmin,$userID)"; 
            $database->query($notifyQuery);
            echo json_encode(["isOk"=>true,"data"=>$id]); 
        }else{
            echo json_encode(["isOk"=>false,"data"=>"Operation failed try again may been you has been made action before"]); 
        }
        break;
    case'REPORTING_TO_ADMIN':
        $id=input::get('id');
        $name=input::get("name");
        $userID=$_SESSION['ht_userId'];
        $serial=input::get("serial");
        $formData=['c_flow'=>'instToAdmin','has_reported'=>"yes"];
        $msg="$name with  #".$serial .'  as serial number need to be replaced';
        $isUpdated=$database->update("supplied_devices","id=$id",$formData);
        if($isUpdated){
            $notifyQuery="INSERT INTO notifications_tb(message,link,level,level_id,done_by) value('$msg','status?d=$id&nm=$name','ADMIN',1,$userID)"; 
           $database->query($notifyQuery);
            echo json_encode(["isOk"=>true,"data"=>$id]); 
        }else{
            echo json_encode(["isOk"=>false,"data"=>"Operation failed try again may been you has been made action before"]); 
        }
        break;
    case 'DEVICE_HEALTH_STATUS':
        if(!input::required(array('description'))){
            echo json_encode(["isOk"=>false,"data"=>"Please description is required"]); 
            exit();  
        }
        $id=input::get('dId');
        $cs=input::get("currentS");
        $status=input::get('status');
        $btnC=input::get("btnClicked");
        $name=input::get("dname");
        $serial=input::get("serial");
        $comment=input::get("description");
        // check status
        if($status==$cs && $btnC!='NR'){
            echo json_encode(["isOk"=>false,"data"=>"last status are the same with new status you selected"]); 
            exit();  
        }
        $userID=$_SESSION['ht_userId'];
        $i=$_SESSION['ht_hotel'];
        $formData=["status"=>$status,"updated_at"=>date('Y-m-d H:i:s'),'has_reported'=>'no','comment'=>$comment];
        $msg="$name with $serial as serial number   placed to $status mode ";
        if($btnC==="NR"){
            $formData['c_flow']='benToInst';
            $formData['status']='nonfunctional';
            $msg="$name with  #".$serial .'  as serial number need to be replaced';
        }
$isUpdated=$database->update("supplied_devices","id=$id",$formData);

if($isUpdated){
    $notifyQuery="INSERT INTO notifications_tb(message,link,level,level_id,done_by) value('$msg','status?d=$id&nm=$name','INST_ADMIN',$i,$userID)"; 
   $database->query($notifyQuery);
    echo json_encode(["isOk"=>true,"data"=>$id]); 
}else{
    echo json_encode(["isOk"=>false,"data"=>"Operation failed try again"]); 
}
       break;
    case 'CREATE_NEW_DEVICE':
        if(!isset($_SESSION['ht_userId'])){
            echo json_encode(["isOk"=>false,"data"=>"Access denied"]); 
            exit();
        }
        if($_SESSION['ht_level']!="INST_ADMIN"){
            echo json_encode(["isOk"=>false,"data"=>"Access denied; please contact  admin"]); 
            exit(); 
        }
        $val=new validate();
        $val->check($_POST,[
         "name"=>["required"=>true,"max"=>50],
         "category"=>['required'=>true,"max"=>50],
         ]);
         if(!$val->passed()){
             echo json_encode(["isOk"=>false,"data"=>implode(',',$val->errors())]); 
             exit();
         }
        //  check if devices was registered
        $inst=$_SESSION['ht_hotel'];
        $cat=$_POST['category'];
        $name=strtolower($_POST['name']);
        $isNameExist=$database->count_all("allowed_devices where institition_id =$inst AND cat='$cat' AND name='$name'");
        if($isNameExist>0){
                echo json_encode(["isOk"=>false,"data"=>$name .' already exists']); 
                exit(); 
        }
        $formData=[
            "name"=>$name,
            "cat"=>$_POST['category'],
            "institition_id "=>$_SESSION['ht_hotel'],
        ];
        $isInserted=$database->insert("allowed_devices",$formData);
        if($isInserted){
            echo json_encode(["isOk"=>true,"data"=>input::get("name") ."  has been saved"]); 
        }else{
            echo json_encode(["isOk"=>false,"data"=>input::get("name") ." Failed to be created please try again"]);
        }
        break;
    case 'CREATE_NEW_BEN':
        // get hote code,Ymd
        if(!isset($_SESSION['ht_userId'])){
            echo json_encode(["isOk"=>false,"data"=>"Access denied"]); 
            exit();
        }
        // check if it is system,manager
        // if($_SESSION['ht_level']!="INST_ADMIN"){
        //     echo json_encode(["isOk"=>false,"data"=>"Access denied; please contact  admin"]); 
        //     exit(); 
        // }
        $val=new validate();
       $val->check($_POST,[
        "name"=>["required"=>true,"max"=>30,"unique"=>["table"=>"beneficiary_tb","column"=>'name']],
        "phone"=>['required'=>true,"min"=>10],
        "email"=>['required'=>true,"max"=>100]
        ]);
        if(!$val->passed()){
            echo json_encode(["isOk"=>false,"data"=>implode(',',$val->errors())]); 
            exit();
        }
        if(!input::valid_email($_POST['email'])){
            echo json_encode(["isOk"=>false,"data"=>"Invalide Email"]); 
            exit();   
        }
        $inst=$_SESSION['ht_hotel'];
if($_SESSION['ht_level']=="ADMIN"){
    $inst=input::get('institition');
    if(empty($inst)){
        echo json_encode(["isOk"=>false,"data"=>"Institition is required"]); 
        exit();
    }
}
    $userData=[
        "name"=>$database->escape_value($_POST['name']),
        "email"=>$database->escape_value($_POST['email']),
        "phone"=>$database->escape_value($_POST['phone']),
        "user_id"=>$_SESSION['ht_userId'],
        "institition_id "=>$inst,
    ];
    $isUserInserted=$database->insert("beneficiary_tb",$userData);
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