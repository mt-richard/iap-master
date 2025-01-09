<?php 
if(!isset($_SESSION)){
    session_start();
}
// check if user is logged in
if(!isset($_SESSION['ht_userId'])){
  echo "Unautorized <span >Redirecting ...</span>";
  echo '<meta http-equiv="refresh" content="2;url=./logout">';
exit(0);
} 
$level=$_SESSION['ht_level'];
include("../util/preventSession.php");

date_default_timezone_set('Africa/kigali');
  function getPageName(){
	  return explode(".",basename($_SERVER['PHP_SELF']))[0];
  }
  $page=getPageName();
  include_once("../util/input.php");
  include_once("../config/grobals.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="robots" content="" />
  <title>IAP Mornitoring, Tracking </title>
  <!-- Favicon icon -->
  <link rel="icon" type="image/ico" sizes="16x16" href="images/logo.ico" />
  <!-- <link href="../vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../vendor/chartist/css/chartist.min.css" />
  <link href="../vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" /> -->
  <link href="vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Poppins:wght@100;200;300;400&display=swap" rel="stylesheet">
  
<style>
  *{
      font-family: 'Merriweather', serif;
      font-family: 'Poppins', sans-serif;
    }
  .pointer{
    cursor: pointer !important;
  }
</style>
  <?php 
  if(in_array($page,['generatedReport'])):
  ?>
  <link rel="stylesheet" type="text/css" href="vendor/star-rating/star-rating-svg.css">
  <?php endif; ?>

  <link href="css/style.css" rel="stylesheet" />
  <link href="css/customer/mycss.css" rel='stylesheet' />
  <link href="css/customer/nprogress.css" rel='stylesheet' />
  <?php 
  if(in_array($page,['sup_profile'])):
  ?>
  <link rel="stylesheet" type="text/css" href="css/customer/summernote-bs4.min.css">
  <?php endif; ?>
      <!-- lazy img loader -->
  <script src="js/customer/lozard.js"></script>
  <script src="js/customer/nprogress.js"></script>
 
  
</head>
<body>
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
  <!--*******************
        Preloader start
    ********************-->
    <?php if($page!="generatedReport"): ?>
  <div id="preloader">
    <div class="sk-three-bounce">
      <div class="sk-child sk-bounce1"></div>
      <div class="sk-child sk-bounce2"></div>
      <div class="sk-child sk-bounce3"></div>
    </div>
  </div>
  <?php  endif;?>

