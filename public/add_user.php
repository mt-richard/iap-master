<?php
include("./includes/head.php");
if(!in_array($level,['ADMIN','INST_ADMIN'])){
    session_regenerate_id(true);
    echo "Your session has expired! <span >Redirecting ...</span>";
    echo '<meta http-equiv="refresh" content="1;url=./home">';
    exit();
}
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
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Add a user</a></li>
                        </ol>
                    </div>
                </div>
            <div class=" row">
                <div class=" col-lg-12">
                    <div class=" card">
                        <div class=" card-body">
                            <form id="formUser" action="#" method="POST">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card ">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="name" class="text-black font-w600 form-label">Names<span class="required">*</span></label>
                                                            <input type="text" class="form-control" value="" name="names" placeholder="Eg:John Doe" id="names">
                                                            <input type="hidden" value="<?= input::enc_dec('e', 'CREATE_NEW_USER') ?>" name="faction">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="name" class="text-black font-w600 form-label">Phone<span class="required">*</span></label>
                                                            <input type="number" class="form-control" value="" name="phone" placeholder="Eg:0789047172" id="phone" onkeypress="limitKeypress(event,this.value,10)">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="uname" class="text-black font-w600 form-label">User name<span class="required">*</span></label>
                                                            <div class=" d-flex flex-row">
                                                                <button class="btn btn btn-outline-light" id="hid" type="button"><?='u'.$_SESSION['ht_hotel'].'_'?></button>
                                                            <input type="text" class="form-control" value="" name="username" placeholder="Eg:JohnD" id="uname">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="hotel_level" class="text-black font-w600 form-label">level <span class="required">*</span></label>
                                                            <select type="text" class="form-control" value="" name="user_level" id="hotel_level" onchange="onLevelChange(this.value)">
                                                            <option value="" disabled selected>__select__</option>
                                                                <option value="ADMIN">Admin</option>
                                                                <option value="USER">Normal user</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="hotel_status" class="text-black font-w600 form-label">Status <span class="required">*</span></label>
                                                            <select type="text" class="form-control" value="" name="user_status" id="hotel_status">
                                                                <option value="active">Active</option>
                                                                <option value="inactive">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="pswd" class="text-black font-w600 form-label">Password<span class="required">*</span></label>
                                                            <input type="text" class="form-control" value="" name="pswd" placeholder="Eg:@123!" id="pswd">
                                                        </div>
                                                    </div>
                                                    <div class=" col-lg-12">
                                                        <div id="ajaxresults"></div>
                                                        <div class=" mb-3 text-center">
                                                            <button type="button" class=" btn  btn-outline-primary btn-sm" onclick="onUserCreated(this)">Save</button>
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
    </div>
    <!-- include footer -->
    <?php include_once("./footer.php") ?>