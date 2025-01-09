<?php
    $currentIntern=(object)$cIntern;
    $studentNumbers=0;
    $given=0;
    $requested=0;
    $today=date('Y-m-d');
    $userID=$_SESSION['ht_hotel'];
    if(isset($currentIntern->id)){
    $studentNumbers=$database->count_all("a_student_tb where suppervisior_id=$userID AND internaship_periode_id={$currentIntern->id}");
    }
   
    ?>

<div class="col-lg-12">
  <div class="row">
  <div class="col-lg-4 pointer">
      <div class="widget-stat card ">
        <div class="card-body p-4" onclick="window.location.href='a_partner_student?sinter=<?=$currentIntern->id?>'">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg12">
              <i class="flaticon-381-add"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0">
                  <?php
                  echo $studentNumbers;
                  ?>
                </span>
              </h3>
              <p class="mb-0 ">Given students </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 pointer">
      <div class="widget-stat card ">
        <div class="card-body p-4" >
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg4">
              <i class="flaticon-381-off"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0">
                  <?php
                  echo input::getRemainingDateTime($today,$currentIntern->end_date)
                  ?>
                </span>
              </h3>
              <p class="mb-0 ">
              <?= '  Internaship days left';?>    
            </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 pointer" onclick="window.location.href='s_log_book?today'">
      <div class="widget-stat card ">
        <div class="card-body p-4">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg8">
              <i class="flaticon-381-home"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0">
                <?php
                  $submited= $database->count_all("a_student_logbook where suppervisor_id=$userID AND log_date='$today'");
                  echo $submited;
                 ?>
                </span>
              </h3>
              <p class="mb-0 ">Submitted daily report </p>
            </div>
          </div>
        </div>
      </div>
    </div>
   
    <div class="col-lg-4 pointer" onclick="window.location.href='a_partner_student?unsubmitted'">
      <div class="widget-stat card ">
        <div class="card-body p-4">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg5">
              <i class="flaticon-381-home"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0"><?= $studentNumbers-$submited ?></span>
              </h3>
              <p class="mb-0 ">Unsubmitted daily report </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 pointer" onclick="window.location.href='a_partner_student?graded'">
      <div class="widget-stat card ">
        <div class="card-body p-4">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg2">
              <i class="flaticon-381-bookmark"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0">
                  <?php
                 $graded=$database->count_all("a_student_grade ast  WHERE ast.internaship_id={$cIntern->id} AND ast.supervisior_id=$userID");
                 echo $graded;
                  ?>
                </span>
              </h3>
              <p class="mb-0 fs-12">Graded Students by partner</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 pointer" onclick="window.location.href='a_partner_student?ungraded'">
      <div class="widget-stat card ">
        <div class="card-body p-4">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg7">
              <i class="flaticon-381-success"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0">
                  <?php
                  echo $studentNumbers-$graded;
                
                  ?>
                </span>
              </h3>
              <p class="mb-0 fs-12 " style="">UnGraded students by partner </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6 pointer" onclick="window.location.href='a_partner_student?graded_by_sup'">
      <div class="widget-stat card ">
        <div class="card-body p-4">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg2">
              <i class="flaticon-381-bookmark"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0">
                  <?php
                 $gradedByMe=$database->count_all("a_student_grade ast  WHERE ast.internaship_id={$cIntern->id} AND ast.supervisior_id=$userID AND s_marks IS NOT NULL");
                 echo $gradedByMe;
                  ?>
                </span>
              </h3>
              <p class="mb-0">Graded Students by supervisior </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6 pointer" onclick="window.location.href='a_partner_student?ungraded_by_sup'">
      <div class="widget-stat card ">
        <div class="card-body p-4">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg7">
              <i class="flaticon-381-success"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0">
                  <?php
                  echo $studentNumbers-$gradedByMe;
                
                  ?>
                </span>
              </h3>
              <p class="mb-0 ">UnGraded students by supervisior </p>
            </div>
          </div>
        </div>
      </div>
    </div>

  
</div>
</div>