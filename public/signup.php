<?php
session_start();
require("../util/input.php");
if(isset($_SESSION['ht_userId'])){
  header('Location:home');
  exit(0);
}
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="IAP System" />
    <meta name="author" content="Richard and Nicolle" />
    <meta name="robots" content="" />
    <meta name="description" content="IAP system" />
    <title>IAP System</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/ico" sizes="16x16" href="images/logo.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Poppins:wght@100;200;300;400&display=swap" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/customer/nprogress.css" rel='stylesheet' />
    <link href="css/customer/mycss.css" rel='stylesheet' />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com"></script>
  
  <script src="js/customer/nprogress.js"></script>
  <style>
    *{
      font-family: 'Merriweather', serif;
      font-family: 'Poppins', sans-serif;
    }
     
  </style>
</head>
<body class="h-100 ourbg" style=" background: rgba(0, 0, 0, 0.91);">

<script type="text/javascript">
    NProgress.configure({
      showSpinner: false
    });
    NProgress.start();
    if (document.readyState === 'ready' || document.readyState === 'complete') {
      NProgress.done(true);
    } else {
      document.onreadystatechange = function() {
        if (document.readyState == "complete") {
          NProgress.done(true);
        }
      }
    }
  </script>
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                  <h3 class="text-gray-100 text-2xl pb-5">Welcome to our site,</h3>
                  <h1 class="text-gray-50 text-3xl font-black uppercase">IAP Monitoring, Tracking and Online interaction System</h1>
                  <p class="text-gray-400 text-lg font-light leading-8 py-4">The IAP is a package of rules and interventions to structure, govern, facilitate and supervise industrial attachments throughout the Rwandan TVET system.</p>
                  <a href="login"><button class="bg-blue-500 hover:bg-blue-700 rounded-lg px-10 py-3 text-white">LOGIN</button></a>
                </div>
                <div class="col-md-5">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center flex justify-center border-b">
                                      
										<a href="./"><img src="images/logo.jpg" alt="" style="width:250px"></a>
									</div>
                                    <h4 class="text-center mt-6 mb-4 font-black text-gray-800 uppercase">Sign up Page</h4>
                                    <p class="text-gray-500 p-b-3">To sign up, you need to send your email address, so that we can send your credentals as well</p>
                                    <form action="#" id="formLock" autocomplete="off" class="pt-4">
                                        <div class="form-group">
                                            <label class="text-gray-600 font-medium">Email: <span class="text-red-600">*</span></label>
                                            <input type="text" class="form-control border-1 border-gray-300 " value="" name="user_name" placeholder="Eg:habimana" onkeypress="limitKeypress(event,this.value,50)">
                                            <input type="hidden" class="form-control" value="<?=input::enc_dec("e",'ADMIN_LOGIN')?>" name="faction">
                                            <p class="font-light text-xs">Ex: example@gmail.com</p>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-gray-600 font-medium">Username: <span class="text-red-700">*</span></label>
                                            <input type="password" class="form-control border-1 border-gray-300  " placeholder="*********" value="" name="password" id="pswd" >
                                            <p class="font-light text-xs">Ex: KALISA James</p>
                                        </div>
                                        <div class="form-group  text-center flex flex-col justify-center">
                                        <div id="ajaxresults"></div>
                                        <div>
                                           <button id="btnaLogin" type="button" class="bg-blue-500 hover:bg-blue-700 rounded-lg px-10 py-2.5 text-white uppercase">Request Account </button>
                                        </div>
                                           
                                      </div>
                                      <div class="flex justify-start text-sm pt-4">
                                        <p class="">If you have account you can,  <a href="login" class="font-semibold text-blue-700 cursor-pointer hover:text-blue-900">Sign In</a></p>
                                      </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
    <!-- Common JS -->
    <script src="vendor/global/global.min.js"></script>
    <!-- Custom script -->
    <!-- <script src="../js/customer/auth.js"></script> -->
    <script src="js/customer/functions.js"></script>
    <script>
      var input = document.getElementById("pswd");
input.addEventListener("keypress", function(event) {
  if (event.key === "Enter") {
    event.preventDefault();
    document.getElementById("btnaLogin").click();
  }
});
      $("#btnaLogin").click(function(){
           let d=$("#formLock").serialize();
           let btn=$(this);
           $(btn).addClass("d-none");
           NProgress.start();
           sendWithAjax(d,"ajax_pages/user/login").then((res) => {
            NProgress.done(true);
            $(btn).removeClass("d-none");
            if (res.isOk) {
          $("#ajaxresults").html(`<div class="alert alert-success"><p>${res.data}</p></div>`);
          window.location.href=`home`;
        } else {
          $("#ajaxresults").html(`<div class="alert alert-warning"><p>${res.data}</p></div>`);
        }
           }).catch((err) => {
            NProgress.done(true);
           });
      })
    </script>
</body>
</html>