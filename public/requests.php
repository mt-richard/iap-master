<?php
require_once("../config/grobals.php");
include("./includes/head.php");

$instId = $_SESSION['ht_hotel'];
// where institition_id=$instId
$lists = $database->fetch("SELECT name,cat FROM allowed_devices  order by name asc");
$dByCats = ["inputDevice" => [], "outputDevice" => [], "networkDevice" => [], "processingDevice" => [], "storageDevice" => []];
foreach ($lists as $key => $l) {
    $ct = $l['cat'];
    $dByCats["$ct"] = array_merge($dByCats["$ct"], [$l['name']]);
}
$jsonDevices = json_encode($dByCats);

?>
<div id="main-wrapper">
    <?php include("./includes/sidebar.php") ?>
    <!-- header here -->
    <?php include("./header.php") ?>
    <!-- chatbox here -->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <?php if(true){?>
                <div class="col-md-12">
                    <div class="card">
                        <div class=" card-header">
                            <h4>Computing devices</h4>
                            <button class=" btn btn-outline-primary openModel d-none" data-bs-toggle="modal" data-bs-target="#basicModal">Make Request</button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class=" card justify-content-center align-items-center">
                                        <div class="mb-3  flex-column d-flex">
                                            <label for="menu_type" class="text-primary form-label">Input devices
                                                 </label>
                                                 <span class=" btn  badge badge-outline-primary ml-2" onclick="openRequestModel('inputDevice')">
                                                 <i class=" flaticon-381-plus"></i>Add</span>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class=" card justify-content-center align-items-center">
                                        <div class="mb-3  flex-column d-flex">
                                            <label for="menu_type" class="text-primary form-label">Processing devices 
                                                </label>
                                                <span class=" btn badge badge-outline-primary ml-2" onclick="openRequestModel('processingDevice')">
                                                <i class=" flaticon-381-plus"></i>Add</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class=" card justify-content-center align-items-center">
                                        <div class="mb-3  flex-column d-flex">
                                            <label for="menu_type" class="text-primary form-label">Output devices 
                                                </label>
                                                <span class=" badge badge-outline-primary btn" onclick="openRequestModel('outputDevice')">
                                                <i class=" flaticon-381-plus"></i>Add</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class=" card justify-content-center align-items-center">
                                        <div class="mb-3  flex-column d-flex">
                                            <label for="menu_type" class="text-primary form-label">Storage devices</label>
                                            <span class=" badge badge-outline-primary btn" onclick="openRequestModel('storageDevice')">
                                            <i class=" flaticon-381-plus"></i> Add</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class=" card justify-content-center align-items-center">
                                        <div class="mb-3 flex-column d-flex">
                                            <label for="menu_type" class="text-primary form-label">Network devices
                                                </label>
                                                <span class=" badge badge-outline-primary btn " onclick="openRequestModel('networkDevice')">
                                                <i class=" flaticon-381-plus"></i>Add </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-none" id="dList">
                    <div class=" card">
                        <div class=" card-header">
                            <h4>List of devices</h4>
                        </div>
                        <div class=" card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div id="inputDevice" class=" m-2" data-list="no"></div>
                                </div>
                                <div class="col-12">
                                    <div id="outputDevice" class=" m-2" data-list="no">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div id="storageDevice" class=" m-2" data-list="no">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div id="processingDevice" class=" m-2" data-list="no">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div id="networkDevice" class=" m-2" data-list="no">
                                    </div>
                                </div>
                                <div class="col-12">
                                <div id="ajaxresults2"></div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-sm btn-outline-primary" type="button" onclick="onSaveDeviceRequest(this)">Send Request</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               <?php } else{ ?>
                <div class=" col-12">
                    <div class=" card">
                        <div class=" card-header">
                            <h4>Requested devices</h4>
                        </div>
                        <div class=" card-body">
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
        <!-- modal -->
        <div class="modal fade bd-example-modal-lg" id="basicModal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Computing device info(<span id="ckey"></span>) <span class="badge badge-outline-info" id="dCount"></span></h5>
                        <button class="close btn btn-xs btn-link text-danger" data-bs-dismiss="modal" > <span class=" fa fa-times " > </span>&times
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form" method="POST" action="#" onsubmit="(e)=>e.preventDefault();">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="name" class="text-black form-label">Name <span class="required text-danger">*</span></label>
                                        <!-- <input type="text" id="name" name="name" value=""  class="form-control text-uppercase" /> -->
                                        <select id="name" name="name" value="" class="form-control text-uppercase">
                                        </select>
                                        <input type="hidden" name="action" value="MAKE_COMPUTING_REQUEST" />
                                        <input type="hidden" name="currentKey" value="" id="currentKey" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="size" class="text-black form-label">Number/size <span class="required text-danger">*</span></label>
                                        <input id="size" type="text" name="size" class="form-control" value="" />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="size" class="text-black form-label">Specifications </label>
                                        <textarea name="specification" class="form-control" rows="8" style="height:150px" placeholder="Write here some specification" id="specification"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center">
                                <div class="mb-3  ">
                                <button type="button" class="btn btn-primary btn-sm" onclick="onAddDeviceOnList()">Add</button>
                                </div>
                                </div>
                                <div class="col-12">
                                    <div id="ajaxresults"></div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- end of modal -->

        <!-- include footer -->
        <?php include_once("./footer.php") ?>