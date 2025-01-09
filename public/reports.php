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
            <div class="form-head d-flex mb-3 align-items-start">
                <div class="me-auto d-none d-lg-block">
                    <h2 class="text-primary font-w600 mb-0">Reports</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <?php
                                if ($level == "ADMIN") { ?>

                                    <div class="col-lg-4">
                                        <div class="widget-stat card">
                                            <div class="h-50 rounded card-body p-4 btn-dark " onclick="chooseReport('LSNCL','List of Students did not complete logbook')">
                                                <div class="media ai-icon d-flex">
                                                    <div class="media-body ">
                                                        <p class="mb-0 text-white font-weight-bolder">List of Students based on how to  complete logbook</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="widget-stat card">
                                            <div class="h-50 rounded card-body p-4 btn-warning dates" onclick="chooseReport('LSNG','List of Students haven\'t grade')">
                                                <div class="media ai-icon d-flex">
                                                    <div class="media-body ">
                                                        <p class="mb-0 text-white font-weight-bolder">List of Students haven't grades </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="widget-stat card">
                                            <div class="h-50 rounded card-body p-4 btn-light dates" onclick="chooseReport('LSNP','List of Students haven\'t partner')">
                                                <div class="media ai-icon d-flex">
                                                    <div class="media-body ">
                                                        <p class="mb-0 text-white font-weight-bolder">List of Students haven't partner </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="widget-stat card">
                                            <div class="h-50 rounded card-body p-4 btn-success dates" onclick="chooseReport('LSWG','List of Students with  grades')">
                                                <div class="media ai-icon d-flex">
                                                    <div class="media-body ">
                                                        <p class="mb-0 text-white font-weight-bolder">List of Students with  grades </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="widget-stat card">
                                            <div class="h-50 rounded card-body p-4 btn-success dates" onclick="chooseReport('LSWGS','List of Students with  grades from supervisors')">
                                                <div class="media ai-icon d-flex">
                                                    <div class="media-body ">
                                                        <p class="mb-0 text-white font-weight-bolder">List of Students with  grades from supervisors </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="widget-stat card">
                                            <div class="h-50 rounded card-body p-4 btn-warning dates" onclick="chooseReport('LSNGS','List of Students haven\'t grade from supervisors')">
                                                <div class="media ai-icon d-flex">
                                                    <div class="media-body ">
                                                        <p class="mb-0 text-white font-weight-bolder">List of Students haven't grades from supervisors </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="widget-stat card">
                                            <div class="h-50 rounded card-body p-4 btn-dark dates" onclick="chooseReport('LSNS','List of Students haven\'t Suppervisor')">
                                                <div class="media ai-icon d-flex">
                                                    <div class="media-body ">
                                                        <p class="mb-0 text-white font-weight-bolder">List of Students haven't Suppervisor</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="widget-stat card">
                                            <div class="h-50 rounded card-body p-4 btn-info dates" onclick="chooseLogbook('SLB','Student logbook')">
                                                <div class="media ai-icon d-flex">
                                                    <div class="media-body ">
                                                        <p class="mb-0 text-white font-weight-bolder">Students Logbook</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="widget-stat card">
                                            <div class="h-50 rounded card-body p-4 btn-primary dates" onclick="chooseReport('CR','Course rating')">
                                                <div class="media ai-icon d-flex">
                                                    <div class="media-body ">
                                                        <p class="mb-0 text-white font-weight-bolder">How major courses requested</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               
                                    <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
    <div class="modal fade bd-example-modal-lg" id="basicModal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span id="asr"></span> reports</h5>
                    <button class=" badge badge-circle badge-outline-danger"> 
                        <span class=" fa fa-times " data-bs-dismiss="modal"></span></button>
                </div>
                <div class="modal-body">
                   <form id="form">
                        <div class="row">
                            <div class="col-lg-12 myhide d-none">
                                <div class="mb-3">
                                    <label for="menu_type" class="text-black form-label">From </label>
                                    <input type="date" name="from" class=" form-control" />
                                    <input type="hidden" name="rname" class="form-control" id="rname" />
                                </div>
                            </div>
                            <div class="col-lg-12 myhide d-none">
                                <div class="mb-3">
                                    <label for="menu_type" class="text-black form-label">To </label>
                                    <input type="date" name="to" class=" form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12 myid">
                                <div class="mb-3">
                                    <label for="menu_type" class="text-black form-label"> Student Id </label>
                                    <input type="number" name="student_id" placeholder="Enter student here" class=" form-control" id="student_id" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3 text-center">
                                    <label for="menu_type" class="text-black form-label"> </label>
                                    <button type="button" class=" btn btn-outline-primary" onclick="generateReport()"> Generate</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- include footer -->
    <?php include_once("./footer.php") ?>
    <script>
        var action="";
 function generateReport(){
  let req=$("#form").serialize();
//   let url="generatedReport?"+req;
  let url1="generatedLogbook?"+req;
//   window.open(url, '_blank').focus();
  window.open(url1, '_blank').focus();
  // window.open(url);
 }
  function chooseReport(name="",label=""){
    action=name;
    if(name!="SLB"){
      let url=`generatedReport?rname=${name}`;
      window.open(url, '_blank').focus();
      return;
    }
    $("#rname").val(name);
    $("#asr").text(label)
    $("#basicModal").modal("show");
  }
  function chooseLogbook(name="",label=""){
    action=name;
    if(name!="SLB"){
      let url1=`generatedLogbook?rname=${name}`;
      window.open(url1, '_blank').focus();
      return;
    }
    $("#rname").val(name);
    $("#asr").text(label)
    $("#basicModal").modal("show");
  }
</script>