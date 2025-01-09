<?php
require_once("../config/grobals.php");

include("./includes/head.php");
if (isset($_GET['n'])) {
    $id = $_GET['n'];
    $idDec=input::enc_dec("d",$id);
    $database->query("DELETE FROM notifications_tb where id=$idDec");
}
?>

<div id="main-wrapper">
    <?php include("./includes/sidebar.php") ?>
    <!-- header here -->
    <?php include("./header.php") ?>
    <!-- chatbox here -->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0 d-sm-flex flex-wrap d-block">
                            <div class="mb-3">
                                <h4 class="card-title mb-1">
                                    <!-- <button class=" btn btn-outline-primary">Create Menu</button> -->
                                    <!-- <button class=" btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#basicModal">Add Student</button> -->
                                    <button class=" btn btn-outline-primary" id="btnRequestStudents">Requested students for IAP</button>
                                </h4>                                   
                                <!-- <small class="mb-0"></small> -->
                            </div>
                            <div class="card-action card-tabs mb-3">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link  <?= !isset($_GET['view'])?'active':''?>"   href="a_student_request_admin" role="tab">
                                            By Partners
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?= isset($_GET['view'])?'active':''?> "  href="a_student_request_admin?view=ByMajor" role="tab">
                                            By Major 
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
             <div class="col-12">
             <div class=" card">
             <div class="card-body">
                    <div class="table-responsive">
                                <table id="example"  class="display">
                                <?php $currentIntern=$cIntern; ?>
                                    <!-- GET RESULT FOR BY partner -->
                                    <?php if(!isset($_GET['view'])){?>
                                <thead>
                                    <tr>
                                        <th class=" ">#</th>
                                        <th class="">Partner</th>
                                            <th class="">Requested Student</th>
                                            <th class="">Given Student</th>
                                    </tr>
                                    </thead>
                                    <tbody class=" fs-13">
                                        <?php
                                        $cond="";
                                        if(isset($_GET['p'])){
                                            $id=$_GET['p'];
                                            $cond="AND apt.partner_id=$id";
                                        }
                                        $sql="SELECT apt.requested_student,apt.partner_id,apt.given_student,pt.email, pt.name,pt.place 
                                        FROM a_partner_student_request_totals apt 
                                        INNER JOIN a_partner_tb pt ON apt.partner_id=pt.id $cond AND apt.internaship_id=$currentIntern->id";
                                        // echo $sql;
                                        $rows=$database->fetch($sql);
                                    //   $rows=[];
                                       foreach ($rows as $key => $byp) {
                                        $byp["from"]="byp";
                                        $byp["internaship_periode_id"]=$currentIntern->id;
                                        $byp["title"]="View All Majors that requested by  ";
                                        $byp["p"]=$byp["partner_id"];
                                        ?>
                                        <tr>
                                        <td class=""><?= $key+1 ?></td>
                                         <td class=" text-capitalize pointer" onclick="openStudentPartner(<?php echo htmlspecialchars(json_encode($byp))?>);"><span>
                                            <?="Name:". $byp['name'].'<br/>Place:'.$byp['place'].'<br/>Email:'.$byp['email'] ?></span>
                                           &nbsp;&nbsp;<span class="flaticon-381-share text-primary"></span>
                                        </td>
                                                <td class=""><?= $byp['requested_student'] ?></td>
                                                <td class=" ml-1"> <a href="a_student?p=<?=$byp['p']?>"><?= $byp['given_student'] ?> 
                                                &nbsp;&nbsp;<span class="flaticon-381-share text-primary"></span></a></td>
                                                </tr>
                                        <?php }
                                        ?>

                                    </tbody>
                                   <?php } else { ?>
                                    <thead>
                                    <tr>
                                        <th class="">#</th>
                                            <th class="">Major In</th>
                                            <th class="">Requested Student</th>
                                            <th class="">Given Student</th>
                                    </tr>
                                    </thead>
                                    <tbody class=" fs-13">
                                        <?php
                                        $q="SELECT major_in,SUM(request_student_number) as requested,SUM(given_student_number) as given FROM a_partner_student_request where internaship_id=$currentIntern->id GROUP by major_in";
                                        $lists=$database->fetch($q);
                                        foreach ($lists as $key => $h) {
                                            $h["from"]="bym";
                                            $h["name"]=$h['major_in'];
                                            $h["title"]="View All Partners that requested the ";
                                            $h["p"]=0;
                                            $h["internaship_periode_id"]=$currentIntern->id;
                                            ?>
                                            <tr>
                                            <td><?= $key+1?></td>
                                            <td class="pointer" onclick="openStudentPartner(<?php echo htmlspecialchars(json_encode($h))?>);">
                                            <span class=" pointer"><?= $h['major_in'] ?></span>&nbsp;&nbsp;<span class="flaticon-381-share text-primary"></span></td>
                                                <td class=" text-capitalize"><?= $h['requested']  ?></td>
                                                <td class=" text-capitalize pointer"><?= $h['given'] ?></td>
                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                               <?php  } ?>
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
                    <h5 class="modal-title" id="title">Add New Student</h5>
                    <span class="  close"> <span class=" fa fa-times " data-bs-dismiss="modal"></span></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form">
                        <div class="row">
                            <div id="viewextra" class="">
                            </div>
                        </div>
                    <div class="row">
                    <div class="col-12">
                            <div id="ajaxresults"></div>
                        </div>
                    </div>
               
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                  
                </div>
            </div>
        </div>
    </div>
    <!-- end of modal -->
    <!-- include footer -->
    <?php include_once("./footer.php") ?>
    <script>
        var selectedStudent={};
        function openStudentPartner(student){
            selectedStudent=student;
            // console.log(selectedStudent);
            $("#title").html(student.title +" <b>"+student.name+"</b>");
                $("#basicModal").modal("show");
                // get suppervisior that has  send request;
                $("#ajaxresults").addClass("alert alert-warning").text("Loading ...");
                fetch(`ajax_pages/pages?action=GET_EXTRA_INFO&p=${student.p}&from=${student.from}&inter=${student.internaship_periode_id}&major=${student.major_in}`).then((res)=>res.text()).then((data)=>{
                    // partners=data.data;
                $("#ajaxresults").removeClass("alert alert-warning").text("");
                $("#viewextra").html(data);
                })
                
        }
    </script>