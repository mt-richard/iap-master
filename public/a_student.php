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
                                    <button class=" btn btn-outline-primary" id="btnRequestStudents">Request internaship students</button>
                                </h4>                                   
                                <!-- <small class="mb-0"></small> -->
                            </div>
                            <div class="card-action card-tabs mb-3">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link  <?= !isset($_GET['view'])?'active':''?>"   href="a_student" role="tab">
                                            ALL current Students
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?= isset($_GET['view'])?'active':''?> "  href="a_student?view=last" role="tab">
                                            ALL previous students
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
                                    <thead>
                                        <tr>
                                        <th class=" fs-13">#</th>
                                        <th class=" fs-13">ID</th>
                                            <th class=" fs-13">Names</th>
                                            <th class="fs-13">Intern</th>
                                            <th class="fs-13">Partner</th>
                                            <th class="fs-13">Sup.Visior</th>
                                            <th class=" fs-13">Major</th>
                                            <th class=" fs-13">Email</th>
                                            <th class=" fs-13">Tel</th>
                                        </tr>
                                    </thead>
                                    <tbody class=" fs-12">
                                    <?php $currentIntern=$cIntern ?>
                                        <?php
                                            $cond="where 1 ";
                                            if(isset($_GET['d'])){
                                                $cond="where id={$_GET['d']}";
                                            } else if(isset($_GET['view'])){
                                                if(isset($currentIntern->id))$cond="where internaship_periode_id !={$currentIntern->id} order by id desc limit 50";
                                            }
                                            $status=input::get("status");
                                            if($status=="no_suppervisior"){
                                                $cond.=" AND suppervisior_id  IS NULL";
                                            }else if($status=="no_partner"){
                                                $cond.=" AND partner_id  IS NULL";
                                            } else if($status=="no_daily"){
                                                $today=date('Y-m-d');
                                                $cond=" WHERE  card_id NOT IN(SELECT student_id FROM a_student_logbook  WHERE  log_date='$today' AND internaship_id=$currentIntern->id)   AND internaship_periode_id={$currentIntern->id} AND partner_id  IS NOT NULL ";  
                                            }
                                            if(isset($_GET['p'])){
                                                $cond=" WHERE partner_id={$_GET['p']} AND internaship_periode_id={$currentIntern->id}";
                                            }
                                        //   var_dump("SELECT * FROM a_student_tb $cond");
                                        // echo "SELECT * FROM a_student_tb $cond";
                                          
                                        $lists=$database->fetch("SELECT * FROM a_student_tb $cond");
                                        // $lists=[];
                                        $i=0;
                                        $inters=[];
                                        $partners=[];
                                        $supv=[];
                                        foreach ($lists as $key => $h) {
                                            $i++;
                                            $h['internaship']='-';
                                            $h['institition_name']='-';
                                            $h['suppervisior_name']='-';
                                            if(!isset($inters["i_{$h['internaship_periode_id']}"])){
                                                     $int=$database->get("*","a_internaship_periode","id={$h['internaship_periode_id']}");
                                                    // $h['internaship']=$int->start_date .' to '. $int->end_date;
                                                    $h['internaship']=$int->end_date;
                                                   $inters=array_merge($inters,["i_{$h['internaship_periode_id']}"=>$h['internaship']]);
                                                }else{
                                                    $h['internaship']=$inters["i_{$h['internaship_periode_id']}"];  
                                                }
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
                                            <td style="padding:.6rem"><?= $i?></td>
                                            <td style="padding:.6rem" class="pointer" onclick="openStudentPartner(<?php echo htmlspecialchars(json_encode($h))?>);"><span class=" pointer"><?= $h['card_id'] ?></span><span class="flaticon-381-share text-primary"></span></td>
                                                <td style="padding:.6rem" class=" text-capitalize"><?= $h['first_name'] .' '. $h['last_name'] ?></td>
                                                <td style="padding:.6rem" class=" text-capitalize"><?= $h['internaship'] ?></td>
                                                <td style="padding:.6rem" class=" text-capitalize" id="pname<?=$h['id']?>"><?= $h['institition_name'] ?></td>
                                                <td style="padding:.6rem" class=" text-capitalize" id="sname<?=$h['id']?>"><?= $h['suppervisior_name'] ?></td> 
                                                <td style="padding:.6rem" class=" text-capitalize"><?= $h['major_in'] ?></td>
                                                <td style="padding:.6rem" class=""><?= $h['email'] ?></td>
                                                <td style="padding:.6rem" class=""><?= $h['phone'] ?></td>
                                                <!-- <td>
                                                    <select  class="approveSupplier form-control is_<?=$h['is_active']?>" data-sup="<?= $h['id']?>">
                                                       <option value="yes" <?php if($h['is_active']=="yes")echo "selected" ?>> Yes </option>
                                                       <option value="no" <?php if($h['is_active']=="no")echo "selected" ?>> No </option>
                                                </select>
                                                </td> -->
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
                    <h5 class="modal-title" id="title">Add New Student</h5>
                    <span class="  close"> <span class=" fa fa-times " data-bs-dismiss="modal"></span></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form">
                        <div class="row divRequestForm mydv" >
                            <div class="col-md-8">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Internaship period <span class="required text-danger">*</span></label>
                                <select type="text" class="form-control" value="" name="internaship" id="intern">
                                    <?php 
                                    
                                    // echo "select * from internaship_periode where status=''"
                                    if(isset($currentIntern->id)){
                                    echo "<option value='{$currentIntern->id}'>{$currentIntern->start_date} to {$currentIntern->end_date}</option>";
                                    }else{
                                        echo "<option value='0'>No Activated internaship period found</option>";
                                    }
                                    ?>
                            </select>                           
                            </div>
                            </div>
                            <?php if(isset($currentIntern->id)){ ?>
                            <div class="col-md-4 mt-2">
                            <div class="mb-3 mt-4">
                            <label  class="text-black form-label"></label>
                            <button type="button" class="btn btn-primary btn-md"  onclick="onStudentRequest(this)">Request</button>
                            </div>   
                        </div>
                        <?php } ?>
                        </div>
                    <div class="row d-none divStudent mydv">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Student name <span class="required text-danger">*</span></label>
                                <input type="text" readonly="true"  name="name" id="names" class=" form-control text-uppercase"/>
                                <input type="hidden" name="action" id="action" value="ASSIGN_STUDENT_TO_PARTNER_TO_SUPPERVISIOR"/>
                            </div>
                        </div> 
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Major In <span class="required text-danger">*</span></label>
                                <input  type="text" name="majorIn" id="majorIn" class=" form-control"/>
                            </div>
                        </div> 
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Suppervisior <span class="required text-danger">*</span></label>
                                <!-- <input type="number"  name="tin" placeholder="Eg:000000001" class=" form-control" onkeypress="limitKeypress(event,this.value,9)"/> -->
                                <select value="" id="sSuppervisior" name="suppervisior" class="form-control">
                                </select>
                            </div>
                        </div> 
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Partner  <span class="required text-danger">*</span> <span class=" text-warning" id="waitPartner"></span></label>
                                <select value="" id="sPartner" name="partner" class=" form-control">
                                </select>
                            </div>
                        </div> 
                        <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-primary "  onclick="onAssignStudent(this)">Save</button> 
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
                    <button type="button" class="btn btn-primary  d-none"  onclick="onSupplierCreated(this)">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end of modal -->
    <!-- include footer -->
    <?php include_once("./footer.php") ?>
    <script>
        var selectedStudent={};
        var partners=[];
        var suppervisiors=[];
        const deps = {
            'Information and Communication technology': 'Information and Communication technology',
            'Transport and Logistics Department': 'Transport and Logistics Department',
            'Mechanical Engineering': 'Mechanical Engineering',
            'Mining Engineering': 'Mining Engineering',
            'Civil Engineering': 'Civil Engineering',
            'Creative Arts Department': 'Creative Arts Department',
            'Electrical and Electronics Engineering': 'Electrical and Electronics Engineering',
            };

    function onAssignStudent(e){
        let partner=$("#sPartner").val();
        let supper=$("#sSuppervisior").val();
        let intershipDate=selectedStudent.internaship;
           NProgress.start();
      $(e).addClass("d-none");
      $("#ajaxresults").html(`<div class="alert alert-warning"><span>Please wait moment ... </span></div>`);
      let i=$("#intern").val();
      sendWithAjax(`card_id=${selectedStudent.card_id}&osup=${selectedStudent.suppervisior_id}&op=${selectedStudent.partner_id}&major=${selectedStudent.major_in}&inter=${selectedStudent.internaship_periode_id}&student=${selectedStudent.id}&p=${partner}&s=${supper}&idate=${intershipDate}&action=ASSSIGN_SUPPERVISIOR_PARTNER_TO_STUDENT`, "ajax_pages/suppervisior").then((res) => {
        $(e).removeClass('d-none');
        NProgress.done(true);
        if (res.isOk) {
        let spname=$("#sPartner option:selected").text();
        let ssname=$("#sSuppervisior option:selected").text();
        $(`#pname${selectedStudent.id}`).text(spname);
        $(`#sname${selectedStudent.id}`).text(ssname);
                    // send to partner
            if(spname!='__select__')
         makePostRequest(`url=a_partner_student?st=${selectedStudent.card_id}&level=PARTNER&level_id=${partner}&action=NOTIFY&message=New Internaship Student(${selectedStudent.last_name} ${selectedStudent.last_name})`).then((res)=>{
                        console.log(res);
                    });  
            // send to supervisior
            if(ssname!='__select__')
            makePostRequest(`url=a_partner_student?st=${selectedStudent.card_id}&level=SUPERVISIOR&level_id=${supper}&action=NOTIFY&&message=New Assigned Student(${selectedStudent.last_name} ${selectedStudent.last_name})`).then((res)=>{
                        console.log(res);
                    }); 
                            // send notification to student
                            ssname=ssname!='__select__'?ssname:"-";
                            spname=spname!='__select__'?spname:"-";
        let msg=`${spname} as partern AND ${ssname} as supervisior`;
        makePostRequest(`url=home&level=STUDENT&level_id=${selectedStudent.card_id}&action=NOTIFY&message=${msg}`).then((res)=>{
                        console.log(res);
                    });
        $("#basicModal").modal("hide");
            // $("#ajaxresults").html(`<div class="alert alert-success"><span>${res.data}</span></div>`);
            $("#ajaxresults").html("");
        } else {
          $("#ajaxresults").html(`<div class="alert alert-warning"><p>${res.data}</p></div>`);
        }
      }).catch((err) => {
        console.log("Error occurred", err);
      })
            }
        function openStudentPartner(student){
            selectedStudent=student;
            // console.log(selectedStudent);
            $("#title").text("Assign Student to partner and suppervisior");
                $("#basicModal").modal("show");
                $(".mydv").addClass("d-none");
                $(".divStudent").removeClass("d-none");
                let names=student.card_id+" - "+student.first_name+" "+student.last_name;
                $("#names").val(names);
                $("#majorIn").val(student.major_in);
                $("#sSuppervisior").html('');
                $("#waitPartner").text("Loading ...");
                // get suppervisior that has  send request;
                fetch(`ajax_pages/internaship?action=GET_PARTNER_FOR_MAJOR_IN&inter=${student.internaship_periode_id}&major=${student.major_in}`).then((res)=>res.json()).then((data)=>{
                    partners=data.data;
                    $("#waitPartner").text("")
                    let option='<option selected value=" " >__select__</option>';
                partners.forEach(p => {
                    let selected=selectedStudent.partner_id==p.id?"selected":"NoSelected";
                    option+=`<option value="${p.id}" ${selected}>${p.name} -> ${p.place}</option>`;
                });
                $("#sPartner").html(option);
                })
                //  append suppervisiors
                let option = '<option selected value="">__select__</option>';

                suppervisiors.forEach(s => {
                let selected = selectedStudent.suppervisior_id === s.id ? "selected" : "";
                console.log(s.id, s.names, s.department);
                
                // Check if the supervisor's department matches the selected student's major department
                if (deps[s.department] === selectedStudent.major_in) {
                    option += `<option value="${s.id}" ${selected}>${s.names} -> ${s.department}</option>`;
                }
                });

                $("#sSuppervisior").html(option);


                
        }
        //  get suppervisiors
        function getSupperVisiorsAndPartners(){
            fetch("ajax_pages/suppervisior?action=GET_SUPPERVISIORS_PARTNERS").then((res)=>res.json()).then((data)=>{
                partners=data.data.partners;
                suppervisiors=data.data.suppervisiors;
                //  put in select
            
            })
        }
        $(document).ready(()=>{
            getSupperVisiorsAndPartners();
            $("#btnRequestStudents").click(()=>{
                $("#title").text("Request new IAP students from IPRC KIGALI system");
                $("#basicModal").modal("show");
            })
        });
        function onStudentRequest(e){
            // let formData=new FormData();
            // formData.append("action","NEW_INTERNASHIP_STUDENTS");
            NProgress.start();
      $(e).addClass("d-none");
      $("#ajaxresults").html(`<div class="alert alert-warning"><span>Please wait moment ... </span></div>`);
      let i=$("#intern").val();
      sendWithAjax(`i=${i}&action=NEW_INTERNASHIP_STUDENTS`, "../fakeApi/").then((res) => {
        $(e).removeClass('d-none');
        NProgress.done(true);
        if (res.isOk) {
            $("#ajaxresults").html(`<div class="alert alert-success"><span>TOT students:${res.data}</span></div>`);
            // console.log(res.data.count);
            window.location.href=`a_student`;
        } else {
          $("#ajaxresults").html(`<div class="alert alert-warning"><p>${res.data}</p></div>`);
        }
      }).catch((err) => {
        console.log("Error occurred", err);
      })
        }
    </script>