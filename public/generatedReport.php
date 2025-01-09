<?php 
include("./includes/head.php");
?>
    <div class="container-fluid">
        <div class="row card">
            <div class="col-12">
                <div class=" row bg-white">
                    <div class="col-3">    
                        <h3 class="h3"></h3>
                    </div>
                    <div class="col-5 d-flex flex-column justify-content-around align-items-center">
                    <img src="images/logo.jpg" alt="" class="pb-10" style="width:45%;">
                    <h3 style="font-weight:500;">IAP Mornitoring, Tracking and Online Interaction System</h3>
                    </div>
                    <div class="col-12 border border-1 border border-bottom">
                    </div>
                </div>
            </div>
          <?php 
           switch ($level) {
            case 'ADMIN':
             include('./partial/report/admin_report.php');
              break;
            default:
            echo "<p>Your homepage not found</p>";
              break;
           }
          ?>
        </div>   
    </div>
<!-- include footer -->
<?php include_once("./footer.php") ?>