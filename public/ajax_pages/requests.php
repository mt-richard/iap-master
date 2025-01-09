<?php 
require("../../config/grobals.php");
// include input and validate
require("../../util/input.php");
include("../../util/validate.php");
$action=input::get("action");
if(!isset($_SESSION)){
    session_start();
}
function displayData($sql="SELECT 1",$page="/",$k=""){
    global $database;
     $rows=$database->fetch($sql);
   foreach ($rows as $key => $r) {
    echo "<li> <a href='$page?d={$r['id']}'>{$r['card_id']}:{$r['name']}</a></li>";
   }
}
switch ($action) {
    case 'CHECK_NOTIFICATION':
        if(!$_SESSION['ht_level']){
            echo "Session expired";
            exit(0);
        }
        $level=$_SESSION['ht_level'];
        $levelId=$level!="STUDENT"?$_SESSION['ht_hotel']:$_SESSION['ht_userId'];
        $hasNotification=$database->count_all("notifications_tb WHERE level_id=$levelId AND level='$level'");
        if($hasNotification){
          $rows=$database->fetch("SELECT * FROM notifications_tb WHERE level_id=$levelId AND level='$level' order by id desc limit 5 ");
          foreach ($rows as $key => $row) { 
            $row['id']=input::enc_dec("e",$row['id']);
            ?>
        <li>
          <div class="timeline-panel" onclick="window.location.href='<?=$row['link']?>&n=<?=$row['id']?>'">
            <div class="media me-2 media-danger">NT</div>
            <div class="media-body">
              <h6 class="mb-1"><?=$row['message'] ?></h6>
              <small class="d-block"><?=input::timeAgo($row['created_at'])?></small>
            </div>
          </div>
        </li>
          <?php
         }
        }else{
            echo "none";
        }
        break;

    case 'MAIN_SEARCH':
        if(!input::required(array('q'))){
            echo '';
            exit();
        }
        $q=$database->escape_value($_GET['q']);
        $level=$_SESSION['ht_level'];
        $userId=$_SESSION['ht_hotel'];
        if($level=="ADMIN"){
        // find(partner,suppervisior,student,)
        displayData("SELECT id,card_id, concat(first_name,' ',last_name) as name from a_student_tb WHERE (first_name like '%$q%' OR last_name LIKE '%$q%' OR card_id LIKE '$q%')","a_student","STU");
        }elseif($level=="PARTNER"){
            /*1. student 2.logbook*/
            displayData("SELECT id,card_id, concat(first_name,' ',last_name) as name from a_student_tb WHERE partner_id=$userId AND  (first_name like '%$q%' OR last_name LIKE '%$q%' OR card_id LIKE '$q%')","a_partner_student","STU");
        }
        elseif($level=="SUPERVISIOR"){
            /*1. student 2.logbook*/
            displayData("SELECT id,card_id, concat(first_name,' ',last_name) as name from a_student_tb WHERE suppervisior_id=$userId AND  (first_name like '%$q%' OR last_name LIKE '%$q%' OR card_id LIKE '$q%')","a_partner_student","STU");
        }
        else{
            // displayData('device_requests',$q,"requested","DEV");
        }
        break;
    case 'NOTIFY':
        $url=input::get("url");
        $level=input::get("level");
        $msg=input::sanitize("message");
        $levelId=input::sanitize("level_id");
        $user=$_SESSION['ht_userId'];
        if(isset($_GET['dt'])){
            $url.="&dt={$_GET['dt']}";
        }
        $isInserted=$database->insert("notifications_tb",
        ["message"=>$msg,"link"=>$url,"level"=>$level,"level_id"=>$levelId,"done_by"=>$user]);
        if($isInserted){
            echo json_encode(["isOk"=>true,"data"=>"success"]); 
        }else{
            echo json_encode(["isOk"=>false,"data"=>"fail"]);
        }
        break;
        case 'NOTIFY_ALL':
            try {
                $msg=input::sanitize("message");
            $user=$_SESSION['ht_userId'];
            $i_id=input::sanitize("i");
            $orign=input::sanitize("o");
            // get current student
            $q="SELECT card_id,partner_id,suppervisior_id FROM a_student_tb st,a_partner_tb where st.internaship_periode_id=$i_id";
            $rows=$database->fetch($q);
            $sups=[];
            $pars=[];
            $stus=[];
            foreach ($rows as $key => $row) {
               if(is_numeric($row['suppervisior_id']) && $orign=="update" && !in_array($row['suppervisior_id'],$sups)){
                $sups=array_merge($sups,[$row['suppervisior_id']]);
                $database->insert("notifications_tb",["message"=>$msg,"link"=>"home?id","level"=>'SUPERVISIOR',"level_id"=>$row['suppervisior_id'],"done_by"=>$user]);
               }
               if(is_numeric($row['partner_id']) && $orign=="update" && !in_array($row['partner_id'],$pars)){
                $pars=array_merge($pars,[$row['partner_id']]);
                $database->insert("notifications_tb",["message"=>$msg,"link"=>"home?id","level"=>'PARTNER',"level_id"=>$row['partner_id'],"done_by"=>$user]);
            }
            if( $orign=="update" && !in_array($row['card_id'],$stus)){
                $stus=array_merge($stus,[$row['card_id']]);
            $database->insert("notifications_tb",["message"=>$msg,"link"=>"home?id","level"=>'STUDENT',"level_id"=>$row['card_id'],"done_by"=>$user]);
            }
        }
            if($orign=="create"){
                $partners=$database->fetch("SELECT id FROM a_partner_tb where is_active='yes'");
             foreach ($partners as $key => $p) {
                $database->insert("notifications_tb",["message"=>$msg,"link"=>"home?id","level"=>'PARTNER',"level_id"=>$p['id'],"done_by"=>$user]);
             }
            }
            echo "sent";
            } catch (\Throwable $e) {
            echo "Failed " . $e->getMessage();
            }
            break;
    default:
        echo json_encode(["isOk"=>false,"data"=>"action".$action.'  not found']);
        break;
}
?>