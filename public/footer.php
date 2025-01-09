<div class="footer <?=$page=="generatedReport"?'noPrint':''?>" >
  <div class="copyright">
    <p>
      Copyright © Designed &amp; Developed by Nicolle &amp; Richard
      <a href="#" target="_blank">. </a> <?php date('Y') ?>
    </p>
  </div>
</div>

</div>
<!-- customer function -->
<script type="text/javascript">
  const observer = lozad(); // lazy loads elements with default selector as '.lozad'
  observer.observe();
</script>
<script>
  function  makePostRequest(bodyQuery, url = "ajax_pages/requests.php") {
      return new Promise((resolve) => {
        fetch(url, {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: bodyQuery,
        })
          .then((res) => res.text())
          .then((res) => {
            resolve(res);
          });
      });
    }
  var tout=null;
  function checkNotification(){
    clearTimeout(tout);
    // NProgress.start();
    tout=setTimeout(() => {
      fetch(`ajax_pages/requests?action=CHECK_NOTIFICATION`).then((res)=>res.text()).then((res)=>{
      // $("#search-results").html(res);
      if(res!="none"){
       $("#notification_dropdown a").addClass("show");
       $("#dropdown-menu-right").addClass("show").attr("data-bs-popper","none");
        $("#notifyList").html(res);
      }
      // NProgress.done(true);
    });
      checkNotification();
    },2000);
  }
  checkNotification();
  function clearInputs(...inputs) {
  inputs.forEach((el) => {
    let i = $("#"+el);
    $("#"+el).val('');
  });
}
let timeout=null;
function searchBy(e){
  clearTimeout(timeout);
  NProgress.start();
  timeout=setTimeout(() => {
    let val=$(e).val();
    fetch(`ajax_pages/requests?action=MAIN_SEARCH&q=${val}`).then((res)=>res.text()).then((res)=>{
      $("#search-results").html(res);
      NProgress.done(true);
    });
  }, 500);
}
</script>
<!-- end -->
<!-- Required vendors -->
<script src="vendor/global/global.min.js"></script>
  <!-- <script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script> -->
  <script src="vendor/chart.js/Chart.bundle.min.js"></script>
  <script src="js/custom.min.js"></script>
  <script src="js/deznav-init.js"></script>

  <!-- Counter Up -->
  <script src="vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="vendor/jquery.counterup/jquery.counterup.min.js"></script>

  <!-- Apex Chart -->
  <script src="vendor/apexchart/apexchart.js"></script>

<script>
  let hasNotification="<?= $hasNotification?>";
  $(document).ready(()=>{
    if(Number(hasNotification)>0){
    $("#notification_dropdown a").addClass("show");
    $("#dropdown-menu-right").addClass("show").attr("data-bs-popper","none");
    }
  })
</script>
<!-- Counter Up -->
<script src="js/customer/functions.js"></script>
<!-- cim -->
<?php
if(in_array($page, ['tenders'])) : 
?>
<script>
  function approveApplicant(code,ta,sup){
    if(confirm("are you sure to confirm this applicant?")){
      // let btn=$("#approveApplicant");
      // $(btn).addClass("d-none");
      sendWithAjax(`sup=${sup}&ta=${ta}&action=CONFIRM_TENDER_APPLICATION&code=${code}`,"ajax_pages/requests")
      .then((res)=>{
        if(res.isOk){
          // window.location.reload(true);
          window.location.href=`requested?c=${code}`;
        }else{
          alert(res.data);
        }
      }).catch((err)=>{
        alert(JSON.stringify(err));
      });
    } 
  }
  $(document).ready(()=>{
    $("#approveApplicant").click(function(){
      if(confirm("are you sure to confirm this applicant?")){
      let btn=$("#approveApplicant");
      let code=$(btn).attr("data-code");
      let ta=$(btn).attr("data-ta");
      let sup=$(btn).attr("sup");
      $(btn).addClass("d-none");
      sendWithAjax(`sup=${sup}&ta=${ta}&action=CONFIRM_TENDER_APPLICATION&code=${code}`,"ajax_pages/requests")
      .then((res)=>{
        if(res.isOk){
          // window.location.reload(true);
          window.location.href=`requested?c=${code}`;
        }else{
          alert(res.data);
        }
      }).catch((err)=>{
        alert(JSON.stringify(err));
      });
    } 
    })
  })
</script>
<?php endif; ?>
<?php 
  if(in_array($page,['sup_profile'])):
  ?>
    <script src="js/customer/summernote-bs4.min.js"></script>
    <script>
function approveSupplier(sup_id,status="yes"){
  // $("#btnUpdate").addClass("d-none");
  $("#btnApprove").addClass("d-none");
  NProgress.start();
  sendWithAjax(`st=${status}&sup=${sup_id}&action=APPROVE_SUPPLIER_REQUEST`,'ajax_pages/supplier').then((res)=>{
    NProgress.done(true);
    if(res.isOk){
      $("#btnApprove").remove();
      alert("The partner is now approved");
    }else{
      $("#btnApprove").removeClass("d-none");
     alert(res.data);
    }
  }).catch((err)=>{
    alert("unable to approve the partner");
  })
}
function updateSupplierProfile(sup_id){
  $("#btnUpdate").addClass("d-none");
  let profile=$("#myprofile").serialize();
  NProgress.start();
  sendWithAjax(`${profile}&sup=${sup_id}&action=UPDATE_SUPPLIER_PROFILE`,'ajax_pages/supplier').then((res)=>{
    NProgress.done(true);
    $("#btnUpdate").removeClass("d-none");
    if(res.isOk){
      alert("The profile has been changed");
    }else{
     alert(res.data);
    }
  }).catch((err)=>{
    alert("unable to update the profile");
  })
}
      $(document).ready(function() {
        $('#summernote').summernote({
        placeholder: 'Write where company profile what company did',
        // tabsize: 2,
        height:350,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
});
    </script>
  <?php endif; ?>
<?php
if(in_array($page, ['generatedReport'])) : 
?>
<script>
  setTimeout(() => {
    window.print();
  }, 500);
</script>
<?php endif; ?>
<?php
if(in_array($page, ['status'])) : 
?>
<script>
  function replaceDevice(){
    $(".no").addClass('d-none');
    $(".nn").removeClass('d-none');
    $("#basicModal").modal("show");
  }
function sendToAdmin(e,action="REPORTING_TO_ADMIN"){
  let req=`action=${action}&id=${$("#id").val()}&name=${$("#name").val()}&serial=${$("#serial").val()}`;
  if(action!="REPORTING_TO_ADMIN"){
    req=$("#form").serialize()+`&action=${action}`;
  }
  if(confirm("Are you sure you want to proceed?")){   
  NProgress.start();
      $(e).addClass("d-none");
      $(".ajaxresults").html(`<div class="alert alert-danger"><p>Please wait ...</p></div>`);
    sendWithAjax(`${req}`, "ajax_pages/benificiary").then((res) => {
      $(e).removeClass('d-none');
        NProgress.done(true);
    if(res.isOk){
      $(".ajaxresults").html(`<div class="alert alert-success"><p>Operation has been completed</p></div>`);
      let id=res.data;
      window.location.reload();
      // $("#btn_"+id).remove();
      // $("#btn2_"+id).remove();
    }else{
      $(".ajaxresults").html(`<div class="alert alert-danger"><p>${res.data}</p></div>`);
    }
  });
}
}
function onDeviceReport(id,action,currentStatus,serial){
  if(action=="NS"){
    $("#NS").removeClass("d-none");
  }else{
    $("#NS").addClass("d-none");
  }
$("#btnClicked").val(action);
$("#currentS").val(currentStatus);
$("#dId").val(id);
$("#serial").val(serial);
$("#info").text(`#${serial}`)
$("#basicModal").modal("show");
}
</script>
<?php endif; ?>
<?php
if(in_array($page, ['device'])) : 
?>
<script>
function onDeviceStatusSave(e){
  let req=$("#form").serialize();
      NProgress.start();
      $(e).addClass("d-none");
      $("#ajaxresults").html(`<div class="alert alert-danger"><p>Please wait ...</p></div>`);
    sendWithAjax(`${req}`, "ajax_pages/benificiary").then((res) => {
      $(e).removeClass('d-none');
        NProgress.done(true);
        $("#ajaxresults").html("");
    if(res.isOk){
      $("#basicModal").modal("hide");
      let id=res.data;
      $("#td_"+id).remove();
    }else{
      $("#ajaxresults").html(`<div class="alert alert-danger"><p>${res.data}</p></div>`);
    }
  });
}
function onDeviceReport(id,action,currentStatus,serial){
  if(action=="NS"){
    $("#NS").removeClass("d-none");
  }else{
    $("#NS").addClass("d-none");
  }
$("#btnClicked").val(action);
$("#currentS").val(currentStatus);
$("#dId").val(id);
$("#serial").val(serial);
$("#info").text(`#${serial}`)
$("#basicModal").modal("show");
}
</script>
<?php endif; ?>
<?php
if(in_array($page, ['requested'])) : 
?>
<script>
  function rejectBenRequest(code){
    console.log(code);
  }
  function onDeviceRegistration(e){
    let req=$("#form").serialize();
      NProgress.start();
      $(e).addClass("d-none");
      $("#ajaxresults").html(`<div class="alert alert-danger"><p>Please wait ...</p></div>`);
    sendWithAjax(`${req}`, "ajax_pages/requests").then((res) => {
      $(e).removeClass('d-none');
        NProgress.done(true);
        $("#ajaxresults").html("");
    if(res.isOk){
      $("#basicModal").modal("hide");
      let id=res.data.dId;
      $("#dNumbers").val(res.data.dNumber);
      if(res.data.dNumber===res.data.dNumbers){
        $("#btn_"+id).remove();
      }
      $("#p_"+id).html(`${res.data.dNumber}/`);
    }else{
      $("#ajaxresults").html(`<div class="alert alert-danger"><p>${res.data}</p></div>`);
    }
  });
  }
function onDeviceRegister(dName,dCount,dId,rcode,dPurchase){
  $("#dId").val(dId);
  $("#dName").val(dName);
  $("#dNumbers").val(dCount);
  $("#dNumber").val(dCount);
  $("#dPurchase").val(dPurchase);
  $("#scode").val(rcode)
  $("#action").val("REGISTER_SUPPLIER_DIVICE");
  $("#dvAssign").addClass("d-none");
  $("#dvRegister").removeClass("d-none");
  $("#dvConfirm").removeClass("d-none");
  $("#dvRegistration").addClass("d-none");
  $(".modalTitle").html("Register  <span class='text-black-50 text-uppercase'> "+ dName +'(s) <span>');
  $("#dvDevices").html("");
  $("#basicModal").modal("show");
}
function removeSerialInput(e){
  let re=Number($("#dNumber").val())-1;
  $("#dNumber").val(re);
  $(e).parent().parent().parent().remove();
}
function onDeviceAvailable(){
  $("#ajaxresults").html("");
  $("#dvDevices").html("");
  let nums=Number($("#dNumbers").val());
  let name=$("#dName").val();
  let re=Number($("#dNumber").val());
  if(nums<re || re<0){
    $("#dvRegistration").addClass("d-none");
    $("#ajaxresults").html(`<div class="alert alert-danger"><p>The maximum device is ${nums} and  The minimun device is 0 please check your input</p></div>`);
  return;
  }
  for (let index = 1; index <=re; index++) {
    $("#dvDevices").append(`<div class="col-lg-12"  ><div class="mb-3">
    <label for="dGuarantee" class="text-black form-label "> <span>Serial number ${index} </span> <span onClick="removeSerialInput(this)" class=" badge badge-sm badge-outline-danger"><span class=" fa fa-times"></span></span> </label>
    <input type="text" value="" name="serial_${index}" class=" form-control border border-1 border-primary" placeholder="Type serial number of the ${name} ${index} " /></div></div>
    `);    
  }
  // $("#dvConfirm").addClass("d-none");
  $("#dvRegistration").removeClass("d-none");
}
  function onAssignSupplier(e){
    $("#action").val("ASSIGN_SUPPLIER");
       NProgress.start();
       let req=$("#form").serialize();
      $(e).addClass("d-none");
      // if($("#btn_action").val()!="actionSup"){
      // }
     sendWithAjax(`${req}`, "ajax_pages/requests").then((res) => {
      $(e).removeClass('d-none');
        NProgress.done(true);
    if(res.isOk){
      // $("#basicModal").modal("hide");
      // let btn=`<span class='badge badge-info'>READY TO DELIVERY</span> 
      // <button class='btn btn-outline-success'
      //   id='cStatus' onClick="sendBack(this)" 
      //   data-s='instToConfirm'
      //   data-code='${res.data.code}'
      //   data-i='${res.data.i}' 
      //   data-b='${res.data.b}'> Send back to Institition</button>`;
      // $("#cSupplier").parent().append(btn);
      // $("#cSupplier").remove();
      // $(".btnregister").removeClass("d-none");
      window.location.reload();
    }else{
      alert("operation failed try again"+ res.data);
    }
  });
  }
  function sendBack(e){
    if(confirm("Are you sure to continue action?")){
    let btn=$(e);
  let code=btn.attr("data-code");
  let status=btn.attr("data-s");
  let i=btn.attr("data-i");
  let b=btn.attr("data-b");
      NProgress.start();
      $(e).addClass("d-none");
     sendWithAjax(`action=CHANGE_REQUEST_STATUS&s=${status}&c=${code}&i=${i}&b=${b}`, "ajax_pages/requests").then((res) => {
      $(e).removeClass('d-none');
        NProgress.done(true);
    if(res.isOk){
      window.location.reload(true);
    }else{
      alert("operation failed try again"+ res.data);
    }
  });
}
}
function approveDelivery(code,sp=0){
  if(confirm(`are you sure to  continue`)){
  NProgress.start();
  $("#cTender").addClass('d-none');
  sendWithAjax(`action=DELIVERY_CONFIRMATION&c=${code}&sup=${sp}`,"ajax_pages/requests").then((res) => {
        NProgress.done(true);
    if(res.isOk){
      window.location.reload(true);
    }else{
      alert(res.data);
    }
  });
}
}
function postTender(code){
  if(confirm(`are you sure to post this tender`)){
  NProgress.start();
  $("#cTender").addClass('d-none');
  sendWithAjax(`action=PUBLISH_TENDER&&c=${code}`,"ajax_pages/requests").then((res) => {
        NProgress.done(true);
    if(res.isOk){
      window.location.reload(true);
    }else{
      alert(res.data);
    }
  });
}
}


  $("#cSupplier").click(()=>{
    $("#btn_action").val("actionSup");
    let btn=$("#cSupplier");
    let code=btn.attr("data-code");
    let i=btn.attr("data-i");
    let b=btn.attr("data-b");
    $("#scode").val(code);
    $("#si").val(i);
    $("#sb").val(b);
    $("#basicModal").modal("show");
  })
$("#cStatus").click(()=>{
  if(confirm("Are you sure to continue action?")){
    let btn=$("#cStatus");
  let code=btn.attr("data-code");
  let status=btn.attr("data-s");
  let i=btn.attr("data-i");
  let b=btn.attr("data-b");
      NProgress.start();
      $("#cStatus").addClass("d-none");
     sendWithAjax(`action=CHANGE_REQUEST_STATUS&s=${status}&c=${code}&i=${i}&b=${b}`, "ajax_pages/requests").then((res) => {
      $("#cStatus").removeClass('d-none');
        NProgress.done(true);
    if(res.isOk){
      window.location.reload(true);
    }else{
      alert("operation failed try again"+ res.data);
    }
  });
}
})

</script>
<?php endif; ?>



<?php if (in_array($page, ['supplier'])) : ?>
  <script>
   $(".approveSupplier").change(function(){
    let v=$(this).val();
    if(confirm("are you sure to change status?")){
      let sup=$(this).attr("data-sup");
      window.location.href=`sup_profile?c=${sup}&v=${v}`;  
    }
    // console.log("supp is now approved")
   })

    function onSupplierCreated(e) {
      let data = $("#form").serialize();
      NProgress.start();
      $(e).addClass("d-none");
      $("#ajaxresults").html(`<div class="alert alert-warning"><span>Please wait moment ... </span></div>`);
      sendWithAjax(data, "ajax_pages/supplier").then((res) => {
        $(e).removeClass('d-none');
        NProgress.done(true);
        if (res.isOk) {
         window.location.reload(true);
        } else {
          $("#ajaxresults").html(`<div class="alert alert-warning"><p>${res.data}</p></div>`);
        }
      }).catch((err) => {
        console.log("Error occurred", err);
      })

    }
  </script>
<?php endif; ?>

<!-- Dashboard 1 -->
<?php if (in_array($page, ['home'])) : ?>
  <script>

    var series=<?php echo json_encode($series)?>;
    var categories=<?php echo json_encode($cats)?>;
  </script>
  <script src="js/dashboard/dashboard-1.js"></script>
<?php endif; ?>

<!-- add_user -->
<?php if (in_array($page, ['add_user'])) : ?>
  <script>
// level was changed
function onLevelChange(value){
   if(value==="INST_ADMIN" || value==="BEN_ADMIN"){
    $("#dvInst").removeClass("d-none");
   }else{
    $("#dvInst").addClass("d-none");
   }
}
function getBen(e){
  let v=$(e).val();
  let level_access=$(e).attr("data-level");
  let levelSelected=$("#hotel_level").val();
  if(levelSelected==="BEN_ADMIN" && level_access=="ADMIN"){
    $("#dvBen").removeClass('d-none');
    let i=$("#insti").val();
    NProgress.start();
    $("#cLoader").removeClass('d-none');
    fetch(`ajax_pages/benificiary?action=GET_BEN&i=${i}`).then((res)=>res.text()).then((res)=>{
      NProgress.done(true);
      $("#cLoader").addClass('d-none');
      $("#ben").html(res);
    })
  }
}
    // add new user in system
    function onUserCreated(e) {
      let data = $("#formUser").serialize();
      let uname=$("#hid").text()+$("#uname").val();
      data+=`&user_name=${uname}`;
      NProgress.start();
      $(e).addClass("d-none");
      $("#ajaxresults").html(`<div class="alert alert-warning"><span>Please wait moment ... </span></div>`);
      sendWithAjax(data, "ajax_pages/user/user").then((res) => {
        $(e).removeClass('d-none');
        NProgress.done(true);
        if (res.isOk) {
          clearInputs("names","uname","pswd");
          $("#ajaxresults").html(`<div class="alert alert-success"><p>${res.data}</p></div>`);
        } else {
          $("#ajaxresults").html(`<div class="alert alert-warning"><p>${res.data}</p></div>`);
        }
      }).catch((err) => {
        console.log("Error occurred", err);
      })
    }
  </script>
<?php endif; ?>
<!-- public  script -->
<script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
	<script>
    $(".notification_dropdown").click();
	(function($) {
    var table = $('#example').DataTable({
        createdRow: function ( row, data, index ) {
           $(row).addClass('selected')
        } ,
		language: {
			paginate: {
			  next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
			  previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>' 
			}
		  }
    });
      
    table.on('click', 'tbody tr', function() {
    var $row = table.row(this).nodes().to$();
    var hasClass = $row.hasClass('selected');
    if (hasClass) {
        $row.removeClass('selected')
    } else {
        $row.addClass('selected')
    }
    })
    table.rows().every(function() {
    this.nodes().to$().removeClass('selected')
    });
	   
	})(jQuery);
  
	</script>
</body>
</html>
<?php //memory_get_usage();?>