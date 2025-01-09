<?php
// require_once("../config/grobals.php");
include("./includes/head.php");
// only manager,system
if (!in_array($level, ['ADMIN', 'INST_ADMIN', 'BEN_ADMIN'])) {
    session_regenerate_id(true);
    echo "Your session has expired! <span >Redirecting ...</span>";
    echo '<meta http-equiv="refresh" content="1;url=./home">';
    exit();
}

function getStatus($status, $level, $code = 0, $i = 0, $b = 0, $sp = 0,$hasPosted="no",$hasDelivered="no")
{
    switch ($status) {
        case 'adminToInst':
            echo "<div class='p-2'>";
            if ($level === "INST_ADMIN") {
                echo "<button class='btn btn-outline-primary btn-xs'  id='cStatus' data-s='benToConfirm' data-code='$code' data-i='$i' data-b='$b'> send back to BEN</button>";
            } elseif ($level == "BEN_ADMIN") {
                echo "<span class='badge badge-outline-info'>PROCESSING</span>";
            } elseif ($level == "ADMIN") {
                echo "<span class='badge badge-outline-success'>COMPLETED</span>";
            }
            echo "</div>";
            break;
            case 'benToConfirm':
                echo "<div class='p-2'>";
                if ($level === "BEN_ADMIN") {
                    echo "<span class='badge badge-outline-warning'>WAIT YOUR APPROVAL</span>";
                    echo "<button class='btn btn-outline-primary btn-xs'  id='cStatus' data-s='instToBen' data-code='$code' data-i='$i' data-b='$b'> Approve</button>";
                } elseif ($level == "INST_ADMIN") {
                    echo "<span class='badge badge-outline-warning'>WAIT APPROVAL</span>";
                } else {
                    echo "<span class='badge badge-outline-success'>COMPLETED</span>";
                }
                echo "</div>";
                break;
            case 'instToConfirm':
                echo "<div class='p-2'>";
                if ($level === "INST_ADMIN") {
                    echo "<span class='badge badge-outline-warning'>WAIT YOUR APPROVAL</span>";
                    echo "<button class='btn btn-outline-primary btn-xs'  id='cStatus' data-s='adminToInst' data-code='$code' data-i='$i' data-b='$b'> Approve</button>";
                } elseif ($level == "BEN_ADMIN") {
                    echo "<span class='badge badge-outline-info'>PROCCESSING</span>";
                } else {
                    echo "<span class='badge badge-outline-warning'>WAIT APPROVAL</span>";
                }
                echo "</div>";
                break;
        case 'instToAdmin':
            echo "<div class='p-2'>";
            if ($level === "INST_ADMIN") {
                echo "<span class='badge badge-success'>SENT TO THE RISA</span>";
            } elseif ($level == "BEN_ADMIN") {
                echo "<span class='badge badge-outline-info'>PROCCESSING</span>";
            } else {
                if ($sp != 0 && $hasDelivered=="yes") {
                    echo "<span class='badge badge-outline-info'>READY TO BE DELIVERED</span>";
                    // $hideOrShow=$hasRegistered=="no"?"d-none":"showSendBackBtn";
                    echo "<button class='btn btn-outline-primary'  id='cStatus' data-s='instToConfirm' data-code='$code' data-i='$i' data-b='$b'> send back to INST</button>";
                } else {
                    if($hasPosted=="yes" && $hasDelivered=="no" && $sp != 0){?>
                       <button class='btn btn-outline-primary' onClick="approveDelivery('<?=$code?>','<?=$sp?>')">Approve delivery </button>
                  <?php } else if($hasPosted=="no"){?>
                   <button class='btn btn-outline-primary' onClick="postTender('<?=$code ?>')">Post Tender</button>";
                  <?php } else{
                   echo "<span class='badge badge-outline-warning'>POSTED</span>";
                  }
                   
                }
            }
            echo "</div>";
            break;
        case 'benToInst':
            echo "<div class='p-2'>";
            if ($level == "BEN_ADMIN") {
                echo "<span class='badge badge-info'>PENDING</span>";
            } elseif ($level == "INST_ADMIN") {
                echo "<button class='btn btn-outline-primary' id='cStatus' data-s='instToAdmin' data-code='$code'> send to Admin </button>";
                ?>
                <!-- <button class="btn btn-outline-danger" type="button" onClick="rejectBenRequest(<?=$code?>)">Reject</button> -->
            <?php
            }
            echo "</div>";
            break;
        case 'instToBen':
            echo "<div class='p-2'>";
            if ($level == "BEN_ADMIN") {
                echo "<span class='badge badge-outline-success'>RECIEVED</span>";
            } elseif ($level == "INST_ADMIN" || $level === "ADMIN") {
                echo "<span class='badge badge-outline-success'>COMPLETED</span>";
            }
            echo "</div>";
            break;
        default:
            break;
    }
}
?>
<?php
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
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <!-- <h4>Hi, welcome back!</h4> -->
                        <span>List of requested devices</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0)"></a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th class=" fs-13">#</th>
                                            <th class=" fs-13">Name</th>
                                            <th class=" fs-13">Qty</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class=" fs-12">
                                        <?php
                                        $ht = $_SESSION['ht_hotel'];
                                        $cond = "1";
                                        if (isset($_GET['c'])) {
                                            $cond = "request_code ='{$_GET["c"]}'";
                                        }
                                        if ($_SESSION['ht_level'] == "INST_ADMIN") {
                                            $cond .= " AND institition_id=$ht";
                                        } elseif ($_SESSION['ht_level'] == "BEN_ADMIN") {
                                            $beId = $_SESSION['ht_ben'];
                                            $cond .= " AND ben_id=$beId";
                                        } else {
                                            if (!isset($_GET['c'])) {
                                                $cond = "request_code IN(SELECT r_code FROM inst_requests where (status='instToAdmin' OR status='adminToInst' OR status='instToBen' OR status='instToConfirm' OR status='benToConfirm'))";
                                            }
                                        }
                                        $cond = ltrim($cond, "AND");
                                        $sId="";
                                        if(isset($_GET['d'])){
                                            $sId="id={$_GET['d']} AND";
                                        }
                                        $sql = "SELECT id,purchased, name,numbers,specifications as spec,created_at,institition_id,ben_id,request_code from device_requests where $sId $cond order by id desc";
                                        //  echo $sql;
                                        $lists = $database->fetch($sql);
                                        $i = 1;
                                        $inst = [];
                                        $ben = [];
                                        $code = [];
                                        $hasCompleted = false;
                                        foreach ($lists as $key => $h) {
                                            if (!isset($inst[$h['institition_id']])) {
                                                $inst[$h['institition_id']] = $database->get("name", "institition_tb", "id={$h['institition_id']}")->name;
                                            }
                                            if (!isset($ben[$h['ben_id']])) {
                                                $bid=$h['ben_id'];
                                                if($bid>0){
                                                $bname=$database->get("name", "beneficiary_tb", "id=$bid");
                                                if(isset($bname->name)){
                                                    $ben[$h['ben_id']] =$bname->name;
                                                }else{
                                                    $ben[$h['ben_id']]='-';  
                                                }
                                            }else{
                                                $ben[$h['ben_id']]='-';   
                                            }

                                                
                                            }
                                            if (!isset($code[$h['request_code']])) {
                                                $c = $h['request_code'];
                                                $code[$h['request_code']] = $c;
                                                $row = $database->get("has_deliveried,status,sup_id,has_registered,has_published", "inst_requests", "r_code='$c'");
                                        ?>
                                                <tr>
                                                    <td colspan='5' class='text-center text-uppercase text-black-50'>
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <div>
                                                                <span>#<?= $h['request_code'] ?></span>
                                                                <span><?= $inst[$h['institition_id']] ?>/<?= $ben[$h['ben_id']] ?>(<?php echo input::timeAgo($h['created_at']) ?>)</span>
                                                            </div>
                                                            <?php
                                                            getStatus($row->status, $_SESSION['ht_level'], $c, $h['institition_id'], $h['ben_id'], $row->sup_id,$row->has_published,$row->has_deliveried);
                                                            if ($row->status == "instToAdmin" && $row->sup_id>0 && $level=="ADMIN") {
                                                                $hasCompleted = true;
                                                            }
                                                            ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php
                                                $i = 1;
                                            }
                                            ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td class="">
                                                    <div class="d-flex flex-column">
                                                    <span><?= $h['name'] ?></span>
                                                    <span class="text-info text-capitalize">(<?=$h['spec']?>)</span>
                                        </div>
                                                </td>
                                                <td class=""> 
                                                <span id="p_<?=$h['id']?>"><?= $h['purchased']?>/</span>
                                                <span><?=$h['numbers'] ?></span></td>
                                                <td>
                                                    <div class="">
                                                        <?php if(($h['numbers']>$h['purchased'])  && $hasCompleted ): ?>
                                                        <button class=" btn btn-outline-primary  btn-xs btnregister" id="btn_<?=$h['id']?>" type="button" onclick="onDeviceRegister('<?= $h['name'] ?>','<?= $h['numbers']-$h['purchased'] ?>',<?= $h['id'] ?>,'<?=$h['request_code']?>',<?=$h['purchased']?>)"><span class=" fa fa-plus"></span> Register </button>
                                                    <?php endif; ?>
                                                    <?php if($h['purchased']>0 ): ?>
                                                    <a href="device?d=<?=$h['id']?>&nm=<?= $h['name']?>" class="btn btn-outline-info btn-xs"><span class=" fa fa-eye"></span> view</a>
                                                <?php  endif;?>    
                                                </div>
                                                </td>
                                            </tr>
                                        <?php
                                            $i++;
                                        }
                                        // empty places;
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
                    <h5 class="modal-title"><span class="modalTitle">Assign the supplier</span></h5>
                    <span class="close"> <span class=" fa fa-times " data-bs-dismiss="modal"></span></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form" method="POST" action="#">
                        <div class="row">
                            <div class="col-lg-12" id="dvAssign">
                                <div class="mb-3">
                                    <label for="name" class="text-black form-label">Suppliers <span class="required text-danger">*</span></label>
                                    <select id="name" name="supplier" value="" class="form-control text-uppercase">
                                        <option value="" selected disabled>__select__</option>
                                        <?php
                                        if ($_SESSION['ht_level'] == "ADMIN") {
                                            $sups = $database->fetch("select id,name FROM a_partner_tb");
                                            foreach ($sups as $key => $s) { ?>
                                                <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                                        <?php }
                                        }
                                        ?>
                                    </select>
                                    <input type="hidden" name="action" id="action" value="ASSIGN_SUPPLIER" />
                                    <input type="hidden" name="code" value="" id="scode" />
                                    <input type="hidden" name="i" value="" id="si" />
                                    <input type="hidden" name="b" value="" id="sb" />
                                    <input type="hidden" name="btn_action" value="" id="btn_action" />
                                </div>
                                <div class="col-lg-12 text-center">
                                    <div class="mb-3  ">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="onAssignSupplier(this)">Save</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12 d-none" id="dvRegister">
                                <div class="row">
                                <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="dManufacturer" class="text-black form-label">Manufacturer<span class="required text-danger">*</span></label>
                                            <input type="text" value="" id="dManufacturer" name="manufacturer" class=" form-control text-uppercase" placeholder="Type here ..." />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="dGuarantee" class="text-black form-label">Guarantee In Months<span class="required text-danger">*</span></label>
                                            <input type="number" value="" name="guarantee" class=" form-control" placeholder="Eg:13" />
                                            <input type="hidden" name="dId" value="" id="dId"/>
                                            <input type="hidden" name="dNumbers" value="" id="dNumbers"/>
                                            <input type="hidden" name="dPurchase" value="" id="dPurchase"/>
                                            <input type="hidden" name="dName" value="" id="dName"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" id="dvConfirm">
                                    <div class="d-flex flex-row justify-content-center align-items-center ">
                                    <label for="dNumber" class="text-black form-label fs-13">Supplied devices<span class="required text-danger">*</span></label>
                                    <div class=" d-flex flex-row justify-content-center align-items-center">
                                    <input type="number" class=" form-control" name="dNumber" value="" id="dNumber" class=" form-control"/>
                                       <button type="button" class="btn btn-outline-primary btn-xs" onclick="onDeviceAvailable()"><i class=" fa fa-check-circle"></i></button>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row" id="dvDevices">
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center d-none" id="dvRegistration">
                                    <div class="mb-3  ">
                                        <button type="button" class="btn btn-primary btn-xs" onclick="onDeviceRegistration(this)">Save</button>
                                    </div>
                                </div>

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
    <?php include_once("./footer.php");
     
    
    ?>
    