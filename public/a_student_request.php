<?php
// require_once("../config/grobals.php");
include("./includes/head.php");
if(session::get("is_active")!='yes' && $level=='PARTERN'){
    echo "Unautorized <span >Redirecting ...</span>";
    echo '<meta http-equiv="refresh" content="1;url=./home">';
    exit(0);
}
?>
<div id="main-wrapper">
    <?php include("./includes/sidebar.php") ?>
    <!-- header here -->
    <?php include("./header.php") ?>
    <?php
    $currentIntern=$cIntern;
    $studentNumbers=0;
    $given=0;
    $requested=0;
    $userID=$_SESSION['ht_hotel'];
    
    
    if(isset($currentIntern->id)){
    $studentNumbers=$database->count_all("a_student_tb where internaship_periode_id={$currentIntern->id}");
    $taken=$database->get("SUM(given_student) AS total","a_partner_student_request_totals","internaship_id={$currentIntern->id}")->total;
    $studentNumbers-=$taken;
    $req=$database->get("(given_student) as given,(requested_student) as requested","a_partner_student_request_totals","internaship_id=$currentIntern->id AND partner_id=$userID");
    $requested=isset($req->requested)?$req->requested:0;
    $given=isset($req->given)?$req->given:0;
    }
   
    ?>
    <!-- chatbox here -->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row <?=$studentNumbers>0?"":"d-none"?>">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0 d-sm-flex flex-wrap d-block">
                            <div class="mb-3">
                                <h4 class=" mb-1">
                             <a href="a_major"> <span>Available students for IAP <span class="badge badge-info badge-sm"><?php 
                             
                                        $partnerID=$_SESSION['ht_hotel'];
                                        
                                        $partnermajor = $database->fetch("SELECT * FROM a_partner_tb where id = $partnerID");
                                        foreach ($partnermajor as $key => $pm) {
                                            $selectedmajor = $pm['major_in'];
                                            $studentNumberss=$database->fetch("SELECT COUNT(*) as total FROM a_student_tb where major_in='{$selectedmajor}' and partner_id IS NULL and  internaship_periode_id={$currentIntern->id} ");
                                            foreach ($studentNumberss as $key => $number) {
                                            echo  $number['total'];
                                        }
                                            // echo json_encode($studentNumberss);
                                        
                                        }
                                        
                             ?></span></span>
                                    <!-- <button class=" btn btn-outline-primary" >View Now</button> -->
                                </a>
                               
                                </h4>                                   
                                <!-- <small class="mb-0"></small> -->
                            </div>
                            <div class=" d-flex flex-row">
                            <span class=" text-right mb-3">Requested:<span class=" badge badge-warning badge-sm"><?=$requested?></span></span>
                            <span class=" text-right mb-3">&nbsp; &nbsp;Given:<span class=" badge badge-success badge-sm"><?=$given?></span></span>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
             <div class="col-12">
                <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                                <table id="example"  class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                        <th class=" fs-13">#</th>
                                            <th class=" fs-13">IAP</th>
                                            <th class=" fs-13">Requested Student</th>
                                            <th class=" fs-13">Given Student</th>
                                            <!-- <th></th> -->
                                        </tr>
                                    </thead>
                                    <tbody class=" fs-12">
                                        <?php
                                        $ins=$_SESSION['ht_hotel'];
                                         $lists=$database->fetch("SELECT pt.*,it.start_date,it.end_date FROM a_partner_student_request_totals pt 
                                         INNER JOIN a_internaship_periode it on pt.internaship_id=it.id WHERE partner_id=$userID order by id DESC");
                                        // $lists=[];/
                                        $i=0;
                                        foreach ($lists as $key => $h) {
                                            $i++;
                                            ?>
                                            <tr>
                                            <td><?= $i?></td>
                                                <td class=" text-capitalize"><?= $h['start_date'] ?> to <?=$h['end_date']?></td>
                                                <td class=""><?= $h['requested_student'] ?></td>
                                                <td class=""><a href="a_partner_student?pinter=<?=$h['internaship_id']?>"><?= $h['given_student'] ?> 
                                                 <span class="flaticon-381-share text-primary"></span></a>
                                             </td>
                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                </div>
                </div>
             </div>
            </div>
        </div>
    </div>
        <!-- modal -->
        <div class="modal fade bd-example-modal-lg" id="basicModal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Current IAP students</h5>
                    <span class="  close"> <span class=" fa fa-times " data-bs-dismiss="modal"></span></span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary" onclick="onBenCreated(this)">Save</button> -->
                </div>
            </div>
        </div>
    </div>
    <!-- end of modal -->
    <!-- include footer -->
    <?php include_once("./footer.php") ?>