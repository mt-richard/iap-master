<?php 
// echo date('D');
 $userId=$_SESSION['ht_userId'];
$student=$database->get("partner_id,suppervisior_id","a_student_tb","card_id=$userId AND internaship_periode_id=$cIntern->id");
$student->partner="-";
$student->supervisior="-";
if(isset($student->partner_id)){
  $p=$database->get("name,email,place,phone","a_partner_tb","id={$student->partner_id}");
  $student->partner=' <p class=" mb-0  ml-20 fs-13 ml-4 ">Name: '.$p->name ."</br>Contact:".$p->email." | ".$p->phone .'</p><p class=" mb-0 fs-13 ml-4  ml-20">Place:'.$p->place.'</p>';
}
// get supper visior
if(isset($student->suppervisior_id)){
  $p=$database->get("names,phone","a_suppervisior_tb","id={$student->suppervisior_id}");
  $student->supervisior=' <p class=" mb-0  ml-20">'.$p->names ." |".$p->phone .'</p>' ;
  
}
?>
<div class="col-lg-12">
  <div class="row">
<!-- onclick="window.location.href='a_internaship'" -->
<div class="col-lg-8 pointer">
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
                </span>
              </h3>
              <p class="mb-0">IAP company</p>
              <div class="card"><?=$student->partner?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 pointer">
      <div class="widget-stat card ">
        <div class="card-body p-4">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg7">
              <i class="flaticon-381-success"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0">
                </span>
              </h3>
              <p class="mb-0 ">My suppervisior </p>
              <?=$student->supervisior?>
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
                  ?>
                </span>
              </h3>
              <p class="mb-0 "><?= input::getRemainingDateTime($today,$cIntern->end_date) .'   days left';?> </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-lg-4 pointer"  onclick="window.location.href='a_log_book'">
      <div class="widget-stat card ">
        <div class="card-body p-4">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg8">
              <i class="flaticon-381-home"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0 fs-13 ">
                  <?php
                  $myReport=$database->count_all("a_student_logbook where  student_id=$userId AND internaship_id={$cIntern->id}");
                  echo $myReport;
                  echo "/";
                  echo input::getRemainingDateTime($cIntern->start_date,$cIntern->end_date);
                  ?>
                </span>
              </h3>
              <p class="mb-0 fs-11">Submitted daily report </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 pointer" onclick="window.location.href='a_student_marks'">
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
                  $myGrade=$database->get("*","a_student_grade","student_id=$userId AND internaship_id=$cIntern->id");
                  if(isset($myGrade->id)){
                    echo $myGrade->marks;
                  }else{
                    echo "...";
                  }
                  ?>
                </span>
              </h3>
              <p class="mb-0">My graded marks </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- <div class="col-lg-4 pointer ">
      <div class="widget-stat card  ">
        <div class="card-body p-4">
          <div class="media ai-icon d-flex">
            <span class="me-3 bgl-primary text-white bg1">
              <i class="flaticon-381-settings-8"></i>
            </span>
            <div class="media-body">
              <h3 class="mb-0 text-black">
                <span class="counter ms-0">
                </span>
              </h3>
              <p class="mb-0">Add Remark </p>
            </div>
          </div>
        </div>
      </div>
    </div> -->

  </div>
</div>