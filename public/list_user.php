<?php
include("./includes/head.php");
include("model/User.php");
// only manager,system
if(!in_array($level,['ADMIN','INST_ADMIN'])){
    session_regenerate_id(true);
    echo "Your session has expired! <span >Redirecting ...</span>";
    echo '<meta http-equiv="refresh" content="1;url=./home">';
    exit();
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
                            <span>List of users</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Users</a></li>
                        </ol>
                    </div>
                </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- <div class="card-header">
                            <h4 class="card-title">Users</h4>
                        </div> -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example"  class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th  class=" fs-13">#</th>
                                            <th  class=" fs-13">Name</th>
                                            <th  class=" fs-13">username</th>
                                            <th  class=" fs-13">Phone</th>
                                            <th  class=" fs-13">Role</th>
                                            <!-- <th  class=" fs-13">Place</th> -->
                                            <th  class=" fs-13">Status</th>
                                            <th class=" fs-13">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody class=" fs-12">
                                        <?php
                                        $ht=$_SESSION['ht_hotel'];
                                        $cond=$_SESSION['ht_level']=='ADMIN'?"ORDER BY status asc,id desc":" WHERE  institition_id='$ht' ORDER by status asc,id desc";
                                        $lists = User::all($cond);
                                        $i=1;
                                        $place=[];
                                        foreach ($lists as $key => $h) {
                                            $hasId=input::enc_dec('e',$h['id']);
                                            ?>
                                            <tr>
                                                <td style="padding:.2rem;"><?= $i ?></td>
                                                <td style="padding:.2rem;" class=" text-capitalize"><?= $h['names'] ?></td>
                                                <td style="padding:.2rem;" class=""><?= $h['username'] ?></td>
                                                <td style="padding:.2rem;" class=""><?= $h['phone'] ?></td>
                                                <td style="padding:.2rem;"><?= $h['level'] ?></td>
                                                <td style="padding:.2rem;">
                                                    <span style="padding:.1rem 2rem; " class="btn btn-xs light <?= $h['status'] != 'active' ? 'btn-warning' : 'btn-success light' ?> w-space-no fs-12 text-uppercase"><?= $h['status'] ?></span>
                                                </td>
                                                <td style="padding:.2rem;">
                                                <a class="dropdown-item" href="edit-user?u=<?=$hasId?>"><i class="las la-check-square scale5 text-primary me-2"></i> Edit</a>
                                                </td>
                                            </tr>
                                        <?php 
                                    $i++;    
                                    }
                                        // empty places;
                                        $place=[];
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