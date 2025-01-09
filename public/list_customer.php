<?php
include("./includes/head.php");
include("./model/Hotel.php");
// get lists of registered hotels
$lists = Hotel::all(" order by id desc");
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
                            <span>List of hotels</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Hotels</a></li>
                        </ol>
                    </div>
                </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- <div class="card-header">
                            <h4 class="card-title">Hotels</h4>
                        </div> -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <!-- <table id="example5" class="display mb-4 dataTablesCard" style="min-width: 845px;"> -->
                                <table id="example"  class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                        <th class=" fs-13">#</th>
                                            <th class=" fs-13">Code</th>
                                            <th class=" fs-13">Name</th>
                                            <th class=" fs-13">Loc</th>
                                            <th class=" fs-13">Date</th>
                                            <th class=" fs-13">Phone</th>
                                            <th class=" fs-13">Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class=" fs-12">
                                        <?php
                                        $i=0;
                                        foreach ($lists as $key => $h) {
                                            $i++;
                                            ?>
                                            <tr>
                                            <td><?= $i?></td>
                                                <td><?= $h['h_id'] ?></td>
                                                <td class=" text-capitalize"><?= $h['h_name'] ?></td>
                                                <td class=""><?= $h['h_location'] ?></td>
                                                <td class=""><?= $h['h_created_at'] ?></td>
                                                <td><?= $h['h_contact'] ?>#<?= $h['h_phone'] ?></td>
                                                <td>
                                                    <span class="btn btn-sm light <?= $h['h_status'] != 'active' ? 'btn-warning' : 'btn-success light' ?> w-space-no fs-16 text-uppercase"><?= $h['h_status'] ?></span>
                                                </td>
                                                <td>
                                                    <div class="dropdown ms-auto text-right">
                                                        <div class="btn-link" data-bs-toggle="dropdown">
                                                            <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                                    <circle fill="#000000" cx="5" cy="12" r="2"></circle>
                                                                    <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                                                    <circle fill="#000000" cx="19" cy="12" r="2"></circle>
                                                                </g>
                                                            </svg>
                                                        </div>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#"><i class="las la-check-square scale5 text-primary me-2"></i> Edit</a>
                                                            <!-- <a class="dropdown-item" href="#"><i class="las la-times-circle scale5 text-danger me-2"></i> Reject Order</a> -->
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php }
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
    <!-- include footer -->
    <?php include_once("./footer.php") ?>