<?php
function redirect()
{
    echo "Unautorized <span >Redirecting ...</span>";
    echo '<meta http-equiv="refresh" content="1;url=./reports">';
    exit(0);
}
if (!input::required(array('rname'))) {
    redirect();
}
$rName = input::get("rname"); // report name;
$from = input::get('from');
$to = input::get('to');
$cIntern=$database->get("*","a_internaship_periode","status='activated'");
if(!isset($cIntern->id)){
  $cIntern=$database->get("*","a_internaship_periode","order by id desc"); 
} 
$totalDays=(int)input::getRemainingDateTime($cIntern->start_date,$cIntern->end_date);
if ($rName == "LSNCL") {
    // list of students did not completed de course
    $fdata=[];
    $sups = $database->fetch("SELECT id,first_name,last_name,major_in,card_id FROM a_student_tb where internaship_periode_id={$cIntern->id}");
    // print_r($sups);
    foreach ($sups as $key => $s) {
        $id=$s['card_id'];
        $studentLogBook=$database->count_all(" a_student_logbook where student_id='$id'");
        $pp=$studentLogBook?$studentLogBook:1;
        $fdata[]=(object)[
    "name"=>$s['first_name'].' '.$s['last_name'],
    "major_in"=>$s['major_in'],
    "card_id"=>$s['card_id'],
    "attended"=>$studentLogBook,
    "per"=>$studentLogBook?round($pp*100/$totalDays,1):0];
    }
    usort($fdata,function($first,$second){
        return $first->per < $second->per;
    });
    ?>
    <!-- THE SUPPLIER RATING -->
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0 pb-0 d-sm-flex d-block">
                <div class=" text-center d-flex justify-content-center align-items-center">
                    <h4 class="card-title mb-1  "> The Students  based on how completed the logbook in <?= $totalDays?> days <br />
                        <hr class=" hr" />
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class=" fs-13">#</th>
                                <th class=" fs-13">ID</th>
                                <th class=" fs-13">Names</th>
                                <th class=" fs-13">Major In</th>
                                <th class=" fs-13">Completed</th>
                                <th class=" fs-13">%</th>
                            </tr>
                        </thead>
                        <tbody class=" fs-12">
                            <?php
                            $i=1;
                            foreach ($fdata as $key => $h) {
                            ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td class=" text-capitalize"><?= $h->card_id ?></td>
                                    <td class=""><?= $h->name ?></td>
                                    <td class=""><?= $h->major_in?></td>
                                    <td class=""><?= $h->attended?></td>
                                    <td class=""><?= $h->per?>%</td>
                                </tr>
                            <?php
                                $i++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
<?php } elseif ($rName == "LSNG") {
    $cond="";
    $date="";
    if(input::required(array('from','to'))){
    $f=input::get('from');
    $t=input::get('to');
        $from=date('Y-m-d 00:00:00',strtotime($f));
        $to=date('Y-m-d 23:59:59',strtotime($t));
        $cond=" where created_at >='$from' AND created_at <='$to'";
        $date="($f to $t)";
    }
      $cond="where st.card_id NOT IN(SELECT student_id  from a_student_grade ast where ast.internaship_id={$cIntern->id})  AND st.internaship_periode_id=$cIntern->id ORDER BY card_id asc";
    ?>
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0 pb-0 d-sm-flex d-block">
                <div class=" text-center d-flex justify-content-center align-items-center">
                    <h4 class="card-title mb-1  "> List of Students haven't grades <br />
                        <hr class=" hr" />
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class=" fs-13">#</th>
                                <th class=" fs-13">ID</th>
                                <th class=" fs-13">Names</th>
                                <th class=" fs-13">Phone</th>
                                <th class=" fs-13">Major In</th>
                                <th class=" fs-13">Partner</th>
                                <th class=" fs-13">Suppervisor</th>
                            </tr>
                        </thead>
                        <tbody class=" fs-12">
                            <?php
        $lists=$database->fetch("SELECT * FROM a_student_tb st $cond");
        $i=0;
        $inters=[];
        $partners=[];
        $supv=[];
        foreach ($lists as $key => $h) {
            $i++;
            $h['internaship']='-';
            $h['institition_name']='-';
            $h['suppervisior_name']='-';
                // partner
                if(!isset($partners["i_{$h['partner_id']}"])){
                    $h['institition_name']="-";
                    if(isset($h['partner_id'])){
                    $int=$database->get("*","a_partner_tb","id={$h['partner_id']}");
                   $h['institition_name']=$int->name;
                   $partners=array_merge($partners,["i_{$h['partner_id']}"=>$h['institition_name']]);
                    }
               }else{
                   $h['institition_name']=$partners["i_{$h['partner_id']}"];  
               }
            // suppervisior
            if(!isset($supv["i_{$h['suppervisior_id']}"])){
                $h['suppervisior_name']='-';
                if(isset($h['suppervisior_id'])){
                $int=$database->get("*","a_suppervisior_tb","id={$h['suppervisior_id']}");
               $h['suppervisior_name']=$int->names;
               $supv=array_merge($supv,["i_{$h['suppervisior_id']}"=>$h['suppervisior_name']]);
                }
              
           }else{
               $h['suppervisior_name']=$supv["i_{$h['suppervisior_id']}"];  
           }
            ?>
            <tr>
            <td><?= $i?></td>
            <td class="pointer"><span class=" pointer"><?= $h['card_id'] ?></span></td>
                <td class=" text-capitalize"><?= $h['first_name'] .' '. $h['last_name'] ?></td>
                <td class=" text-capitalize"><?= $h['phone'] ?></td>
                <td class=" text-capitalize"><?= $h['major_in'] ?></td>

                <td class=" text-capitalize" id="pname<?=$h['id']?>"><?= $h['institition_name'] ?></td>
                <td class=" text-capitalize" id="sname<?=$h['id']?>"><?= $h['suppervisior_name'] ?></td> 
            </tr>
        <?php }
        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php } elseif ($rName == "LSNGS") {
    $cond="";
    $date="";
    if(input::required(array('from','to'))){
    $f=input::get('from');
    $t=input::get('to');
        $from=date('Y-m-d 00:00:00',strtotime($f));
        $to=date('Y-m-d 23:59:59',strtotime($t));
        $cond=" where created_at >='$from' AND created_at <='$to'";
        $date="($f to $t)";
    }
      $cond="where st.card_id NOT IN(SELECT student_id  from a_student_grade ast where ast.internaship_id={$cIntern->id} AND ast.s_marks IS NOT NULL)  AND st.internaship_periode_id=$cIntern->id ORDER BY card_id asc";
    ?>
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0 pb-0 d-sm-flex d-block">
                <div class=" text-center d-flex justify-content-center align-items-center">
                    <h4 class="card-title mb-1  "> List of Students haven't grades from Supervisors <br />
                        <hr class=" hr" />
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class=" fs-13">#</th>
                                <th class=" fs-13">ID</th>
                                <th class=" fs-13">Names</th>
                                <th class=" fs-13">Phone</th>
                                <th class=" fs-13">Major In</th>
                                <th class=" fs-13">Partner</th>
                                <th class=" fs-13">Suppervisor</th>
                            </tr>
                        </thead>
                        <tbody class=" fs-12">
                            <?php
        $lists=$database->fetch("SELECT * FROM a_student_tb st $cond");
        $i=0;
        $inters=[];
        $partners=[];
        $supv=[];
        foreach ($lists as $key => $h) {
            $i++;
            $h['internaship']='-';
            $h['institition_name']='-';
            $h['suppervisior_name']='-';
                // partner
                if(!isset($partners["i_{$h['partner_id']}"])){
                    $h['institition_name']="-";
                    if(isset($h['partner_id'])){
                    $int=$database->get("*","a_partner_tb","id={$h['partner_id']}");
                   $h['institition_name']=$int->name;
                   $partners=array_merge($partners,["i_{$h['partner_id']}"=>$h['institition_name']]);
                    }
               }else{
                   $h['institition_name']=$partners["i_{$h['partner_id']}"];  
               }
            // suppervisior
            if(!isset($supv["i_{$h['suppervisior_id']}"])){
                $h['suppervisior_name']='-';
                if(isset($h['suppervisior_id'])){
                $int=$database->get("*","a_suppervisior_tb","id={$h['suppervisior_id']}");
               $h['suppervisior_name']=$int->names;
               $supv=array_merge($supv,["i_{$h['suppervisior_id']}"=>$h['suppervisior_name']]);
                }
              
           }else{
               $h['suppervisior_name']=$supv["i_{$h['suppervisior_id']}"];  
           }
            ?>
            <tr>
            <td><?= $i?></td>
            <td class="pointer"><span class=" pointer"><?= $h['card_id'] ?></span></td>
                <td class=" text-capitalize"><?= $h['first_name'] .' '. $h['last_name'] ?></td>
                <td class=" text-capitalize"><?= $h['phone'] ?></td>
                <td class=" text-capitalize"><?= $h['major_in'] ?></td>

                <td class=" text-capitalize" id="pname<?=$h['id']?>"><?= $h['institition_name'] ?></td>
                <td class=" text-capitalize" id="sname<?=$h['id']?>"><?= $h['suppervisior_name'] ?></td> 
            </tr>
        <?php }
        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php }
else if ($rName == "LSNP") { 
           $cond="where  st.internaship_periode_id=$cIntern->id AND  partner_id  IS NULL ORDER BY card_id asc";
           ?>
           <div class="col-12">
               <div class="card">
                   <div class="card-header border-0 pb-0 d-sm-flex d-block">
                       <div class=" text-center d-flex justify-content-center align-items-center">
                           <h4 class="card-title mb-1  "> List of Students haven't partners <br />
                               <hr class=" hr" />
                           </h4>
                       </div>
                   </div>
                   <div class="card-body">
                       <div class="table-responsive">
                           <table class="table">
                               <thead>
                                   <tr>
                                       <th class=" fs-13">#</th>
                                       <th class=" fs-13">ID</th>
                                       <th class=" fs-13">Names</th>
                                       <th class=" fs-13">Phone</th>
                                       <th class=" fs-13">Major In</th>
                                       <th class=" fs-13">Partner</th>
                                   </tr>
                               </thead>
                               <tbody class=" fs-12">
                                   <?php
               $lists=$database->fetch("SELECT * FROM a_student_tb st $cond");
               $i=0;
               $inters=[];
               $partners=[];
               $supv=[];
               foreach ($lists as $key => $h) {
                   $i++;
                   $h['internaship']='-';
                   $h['institition_name']='-';
                   $h['suppervisior_name']='-';
                       // partner
                       if(!isset($partners["i_{$h['partner_id']}"])){
                           $h['institition_name']="-";
                           if(isset($h['partner_id'])){
                           $int=$database->get("*","a_partner_tb","id={$h['partner_id']}");
                          $h['institition_name']=$int->name;
                          $partners=array_merge($partners,["i_{$h['partner_id']}"=>$h['institition_name']]);
                           }
                      }else{
                          $h['institition_name']=$partners["i_{$h['partner_id']}"];  
                      }
                   // suppervisior
                   if(!isset($supv["i_{$h['suppervisior_id']}"])){
                       $h['suppervisior_name']='-';
                       if(isset($h['suppervisior_id'])){
                       $int=$database->get("*","a_suppervisior_tb","id={$h['suppervisior_id']}");
                      $h['suppervisior_name']=$int->names;
                      $supv=array_merge($supv,["i_{$h['suppervisior_id']}"=>$h['suppervisior_name']]);
                       }
                     
                  }else{
                      $h['suppervisior_name']=$supv["i_{$h['suppervisior_id']}"];  
                  }
                   ?>
                   <tr>
                   <td><?= $i?></td>
                   <td class="pointer"><span class=" pointer"><?= $h['card_id'] ?></span></td>
                       <td class=" text-capitalize"><?= $h['first_name'] .' '. $h['last_name'] ?></td>
                       <td class=" text-capitalize"><?= $h['phone'] ?></td>
                       <td class=" text-capitalize"><?= $h['major_in'] ?></td>
                       <td class=" text-capitalize" id="pname<?=$h['id']?>"><?= $h['institition_name'] ?></td>
                   </tr>
               <?php }
               ?>
                               </tbody>
                           </table>
                       </div>
                   </div>
               </div>
           </div>
           

<?php } else if ($rName == "LSWG") {
  
      $cond="where  st.internaship_periode_id=$cIntern->id  ORDER BY sg.marks DESC";
    ?>
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0 pb-0 d-sm-flex d-block">
                <div class=" text-center d-flex justify-content-center align-items-center">
                    <h4 class="card-title mb-1  "> List of Students with grades <br />
                        <hr class=" hr" />
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class=" fs-13">#</th>
                                <th class=" fs-13">ID</th>
                                <th class=" fs-13">Names</th>
                                <th class=" fs-13">Phone</th>
                                <th class=" fs-13">Major In</th>
                                <th class=" fs-13">Partner</th>
                                <th class=" fs-13">Suppervisor</th>
                                <th class=" fs-13">Marks</th>
                            </tr>
                        </thead>
                        <tbody class=" fs-12">
                            <?php
        $lists=$database->fetch("SELECT st.*,sg.marks FROM a_student_tb st INNER JOIN a_student_grade  sg ON st.card_id=sg.student_id   $cond");
        $i=0;
        $inters=[];
        $partners=[];
        $supv=[];
        foreach ($lists as $key => $h) {
            $i++;
            $h['internaship']='-';
            $h['institition_name']='-';
            $h['suppervisior_name']='-';
                // partner
                if(!isset($partners["i_{$h['partner_id']}"])){
                    $h['institition_name']="-";
                    if(isset($h['partner_id'])){
                    $int=$database->get("*","a_partner_tb","id={$h['partner_id']}");
                   $h['institition_name']=$int->name;
                   $partners=array_merge($partners,["i_{$h['partner_id']}"=>$h['institition_name']]);
                    }
               }else{
                   $h['institition_name']=$partners["i_{$h['partner_id']}"];  
               }
            // suppervisior
            if(!isset($supv["i_{$h['suppervisior_id']}"])){
                $h['suppervisior_name']='-';
                if(isset($h['suppervisior_id'])){
                $int=$database->get("*","a_suppervisior_tb","id={$h['suppervisior_id']}");
               $h['suppervisior_name']=$int->names;
               $supv=array_merge($supv,["i_{$h['suppervisior_id']}"=>$h['suppervisior_name']]);
                }
              
           }else{
               $h['suppervisior_name']=$supv["i_{$h['suppervisior_id']}"];  
           }
            ?>
            <tr>
            <td><?= $i?></td>
            <td class="pointer"><span class=" pointer"><?= $h['card_id'] ?></span></td>
                <td class=" text-capitalize"><?= $h['first_name'] .' '. $h['last_name'] ?></td>
                <td class=" text-capitalize"><?= $h['phone'] ?></td>
                <td class=" text-capitalize"><?= $h['major_in'] ?></td>

                <td class=" text-capitalize"><?= $h['institition_name'] ?></td>
                <td class=" text-capitalize" ><?= $h['suppervisior_name'] ?></td>
                <td class=" text-capitalize" ><?= $h['marks'] ?></td>  
            </tr>
        <?php }
        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php ?>

<?php } else if ($rName == "LSWGS") {
  
  $cond="where  st.internaship_periode_id=$cIntern->id AND sg.s_marks IS NOT NULL ORDER BY sg.marks DESC";
?>
<div class="col-12">
    <div class="card">
        <div class="card-header border-0 pb-0 d-sm-flex d-block">
            <div class=" text-center d-flex justify-content-center align-items-center">
                <h4 class="card-title mb-1  "> List of Students with grades from supervisors <br />
                    <hr class=" hr" />
                </h4>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class=" fs-13">#</th>
                            <th class=" fs-13">ID</th>
                            <th class=" fs-13">Names</th>
                            <th class=" fs-13">Phone</th>
                            <th class=" fs-13">Major In</th>
                            <th class=" fs-13">Partner</th>
                            <th class=" fs-13">Suppervisor</th>
                            <th class=" fs-13">Marks</th>
                        </tr>
                    </thead>
                    <tbody class=" fs-12">
                        <?php
    $lists=$database->fetch("SELECT st.*,sg.s_marks as marks FROM a_student_tb st INNER JOIN a_student_grade  sg ON st.card_id=sg.student_id   $cond");
    $i=0;
    $inters=[];
    $partners=[];
    $supv=[];
    foreach ($lists as $key => $h) {
        $i++;
        $h['internaship']='-';
        $h['institition_name']='-';
        $h['suppervisior_name']='-';
            // partner
            if(!isset($partners["i_{$h['partner_id']}"])){
                $h['institition_name']="-";
                if(isset($h['partner_id'])){
                $int=$database->get("*","a_partner_tb","id={$h['partner_id']}");
               $h['institition_name']=$int->name;
               $partners=array_merge($partners,["i_{$h['partner_id']}"=>$h['institition_name']]);
                }
           }else{
               $h['institition_name']=$partners["i_{$h['partner_id']}"];  
           }
        // suppervisior
        if(!isset($supv["i_{$h['suppervisior_id']}"])){
            $h['suppervisior_name']='-';
            if(isset($h['suppervisior_id'])){
            $int=$database->get("*","a_suppervisior_tb","id={$h['suppervisior_id']}");
           $h['suppervisior_name']=$int->names;
           $supv=array_merge($supv,["i_{$h['suppervisior_id']}"=>$h['suppervisior_name']]);
            }
          
       }else{
           $h['suppervisior_name']=$supv["i_{$h['suppervisior_id']}"];  
       }
        ?>
        <tr>
        <td><?= $i?></td>
        <td class="pointer"><span class=" pointer"><?= $h['card_id'] ?></span></td>
            <td class=" text-capitalize"><?= $h['first_name'] .' '. $h['last_name'] ?></td>
            <td class=" text-capitalize"><?= $h['phone'] ?></td>
            <td class=" text-capitalize"><?= $h['major_in'] ?></td>

            <td class=" text-capitalize"><?= $h['institition_name'] ?></td>
            <td class=" text-capitalize" ><?= $h['suppervisior_name'] ?></td>
            <td class=" text-capitalize" ><?= $h['marks'] ?></td>  
        </tr>
    <?php }
    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php ?>
<?php } else if ($rName == "LSNS") { 
           $cond="where  st.internaship_periode_id=$cIntern->id AND  suppervisior_id   IS NULL ORDER BY card_id asc";
           ?>
           <div class="col-12">
               <div class="card">
                   <div class="card-header border-0 pb-0 d-sm-flex d-block">
                       <div class=" text-center d-flex justify-content-center align-items-center">
                           <h4 class="card-title mb-1  "> List of Students haven't supervisors <br />
                               <hr class=" hr" />
                           </h4>
                       </div>
                   </div>
                   <div class="card-body">
                       <div class="table-responsive">
                           <table class="table">
                               <thead>
                                   <tr>
                                       <th class=" fs-13">#</th>
                                       <th class=" fs-13">ID</th>
                                       <th class=" fs-13">Names</th>
                                       <th class=" fs-13">Phone</th>
                                       <th class=" fs-13">Major In</th>
                                       <th class=" fs-13">Supervisior</th>
                                   </tr>
                               </thead>
                               <tbody class=" fs-12">
                                   <?php
               $lists=$database->fetch("SELECT * FROM a_student_tb st $cond");
               $i=0;
               $inters=[];
               $partners=[];
               $supv=[];
               foreach ($lists as $key => $h) {
                   $i++;
                   $h['suppervisior_name']='-';
                   // suppervisior
                   ?>
                   <tr>
                   <td><?= $i?></td>
                   <td class="pointer"><span class=" pointer"><?= $h['card_id'] ?></span></td>
                       <td class=" text-capitalize"><?= $h['first_name'] .' '. $h['last_name'] ?></td>
                       <td class=" text-capitalize"><?= $h['phone'] ?></td>
                       <td class=" text-capitalize"><?= $h['major_in'] ?></td>
                       <td class=" text-capitalize" id="pname<?=$h['id']?>"><?= $h['suppervisior_name'] ?></td>
                   </tr>
               <?php }
               ?>
                               </tbody>
                           </table>
                       </div>
                   </div>
               </div>
           </div>
<?php } elseif ($rName == "SLB" && isset($_GET['student_id'])) {
 
 $id=(int)$_GET['student_id'];
 $cond="WHERE st.card_id=al.student_id  AND al.internaship_id='{$cIntern->id}'";
 if($id!=0){
 $student=$database->get("*","a_student_tb","card_id=$id");
 if(!isset($student->id) ){
     echo "<center><div class='alert alert-danger'>Student with $id as student id not found try again</center></h1>";
     exit(0);
 }
 $cond="WHERE st.card_id=al.student_id AND al.student_id=$student->card_id AND al.internaship_id='{$cIntern->id}'";
}
$sql= "SELECT al.*,st.first_name,st.last_name,st.card_id FROM a_student_logbook as al INNER JOIN a_student_tb as st $cond order by al.log_date asc";
    // echo $sql;
$lists=$database->fetch($sql);
    ?>
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0 pb-0 d-sm-flex d-block">
                <div class=" text-center d-flex justify-content-center align-items-center">
                    <h4 class="card-title mb-1"> Student(s) logbook<br />
                        <hr class=" hr" />
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                    <thead>
                                        <tr>
                                          <th class=" fs-13">#</th>
                                           <th class=" fs-13">Date</th>
                                            <th class=" fs-13">Names/ID</th>
                                            <th class=" fs-13">Description</th>                                       
                                            <th class=" fs-13">Lesson </th>
                                            <th class=" fs-13">Challenges</th>
                                            <th class=" fs-13">P. Comment</th>
                                            <th class=" fs-13">S. Comment</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                      
                                    <tbody class=" fs-12">
                                        <?php
                                        $i=0;
                                        foreach ($lists as $key => $h) {
                                            $i++;
                                            ?>
                                            <tr>
                                            <td><?= $i?></td>
                                            <td class=""><?= $h['created_at'] ?></td>
                                                <td  ><span class=" pointer"><?= $h['first_name']." ".$h['last_name'] ?>/<?=$h['card_id']?></span></td>                                            
                                                <td class=" text-capitalize"><?= $h['name'] ?></td>
                                                <td class=""><?= $h['objective'] ?></td>
                                                <td class=""><?= $h['challenges'] ?></td>
                                                <td class=""><?= $h['partner_comment'] ?></td>
                                                <td class="" id="sup<?=$h['id']?>"><?= $h['suppervisior_comment'] ?></td>
                                     
                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                               
                    
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php 
} else if($rName == "CR") { 
    $fdata=[];
    $allRequested=$database->get("sum(request_student_number) as total","a_partner_student_request","1")->total;
    $sups = $database->fetch("SELECT SUM(request_student_number) as requested, major_in FROM a_partner_student_request ps group by major_in ");
    // print_r($sups);
    foreach ($sups as $key => $s) {
        $mr=$s['requested'];
        $fdata[]=(object)[
    "major_in"=>$s['major_in'],
    "requested"=>$mr,
    "per"=>$mr?round($mr*100/$allRequested,1):0];
    }
    usort($fdata,function($first,$second){
        return $first->per < $second->per;
    });
    ?>
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0 pb-0 d-sm-flex d-block">
                <div class=" text-center d-flex justify-content-center align-items-center">
                    <h4 class="card-title mb-1">Courses rating based on how the partners requested students <br />
                        <hr class=" hr" />
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                    <thead>
                                        <tr>
                                          <th class=" fs-13">#</th>
                                           <th class=" fs-13">Course</th>
                                            <th class=" fs-13">Requested</th>
                                            <th class=" fs-13">%</th>                                       
                                            <th></th>
                                        </tr>
                                    </thead>
                                      
                                    <tbody class=" fs-12">
                                        <?php
                                        $i=0;
                                        foreach ($fdata as $key => $h) {
                                            $i++;
                                            ?>
                                            <tr>
                                            <td><?= $i?></td>                                         
                                                <td class=" text-capitalize"><?= $h->major_in ?></td>
                                                <td class=""><?= $h->requested ?></td>
                                                <td class=""><?= $h->per ?>%</td>
                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                               
                    
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php }?>
