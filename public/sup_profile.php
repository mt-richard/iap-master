<?php
require_once("../config/grobals.php");
include("./includes/head.php");
// check if id provided
$approve="yes";
function backTo(){
echo "Unautorized <span >Redirecting ...</span>";
echo '<meta http-equiv="refresh" content="1;url=./home">';
}
if(isset($_GET['c']) && $level=="ADMIN" && is_numeric($_GET['c'])){
    $id=(int)$_GET['c'];
    if(isset($_GET['v'])){
        $approve=$_GET['v'];
    }
} else if($level=="SUP_ADMIN"){
    $id=$_SESSION['ht_hotel'];
}else{
backTo();
exit(0); 
}
$supp=$database->get("id,name,c_profile","a_partner_tb","id=$id");
if(!isset($supp->id)){
    backTo();
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
                <div class=" card">
                    <div class=" card-header">
                      <span> Profile-<?=$supp->name?> </span>
                       <?php if($level=="SUP_ADMIN"){ ?>
                      <button class=" btn btn-xs btn-outline-primary" type="button" id="btnUpdate" onclick="updateSupplierProfile('<?=$id?>')">Save changes</button>
                       <?php }if($level=="ADMIN"){ ?>
                      <button class=" btn btn-xs btn-outline-success" type="button" id="btnApprove" onclick="approveSupplier('<?=$id?>','<?=$approve?>')">Approve the partner</button>
                    <?php } ?>
                    </div>
             <div class="card-body">
             <form method="post" id="myprofile">
                <textarea id="summernote" name="editordata"><?=$supp->c_profile?></textarea>
            </form>
            </div>
             </div>
             </div>
            </div>
        </div>
    </div>
    <?php include_once("./footer.php") ?>