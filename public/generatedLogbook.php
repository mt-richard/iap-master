<?php
include("./includes/head.php");
?>
<script src="https://cdn.tailwindcss.com"></script>

<!-- logbook -->
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
$cIntern = $database->get("*", "a_internaship_periode", "status='activated'");
if (!isset($cIntern->id)) {
    $cIntern = $database->get("*", "a_internaship_periode", "order by id desc");
}
$totalDays = (int)input::getRemainingDateTime($cIntern->start_date, $cIntern->end_date);
if ($rName == "LSNCL") {
    // list of students did not completed de course
    $fdata = [];
    $sups = $database->fetch("SELECT id,first_name,last_name,major_in,card_id FROM a_student_tb where internaship_periode_id={$cIntern->id}");
    // print_r($sups);
    foreach ($sups as $key => $s) {
        $id = $s['card_id'];
        $studentLogBook = $database->count_all(" a_student_logbook where student_id='$id'");
        $pp = $studentLogBook ? $studentLogBook : 1;
        $fdata[] = (object)[
            "name" => $s['first_name'] . ' ' . $s['last_name'],
            "major_in" => $s['major_in'],
            "card_id" => $s['card_id'],
            "attended" => $studentLogBook,
            "per" => $studentLogBook ? round($pp * 100 / $totalDays, 1) : 0
        ];
    }
    usort($fdata, function ($first, $second) {
        return $first->per < $second->per;
    });
}

?>
<?php if ($rName == "SLB" && isset($_GET['student_id'])) {

    $id = (int)$_GET['student_id'];
    $cond = "WHERE st.card_id=al.student_id  AND al.internaship_id='{$cIntern->id}'";
    if ($id != 0) {
        $student = $database->get("*", "a_student_tb", "card_id=$id");
        if (!isset($student->id)) {
            echo "<center><div class='alert alert-danger'>Student with $id as student id not found try again</center></h1>";
            exit(0);
        }
        $cond = "WHERE st.card_id=al.student_id AND al.student_id=$student->card_id AND al.internaship_id='{$cIntern->id}'";
    }
    $sql = "SELECT al.*,st.first_name,st.last_name,st.card_id, st.phone, st.email, st.major_in FROM a_student_logbook as al INNER JOIN a_student_tb as st $cond order by al.log_date asc";
    // echo $sql;
    $lists = $database->fetch($sql);
?>

<style>
@media print {
    /* Set A4 dimensions for printing */
    .container-fluid {
        width: 210mm;
        height: 277mm;
        margin: 0mm;
        page-break-before: always;
        font-size: small;
    }
    /* Ensure the header/footer appears correctly */
    header, footer {
        position: fixed;
        width: 100%;
    }
    /* Page breaks */
    .page-break {
        page-break-before: always;
    }
    /* Hide elements that aren't useful for printing */
    .no-print {
        display: none;
    }
}


</style>

<!-- cover page -->

    <div class="container-fluid col-8 bg-yellow-200 py-5 px-5 h-[1300px]">
        <div class="row card px-5 py-5 bg-yellow-200 border-2 border-gray-600 rounded-lg">
            <div class="col-12 ">
                <div class="h-100 w-full flex justify-center items-center flex-col">
                    <img src="images/rplogo.png" alt="" class="pb-10 w-80">
                    <h3 class="font-black text-5xl text-gray-900">Rwanda Polytechnic</h3>
                    <div class="flex w-full pt-5 gap-1">
                        <div class="w-1/3 h-5 bg-green-600"></div>
                        <div class="w-1/3 h-5 bg-yellow-600"></div>
                        <div class="w-1/3 h-5 bg-blue-500"></div>
                    </div>
                    <div class="flex justify-center flex-col items-center py-5">
                        <h1 class="text-4xl text-gray-800 font-black py-2">IPRC KIGALI</h1>
                        <h1 class="text-3xl text-gray-800">Industrial Attachment Program (IAP)</h1>
                    </div>
                    <div class="flex justify-center flex-col items-center py-1">
                        <h1 class="text-4xl text-gray-800 font-black">STUDENT LOGBOOK</h1>
                        <!-- <h1>Industrial Attachment Program (IAP)</h1> -->
                    </div>
                    <?php
                    $i = 0;
                    foreach ($lists as $key => $h) {
                        $i++;
                    ?>
                        <div class="flex justify-between w-full py-5">
                            <div class="flex flex-col w-1/2">
                                <span class="text-gray-700 font-semibold"></span></span>
                                <h1 class="text-gray-800 text-[20px] font-bold py-3">STUDENT IDENTIFICATION</h1>
                                <span class="ml-4 leading-8 text-gray-700 text-lg capitalize">Names : <span class="text-gray-700 font-semibold"><?= $h['first_name'] . " " . $h['last_name'] ?></span></span>
                                <span class="ml-4 leading-8 text-gray-700 text-lg">Registration No : <span class="text-gray-700 font-semibold"><?= $h['card_id'] ?></span></span>
                                <span class="ml-4 leading-8 text-gray-700 text-lg">Phone : <span class="text-gray-700 font-semibold"><?= $h['phone'] ?></span></span>
                                <span class="ml-4 leading-8 text-gray-700 text-lg">Email : <span class="text-gray-700 font-semibold"><?= $h['email'] ?></span></span>
                                <span class="ml-4 leading-8 text-gray-700 text-lg">Department : <span class="text-gray-700 font-semibold"><?= $h['major_in'] ?></span></span>
                            </div>
                            <div class="flex flex-col w-1/2">
                                <?php
                                $id = $h['partner_id'];
                                $pat = $database->get("*", "a_partner_tb", "id = $id");
                                $person = $database->get("*", "a_users", "institition_id = $id");
                                ?>
                                <h1 class="text-gray-800 text-[20px] font-bold py-3">COMPANY IDENTIFICATION</h1>
                                <span class="ml-4 leading-8 text-gray-700 text-lg">Names of Company : <span class="text-gray-700 font-semibold"><?= $pat->name; ?></span></span>
                                <span class="ml-4 leading-8 text-gray-700 text-lg">Location: <span class="text-gray-700 font-semibold"><?= $pat->place; ?></span></span>
                                <span class="ml-4 leading-8 text-gray-700 text-lg">Contact Person : <span class="text-gray-700 font-semibold"><?= $person->names; ?></span></span>
                                <span class="ml-4 leading-8 text-gray-700 text-lg">Phone : <span class="text-gray-700 font-semibold"><?= $pat->phone; ?></span></span>
                                <span class="ml-4 leading-8 text-gray-700 text-lg">Email : <span class="text-gray-700 font-semibold"><?= $pat->email; ?></span></span>
                                <span class="ml-4 leading-8 text-gray-700 text-lg">Area of Specialisation : <span class="text-gray-700 font-semibold"><?= $pat->major_in; ?></span></span>

                            </div>
                        </div>
                        <div class="flex justify-between w-full">
                            <div class="flex flex-col  w-1/2  ">
                                <h1 class="text-gray-800 text-[20px] font-bold py-3">COLLEGE INDUSTRY LIAISON SPECIALIST</h1>
                                <span class="ml-4 leading-8 text-gray-700 text-lg">Names : Apophia KATUSHABE</span>
                                <span class="ml-4 leading-8 text-gray-700 text-lg">Phone : (+250) 785 703 490</span>
                                <span class="ml-4 leading-8 text-gray-700 text-lg">Email : katupophia2016@gmail.com</span>
                            </div>
                            <div class=" w-1/2"></div>
                        </div>

                </div>
            </div>
        </div>
    </div>

    <!-- page 2 -->

    <div class="container-fluid col-8 bg-gray-50 py-5 px-5 h-[1300px]">
        <div class="row card px-5 py-5 bg-gray-50 border-2 border-gray-600 rounded-lg">
            <div class="col-12 ">
                <div class="h-100 w-full flex justify-center items-center flex-col">
                    <h3 class="font-black text-5xl text-gray-900">Rwanda Polytechnic</h3>
                    <div class="flex w-full pt-5 gap-1">
                        <div class="w-1/3 h-5 bg-green-600"></div>
                        <div class="w-1/3 h-5 bg-yellow-600"></div>
                        <div class="w-1/3 h-5 bg-blue-500"></div>
                    </div>
                    <div class="flex justify-center flex-col items-center py-5">
                        <span class="text-3xl pb-5 text-gray-800">Industrial Attachment Program (IAP)</span>
                        <span class="text-lg text-gray-600">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsam, numquam saepe eius libero voluptates possimus tempora, ad sunt at, a eum hic. Tempore quidem molestiae voluptates rerum sapiente, et pariatur soluta saepe exercitationem consectetur nihil obcaecati delectus quaerat, omnis nesciunt quas magnam libero consequuntur incidunt possimus cumque amet animi unde!</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- page 3 -->

    <div class="container-fluid col-8 bg-gray-50 py-5 px-5 h-[1300px]">
        <div class="row card px-5 py-5 bg-gray-50 border-2 border-gray-600 rounded-lg">
            <div class="col-12 ">
                <div class="h-100 w-full flex justify-center items-center flex-col">
                    <h3 class="font-black text-5xl text-gray-900">Rwanda Polytechnic</h3>
                    <div class="flex w-full pt-5 gap-1">
                        <div class="w-1/3 h-5 bg-green-600"></div>
                        <div class="w-1/3 h-5 bg-yellow-600"></div>
                        <div class="w-1/3 h-5 bg-blue-500"></div>
                    </div>
                    <div class="flex justify-center flex-col items-center py-5">
                        <span class="text-3xl pb-5 text-gray-800">Outcomes</span>
                        <span class="text-lg text-gray-600">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsam, numquam saepe eius libero voluptates possimus tempora, ad sunt at, a eum hic. Tempore quidem molestiae voluptates rerum sapiente, et pariatur soluta saepe exercitationem consectetur nihil obcaecati delectus quaerat, omnis nesciunt quas magnam libero consequuntur incidunt possimus cumque amet animi unde!</span>
                    
                    
                    </div>
                    <div class="text-left">
                    <ul>
                        <Li>1. ............................................</Li>
                        <Li>1. ............................................</Li>
                        <Li>1. ............................................</Li>
                        <Li>1. ............................................</Li>
                        <Li>1. ............................................</Li>
                        <Li>1. ............................................</Li>
                        <Li>1. ............................................</Li>
                        <Li>1. ............................................</Li>
                        <Li>1. ............................................</Li>
                        <Li>1. ............................................</Li>
                        <Li>1. ............................................</Li>
                        <Li>1. ............................................</Li>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- page 4 -->
        <div class=" container-fluid col-8 bg-gray-200 py-5 px-5 ">
            <div class="col-12 border border-1 border border-bottom">
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header border-0 pb-0 d-sm-flex d-block">
                        <div class=" text-center d-flex justify-content-center align-items-center">
                            <h4 class="card-title mb-1"> Student(s) logbook<br />
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
                                        <th class=" fs-13">Names/ID</th>
                                        <th class=" fs-13">Description</th>
                                        <th class=" fs-13">Lesson </th>
                                        <th class=" fs-13">Challenges</th>
                                        <th class=" fs-13">P. Comment</th>
                                        <th class=" fs-13">S. Comment</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody class=" fs-12">

                                    <tr>
                                        <td><?= $i ?></td>
                                        <td class=""><?= $h['created_at'] ?></td>
                                        <td><span class=" pointer"><?= $h['first_name'] . " " . $h['last_name'] ?>/<?= $h['card_id'] ?></span></td>
                                        <td class=" text-capitalize"><?= $h['name'] ?></td>
                                        <td class=""><?= $h['objective'] ?></td>
                                        <td class=""><?= $h['challenges'] ?></td>
                                        <td class=""><?= $h['partner_comment'] ?></td>
                                        <td class="" id="sup<?= $h['id'] ?>"><?= $h['suppervisior_comment'] ?></td>

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
    <?php } ?>
    <!-- include footer -->
    <?php include_once("./footer.php") ?>