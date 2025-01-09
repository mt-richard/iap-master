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
                                </h4>                                   
                                <!-- <small class="mb-0"></small> -->
                            </div>
                            <div class="card-action card-tabs mb-3">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a  class="nav-link  active"    href="home" role="tab">
                                            Home
                                        </a>
                                    </li>
                                   
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $userId=$_SESSION['ht_hotel'];
            $column="";
            $levelCond="ast.partner_id={$userId}";
            $levelCond1="st.partner_id={$userId}";
            if($level=="SUPERVISIOR"){
                $levelCond="ast.supervisior_id ={$userId}";
                $levelCond1="st.suppervisior_id={$userId}";
                // exit(0);
            }
                $cond=" WHERE  st.partner_id={$userId} order by id desc ";
                if(isset($_GET['pinter']) && is_numeric($_GET['pinter'])){
                    $cond="where st.internaship_periode_id={$_GET['pinter']} AND st.partner_id={$userId} order by id desc ";
                }
                if(isset($_GET['ungraded'])){
                    // get student who does not have a marks
                    $cond="where st.card_id NOT IN(SELECT student_id  from a_student_grade ast where $levelCond AND ast.internaship_id={$cIntern->id}) AND $levelCond1 AND st.internaship_periode_id=$cIntern->id";
                } else if(isset($_GET['graded'])){
                    // get student graded
                    $cond="where st.card_id  IN(SELECT student_id  from a_student_grade ast where $levelCond AND ast.internaship_id={$cIntern->id}) AND $levelCond1 AND st.internaship_periode_id=$cIntern->id";
                        $column=",(SELECT ast.s_marks  from a_student_grade ast where ast.student_id=st.card_id AND ast.internaship_id={$cIntern->id}) as s_marks,(SELECT ast.marks  from a_student_grade ast where ast.student_id=st.card_id AND $levelCond AND ast.internaship_id={$cIntern->id}) as marks";
                }
                else if(isset($_GET['ungraded_by_sup'])){
                    // get student who does not have a marks
                    $cond="where st.card_id NOT IN(SELECT student_id  from a_student_grade ast where $levelCond AND ast.internaship_id={$cIntern->id}  AND ast.s_marks IS NOT  NULL) AND $levelCond1 AND st.internaship_periode_id=$cIntern->id";
                } else if(isset($_GET['graded_by_sup'])){
                    // get student graded
                    $cond="where st.card_id  IN(SELECT student_id  from a_student_grade ast where $levelCond AND ast.internaship_id={$cIntern->id} AND ast.s_marks IS NOT NULL) AND $levelCond1 AND st.internaship_periode_id=$cIntern->id ";
                // echo $cond;
                        $column=",(SELECT ast.s_marks  from a_student_grade ast where ast.student_id=st.card_id AND ast.internaship_id={$cIntern->id}) as s_marks,(SELECT ast.marks  from a_student_grade ast where ast.student_id=st.card_id AND $levelCond AND ast.internaship_id={$cIntern->id}) as marks";
                }
                else if(isset($_GET['viewgraded']) && $level=="ADMIN"){
                    $cond="where st.card_id  IN(SELECT student_id  from a_student_grade ast where  ast.internaship_id={$cIntern->id})  AND st.internaship_periode_id=$cIntern->id";
                    $column=",(SELECT ast.s_marks  from a_student_grade ast where ast.student_id=st.card_id AND ast.internaship_id={$cIntern->id}) as s_marks,(SELECT ast.marks  from a_student_grade ast where ast.student_id=st.card_id AND ast.internaship_id={$cIntern->id}) as marks";
                }
                if(isset($_GET['sinter']) && is_numeric($_GET['sinter'])){
                    $cond="where st.internaship_periode_id={$_GET['sinter']} AND st.suppervisior_id={$userId} order by id desc ";
                }
                if(isset($_GET['unsubmitted'])){
                    $today=date('Y-m-d');
                    $cond="where st.card_id NOT IN(SELECT student_id FROM a_student_logbook where log_date='$today' AND suppervisor_id={$userId} ) AND $levelCond1 ";  
                }
                if(isset($_GET['st'])){
                    // get one students
                    $cond="where st.card_id={$_GET['st']}";
                }
                if(isset($_GET['d'])){
                    // get one students
                    $cond="where st.id={$_GET['d']}";
                }
                $query="SELECT st.* $column FROM a_student_tb st $cond";
    
                // echo $query;
            
            ?>
            <div class="row">
             <div class="col-12">
             <div class=" card">
             <div class="card-body">
                    <div class="table-responsive">
                                <table id="example"  class="display">
                                    <thead>
                                        <tr>
                                        <th class=" fs-13">#</th>
                                        <!-- <th class=" fs-13">ID</th> -->
                                            <th class=" fs-13">Names</th>
                                            <th class=" fs-13">Major</th>
                                            <th class=" fs-13">Email</th>
                                            <th class=" fs-13">Tel</th>
                                            <?php if(!empty($column)): ?>
                                                <th class=" fs-13">P.Marks</th> 
                                                <th class=" fs-13">S.Marks</th> 
                                                <?php endif; ?>
                                            <th class=" fs-13"></th>
                                        </tr>
                                    </thead>
                                    <tbody class=" fs-12">
                                    
                                        <?php
                                        $lists=$database->fetch($query);
                                        // $lists=[];
                                        $i=0;
                                        foreach ($lists as $key => $h) {
                                            $i++;
                                            $cId=input::enc_dec("e",$h['card_id']);
                                            $names=$h['first_name'] .' '. $h['last_name'];
                                            ?>
                                            <tr>
                                            <td><?= $i?></td>
                                                <td class=" text-capitalize"><?= $names ?></td>
                                                <td class=" text-capitalize"><?= $h['major_in'] ?></td>
                                                <td class=""><?= $h['email'] ?></td>
                                                <td class=""><?= $h['phone'] ?></td>
                                                <?php if(!empty($column)): ?>
                                                <td class=" fs-13"><?=$h['marks']?></td> 
                                                <td class=" fs-13"><?=$h['s_marks']?></td> 
                                                <?php endif; ?>
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
                                                            <?php if($level=="PARTNER"): ?>
                                                            <a class="dropdown-item" href="#" onclick="openStudentPartner(<?php echo htmlspecialchars(json_encode($h))?>,'ADD_GRADE');">
                                                            <i class="las la-check-square scale5 text-primary me-2"></i> Add Grade</a>
                                                            <?php endif ?>
                                                            <?php if($level=="SUPERVISIOR"): ?>
                                                            <a class="dropdown-item" href="#" onclick="openStudentSupervisior(<?php echo htmlspecialchars(json_encode($h))?>,'ADD_GRADE');">
                                                            <i class="las la-check-square scale5 text-primary me-2"></i> Add Grade</a>
                                                            <?php endif ?>
                                                            <a class="dropdown-item" href="a_student_marks?st=<?=$cId?>&nm=<?=$names?>&c=<?=$h['card_id']?>">
                                                            <i class="las la-check-square scale5 text-primary me-2"></i> View Grade details</a>
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
                    <h5 class="modal-title" id="title">Evaluation Form:<span id="s_name"></span></h5>
                    <span class="  close"> <span class=" fa fa-times " data-bs-dismiss="modal"></span></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form">
                        <div class="row d-none  divRequestForm mydv" >
                        <!-- view grade here -->
                        </div>
                    <div class="row divStudent mydv">
                        <div class="col-lg-12">
                            <form id="form">

                              <table class=" table" id="tbGrade">
                                <thead>
                                    <tr><th colspan="3" class=" text-center"><span id="names"></span></th></tr>
                                    <tr>
                                        <th>#</th><th>Evaluation Criterias</th><th>Marks</th></tr></thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td class="tdlbl">Professional knowledge</td>
                                        <td class="nodb knowledge">
      
                                            <input type="number" onblur="updateTotal(this,'PRK')" value="" name="professional_knowledge"> <span class="text-danger">*</span>/10
                                    </td>
                                    </tr>
                                    <tr>
                                    <td>2</td>
                                        <td class="tdlbl">
                                            <ul>
                                                <li>
                                                Professional Qualities 
                                                <!-- <span class="badge badge-primary badge-sm">Add new</span> -->
                                                    <ul class="myli">
                                                        <li>
                                                            Punctuality
                                                        </li>
                                                        <li >
                                                            Initiative
                                                        </li>
                                                        <li>
                                                            Adaptability
                                                        </li>
                                                        <li>
                                                            Discipline
                                                        </li>
                                                        <li>
                                                            Achievement
                                                        </li>
                                                        <li>
                                                            Team Sprit
                                                        </li>
                                                        
                                                    </ul>
                                                </li>
                                            </ul>
                                        </td>
                                        <td class="nodb qualities">
                                            <input type="number" onblur="updateTotal(this,'PRQ')" value="" name="professional_qualities"> <span class="text-danger">*</span>/10
                                    </td>
                                    </tr>
                                    <tr>
                                    <td>3</td>
                                    <td class="tdlbl">
                                            <ul>
                                                <li>
                                                Personal Qualities 
                                                <!-- <span class="badge badge-primary badge-sm">Add new</span> -->
                                                    <ul class="myli">
                                                        <li>
                                                            Originality
                                                        </li>
                                                        <li >
                                                            Enthusiasm
                                                        </li>
                                                        <li>
                                                            Courtesy
                                                        </li>
                                                        
                                                    </ul>
                                                </li>
                                            </ul>
                                        </td>
                                        <td class="nodb personal">
      
                                            <input type="number" value="" onblur="updateTotal(this,'PEQ')" name="personal_qualities" > <span class="text-danger">*</span>/10
                                    </td>
                                    </tr>
                                    <tr>
                                    <td>4</td>
                                        <td id="" class="tdlbl">
                                            Responsibility
                                        </td>
                                        <td class="nodb responsibility">
      
                                            <input type="number" value=""  onblur="updateTotal(this,'RES')" name="responsibility" > <span class="text-danger">*</span>/10
                                    </td>
                                    </tr>
                                    <tr>
                                    <td>5</td>
                                        <td id="" class="tdlbl">Relationship with co-workers</td>
                                        <td class="nodb relationship">
                                           <input type="number" value="" onblur="updateTotal(this,'REL')" name="relationship" ><span class="text-danger">*</span>/10
                                    </td>
                                    </tr>
                                    <tr>
                                    <td></td>
                                        <td id="" class="tdlbl">Attchment <span class="text-danger">*</span></td>
                                        <td><input type="file" name="attachment" accept="images/*"/></td>
                                    </tr>
                                    <tr>
                                    <td></td>
                                        <td id="" class="tdlbl"></td>
                                        <td id="tdtoto">Tot:<span id="mytoto"></span><span>/50</span></td>
                                    </tr>
                                </tbody>
                            </table>
                               <div class="row d-none" id="sup_marks">
                                <div class="col-4">
                                    <label>Enter  Marks</label>
                                </div>
                                <div class="col-6">
                                    <input type="number" value="" name="student_marks" class="" placeholder="/20"/>
                                </div>
                               </div>
                        </form>
                        </div>  
                        <div class="col-12">
                            <div id="ajaxresults"></div>
                        </div>
                        <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-primary btn-sm"  onclick="onGradeStudent(this)">Save</button> 
                        </div> 
                    </div>
               
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary  d-none"  onclick="onSupplierCreated(this)">Save</button> -->
                </div>
            </div>
        </div>
    </div>
    <!-- end of modal -->
    <!-- include footer -->
    <?php include_once("./footer.php") ?>
    <script>
        var student=null;
        var tot={};
        function updateTotal(e,key){
            $(".check").remove();
            let v=Number($(e).val());
            if(v>10 || v<0){
                $(e).before("<span class='text-danger check'> Please check <br/></span>");
            }
            tot[key]=v;
            getTotal();
        }
        function getTotal(){
            let t=0;
           Object.entries(tot).map(([key,val]=entry)=>{
            console.log(val);
            t+=val;
           });
           $("#mytoto").text(t);
        }
    function openStudentSupervisior(selectedStudent,action){
        student=selectedStudent;
        $("#s_name").text(`${student.first_name} ${student.last_name} : ${student.major_in}`);
        $("#sup_marks").removeClass("d-none");
        $("#tbGrade").addClass("d-none");
        $("#basicModal").modal("show");
    }
function openStudentPartner(selectedStudent,action){
    student=selectedStudent;
    $("#names").text(`${student.first_name} ${student.last_name} : ${student.major_in}`)
    $("#sup_marks").addClass("d-none");
    $("#tbGrade").removeClass("d-none");
    $("#basicModal").modal("show");
}
function onGradeStudent(e){
    $(e).attr("disabled","disabled");
    var formData = new FormData($("#form")[0]);
    formData.append("student_id",student.card_id);
    formData.append("internaship_id",student.internaship_periode_id );
    formData.append("supervisior_id",student.suppervisior_id);
    formData.append("action","ADD_GRADE_TO_STUDENT");
    $.ajax({
        type: "POST",
        url:"ajax_pages/internaship.php",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(data, textStatus, jqXHR) {
            $(e).removeAttr("disabled");
           //process data
           if(data.isOk){
               // send notification to the  student
               makePostRequest(`url=a_student_marks&level=STUDENT&level_id=${student.card_id}&action=NOTIFY&message=Check your internaship marks`).then((res)=>{
                        console.log(res);
                    });
            $("#form").trigger("reset");
            $("#ajaxresults").removeClass("alert alert-danger").addClass("alert alert-success").html(data.data);
            $("#basicModal").modal("hide");
            window.location.reload();
           }else{
            $("#ajaxresults").removeClass("alert alert-success").addClass("alert alert-danger").html(data.data);
           }
        },
        error: function(data, textStatus, jqXHR) {
            $(e).removeAttr("disabled");
           //process error msg
           $("#ajaxresults").html(data);
        }});
        return
}
</script>
