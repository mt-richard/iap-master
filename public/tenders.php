<?php
include("includes/head.php");

?>
    <?php
    $ncond="";
    if (isset($_GET['n'])) {
        $id = $_GET['n'];
        $idDec=input::enc_dec("d",$id);
        $database->query("DELETE FROM notifications_tb where id=$idDec");
    }
    if(isset($_GET['c']) && is_numeric($_GET['c'])){
        $c=input::get("c");
        $ncond="id=$c AND ";
    }
    ?>

<div id="main-wrapper">
    <?php include("includes/sidebar.php") ?>
    <!-- header here -->
    <?php include("header.php") ?>
    <!-- chatbox here -->
    <div class="content-body">
    <div class="container-fluid">
        <div class="row">
        <?php
function displayDevices($r_code){
    global $database;
    $devices=$database->fetch("SELECT name,numbers,specifications as spec  FROM device_requests where request_code='$r_code'");
    echo "<ul class='list-group list-group-flush'>";
   foreach ($devices as $key => $d) {
     echo "<li class='list-group-item'>
     {$d['name']} ({$d['numbers']})<br/>
     <p>{$d['spec']}</p>
     </li>";
    }
    echo "</ul>";
}
?>
<div class="col-xl-12" >
    <div class="card" style="height:500px;overflow: auto;">
        <div class="card-header border-0 pb-0 d-sm-flex flex-wrap d-block">
            <div class="mb-3">
                <h4 class="card-title mb-1 text-capitalize">Tenders Application</h4>
            </div>
            <div class="card-action card-tabs mb-3">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#monthly" role="tab" aria-selected="false">
                           Last Winners
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#today" role="tab" aria-selected="true">
                            New application
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body tab-content pt-3">

    <div class="tab-pane fade" id="monthly">
                <div class="height500 dz-scroll loadmore-content ps ps--active-y" id="sellingItemsContent">
                    <?php
                     $lastWinners=$database->fetch("SELECT r_code,updated_at,sup_id,
                     (select name from a_partner_tb st where st.id=ir.sup_id limit 1) as inst
                      FROM inst_requests ir WHERE ir.sup_id!=0  and ir.has_published='yes' order by id desc");
                    $hasWinner=false;
                    foreach ($lastWinners as $key => $mt) {
                        $rcode=$mt['r_code'];  
                        $hasWinner=true;
                         $applicant=$database->get("id,guarante,price,special_offer,delivery_time","supplier_application","request_code='{$rcode}' AND sup_id={$mt['sup_id']}");
                        if(!isset($applicant->id)){
                            $applicant=(object)["guarante"=>'-','price'=>'-',"special_offer"=>'-','delivery_time'=>''];
                        }
                        ?>
                <div class="media mb-4 items-list-2">
                        <a href="ecom-product-detail.html">
                        <img class="img-fluid rounded me-3" width="85" src="images/tender.png" alt="DexignZone"></a>
                        <div class="media-body col-6 px-0">
                            <h5 class="mt-0 mb-1"><a class="text-black" href="#">TenderId #<?=$rcode?></a></h5>
                            <small class="font-w500 mb-3">
                            <a class="text-success text-uppercase" href="javascript:void(0);"><?=$mt['inst']?></a></small>
                            <span class="text-secondary me-2 fo"></span>
                            <ul class="fs-14 list-inline">
                                <li class="me-3">
                                    <?php
                                     echo displayDevices($rcode);
                                    ?>
                                </li>
                                <li><?=input::timeAgo($mt['updated_at'])?></li>
                            </ul>
                            <div class="d-flex flex-column text-center">
                                <p>Guarante: <?=$applicant->guarante ?></p>
                                <p>Delivery Time: <?=$applicant->delivery_time ?></p>
                                <p>Special offer:<?=$applicant->special_offer?>
                                 </p>
                            </div>
                        </div>
                        <div class="media-footer align-self-center ms-auto d-block align-items-center d-sm-flex">
                            <h3 class="mb-0 font-w600 text-secondary">FRW <?=$applicant->price?></h3>
                            <div class=" ms-3 ">
                            <a  href="sup_profile?c=<?=$mt['sup_id']?>"  class="btn btn-xs btn-outline-info" id="cancelTender">
                                    View Applicant
                                </a>
                            </div>
                        </div>
                    </div>
                <?php
            }
            echo $hasWinner?"":"<div class='alert alert-danger'>Empty lists</div>";
                ?>
                </div>
                <div class="text-center bg-white pt-3">
                    <a href="javascript:void(0);" class="btn-link dz-load-more" rel="#" id="sellingItems">View more <i class="fa fa-angle-down ms-2 scale-2"></i></a>
                </div>
            </div>  
        <div class="tab-pane fade show active" id="today">
                <div class="height500 dz-scroll loadmore-content ps ps--active-y" id="sellingItemsContent">
                    <?php
                    $newApps=$database->fetch("SELECT * FROM supplier_application WHERE $ncond winner_id=0 order by id desc");
                    $hasData=false;
                    foreach ($newApps as $key => $na) {
                        $hasData=true;
                        $rcode=$na['request_code'];
                        ?>
                 <div class="media mb-4 items-list-2">
                        <a href="ecom-product-detail.html">
                        <img class="img-fluid rounded me-3" width="85" src="images/tender.png" alt="DexignZone"></a>
                        <div class="media-body col-6 px-0">
                            <h5 class="mt-0 mb-1"><a class="text-black" href="#">TenderId #<?=$rcode?></a></h5>
                            <small class="font-w500 mb-3">
                            <a class="text-primary text-uppercase" href="javascript:void(0);"><?= $database->get('name',"a_partner_tb","id={$na['sup_id']}")->name?></a></small>
                            <span class="text-secondary me-2 fo"></span>
                            <ul class="fs-14 list-inline">
                                <li class="me-3">
                                    <?php
                                     echo displayDevices($rcode);
                                    ?>
                                </li>
                                <li><?=input::timeAgo($na['created_at'])?></li>
                            </ul>
                            <div class="d-flex flex-column">
                                <p>Guarante: <?=$na['guarante'] ?></p>
                                <p>Delivery Time: <?=$na['delivery_time'] ?></p>
                                <p>Special offer:<?=$na['special_offer']?>
                                 </p>
                            </div>
                        </div>
                        <div class="media-footer align-self-center ms-auto d-block align-items-center d-sm-flex">
                            <h3 class="mb-0 font-w600 text-secondary">FRW <?=$na['price']?></h3>
                            <div class=" ms-3 ">
                                <button type="button" class="btn btn-xs btn-outline-warning "
                                 onclick="approveApplicant('<?=$rcode?>','<?=$na['id']?>','<?=$na['sup_id']?>')">
                                    Confirm  
                                </button>
                                <a  href="sup_profile?c=<?=$na['sup_id']?>"  class="btn btn-xs btn-outline-info" >
                                    View Applicant
                                </a>
                            </div>
                        </div>
                    </div>
                <?php
            }
            echo $hasData?"":"<div class='alert alert-danger'>No any applicants</div>";
                ?>
                </div>
                <div class="text-center bg-white pt-3">
                    <a href="javascript:void(0);" class="btn-link dz-load-more" rel="#" id="sellingItems">View more <i class="fa fa-angle-down ms-2 scale-2"></i></a>
                </div>
            </div>  
        </div>
    </div>
</div>
        </div>   
    </div>
    </div>

<!-- include footer -->
<?php include_once("./footer.php") ?>