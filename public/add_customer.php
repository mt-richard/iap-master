<?php
include("./includes/head.php");
// input
include("../util/input.php");
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
                    <h2 class="text-primary font-w600 mb-0">Hotel</h2>
                    <p class="mb-0">Register new hotel</p>
                </div>
            </div> -->
            <!-- <div class="row page-titles">
                <div class="col-12  p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">hotel</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Add</a></li>
                    </ol>
                </div>
            </div> -->
            <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <!-- <h4>Hi, welcome back!</h4> -->
                            <span>Hotel account</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Add a hotel</a></li>
                        </ol>
                    </div>
                </div>
            <div class=" row">
                <div class=" col-lg-12">
                    <div class=" card">
                        <div class=" card-body">
                            <form id="hotelForm" action="#" method="POST">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="hotel" class="text-black font-w600 form-label">Name <span class="required">*</span></label>
                                            <input type="text" class="form-control text-uppercase" value="" name="hotel_name" placeholder="hotel name" id="hotel">
                                            <input type="hidden" value="<?= input::enc_dec('e', 'CREATE_HOTEL') ?>" name="faction">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="hotel_status" class="text-black font-w600 form-label">Status <span class="required">*</span></label>
                                            <select type="text" class="form-control" value="" name="hotel_status" id="hotel_status">
                                                <option value="active">Active</option>
                                                <option value="inactive" selected>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="hotel_trial" class="text-black font-w600 form-label">Trial days <span class="required">*</span></label>
                                            <input type="number" class="form-control text-uppercase" value="90" name="hotel_trial" placeholder="Eg:90" id="hotel_trial">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="clocation" class="text-black font-w600 form-label">Location <span class="required">*</span></label>
                                            <input type="text" class="form-control" value="" name="hotel_location" placeholder="Eg:Kigali-nyarugenge" id="clocation">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="cname" class="text-black font-w600 form-label">Contact person <span class="required">*</span></label>
                                            <input type="text" class="form-control" value="" name="contact_names" placeholder="person name" id="cname">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="cphone" class="text-black font-w600 form-label">Contact person phone <span class="required">*</span></label>
                                            <input type="number" class="form-control" value="" name="contact_phone" placeholder="contact phone" id="cphone" onkeypress="limitKeypress(event,this.value,10)">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="card ">
                                            <div class=" card-header">
                                                Add Admin User
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="name" class="text-black font-w600 form-label">Name<span class="required">*</span></label>
                                                            <input type="text" class="form-control" value="" name="admin_names" placeholder="Eg:John Doe" id="name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="uname" class="text-black font-w600 form-label">User name<span class="required">*</span></label>
                                                            <input type="text" class="form-control" value="" name="user_name" placeholder="Eg:JohnD" id="uname">
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
                                                            <button type="button" class=" btn  btn-outline-primary btn-sm" onclick="onHotelCreated(this)">Save</button>
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
