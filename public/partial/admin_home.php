<?php 
?>
<div class="col-lg-12">
  <div class="row">
    <div class="col-lg-4 pointer">
      <div class="widget-stat card ">
        <div class="card-body p-4" onclick="window.location.href='a_student'">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg4">
              <i class="flaticon-381-add"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0">
                  <?php
                 echo $database->count_all("a_student_tb where internaship_periode_id='{$cIntern->id}'");
                  ?>
                </span>
              </h3>
              <p class="mb-0 fs-12"> IAP Students </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 pointer" onclick="window.location.href='a_student_request_admin'">
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
                  // var_dump($cIntern->id);
                   $t= $database->get("SUM(requested_student) as total","a_partner_student_request_totals","internaship_id='{$cIntern->id}'");
                   echo isset($t->total)?$t->total:0
                  ?>
                </span>
              </h3>
              <p class="mb-0 fs-11"> Requested Stuents for IAP </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  
    <div class="col-lg-4 pointer" onclick="window.location.href='a_student?status=no_partner'">
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
                   echo $database->count_all("a_student_tb where internaship_periode_id='{$cIntern->id}' AND partner_id IS NULL");
                  ?>
                </span>
              </h3>
              <p class="mb-0 fs-12">Students haven't partners </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 pointer" onclick="window.location.href='a_student?status=no_suppervisior'">
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
                   echo $database->count_all("a_student_tb where internaship_periode_id='{$cIntern->id}' AND suppervisior_id  IS NULL");
                  ?>
                </span>
              </h3>
              <p class="mb-0 fs-12">Students haven't suppervisior </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="col-lg-4 pointer">
      <div class="widget-stat card ">
        <div class="card-body p-4">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg5">
               <i class="ti-user"></i> -->
              <!-- <i class="flaticon-381-share-2"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0" onclick="window.location.href='a_student?status=no_visit'">
                  <?php
                  echo 0;
                  ?>
                </span>
              </h3>
              <p class="mb-0">UnVisited Students</p>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    
  
    <div class="col-lg-4 pointer" onclick="window.location.href='a_student?status=no_daily'">
      <div class="widget-stat card  ">
        <div class="card-body p-4">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg1">
              <i class="flaticon-381-settings-8"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0">
                  <?php
                  $today=date('Y-m-d');
                  $cond=" WHERE  card_id NOT IN(SELECT student_id FROM a_student_logbook  WHERE  log_date='$today' AND internaship_id=$cIntern->id)   AND internaship_periode_id={$cIntern->id} AND partner_id  IS NOT NULL "; 
                    echo $database->count_all("a_student_tb $cond");  
                  ?>
                </span>
              </h3>
              <p class="mb-0 fs-12">Unreported daily report </p>
            </div>
          </div>
        </div>
      </div>
    </div>
      
    <div class="col-lg-4 pointer" onclick="window.location.href='a_partner'">
      <div class="widget-stat card  ">
        <div class="card-body p-4">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg11">
              <i class="flaticon-381-settings-8"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0">
                  <?php
                  echo $database->count_all("a_partner_tb where is_active='yes'")
                  ?>
                </span>
              </h3>
              <p class="mb-0 fs-12">All Partners </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 pointer" onclick="window.location.href='a_internaship'" >
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
                
                  ?>
                </span>
              </h3>
              <p class="mb-0 "><?=   input::getRemainingDateTime($today,$cIntern->end_date) .'   days left';?> </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 pointer " onclick="window.location.href='a_suppervisior'" >
      <div class="widget-stat card  ">
        <div class="card-body p-4">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg9">
              <i class="flaticon-381-settings-8"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0">
                  <?php
                echo $database->count_all("a_suppervisior_tb where status='active'")
                  ?>
                </span>
              </h3>
              <p class="mb-0 fs-12">Suppervisiors </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    

  </div>
</div>