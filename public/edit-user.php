<?php
include("./includes/head.php");
include("model/User.php");
function backHome(){
    echo " <span >Redirecting ...</span>";
    echo '<meta http-equiv="refresh" content="1;url=./home">';
    exit();
}
if(!in_array($level,['ADMIN'])){
    backHome();
    exit();
}
if(!input::required(["u"])){
    backHome();
}
$userId=input::enc_dec('d', input::get("u"));
if(!is_numeric($userId)){
    backHome();
}
$user=User::findById($userId);
?>

<div id="main-wrapper">
    <?php include("./includes/sidebar.php") ?>
    <!-- header here -->
    <?php include("./header.php") ?>
    <!-- chatbox here -->
    <div class="content-body">
        <div class="container-fluid">
            <!-- <div class="form-head d-flex mb-1 align-items-start">
                <div class="me-auto d-none d-lg-block">
                    <h2 class="text-primary font-w600 mb-0">User</h2>
                    <p class="mb-0">Register new user</p>
                </div>
            </div> -->
            <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <!-- <h4>Hi, welcome back!</h4> -->
                            <span>User account</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit a user</a></li>
                        </ol>
                    </div>
                </div>
            <div class=" row">
                <div class=" col-lg-12">
                    <div class=" card">
                        <div class=" card-body">
                            <form id="formUser" action="#" method="POST">
                                <?php 
                                // var_dump($user);
                                ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card ">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="name" class="text-black font-w600 form-label">Names<span class="required">*</span></label>
                                                            <input type="text" class="form-control" value="<?=$user->names?>" name="names" placeholder="Eg:John Doe" id="names">
                                                            <input type="hidden" value="<?= input::enc_dec('e', 'EDIT_USER_INFO') ?>" name="faction">
                                                            <input type="hidden" value="<?= $userId ?>" name="user_id">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="name" class="text-black font-w600 form-label">Phone<span class="required">*</span></label>
                                                            <input type="number" class="form-control" value="<?=$user->phone?>" name="phone" placeholder="Eg:0789047172" id="phone" onkeypress="limitKeypress(event,this.value,10)">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="uname" class="text-black font-w600 form-label">User name<span class="required">*</span></label>
                                                            <div class=" d-flex flex-row">
                                                            <input type="text" class="form-control" readonly="true" value="<?=$user->username?>" name="username" placeholder="Eg:JohnD" id="uname">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="hotel_level" class="text-black font-w600 form-label">level <span class="required">*</span></label>
                                                            <select type="text" class="form-control" value="" name="user_level" id="hotel_level">
                                                            <option value="" disabled selected>__select__</option> 
                                                                <option value="ADMIN" <?=$user->level=='ADMIN'?'selected':''?>>Admin</option>
                                                                <option value="STUDENT" <?=$user->level=='STUDENT'?'selected':''?>>Student</option>
                                                                <option value="SUPERVISIOR" <?=$user->level=='SUPERVISIOR'?'selected':''?>>Supervisior</option>
                                                                <option value="PARTNER" <?=$user->level=='PARTNER'?'selected':''?>>Partner</option>
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="hotel_status" class="text-black font-w600 form-label">Status <span class="required">*</span></label>
                                                            <select type="text" class="form-control" value="" name="user_status" id="hotel_status">
                                                                <option value="active" <?=$user->status=='active'?'selected':''?>>Active</option>
                                                                <option value="inactive" <?=$user->status=='inactive'?'selected':''?>>Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class=" col-lg-12">
                                                        <div id="ajaxresults"></div>
                                                        <div class=" mb-3 text-center">
                                                            <button type="button" class=" btn  btn-outline-primary btn-sm" onclick="onUserCreated1(this)">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
    function onUserCreated1(e) {
      let data = $("#formUser").serialize();
      let uname=$("#uname").val();
      data+=`&user_name=${uname}`;
      NProgress.start();
      $(e).addClass("d-none");
      $("#ajaxresults").html(`<div class="alert alert-warning"><span>Please wait moment ... </span></div>`);
      sendWithAjax(data, "ajax_pages/user/user").then((res) => {
        $(e).removeClass('d-none');
        NProgress.done(true);
        if (res.isOk) {
          $("#ajaxresults").html(`<div class="alert alert-success"><p>${res.data}</p></div>`);
        } else {
          $("#ajaxresults").html(`<div class="alert alert-warning"><p>${res.data}</p></div>`);
        }
      }).catch((err) => {
        console.log("Error occurred", err);
      })
    }
 function getBen1(e){
  let v=$(e).val();
  let level_access=$(e).attr("data-level");
  let levelSelected=$("#hotel_level").val();
  if(levelSelected==="BEN_ADMIN" && level_access=="ADMIN"){
    $("#dvBen").removeClass('d-none');
    let i=$("#insti").val();
    NProgress.start();
    $("#cLoader").removeClass('d-none');
    fetch(`ajax_pages/benificiary?action=GET_BEN&i=${i}`).then((res)=>res.text()).then((res)=>{
      NProgress.done(true);
      $("#cLoader").addClass('d-none');
      $("#ben").html(res);
    })
  }
}
        </script>
    </div>
    <!-- include footer -->
    <?php include_once("./footer.php") ?>
