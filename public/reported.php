<?php
include("./includes/head.php");

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
                                    <!-- <button class=" btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#basicModal">Add New</button> -->
                                </h4>                                   
                                <!-- <small class="mb-0"></small> -->
                            </div>
                            <div class="card-action card-tabs mb-3">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#monthly" role="tab">
                                            Reported devices </span>
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
                                        <th>#</th>
                                        <th class=" fs-13">Name</th>
                                        <th class=" fs-13">Serial.N</th>
                                        <th class=" fs-13">Manufacturer</th>
                                        <th class=" fs-13">Date</th>
                                        <!-- <th class=" fs-13">place</th> -->
                                        <th class=" fs-13"></th>
                                        </tr>
                                    </thead>
                                    <tbody class=" fs-12">
                                        <?php
                                        $i=1;
                                        $cond="";
                                        if($level=="BEN_ADMIN"){
                                            $id=$_SESSION['ht_ben'];
                                            $cond=" INNER JOIN device_requests dr on sd.device_id=dr.id AND dr.ben_id=$id AND sd.c_flow='instToBen'";
                                        }
                                        elseif($level=="INST_ADMIN"){
                                            $id=$_SESSION['ht_hotel'];
                                            $cond=" INNER JOIN device_requests dr on sd.device_id=dr.id AND institition_id=$id AND (sd.c_flow='instToBen' OR sd.c_flow='benToConfirm' OR sd.c_flow='instToAdmin' OR sd.c_flow='benToInst')";
                                        }else{
                                            $cond=" INNER JOIN device_requests dr on sd.device_id=dr.id AND sd.has_reported='yes'";  
                                        }
                                        $sql="SELECT sd.c_flow,sd.id,sd.manufacturer,sd.serial_number,sd.updated_at,dr.name  FROM supplied_devices sd $cond order by sd.id desc";
                                        // echo $sql;
                                        $lists=$database->fetch($sql);
                                        // $names=
                                        foreach ($lists as $key => $h) {
                                            ?>
                                            <tr>
                                                <td><?=$i?></td>
                                                <td><?=$h['name']?></td>
                                                <td><?=$h['serial_number']?></td>
                                                <td  class=" text-uppercase"><?=$h['manufacturer']?></td>
                                                <td  class=""><?=$h['updated_at']?></td>
                                                <!-- <td><?=$h['c_flow']?></td> -->
                                                <td class=" d-flex flex-row justify-content-center align-items-center" id="td_<?=$h['id']?>">
                                                <a href="status?d=<?=$h['id']?>&nm=<?= $h['name']?>" class="btn btn-outline-info btn-xs"><span class=" fa fa-eye"></span> view</a>
                                            </td>
                                            </tr>
                                        <?php 
                                    $i++;
                                    }
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
                    <div class="col-lg-12 d-none "id="NS">
                            <div class="mb-3">
                                <label for="cat" class="text-black form-label">Health Status <span class="required text-danger">*</span></label>
                                <select type="text" class="form-control" value="" name="status" id="cat">
                                    <option value="" disabled selected>__select__</option>
                                    <option value="functional">Functional</option>
                                    <option value="maintenance">Maintenance</option>
                                    <option value="nonfunctional">Non functional</option>
                                    <option value="lost">Lost</option>
                                </select>
                            </div>
                        </div> 
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="name" class="text-black form-label">Short Descriptions <span class="required text-danger">*</span></label>
                                <textarea  name="description"  class=" form-control " id="name"></textarea>
                                <input type="hidden" name="action" value="DEVICE_HEALTH_STATUS"/>
                                <input type="hidden" name="currentS" value="" id="currentS"/>
                                <input type="hidden" name="serial" value="" id="serial"/>
                                <input type="hidden" name="btnClicked" value="" id="btnClicked"/>
                                <input type="hidden" name="dname" value="<?=$_GET['nm']?>" id="btnClicked"/>
                                <input type="hidden" name="dId" value="" id="dId"/>
                            </div>
                        </div> 
                        <div class="col-12">
                            <div id="ajaxresults"></div>
                        </div>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light"  data-bs-dismiss="modal" >Close</button>
                    <button type="button" class="btn btn-primary" onclick="onDeviceStatusSave(this)">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end of modal -->
    <!-- include footer -->
    <?php include_once("./footer.php") ?>