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
if ($rName == "LUD") {
    $cond = "";
    $date = "";
    if (input::required(array('from', 'to'))) {
        $f = input::get('from');
        $t = input::get('to');
        $from = date('Y-m-d 00:00:00', strtotime($f));
        $to = date('Y-m-d 23:59:59', strtotime($t));
        $cond = " AND  updated_at >='$from' AND updated_at <='$to'";
        $date = "($f to $t)";
    }
?>
    <!-- // The list of reported devices -->
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0 pb-0 d-sm-flex d-block">
                <div class=" text-center d-flex justify-content-center align-items-center">
                    <h4 class="card-title mb-1  "> List of unfunctional devices<?= $date ?> <br />
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
                                <th class=" fs-13">Name/serial number</th>
                                <th class=" fs-13">Status</th>
                            </tr>
                        </thead>
                        <tbody class=" fs-12">
                            <?php
                            $id = $_SESSION['ht_ben'];
                            $cond2 = " INNER JOIN device_requests dr on sd.device_id=dr.id AND ben_id=$id AND sd.status='nonfunctional'";
                            $lists = $database->fetch("
                             SELECT  sd.serial_number,sd.request_code,sd.device_id,sd.updated_at,sd.status,dr.ben_id
                             FROM supplied_devices sd $cond2 $cond ");
                            $i = 1;
                            $instName = '';
                            $suppName = '';
                            $devs = [];
                            $codes = [];
                            foreach ($lists as $key => $h) {
                                if (!isset($devs[$h['device_id']])) {
                                    $did = $h['device_id'];
                                    $devs[$did] = $database->get('name', "device_requests", "id={$h['device_id']}")->name;
                                }
                            ?>
                                <tr>

                                    <td><?= $i ?></td>
                                    <td class=" "><?= date("Y-d-m", strtotime($h['updated_at'])) ?></td>
                                    <td class="text-uppercase">
                                        <?= $devs[$h['device_id']] ?>/<?= $h['serial_number'] ?></td>
                                    <td class=" text-uppercase"><?= $h['status'] ?></td>
                                </tr>
                            <?php
                                $i++;
                            }
                            $devs = true;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    ?>
    <!-- THE BENEFICIARY RATING -->

<?php } elseif ($rName == "LRQD") {
    $cond = "where ben_id={$_SESSION['ht_ben']}";
    $date = "";
    if (input::required(array('from', 'to'))) {
        $f = input::get('from');
        $t = input::get('to');
        $from = date('Y-m-d 00:00:00', strtotime($f));
        $to = date('Y-m-d 23:59:59', strtotime($t));
        $cond = " where ben_id={$_SESSION['ht_ben']} AND  created_at >='$from' AND created_at <='$to'";
        $date = "($f to $t)";
    }
?>
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0 pb-0 d-sm-flex d-block">
                <div class=" text-center d-flex justify-content-center align-items-center">
                    <h4 class="card-title mb-1  "> List of requested devices <?= $date ?> <br />
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
                            </tr>
                        </thead>
                        <tbody class=" fs-12">
                            <?php

                            $lists = $database->fetch("SELECT * FROM device_requests $cond ");
                            $i = 1;
                            foreach ($lists as $key => $h) {
                            ?>
                                <tr>

                                    <td><?= $i ?></td>
                                    <td class=" "><?= date('Y-m-d', strtotime($h['created_at'])) ?></td>
                                    <td class="text-capitalize">
                                        <?= $h['name'] ?></td>
                                    <td class=""><?= $h['numbers'] ?></td>
                                    <td class=""><?= $h['purchased'] ?></td>
                                </tr>
                            <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- The list of requested devices -->

<?php } else if ($rName == "LMD") {
    $cond = "";
    $date = "";
    if (input::required(array('from', 'to'))) {
        $f = input::get('from');
        $t = input::get('to');
        $from = date('Y-m-d 00:00:00', strtotime($f));
        $to = date('Y-m-d 23:59:59', strtotime($t));
        $cond = " AND  updated_at >='$from' AND updated_at <='$to'";
        $date = "($f to $t)";
    }
?>
    <!-- // The list of reported devices -->
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0 pb-0 d-sm-flex d-block">
                <div class=" text-center d-flex justify-content-center align-items-center">
                    <h4 class="card-title mb-1  "> List of maintenance devices<?= $date ?> <br />
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
                                <th class=" fs-13">Status</th>
                            </tr>
                        </thead>
                        <tbody class=" fs-12">
                            <?php
                            $id = $_SESSION['ht_ben'];
                            $cond2 = " INNER JOIN device_requests dr on sd.device_id=dr.id AND ben_id=$id AND sd.status='maintenance'";
                            $lists = $database->fetch("SELECT  sd.serial_number,sd.request_code,sd.device_id,sd.updated_at,sd.status,dr.ben_id FROM supplied_devices sd $cond2 $cond ");
                            $i = 1;
                            $instName = '';
                            $suppName = '';
                            $devs = [];
                            $codes = [];
                            foreach ($lists as $key => $h) {
                                if (!isset($devs[$h['device_id']])) {
                                    $did = $h['device_id'];
                                    $devs[$did] = $database->get('name', "device_requests", "id={$h['device_id']}")->name;
                                }
                            ?>
                                <tr>

                                    <td><?= $i ?></td>
                                    <td class=" "><?= date("Y-d-m", strtotime($h['updated_at'])) ?></td>
                                    <td class="text-uppercase">
                                        <?= $devs[$h['device_id']] ?>/<?= $h['serial_number'] ?></td>
                                    <td class=" text-uppercase"><?= $h['status'] ?></td>
                                </tr>
                            <?php
                                $i++;
                            }
                            $devs = true;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



<?php } else if ($rName == "LRD") {
    $cond = "";
    $date = "";
    if (input::required(array('from', 'to'))) {
        $f = input::get('from');
        $t = input::get('to');
        $from = date('Y-m-d 00:00:00', strtotime($f));
        $to = date('Y-m-d 23:59:59', strtotime($t));
        $cond = " AND  updated_at >='$from' AND updated_at <='$to'";
        $date = "($f to $t)";
    }
?>
    <!-- // The list of reported devices -->
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0 pb-0 d-sm-flex d-block">
                <div class=" text-center d-flex justify-content-center align-items-center">
                    <h4 class="card-title mb-1  "> List of replaced devices<?= $date ?> <br />
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
                                <th class=" fs-13">Name/serial number</th>
                                <th class=" fs-13">Replaced serial number</th>
                            </tr>
                        </thead>
                        <tbody class=" fs-12">
                            <?php
                            $id = $_SESSION['ht_ben'];
                            $cond2 = " INNER JOIN device_requests dr on sd.device_id=dr.id AND ben_id=$id AND sd.has_replaced='yes'";
                            $lists = $database->fetch("
                            SELECT  sd.serial_number,sd.request_code,sd.device_id,sd.updated_at,sd.comment
                            FROM supplied_devices sd $cond2 $cond ");
                            $i = 1;
                            $suppName = '';
                            $devs = [];
                            $codes = [];
                            foreach ($lists as $key => $h) {
                                if (!isset($devs[$h['device_id']])) {
                                    $did = $h['device_id'];
                                    $devs[$did] = $database->get('name', "device_requests", "id={$h['device_id']}")->name;
                                }
                                $oldSerial = explode(":", $h['comment']);
                                $old = '-';
                                if (isset($oldSerial[1])) {
                                    $old = $oldSerial[1];
                                }
                            ?>
                                <tr>

                                    <td><?= $i ?></td>
                                    <td class=" "><?= date("Y-d-m", strtotime($h['updated_at'])) ?></td>
                                    <td class="text-uppercase">
                                        <?= $devs[$h['device_id']] ?>/<?= $h['serial_number'] ?></td>
                                    <td class="text-capitalize"><?= $old ?></td>
                                </tr>
                            <?php
                                $i++;
                            }
                            $devs = true;
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