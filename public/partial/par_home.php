<?php
    $currentIntern=(object)$cIntern;
    $studentNumbers=0;
    $given=0;
    $requested=0;
    $userID=$_SESSION['ht_hotel'];
    if(isset($currentIntern->id)){
    $studentNumbers=$database->count_all("a_student_tb where partner_id=$userID");
    $req=$database->get("(given_student) as given,(requested_student) as requested","a_partner_student_request_totals","internaship_id=$currentIntern->id AND partner_id=$userID");
    $requested=isset($req->requested)?$req->requested:0;
    $given=isset($req->given)?$req->given:0;
    }
    $par=$database->get("name,is_active","a_partner_tb","id=$userID");
    // echo($userID);
    session::put("is_active",'no');
   if($par->is_active=='yes'){
    session::put("is_active",'yes');
    ?>
<div class="col-lg-12">
  <div class="row">
  <div class="col-lg-4 pointer">
      <div class="widget-stat card ">
        <div class="card-body p-4" onclick="window.location.href='a_student_request'">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg9">
              <i class="flaticon-381-add"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0">
                  <?php
                  echo $requested;
                  ?>
                </span>
              </h3>
              <p class="mb-0">Requested students </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 pointer">
      <div class="widget-stat card ">
        <div class="card-body p-4" onclick="window.location.href='a_partner_student?pinter=<?=$currentIntern->id?>'">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg4">
              <i class="flaticon-381-user-3"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0">
                  <?php
                  echo $given;
                  ?>
                </span>
              </h3>
              <p class="mb-0 ">Given students </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 pointer" onclick="window.location.href='p_log_book?today'">
      <div class="widget-stat card">
        <div class="card-body p-4">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg8">
              <i class="flaticon-381-home"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0 ">
                 <?php
                 $today=date('Y-m-d');
                 echo $database->count_all("a_student_logbook where partner_id=$userID AND log_date='$today'");
                 ?>
              </span>
              </h3>
              <p class="mb-0 fs-12 ">Submitted daily report</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 pointer"  >
      <div class="widget-stat card  ">
        <div class="card-body p-4">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg10">
              <i class="flaticon-381-settings-8"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0 fs-12">
                  <?php
                  $today=date('Y-m-d');
                  echo input::getRemainingDateTime($today,$currentIntern->end_date);
                  ?>
                </span>
              </h3>
              <p class="mb-0 ">
                <?=  '  Internaship days left';?> </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 pointer " onclick="window.location.href='a_partner_student?graded'">
      <div class="widget-stat card  ">
        <div class="card-body p-4">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg12">
              <i class="flaticon-381-notebook-4"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0">
                  <?php
                $graded=$database->count_all("a_student_grade ast  WHERE ast.internaship_id={$cIntern->id} AND ast.partner_id=$userID");
                echo $graded;
                  ?>
                </span>
              </h3>
              <p class="mb-0 fs-12">Graded students </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 pointer" onclick="window.location.href='a_partner_student?ungraded'">
      <div class="widget-stat card ">
        <div class="card-body p-4">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg5">
              <!-- <i class="ti-user"></i> -->
              <i class="flaticon-381-share-2"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0">
                  <?php
                   echo $given-$graded;
                  ?>
                </span>
              </h3>
              <p class="mb-0">Ungraded students</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 pointer">
      <div class="widget-stat card ">
        <div class="card-body p-4" onclick="window.location.href='a_partner_student'">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg11">
              <i class="flaticon-381-send-2"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0">
                  <?php
                  echo $database->count_all("a_student_tb where partner_id=$userID");
                  ?>
                </span>
              </h3>
              <p class="mb-0 =">All Served students </p>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<?php } else{ ?>
            <div class="card-body">
                <div class="col-12 text-center">
                <button class=" btn btn-lg btn-outline-warning">
                    Your Account is not Approved 
                </button>
                </div>
               
            </div>
       <?php }  ?>