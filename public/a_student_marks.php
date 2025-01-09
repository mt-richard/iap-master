<?php
// require_once("../config/grobals.php");
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
                                    <?php
                                     if(isset($_GET['st'])){
                                        echo input::get("nm").' :'. input::get("c");
                                     }
                                    ?>
                                    <!-- <button class=" btn btn-outline-primary">Create Menu</button> -->
                                </h4>                                   
                                <!-- <small class="mb-0"></small> -->
                            </div>
                            <div class="card-action card-tabs mb-3">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#monthly" role="tab">
                                           Marks
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
                <!-- <div class="card">
                <div class="card-body"> -->
                    <div class="row">
                        <?php
                         $userId=$_SESSION['ht_userId'];
                        if($level=="STUDENT" || isset($_GET['st'])){
                            if(isset($_GET['st'])){
                                $userId=input::enc_dec("d",$_GET['st']);
                            }
                            $myGrade=$database->get("*","a_student_grade","student_id=$userId AND internaship_id=$cIntern->id");
                            if(isset($myGrade->id)){
                            //   echo $myGrade->marks;
                              $grades=explode(",",$myGrade->evaluation_criteria);
                              foreach ($grades as $key => $g) {?>
                              <div class="col-6">
                                <div class=" card">
                                    <div class=" card-body">
                                        <?= $g?>
                                    </div>
                                </div>
                              </div>
                              <?php } ?>
                              <div class="col-6 ">
                                <div class=" card bg1">
                                    <div class=" card-body text-white">
                                       Tot: <?=$myGrade->marks .'/50'?> = <?= ($myGrade->marks*100)/50 .'%'?>
                                       <?php if($level!="PARTNER"): ?>
                                        <div>
                                       Supervisior:<?=$myGrade->s_marks?$myGrade->s_marks .'/20='.($myGrade->s_marks*100)/20 .'%':"-"?>
                                       </div>
                                       <?php endif ?>
                                    </div>
                                </div>
                              </div>
                            <?php 
                            }
                            else{
                              echo "<h1>No Grade found</h1>";
                            }
                        }
                        ?>
                    </div>
                <!-- </div> -->
                </div>
             </div>
            </div>
        </div>
    </div>
    <!-- include footer -->
    <?php include_once("./footer.php") ?>

   