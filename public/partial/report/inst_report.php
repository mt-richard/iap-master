<?php
function redirect()
{
    echo "Unautorized <span >Redirecting ...</span>";
    echo '<meta http-equiv="refresh" content="1;url=./reports">';
    exit(0);
}
if (!input::required(array('rname'))) {
    redirect();
}
$rName = input::get("rname"); // report name;
$from = input::get('from');
$to = input::get('to');
if ($rName == "BR") { 
    $fdata=[];
    $inst=$_SESSION['ht_hotel'];
    $sups = $database->fetch("SELECT id,email,name FROM beneficiary_tb where institition_id = $inst");
    foreach ($sups as $key => $s) {
        $id=$s['id'];
        // get supplied ist
        $purchased=(int)$database->get("sum(purchased) as p","device_requests","ben_id=$id")->p;
        // $purchased=$purchased:$purchased:1
        $pp=$purchased?$purchased:1;
        // count devices got problems while in guarante
        $problems=(int)$database->get("count(*) as b","supplied_devices sd INNER JOIN device_requests dr on sd.device_id=dr.id","dr.ben_id=$id AND sd.status!='functional' ")->b;
        $fdata[]=(object)[
    "name"=>$s['name'],
    "email"=>$s['email'],
    "pur"=>$purchased,
    "pro"=>$problems,
    "per"=>round($problems*100/$pp,2)];
    }
    usort($fdata,function($first,$second){
        return $first->per > $second->per;
    });
    ?>
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0 pb-0 d-sm-flex d-block">
                <div class=" text-center d-flex justify-content-center align-items-center">
                    <h4 class="card-title mb-1 "> The beneficiary rating based on how many devices are not working <br />
                        <hr class=" hr" />
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class=" fs-13">#</th>
                                <th class=" fs-13">Name</th>
                                <th class=" fs-13">Email</th>
                                <th class=" fs-13">Purchased</th>
                                <th class=" fs-13">Problems</th>
                                <th class=" fs-13">%</th>
                            </tr>
                        </thead>
                        <tbody class=" fs-12">
                            <?php
                            $i=1;
                            foreach ($fdata as $key => $h) {
                            ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td class=" text-capitalize"><?= $h->name ?></td>
                                    <td class=""><?= $h->email ?></td>
                                    <td class=""><?= $h->pur?></td>
                                    <td class=""><?= $h->pro?></td>
                                    <td class=""><?= $h->per?>%</td>
                                </tr>
                            <?php
                                $i++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    
<?php } elseif ($rName == "LRQD") {
    $cond="where institition_id={$_SESSION['ht_hotel']}";
    $date="";
    if(input::required(array('from','to'))){
    $f=input::get('from');
    $t=input::get('to');
        $from=date('Y-m-d 00:00:00',strtotime($f));
        $to=date('Y-m-d 23:59:59',strtotime($t));
        $cond=" where institition_id={$_SESSION['ht_hotel']} AND  created_at >='$from' AND created_at <='$to'";
        $date="($f to $t)";
    }
    ?>
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0 pb-0 d-sm-flex d-block">
                <div class=" text-center d-flex justify-content-center align-items-center">
                    <h4 class="card-title mb-1  "> List of requested devices <?=$date?> <br />
                        <hr class=" hr" />
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class=" fs-13">#</th>
                                <th class=" fs-13">Date</th>
                                <th class=" fs-13">Name</th>
                                <th class=" fs-13">R.QTY</th>
                                <th class=" fs-13">S.QTY</th>
                                <th class=" fs-13">Ben</th>
                            </tr>
                        </thead>
                        <tbody class=" fs-12">
                            <?php
     
                            $lists = $database->fetch("SELECT * FROM device_requests $cond ");
                            $i = 1;
                            $instName=[];
                            foreach ($lists as $key => $h) {
                                if(!isset($instName[$h['ben_id']])){
                                    $ii=$h['ben_id'];
                                    $instName[$ii]=$database->get('name',"beneficiary_tb","id=$ii")->name;
                                }
                            ?>
                                <tr>
                                    
                                    <td><?= $i ?></td>
                                    <td class=" "><?= date('Y-m-d',strtotime($h['created_at'])) ?></td>
                                    <td class="text-capitalize">
                                        <?= $h['name'] ?></td>
                                    <td class=""><?= $h['numbers'] ?></td>
                                    <td class=""><?= $h['purchased'] ?></td>
                                    <td class="text-capitalize"><?= $instName[$h['ben_id']]?></td>
                                </tr>
                            <?php
                                $i++;
                            } 
                            $instName=true;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- The list of requested devices -->

    <?php } else if ($rName == "LRPD") { 
            $cond="";
            $date="";
            if(input::required(array('from','to'))){
            $f=input::get('from');
            $t=input::get('to');
                $from=date('Y-m-d',strtotime($f));
                $to=date('Y-m-d',strtotime($t));
                $cond="  AND  status_date >='$from' AND status_date <='$to'";
                $date="($f to $t)";
            }
        ?>
    <!-- // The list of reported devices -->
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0 pb-0 d-sm-flex d-block">
                <div class=" text-center d-flex justify-content-center align-items-center">
                    <h4 class="card-title mb-1  "> List of reported devices <?=$date?> <br />
                        <hr class=" hr" />
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class=" fs-13">#</th>
                                <th class=" fs-13">Date</th>
                                <th class=" fs-13">Name/serial</th>
                                <th class=" fs-13">Ben</th>
                                <th class=" fs-13">Reason</th>
                            </tr>
                        </thead>
                        <tbody class=" fs-12">
                            <?php
                             $id=$_SESSION['ht_hotel'];
                             $cond2=" INNER JOIN device_requests dr on sd.device_id=dr.id AND institition_id=$id AND (sd.c_flow='instToBen' OR sd.c_flow='benToConfirm' OR sd.c_flow='instToAdmin' OR sd.c_flow='benToInst')";
                            $lists = $database->fetch("
                            SELECT  sd.serial_number,sd.request_code,sd.device_id,sd.comment,sd.status_date,dr.ben_id
                            FROM supplied_devices sd $cond2 $cond ");
                            $i = 1;
                            $instName='';
                            $suppName='';
                            $devs=[];
                            $codes=[];
                            foreach ($lists as $key => $h) {
                                if(!isset($codes[$h['request_code']])){
                                    $instName=$database->get('name',"beneficiary_tb","id={$h['ben_id']}")->name;
                                    $codes[$h['request_code']]= $instName;
                                }
                                if(!isset($devs[$h['device_id']])){
                                    $did=$h['device_id'];
                                    $devs[$did]=$database->get('name',"device_requests","id={$h['device_id']}")->name;
                                }
                            ?>
                                <tr>
                                    
                                    <td><?= $i ?></td>
                                    <td class=" "><?= $h['status_date'] ?></td>
                                    <td class="text-uppercase">
                                    <?= $devs[$h['device_id']]?>/<?= $h['serial_number'] ?></td>
                                    <td class="text-capitalize"><?= $instName ?></td>
                                    <td class=""><?=$h['comment']?></td>
                                </tr>
                            <?php
                                $i++;
                            } 
                            $devs=true;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php } else if ($rName == "LDNW") {
   $cond="";
   $date="";
   if(input::required(array('from','to'))){
   $f=input::get('from');
   $t=input::get('to');
       $from=date('Y-m-d 00:00:00',strtotime($f));
       $to=date('Y-m-d 23:59:59',strtotime($t));
       $cond=" AND  updated_at >='$from' AND updated_at <='$to'";
       $date="($f to $t)";
   }
        ?>
    <!-- // The list of reported devices -->
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0 pb-0 d-sm-flex d-block">
                <div class=" text-center d-flex justify-content-center align-items-center">
                    <h4 class="card-title mb-1  "> List of  devices not working<?=$date?> <br />
                        <hr class=" hr" />
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class=" fs-13">#</th>
                                <th class=" fs-13">Date</th>
                                <th class=" fs-13">Name/serial</th>
                                <th class=" fs-13">Ben</th>
                                <th class=" fs-13">Status</th>
                            </tr>
                        </thead>
                        <tbody class=" fs-12">
                            <?php
                             $id=$_SESSION['ht_hotel'];
                             $cond2=" INNER JOIN device_requests dr on sd.device_id=dr.id AND institition_id=$id AND sd.status!='functional'";
                            $lists = $database->fetch("
                            SELECT  sd.serial_number,sd.request_code,sd.device_id,sd.updated_at,sd.status,dr.ben_id
                            FROM supplied_devices sd $cond2 $cond ");
                            $i = 1;
                            $instName='';
                            $suppName='';
                            $devs=[];
                            $codes=[];
                            foreach ($lists as $key => $h) {
                                if(!isset($codes[$h['request_code']])){
                                    $instName=$database->get('name',"beneficiary_tb","id={$h['ben_id']}")->name;
                                    $codes[$h['request_code']]= $instName;
                                }
                                if(!isset($devs[$h['device_id']])){
                                    $did=$h['device_id'];
                                    $devs[$did]=$database->get('name',"device_requests","id={$h['device_id']}")->name;
                                }
                            ?>
                                <tr>
                                    
                                    <td><?= $i ?></td>
                                    <td class=" "><?= date("Y-d-m",strtotime($h['updated_at'])) ?></td>
                                    <td class="text-uppercase">
                                    <?= $devs[$h['device_id']]?>/<?= $h['serial_number'] ?></td>
                                    <td class="text-capitalize"><?= $instName ?></td>
                                    <td class=" text-uppercase"><?=$h['status']?></td>
                                </tr>
                            <?php
                                $i++;
                            } 
                            $devs=true;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php } else {
    redirect();
}
?>