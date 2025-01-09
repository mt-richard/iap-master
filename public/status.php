<?php

if (!isset($_GET['d']) || !is_numeric($_GET['d'])) {
    echo "Some data are missing! <span >Redirecting ...</span>";
    echo '<meta http-equiv="refresh" content="2;url=./home">'; 
}
$mainid=$_GET['d'];
$nm=$_GET['nm'];
include("./includes/head.php");
?>
<?php

$r=$database->get("*","supplied_devices","id=$mainid");
if(!isset($r->serial_number)){
    echo "Your session has expired! <span >wait ...</span>";
    echo '<meta http-equiv="refresh" content="1;url=./home">';
    exit(0);
}
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
                <div class="card-body">
                <div class="row">
                        <div class="col-4">
                            <div class=" mb-3">
                                <label>Name</label>
                                <input type="text" readonly class=" form-control text-capitalize" value="<?=$nm?>" id="name"/>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class=" mb-3">
                                <label>Serial Number</label>
                                <input type="text" readonly class=" form-control" value="<?=$r->serial_number?>" id="serial" />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class=" mb-3">
                                <label>Guarantee(<?=$r->guarantee?> months) end to</label>
                                <input type="text" readonly class=" form-control" value="<?=$r->end_guarantee?>"  />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class=" mb-3">
                                <label>Manufacturer</label>
                                <input type="hidden" readonly class=" form-control text-capitalize" value="<?=$mainid?>" id="id"/>
                                <input type="text" readonly class=" form-control text-uppercase" value="<?=$r->manufacturer?>" />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class=" mb-3">
                                <label>Current Status</label>
                                <input type="text" readonly class=" form-control  text-uppercase" value="<?=$r->status?>"  />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class=" mb-3">
                                <label>Descriptions</label>
                                <p class=" text-capitalize text-danger"><?=$r->comment?> </p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="ajaxresults"></div>
                            <div class=" mb-3 text-center">
                                <label></label>
                                <!-- while ben send request -->  
                                   <?php
                                      if($level=="INST_ADMIN"):
                                        if($r->c_flow=="benToInst"):?>
                                        <button class="btn btn-outline-primary" type="button" id="btn_<?=$mainid?>" onclick="sendToAdmin(this)">Send to Admin</button>
                                        <button class="btn btn-outline-danger" type="button" id="btn2_<?=$mainid?>"  data-bs-toggle="modal" data-bs-target="#basicModal">Reject</button>
                                      <?php endif;
                                        if($r->c_flow=="adminToInst"):?>
                                            <button class="btn btn-outline-primary" type="button" id="btn_<?=$mainid?>" onclick="sendToAdmin(this,'SEND_REPLACED_TO_BEN')">Send To BEN</button>
                                        <?php endif;
                                        if($r->c_flow=="benToConfirm"):?>
                                            <button class="btn btn-outline-warning" type="button" id="btn_<?=$mainid?>" >Wait Approval from BEN</button>
                                        <?php endif;
                                    endif; ?>     
                               <?php  
                               if($level==="ADMIN"):
                                 if( $r->c_flow=="instToAdmin"):
                               ?>
                               <button class="btn btn-outline-primary" type="button" id="btn_<?=$mainid?>" onclick="sendToAdmin(this,'SEND_REPLACED_TO_SUP')">Send To SUP</button>
                                <?php
                                endif;
                                if( $r->c_flow=="supToAdmin"):?>
                                  <button class="btn btn-outline-primary" type="button" id="btn_<?=$mainid?>" onclick="replaceDevice(this,'REPLACE_DEVICE')">Replace</button>
                                   <?php
                                    endif;
                                if( $r->c_flow=="supToConfirm"):?>
                                  <button class="btn btn-outline-warning" type="button" id="btn_<?=$mainid?>" >Wait Approval from supplier</button>
                                   <?php
                                    endif;
                                    if( $r->c_flow=="adminToInst"):?>
                                    <button class="btn btn-outline-success" type="button" id="btn_<?=$mainid?>" >device has  replaced</button>
                                <?php endif; 
                            endif;?>
                                    <?php
                                    if($level=="BEN_ADMIN"):
                                        if($r->c_flow=="benToConfirm"):?>
                                        <button class="btn btn-outline-primary" type="button" id="btn_<?=$mainid?>" onclick="sendToAdmin(this,'CONFIRM_REPLACEMENENT_TO_INST')">Confirm replacement</button>
                                        <?php
                                            endif;
                                            if($r->c_flow=="instToBen"):?>
                                                <button class="btn btn-outline-success" type="button" id="btn_<?=$mainid?>" 
                                                >Device has replaced </button>
                                                <?php
                                                    endif;
                                        endif
                                        ?>     
                                         <?php
                                    if($level=="SUP_ADMIN"):
                                        if($r->c_flow=="supToConfirm"):?>
                                        <button class="btn btn-outline-primary" type="button" id="btn_<?=$mainid?>" onclick="sendToAdmin(this,'SEND_REPLACED_TO_ADMIN')">Confirm replacement</button>
                                        <?php
                                            endif;
                                            if($r->c_flow=="supToAdmin"):?>
                                                <button class="btn btn-outline-warning" type="button" id="btn_<?=$mainid?>" 
                                                >Wait approval from Risa</button>
                                            
                                      <?php
                                        endif;
                                    endif;
                                        ?>    
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
             </div>
            </div>
        </div>
    </div>
        <!-- modal -->
        <div class="modal fade bd-example-modal-lg" id="basicModal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit devices status Info <span class=" text-black-50" id="info"></span></h5>
                    <span class="  close"  data-bs-dismiss="modal"> <span class=" fa fa-times" ></span></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form" method="post" action="#">
                    <div class="row">
                    <div class="col-lg-12 no"id="NS">
                            <div class="mb-3">
                                <label for="cat" class="text-black form-label">Health Status <span class="required text-danger">*</span></label>
                                <select type="text" class="form-control" value="" name="status" id="cat">
                                    <option value="" disabled selected>__select__</option>
                                    <option value="functional">Functional</option>
                                    <option value="maintenance">Maintenance</option>
                                    <!-- <option value="nonfunctional">Non functional</option>
                                    <option value="lost">Lost</option> -->
                                </select>
                            </div>
                        </div> 
                        <div class="col-lg-12 no">
                            <div class="mb-3">
                                <label for="name" class="text-black form-label">Short Descriptions <span class="required text-danger">*</span></label>
                                <textarea  name="description"  class=" form-control " id="comment"></textarea>
                                <input type="hidden" name="serial" value="<?=$r->serial_number?>" id="serial"/>
                                <input type="hidden" name="name" value="<?=$_GET['nm']?>" id="name"/>
                                <input type="hidden" name="dId" value="<?=$r->id?>" id="id"/>
                                <input type="hidden" name="old_comment" value="<?=$r->comment?>" id="old_comment"/>
                                <input type="hidden" name="request_code" value="<?=$r->request_code?>"/>
                            </div>
                        </div> 
                        <div class="row nn d-none">
                        <!-- <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="" class="text-black form-label">Name <span class="required text-danger">*</span></label>
                               <input type="text" value="<?=$nm?>"  name="new_name" class="form-control" />
                            </div>
                        </div> 
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="" class="text-black form-label">Manufacturer <span class="required text-danger">*</span></label>
                               <input type="text" value="<?=$r->manufacturer?>"  name="new_manufacturer" class="form-control" />
                            </div>
                        </div>  -->
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="" class="text-black form-label">New Serial Number <span class="required text-danger">*</span></label>
                               <input type="text" value=""  name="new_serial" class="form-control"  />
                            </div>
                        </div> 
                        </div>
                        <div class="col-12">
                            <div class="ajaxresults"></div>
                        </div>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light"  data-bs-dismiss="modal" >Close</button>
                    <?php if($level=="ADMIN"): ?>
                    <button type="button" class="btn btn-primary" onclick="sendToAdmin(this,'REPLACE_REPORTED_DEVICE')">Save</button>
                    <?php endif; if($level!="ADMIN"): ?>
                    <button type="button" class="btn btn-primary" onclick="sendToAdmin(this,'REJECT_DEVICE_REPORTING')">Save</button>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- end of modal -->
    <!-- include footer -->
    <?php include_once("./footer.php") ?>