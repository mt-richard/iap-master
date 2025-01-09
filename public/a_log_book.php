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
                                    <button class=" btn btn-outline-primary"type="button" onclick="openModel()" >Add Daily Activity</button>
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
                                        <th class=" fs-13">DateTime</th>
                                          <!-- <th class=" fs-13">Photo</th> -->
                                            <th class=" fs-13">Description</th>
                                           
                                            <th class=" fs-13">Lesson Learnt</th>
                                            <th class=" fs-13">Challenges</th>
                                            <th class=" fs-13">Partner Comment</th>
                                            <th class=" fs-13">Supervisor Comment</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class=" fs-13">
                                        <?php
                                        $user_id=$_SESSION['ht_userId'];
                                        // echo "SELECT * FROM a_student_logbook  where student_id ='{$user_id}' order by id desc";
                                         $cond="";
                                         if(isset($_GET['id']) && is_numeric($_GET['id'])){
                                            $id=$_GET['id'];
                                            $cond="id=$id AND";
                                         }
                                        $lists=$database->fetch("SELECT * FROM a_student_logbook  where $cond student_id ='{$user_id}' order by id desc");
                                        $i=0;
                                        foreach ($lists as $key => $h) {
                                            $i++;
                                            ?>
                                            <tr>
                                            <td><?= $i?></td>
                                            <td class=""><?= $h['created_at'] ?></td>
                                            <!-- <td class="">
                                                <a href="#open photos" class=" d-flex flex-row" onclick="openPhotos('<?=$h['screenshoots']?>')">View Photo
                                                 <span class=" flaticon-381-next fs-11"></span>
                                                </a>
                                            </td> -->
                                                <td class=" text-capitalize"><?= $h['name'] ?></td>
                                                <td class=""><?= $h['objective'] ?></td>
                                                <td class=""><?= $h['challenges'] ?></td>
                                                <td class=""><?= $h['partner_comment'] ?></td>
                                                <td class=""><?= $h['suppervisior_comment'] ?></td>
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
                                                            <?php if($h['log_date']==date('Y-m-d')): ?>
                                                            <a class="dropdown-item" href="#" onclick="openStudentLog(<?php echo htmlspecialchars(json_encode($h))?>);"><i class="las la-check-square scale5 text-primary me-2"></i> Edit</a>
                                                            <!-- <a class="dropdown-item" href="#"><i class="las la-times-circle scale5 text-danger me-2"></i> Reject Order</a> -->
                                                        <?php endif; ?>
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
                        <div class="row dvShow"></div>
                    <div class="row addDv">      
                    <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Description <span class="required text-danger">*</span></label>
                                <input type="text"  name="description" id="name" placeholder="Eg:Environment setup" class=" form-control "/>
                                <input type="hidden" name="action" value="ADD_LOGBOOK"/>
                                            
                            
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Lessons Learnt <span class="required text-danger">*</span></label>
                                <input type="text"  name="lesson" id="lesson" placeholder="Eg:php" class=" form-control "/>
                                <!-- <input type="hidden" name="lesson" value="CREATE_NEW_BEN"/> -->
                            </div>
                        </div> 
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Challenges Faced <span class="required text-danger">*</span></label>
                                <input type="text"  name="challenge" id="challenge" placeholder="Eg:challenge here ..." class=" form-control "/>
                                <!-- <input type="hidden" name="challenge" value="CREATE_NEW_BEN"/> -->
                            </div>
                        </div>  
                        <!-- <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Add Photo <span class="required text-danger">*</span></label>
                                <input type="file"  name="photo[]" multiple placeholder="Eg:working hours" class=" form-control "/>
                            </div>
                        </div>       -->
                        <div class="col-12">
                            <div id="ajaxresults"></div>
                        </div>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btnlog addDv" name="logbook" onclick="return onAddDailyActivity()">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end of modal -->
    <!-- include footer -->
    <?php include_once("./footer.php") ?>
    <script>
        var isEditable=false;
        function openStudentLog(log){
            isEditable=true;
            $("#title").text("Edit ");
            $("#name").val(log.name);
            $("#lesson").val(log.objective);
            $("#challenge").val(log.challenges);
            openModel("Edit Daily logbook")
            // console.log(log);
        }
        function openPhotos(images){
            $("#title").text("View Uploaded Photos ");
            $(".modal-dialog").addClass("modal-xl");
            $("#basicModal").modal("show");
            $(".dvShow").removeClass("d-none");
            $(".addDv").addClass("d-none");
            let array=images.split(",");
            let dv="";
           array.forEach(photo => {
            dv+=`<div class=" col-6 card"><img class=" img img-fluid" src="uploads/${photo}"/></div>`;
           });
           $(".dvShow").html(dv);
        //    $("#basicModal").modal("show");
            // console.log(images);
        }
        function openModel(title="Add Daily Activity"){
            $("#title").text(title);
            // console.log("my modele is now open");
            $(".modal-dialog").removeClass("xl").addClass("modal-lg");
            $(".addDv").removeClass("d-none");
            $(".dvShow").addClass("d-none");
            $("#basicModal").modal("show");
        }
        function editActivity(){
            isEditable=true;
            onAddDailyActivity();
        }
        function onAddDailyActivity(){
    var formData = new FormData($("#form")[0]);
    if(isEditable){
        formData.append("isEditable",true);
    }
    $(".btnlog").attr("disabled","disabled");
    $.ajax({
        type: "POST",
        url:"ajax_pages/logbook",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(data, textStatus, jqXHR) {
            $(".btnlog").removeAttr("disabled");
           //process data
           if(data.isOk){
            $("#ajaxresults").removeClass("alert alert-danger").addClass("alert alert-success").html(data.data);
            makePostRequest(`url=s_log_book?st=${data.st}&dt=${data.today}&&level=SUPERVISIOR&level_id=${data.sid}&action=NOTIFY&message=${data.message}`).then((res)=>{
                        console.log(res);
                    });
                    makePostRequest(`url=p_log_book?st=${data.st}&dt=${data.today}&level=PARTNER&level_id=${data.pid}&action=NOTIFY&message=${data.message}`).then((res)=>{
                        console.log(res);
                    });
            window.location.reload();
           }else{
            $("#ajaxresults").removeClass("alert alert-success").addClass("alert alert-danger").html(data.data);
           }
        },
        error: function(data, textStatus, jqXHR) {
            $(".btnlog").removeAttr("disabled");
           //process error msg
           $("#ajaxresults").html(data);
        }});
        }
    </script>
    


   