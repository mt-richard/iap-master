<?php 

require("../../config/grobals.php");
require("../../util/input.php");
include("../../util/validate.php");
$action=input::get("action");
if($action=="GET_EXTRA_INFO"){
    // echo "display the data";
    $p=(int)input::get("p");
    $intern=input::get("inter");
    if($p==0){
        //  get all partners that selected major courses
        $name=input::get("major");
        $sql="SELECT partner_id, SUM(request_student_number) as requested,SUM(given_student_number) as given FROM a_partner_student_request WHERE internaship_id=$intern AND major_in='$name' group by partner_id";
        $rows=$database->fetch($sql);
        echo "<table class='table '><thead><th>#</th><th>Partner</th><th>Requested</th><th>Given</th></thead><tbody>";
        foreach ($rows as $key => $r) {
            $parter=$database->get("name","a_partner_tb","id={$r['partner_id']}")->name;
            ?>
            <tr><td><?=$key+1?></td><td><?=$parter?></td><td><?=$r['requested']?></td><td><?=$r['given']?></td></tr>
        <?php }
        echo "</tbody></table>";
    }else{
        // get all majors selected by a partners
        $lists=0;
        $name=input::get("major");
        $sql="SELECT major_in, SUM(request_student_number) as requested,SUM(given_student_number) as given FROM a_partner_student_request WHERE internaship_id=$intern AND partner_id=$p group by major_in";
        $rows=$database->fetch($sql);
        echo "<table class='table '><thead><th>#</th><th>Major</th><th>Requested</th><th>Given</th></thead><tbody>";
        foreach ($rows as $key => $r) {
            // $parter=$database->get("name","a_partner_tb","id={$r['partner_id']}")->name;
            ?>
            <tr><td><?=$key+1?></td><td><?=$r['major_in']?></td><td><?=$r['requested']?></td><td><?=$r['given']?></td></tr>
        <?php }
        echo "</tbody></table>";
    }
}
?>