<?php
// require_once("../config/grobals.php");
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
                                </h4>                                   
                                <!-- <small class="mb-0"></small> -->
                            </div>
                            <div class="card-action card-tabs mb-3">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#monthly" role="tab">
                                            LogBook
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
                <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                                <table id="example"  class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                        <th class=" fs-13">#</th>
                                        <th class=" fs-13">Date</th>
                                            <th class=" fs-13">Student</th>
                                            <th class=" fs-13">Description</th>
                                            
                                            <th class=" fs-13">Lesson Learnt</th>
                                            <th class=" fs-13">Challenges</th>
                                            <th class=" fs-13">Partner Comment</th>
                                            <th class=" fs-13">Supervisor Comment</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody class=" fs-12">
                                        <?php
                                        $user_id=$_SESSION['ht_hotel'];
                                        $cond="WHERE st.card_id=al.student_id and al.suppervisor_id ='{$user_id}' ORDER BY al.id desc";
                                        if(isset($_GET["today"])){
                                            $today=date('Y-m-d');
                                            $cond="WHERE st.card_id=al.student_id AND al.log_date='$today' AND al.suppervisor_id ='{$user_id}' ORDER BY al.id desc";  
                                        }
                                        if(isset($_GET['st'])){
                                            $cond="WHERE al.student_id ='{$_GET['st']}' AND al.suppervisor_id ='{$user_id}' ORDER BY al.id desc"; 
                                        }
                                            $sql= "SELECT al.*,st.first_name,st.last_name FROM a_student_logbook as al INNER JOIN a_student_tb as st $cond";
                                           
                                            $lists=$database->fetch($sql);
                                        $i=0;
                                        foreach ($lists as $key => $h) {
                                            $i++;
                                            ?>
                                            <tr>
                                            <td><?= $i?></td>
                                            <td class=""><?= $h['created_at'] ?></td>
                                                <td  ><span class=" pointer"><?= $h['first_name']." ".$h['last_name'] ?></span></td>
                                               
                                                <td class=" text-capitalize"><?= $h['name'] ?></td>
                                               
                                                <td class=""><?= $h['objective'] ?></td>
                                                <td class=""><?= $h['challenges'] ?></td>
                                                <td class=""><?= $h['partner_comment'] ?></td>
                                                <td class="" id="sup<?=$h['id']?>"><?= $h['suppervisior_comment'] ?></td>
                                                <td>
                                                    <div class="dropdown ms-auto text-right">
                                                        <div class="btn-link" data-bs-toggle="dropdown">
                                                            <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                                    <circle fill="#000000" cx="5" cy="12" r="2"></circle>
                                                                    <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                                                    <circle fill="#000000" cx="19" cy="12" r="2"></circle>
                                                                </g>
                                                            </svg>
                                                        </div>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <!-- <a class="dropdown-item" href="#"  onclick="openStudentPartner(<?php echo htmlspecialchars(json_encode($h))?>);">
                                                            <i class="las la-check-square scale5 text-primary me-2"></i> Edit</a> -->
                                                            <a class="dropdown-item" href="#"  onclick="openStudentPartner(<?php echo htmlspecialchars(json_encode($h))?>);">
                                                            <i class="las la-check-square scale5 text-primary me-2"></i>  Comment</a>
                                                            <!-- <a class="dropdown-item" href="#"><i class="las la-times-circle scale5 text-danger me-2"></i> Reject Order</a> -->
                                                        </div>
                                                    </div>
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
                    <h5 class="modal-title" id="title">Add Daily Activity</h5>
                    <span class="  close"> <span class=" fa fa-times " data-bs-dismiss="modal"></span></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form" method="post">
                    <div class="col-lg-6">
                               
                        </div>
                      
                    <div class="row">
                        

                            
                    <div class="col-lg-12">
                    
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Description <span class="required text-danger">*</span></label>
                                <input type="text"  name="description" value="" id="description" class=" form-control text-uppercase" readonly/>
                                <input type="hidden" name="action" value="ADD_COMMENT"/>
                                <input type="hidden" name="row_id" value="" id="studentId"/>           
                            
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Lessons Learnt <span class="required text-danger">*</span></label>
                                <input type="text" id="lesson"  name="lesson" value="" class=" form-control text-uppercase" readonly/>
                                <!-- <input type="hidden" name="lesson" value="CREATE_NEW_BEN"/> -->
                            </div>
                        </div> 
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Challenges Faced <span class="required text-danger">*</span></label>
                                <input type="text" id="challenge" name="challenge" value="" class=" form-control text-uppercase" readonly/>
                                <!-- <input type="hidden" name="challenge" value="CREATE_NEW_BEN"/> -->
                            </div>
                        </div> 
                     
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Supervisor Comment <span class="required text-danger">*</span></label>
                                <textarea  name="sp_comment" id="sp_comment" placeholder="Eg:Great.." class=" form-control text-uppercase"></textarea>
                                <!-- <input type="hidden" name="lesson" value="CREATE_NEW_BEN"/> -->
                            </div>
                        </div>
                        <div class="col-12">
                            <div id="ajaxresults"></div>
                        </div>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btnlog" name="logbook" onclick="return onLogBookSubmit()">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end of modal -->
    <!-- include footer -->
    <?php include_once("./footer.php") ?>
    <script>
        var selectedStudent=null;
        function onLogBookSubmit(){
        //  let formdData=document.getElementById("form");
        $(".btnlog").attr("disabled","disabled");
         let formData=$("#form").serialize();
         let comment=$("#sp_comment").val();
        //   let  formData2 = $(#from).serialize();
                // console.log(formData);
                // return;
         fetch(`ajax_pages/logbook?${formData}`).then((res)=>res.text()).then((data)=>{
            // $(".btnlog").removeClass("d-none");
        $(".btnlog").removeAttr("disabled");
            try {
               let json=JSON.parse(data);
               console.log(json);
              if(json.isOk){
                  // send notification to the  student
                  makePostRequest(`url=a_log_book?id=${json.id}&level=STUDENT&level_id=${selectedStudent.student_id}&action=NOTIFY&message=${json.from} make comment click to view`).then((res)=>{
                        console.log(res);
                    });
                // alert("Data was saved");
                $("#basicModal").modal("hide");
                $(`#sup${selectedStudent.id}`).text(comment);
                // $("#basicModal").hide("d-none");
                // window.location.reload();
              }else{
                // console.log(json.data);
                alert(json.data);
              }
            } catch (error) {
                alert(data);
            }
         })  
        }


        function openStudentPartner(student){
            selectedStudent=student;
            console.log(selectedStudent);
            $("#studentId").val(selectedStudent.id);
            $("#challenge").val(student.challenges);
            $("#sp_comment").val(student.suppervisior_comment);
            $("#description").val(student.name);
            $("#lesson").val(student.objective);
            $("#title").text("Add comment as Supervisor");
                $("#basicModal").modal("show");
                $(".mydv").addClass("d-none");
                $(".divStudent").removeClass("d-none");
                // let names=student.card_id+" - "+student.first_name+" "+student.last_name;
                // $("#names").val(names);
                // $("#majorIn").val(student.major_in);
                // $("#sSuppervisior").html('');
                //  append suppervisiors
                
        }
    </script>
    


   