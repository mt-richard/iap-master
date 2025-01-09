<?php
session_start();
require("../util/input.php");
if (isset($_SESSION['ht_userId'])) {
    header('Location:home');
    exit(0);
}
?>
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="" />
    <title>IAP -Registration-Form</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/customer/nprogress.css" rel='stylesheet' />
    <link href="css/customer/mycss.css" rel='stylesheet' />
    <script src="js/customer/nprogress.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-100 ourbg" style="">
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
    <div class="authincation h-100 ">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-12">
                    <div class="authincation-content">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="row">
                                        <div class="col-md-12 text-center mb-2 border-b">
                                            <h1 class="mb-2 font-black text-4xl">IPRC KIGALI Partner Registration Form</h1>
                                            <hr/>
                                        </div>
                                        <div class="col-md-4 my-auto pt-4">
                                            <div class="text-center">
                                                <!-- MyStoma -->
                                                <a href="./"><img src="images/rplogo.png" alt="" width="330" class="mt-10 my-auto"></a>
                                            </div>
                                        </div>
                                        <div class="col-md-8 pt-4">
                                            <form action="#" id="formLock" autocomplete="off">
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label class="font-bold text-gray-700 form-label">Company Name <span class="required text-danger">*</span></label>
                                                        <input type="text" class="form-control border-1 border-gray-400 font-bold leading-6 text-lg" value="" name="company" placeholder="Eg:mucyo ltd">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="font-bold text-gray-700 form-label">TIN <span class="required text-danger">*</span></label>
                                                        <input type="number" class="form-control border-1 border-gray-400 font-bold leading-6 text-lg" value="" name="tin" placeholder="Eg:111111111" onkeypress="limitKeypress(event,this.value,9)">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                     <div class="col-md-6">
                                                        <label class="font-bold text-gray-700 form-label">Contact Person <span class="required text-danger">*</span></label>
                                                        <input type="text" class="form-control border-1 border-gray-400 font-bold leading-6 text-lg" value="" name="person" placeholder="Eg:Kalisa Shaffi" onkeypress="limitKeypress(event,this.value,60)">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="font-bold text-gray-700 form-label">Contact Phone <span class="required text-danger">*</span></label>
                                                        <input type="text" class="form-control border-1 border-gray-400 font-bold leading-6 text-lg" value="" name="phone" placeholder="Eg:07....." onkeypress="limitKeypress(event,this.value,10)">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="font-bold text-gray-700 form-label">Contact Email <span class="required text-danger">*</span></label>
                                                        <input type="text" class="form-control border-1 border-gray-400 font-bold leading-6 text-lg" value="" name="email" placeholder="Eg:mucyoltd@gmail.com" >
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="font-bold text-gray-700 form-label">Working place <span class="required text-danger">*</span></label>
                                                        <input type="text" class="form-control border-1 border-gray-400 font-bold leading-6 text-lg" value="" name="place" placeholder="Eg:kigali city" >
                                                    </div>

                                                    
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="font-bold text-gray-700 form-label" for="menu_type" class="text-gray-700 form-label">Major Field <span class="required text-danger">*</span></label>
                                                        <select type="text" class="form-control border-1 border-gray-400 font-bold leading-6 text-lg" name="major_in" >
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
                                                        <label for="menu_type" class="font-bold text-gray-700 form-label">Company Profile <span class="required text-danger">*</span></label>
                                                        <textarea type="text"  name="profile" placeholder="Eg:Bio" class=" form-control border-1 border-gray-400 font-bold leading-6 text-lg "></textarea>
                                                        
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                    <label class="font-bold text-gray-700 form-label">Username <span class="required text-danger">*</span></label>
                                                    <input type="text" class="form-control border-1 border-gray-400 font-bold leading-6 text-lg" value="" name="user_name" placeholder="Eg: Habimana" onkeypress="limitKeypress(event,this.value,50)">
                                                    <input type="hidden" class="form-control border-1 border-gray-400 font-bold leading-6 text-lg" value="SUPPLIER_REGISTRATION" name="action">
                                                    </div>
                                                    <div class="col-md-6">
                                                    <label class="font-bold text-gray-700 form-label">Password <span class="required text-danger">*</span></label>
                                                    <input type="password" class="form-control border-1 border-gray-400 font-bold leading-6 text-lg text-uppercase" placeholder="*********" value="" name="password" id="pswd">
                                                    </div>
                                                    
                                                </div>
                                                
                                            </form>
                                        </div>
                                        <div class="col-12 text-center">
                                        <div class="form-group  text-center pt-3">
                                                    <div id="ajaxresults"></div>
                                                     <button id="btnaLogin" type="button" class="btn  btn-md bg-blue-500 text-white w-25">Make Request</button>
                                                     <a class=" btn  btn-md btn-outline-warning w-25" href="./">Back</a>
                                                </div>
                                        </div>
                                    </div>

                                    <!-- <h4 class="text-center mb-4">Account Locked</h4> -->

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
        $("#btnaLogin").click(function() {
            let d = $("#formLock").serialize();
            let btn = $(this);
            $(btn).addClass("d-none");
            NProgress.start();
            sendWithAjax(d, "ajax_pages/supplier").then((res) => {
                NProgress.done(true);
                $(btn).removeClass("d-none");
                if (res.isOk) {
                    $("#ajaxresults").html(`<div class="alert alert-success"><p>${res.data}</p></div>`);
                    window.location.href = `home`;
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