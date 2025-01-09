<?php
// require_once("../config/grobals.php");
include("./includes/head.php");
?>
<style>
.border-red{
    border: 1px solid red;
}
</style>
<div id="main-wrapper">
    <?php include("./includes/sidebar.php") ?>
    <!-- header here -->
    <?php include("./header.php") ?>
    <?php
    $currentIntern=$database->get("*","a_internaship_periode","status='activated' ");
    $studentNumbers=0;
    if(isset($currentIntern->id)){
    $studentNumbers=$database->count_all("a_student_tb where internaship_periode_id={$currentIntern->id}");
    $studentNumbers-=$currentIntern->taken_student;
    }
    if($studentNumbers==0){
        redirect::back();
        exit(0);
    }
   
    ?>
    <!-- chatbox here -->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0 d-sm-flex flex-wrap d-block">
                            <div class="mb-3">
                                <p class="mb-1">
                                    <span>You can request student to partcipate IAP in your companys</span>
                              <!-- <span>Current IAP students <span class="badge badge-info badge-sm">
                                <?php
                                // $studentNumbers
                                ?>
                            </span></span> -->
                                  
                                </p>                                   
                                <!-- <small class="mb-0"></small> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
             <div class="col-12">
                <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                                <table id="example"  class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                        <th class=" fs-13">#</th>
                                            <th class=" fs-13">Major </th>
                                            <th class=" fs-13">Available</th>
                                            <th class=" fs-13">Requested</th>
                                        </tr>
                                    </thead>
                                    <tbody class=" fs-12">
                                        <?php
                                        
                                        $i=0;
                                        $userID=$_SESSION['ht_userId'];
                                        $partnerID=$_SESSION['ht_hotel'];
                                        
                                        $partnermajor = $database->fetch("SELECT * FROM a_partner_tb where id = $partnerID");
                                        foreach ($partnermajor as $key => $pm) {
                                            $selectedmajor = $pm['major_in'];
                                        }
                                        // echo "<script>console.log($partnerID)</script>";
                                        $major=$database->fetch("SELECT COUNT(*) as total,major_in FROM a_student_tb WHERE (internaship_periode_id={$currentIntern->id} AND partner_id IS NULL AND major_in = '$selectedmajor') GROUP by major_in ");
                                        foreach ($major as $key => $m) {
                                            $i++;
                                            $noSpace=input::removeSpaceWith($m['major_in'],"_");
                                            $requested=$database->get("request_student_number as nb","a_partner_student_request","internaship_id={$currentIntern->id} AND partner_id={$userID} AND major_in='{$m['major_in']}' ");
                                            $req=0;
                                            if(isset($requested->nb)) $req=$requested->nb;
                                            ?>
                                            <tr> 
                                            <td class="p-0"><?= $i?></td>
                                    <td class="p-0" class=" text-capitalize"><?=$m['major_in']?></td>
                                    <td class="p-0"><?=$m['total']?></td>
                                    <td class="p-0">
                                    <input class="form-control" type="number" <?=$req>0?"readonly":""?>
                                     name="<?=$noSpace?>" id="input<?=$i?>" data-count="<?=$m['total']?>"
                                      data-name="<?=$m['major_in']?>" 
                                      data-old="<?=$req?>"
                                      value="<?=$req?>"></td>
                                    </tr>
                                    <?php 
                                    }
                                    ?>
                                    <!-- <tr><td colspan="3" class=" text-center">
                                        </td></tr> -->
                                    </tbody>
                                </table>
                                <button  style=" margin-left: 40%;position: absolute;margin-top: -5%;" class="btn btn-outline-primary mb-3" onclick="onPartnerSendRequest(<?=$i?>)">Send Request Now</button>
                            </div>
                   
                 </div>
                </div>
             </div>
            </div>
        </div>
    </div>
    <!-- include footer -->
    <?php include_once("./footer.php") ?>
    <script>
        var inter="<?=$currentIntern->id?>";
        function onPartnerSendRequest(round=0){
            $("#btnRequest").addClass("d-none");
            let urlname="";
            let urlvalue="";
            let isCorrect=true;
            let hasData=false;
            for (let index = 1; index <=round; index++) {
                let taken=$(`#input${index}`).val();
                let Available= $(`#input${index}`).data("count");
                let oldInput=Number($(`#input${index}`).data("old"));
                let name=$(`#input${index}`).data("name");
                if(taken>Available && taken>0){
                    $(`#input${index}`).addClass("border-red");
                    isCorrect=false;
                }else if(taken>0){
                urlname+=`${name},`;
                urlvalue+=`${taken},`;
                hasData=true;
                }else{
                    $(`#input${index}`).removeClass("border-red");   
                }
            }
            if(!isCorrect){
                $("#btnRequest").removeClass("d-none");
                alert("Please check your input");
                return;
            }
            if(!hasData){
                $("#btnRequest").removeClass("d-none");
                alert("couldn't empty");
                return;
            }
            fetch(`ajax_pages/internaship?action=PARTNER_REQUEST_STUDENT&major=${urlname}&major_value=${urlvalue}&inter=${inter}`)
            .then((res)=>res.text()).then((res)=>{
                $("#btnRequest").removeClass("d-none");
                try {
                    let json=JSON.parse(res);
                if(json.status=="ok"){
                    // notify admin
                    let requestedStudent=json.students;
                    let msg=`${json.from} requests ${requestedStudent} students for internaship`
                    makePostRequest(`url=a_student_request_admin?p=${json.myId}&level=ADMIN&level_id=1&action=NOTIFY&message=${msg}`).then((res)=>{
                        console.log(res);
                    })
                    window.location.href="a_student_request";return;
                    }
                    alert(json.status);
                } catch (error) {
                    alert(JSON.stringify(res));
                }
               

            });
        }
        $(document).ready(()=>{

        })
    </script>