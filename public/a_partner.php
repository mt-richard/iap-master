<?php
// require_once("../config/grobals.php");
include("./includes/head.php");
if (isset($_GET['n'])) {
    $id = $_GET['n'];
    $idDec=input::enc_dec("d",$id);
    $database->query("DELETE FROM notifications_tb where id=$idDec");
}
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
                                    <!-- <button class=" btn btn-outline-primary">Create Menu</button> -->
                                    <button class=" btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#basicModal">Add New</button>
                                </h4>                                   
                                <!-- <small class="mb-0"></small> -->
                            </div>
                            <div class="card-action card-tabs mb-3">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#monthly" role="tab">
                                            All Partners
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
                <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                                <table id="example"  class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                        <th class=" fs-13">#</th>
                                            <th class=" fs-13">Names</th>
                                            <th class=" fs-13">Email</th>
                                            <th class=" fs-13">Place</th>
                                            <th class=" fs-13">Phone</th>
                                            <!-- <th class=" fs-13">TIN Number</th> -->
                                            <th class=" fs-13">Join Date</th>
                                            <th class="fs-13">Approved</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class=" fs-12">
                                        <?php
                                        $i=0;
                                        $cond="";
                                        if(isset($_GET['d'])){
                                            $cond="where id={$_GET['d']}";
                                        }
                                    $lists=$database->fetch("SELECT * FROM a_partner_tb $cond  order by id desc");
                                   
                                        foreach ($lists as $key => $h) {
                                            $i++;
                                            ?>
                                            <tr>
                                            <td style="padding:.6rem"><?= $i?></td>
                                                <td style="padding:.6rem" class=" text-capitalize"><?= $h['name'] ?></td>
                                                <td style="padding:.6rem" class=""><?= $h['email'] ?></td>
                                                <td style="padding:.6rem" class=""><?= $h['place'] ?></td>
                                                <td style="padding:.6rem" class=""><?= $h['phone'] ?></td>
                                                <!-- <td style="padding:.6rem" class=""><?= $h['tin'] ?></td> -->
                                                <td style="padding:.6rem" class=""><?= date('Y-m-d',strtotime($h['created_at'])) ?></td>
                                                <td style="padding:.6rem">
                                                    <select style="padding: .6rem 1.5rem;"  class="approveSupplier  is_<?=$h['is_active']?>" data-sup="<?= $h['id']?>">
                                                       <option value="yes" <?php if($h['is_active']=="yes")echo "selected" ?>> Yes </option>
                                                       <option value="no" <?php if($h['is_active']=="no")echo "selected" ?>> No </option>
                                                </select>
                                                </td>
                                                
                                                <td style="padding:.6rem">
                                                    <div class="dropdown ms-auto text-right">
                                                        <div class="btn-link" data-bs-toggle="dropdown">
                                                            <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                                    <circle fill="#000000" cx="5" cy="12" r="2"></circle>
                                                                    <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                                                    <circle fill="#000000" cx="19" cy="12" r="2"></circle>
                                                                </g>
                                                            </svg>
                                                        </div>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#"><i class="las la-check-square scale5 text-primary me-2"></i> Edit</a>
                                                            <!-- <a class="dropdown-item" href="#"><i class="las la-times-circle scale5 text-danger me-2"></i> Reject Order</a> -->
                                                        </div>
                                                    </div>
                                                </td>
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
        </div>
    </div>
        <!-- modal -->
        <div class="modal fade bd-example-modal-lg" id="basicModal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Partner</h5>
                    <span class="  close"> <span class=" fa fa-times " data-bs-dismiss="modal"></span></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form">
                    <div class="row">
                       
                    
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Name <span class="required text-danger">*</span></label>
                                <input type="text"  name="name" placeholder="Eg:UR" class=" form-control text-uppercase"/>
                                <input type="hidden" name="action" value="ADD_PARTNER"/>
                            </div>
                        </div> 
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Email<span class="required text-danger">*</span></label>
                                <input type="email"  name="email" placeholder="Eg:UR@company.net" class=" form-control "/>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Place <span class="required text-danger">*</span></label>
                                <input  type="text" name="place" placeholder="Eg:KIGALI" class=" form-control"/>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Contact Phone <span class="required text-danger">*</span></label>
                                <input  type="number" name="phone"  onkeypress="limitKeypress(event,this.value,10)" placeholder="Eg:0789000000" class=" form-control"/>
                            </div>
                        </div> 
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">TIN Number<span class="required text-danger">*</span></label>
                                <input  type="number" name="tin"   placeholder="Eg:12800000" class=" form-control onkeypress="limitKeypress(event,this.value,9)/>
                            </div>
                        </div> 
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Username <span class="required text-danger">*</span></label>
                                <input  type="text" name="username" placeholder="Eg:john" class=" form-control"/>
                            </div>
                        </div> 
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Password<span class="required text-danger">*</span></label>
                                <input  type="text" name="password"   placeholder="Eg:*****" class=" form-control"/>
                            </div>
                        </div> 
                        <div class="col-lg-12">
                        <div class="mb-3">
                                                        <label class="text-black form-label" for="menu_type" class="text-black form-label">Major Field <span class="required text-danger">*</span></label>
                                                        <select type="text" class="form-control" name="major_in" >
                                                            <option value="" disabled selected>__select__</option>
                                                            <option value="Information and Communication technology">Information and Communication technology</option>
                                                            <option value="Transport and Logistics Department">Transport and Logistics Department</option>
                                                            <option value="Mechanical Engineering">Mechanical Engineering</option>
                                                            <option value="Mining Engineering">Mining Engineering</option>
                                                            <option value="Civil Engineering">Civil Engineering</option>
                                                            <option value="Creative Arts Department">Creative Arts Department</option>
                                                            <option value="Electrical and Electronics Engineering">Electrical and Electronics Engineering</option>
                                                        </select>
                                                    
                                                    </div>
                                                </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Company Profile <span class="required text-danger">*</span></label>
                                <textarea type="text"  name="profile" placeholder="Eg:Bio" class=" form-control "></textarea>
                                
                            </div>
                        </div>
                        <div class="col-12">
                            <div id="ajaxresults"></div>
                        </div>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick=" return onSupervisorAdd()">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end of modal -->
    <!-- include footer -->
    <?php include_once("./footer.php") ?>

    <script>
          $(".approveSupplier").change(function(){
    let v=$(this).val();
    if(confirm("are you sure to change status?")){
      let sup=$(this).attr("data-sup");
      window.location.href=`sup_profile?c=${sup}&v=${v}`;  
    }
    // console.log("supp is now approved")
   })
        function onSupervisorAdd(){

        let formData=$("#form").serialize();
        console.log(formData);
        fetch(`ajax_pages/partner?${formData}`).then((res)=>res.text()).then((data)=>{
           
            try {
                let json=JSON.parse(data);
                if (json.isOk) {
                    alert("Data was Saved");
                    window.location.reload();
                } else {
                    alert(json.data);
                }       
                
            } catch (error) {
                alert(data);
            }
        });
        return

        }

    </script>