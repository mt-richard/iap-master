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
  <script src="js/customer/nprogress.js"></script>
  <style>
    *{
      font-family: 'Merriweather', serif;
      font-family: 'Poppins', sans-serif;
    }
     
  </style>
</head>
<body class="" style=" background: rgba(0, 0, 0, 0.91);">
<!-- Nav abr -->
<div class="bg-white py-4 px-20 flex justify-between ">
    <div class="flex gap-5">
      <img src="../public/images/logo.jpg" alt="" class="w-60">
    </div>
    <div class="flex justify-center">
      <ul class="flex gap-6 justify-center items-center">
        <a href="#" class="hover:text-blue-600 hover:font-bold"><li>Home</li></a>
        <a href="#" class="hover:text-blue-600 hover:font-bold"><li>About</li></a>
        <a href="register" class="hover:text-blue-600 hover:font-bold"><li>Request Partenership</li></a>
      </ul>
    </div>
    <div class="flex gap-5">
      <a href="login"><button class="text-white bg-blue-500 rounded px-10 uppercase py-2.5 hover:bg-blue-700">LOGIN</button></a>
      <a href="signup"><button class="text-gray-700  border-2 border-blue-500 rounded px-10 uppercase py-2 hover:bg-blue-500 hover:text-white">SIGNUP</button></a>
    </div>
</div>

<!-- Banner Section -->
<section>
  <div class="md:flex justify-center py-10">
    <div class="col-md-4 flex flex-col justify-center">
      <h3 class="text-gray-100 text-2xl pb-5">Welcome to our site,</h3>
      <h1 class="text-gray-50 text-5xl font-black uppercase">IAP Monitoring, Tracking and Online interaction System</h1>
      <p class="text-gray-400 text-lg font-light leading-8 py-4">The IAP is a package of rules and interventions to structure, govern, facilitate and supervise industrial attachments throughout the Rwandan TVET system.</p>
      <a href="register"><button class="bg-blue-500 hover:bg-blue-700 rounded px-10 py-3 text-white w-60 font-semibold">Get Started</button></a>
    </div>
    <div class="col-md-4">
      <img src="../public/images/home.png" alt="">
    </div>
  </div>
</section>

<!-- Cards -->
<section class="bg-white py-20 ">
  <div class="flex justify-center items-center gap-4">
    <!-- card1 -->
    <div class="flex flex-col justify-center items-center shadow w-1/5 rounded p-5">
      <div>
        <img src="../public/images/icons8-students-96 1.png" alt="" class="w-14">
      </div>
      <div>
        <h2 class="font-bold uppercase py-4 text-center">Students</h2>
        <p class="font-light text-gray-600">"Fostering Student Growth through Participation: Our Industrial Attachment Program empowers students with hands-on skills and experience, industry connections, and essential skills, shaping their future success.</p>
      </div>
    </div>

    <!-- card2 -->
    <div class="flex flex-col justify-center items-center shadow w-1/5 rounded p-5">
      <div>
        <img src="../public/images/icons8-graduation.png" alt="" class="w-14">
      </div>
      <div>
        <h2 class="font-bold uppercase py-4 text-center">Colleges</h2>
        <p class="font-light text-gray-600">Empowering students with real-world experience for successful careers, our Industrial Attachment Program bridges the gap between education and practical skills, fostering connections and leadership for the future. </p>
      </div>
    </div>

    <!-- card3 -->
    <div class="flex flex-col justify-center items-center shadow w-1/5 rounded p-5">
      <div>
        <img src="../public/images/icons8-college.png" alt="" class="w-14">
      </div>
      <div>
        <h2 class="font-bold uppercase py-4 text-center">Companies</h2>
        <p class="font-light text-gray-600">Collaborating with Companies to Cultivate Future Talent: Our Industrial Attachment Program nurtures young minds, forging strong industry ties, imparting practical skills, and preparing the next generation of leaders.</p>
      </div>
    </div>

    <!-- card4 -->
    <div class="flex flex-col justify-center items-center  w-1/5 rounded p-5">
      <div>
        <img src="../public/images/note.png" alt="">
      </div>
      <div>
        <h2 class="font-bold uppercase py-4 text-center text-2xl text-gray-500 leading-8">Join Us, we’re working this for, </h2><h2 class="text-2xl uppercase text-blue-600 font-black text-center">Better Destiny</h2>
      </div>
    </div>

  </div>
</section>


<!-- gallery -->

<section>
  <div class="flex justify-center items-center flex-col">
    <div class="flex justify-center items-center flex-col w-3/5">
      <h3 class="font-black text-white text-3xl uppercase p-5">WorkPlace Learning</h3>
      <p class="text-gray-300 text-center text-lg font-light leading-8 ">Participation in workplace learning is a transformative journey towards professional growth. Our program places a strong emphasis on practical experience, giving individuals the opportunity to immerse themselves in real-world work environments. This participation not only enriches their skillset but also forges connections with industry professionals, providing valuable insights and opening doors to future opportunities. By actively engaging in workplace learning, individuals are not only investing in their own development but also contributing to the long-term success of their chosen career path.</p>
    </div>
   
    <div class="flex flex-col justify-center items-center py-10">
      <div class="flex gap-2 p-1">
        <div class="w-1/2 flex gap-2 flex-col">
          <img src="./images/img2.jpg" alt="" class=" object-cover rounded">
          <img src="./images/img1.jpg" alt="" class=" object-cover rounded">
        </div>
        <div class="w-1/2">
          <img src="./images/img13.avif" alt="" class="h-full object-cover w-full rounded">
        </div>
      </div>
      
      <div class="flex gap-2 flex-wrap gap-2 w-full justify-center p-1">
          <img src="./images/img4.jpg" alt="" class="w-1/2 object-cover rounded">
          <!-- <img src="./images/img3.jpg" alt="" class="w-1/4 object-cover rounded"> -->
          <img src="./images/img5.jpg" alt="" class="w-1/4 object-cover rounded">
      </div>
      <div class="flex flex-wrap gap-2 w-full justify-center ">
          <img src="./images/img6.jpeg" alt="" class="w-1/4 object-cover rounded">
          <img src="./images/img7.jpg" alt="" class="w-1/4 object-cover rounded">
          <img src="./images/img8.jpg" alt="" class="w-1/4 object-cover rounded">
          <img src="./images/img9.jpg" alt="" class="w-1/4 object-cover rounded">
          <img src="./images/img10.gif" alt="" class="w-1/4 object-cover rounded">
          <img src="./images/img11.jpeg" alt="" class="w-1/4 object-cover rounded">
          <img src="./images/img12.avif" alt="" class="w-1/4 object-cover rounded">
          <img src="./images/img13.avif" alt="" class="w-1/4 object-cover rounded">
          <img src="./images/img14.jpg" alt="" class="w-1/4 object-cover rounded">
      </div>
    </div>
  </div>
</section>

<!-- quick recap1 -->
<section class="flex flex-col bg-white justify-center items-center py-5">
  <h2 class="text-3xl p-3 font-black text-blue-500">"We invite you to join us in improving the IAP for a brighter destiny."</h2>
  <div class="bg-white flex justify-center items-center py-10">
    <div class="w-1/2">
      <p class="text-gray-600 text-lg font- leading-10 text-center">At our Industrial Attachment Program, we invite companies to embark on a rewarding partnership that can shape the future of their industries. By participating in our program, your organization gains access to a pool of driven and motivated students eager to contribute their fresh perspectives and energy to your projects. We offer a seamless integration process, ensuring that your work environment becomes a nurturing ground for talent development. By opening your doors to our program, you not only inspire the next generation of professionals but also enrich your workforce with innovative ideas and a fresh wave of enthusiasm. Join us and be part of a transformative journey that fosters mutually beneficial growth, drives innovation, and sets the stage for the future leaders of your industry.</p>
    </div>
    <div class="w-1/4">
      <img src="./images/undraw_going_offline_ihag.png" alt="" class="w-4/6">
    </div>
    
  </div>
</section>

<!-- quick recap2 -->
<section>
  <div class="flex justify-center items-center py-10">
    <div class="w-1/2">
      <h2 class="text-white text-4xl font-black leading-10 text-center">All, while gaining valuable experience through an online interactive IAP.</h2>
    </div>
    <div class="w-60">
    <a href="register"><button class="text-white bg-blue-500 rounded px-10 uppercase py-3">Get Started</button></a>
    </div>
  </div>
</section>

<!-- reviews -->
<section class="bg-white flex flex-col justify-center items-center py-10">
  <h2 class="text-3xl py-5">Customer Reviews</h2>
  <div class="flex justify-center gap-5">

  <!-- card1 -->
    <div class="w-1/4 shadow rounded p-5">
      <div class="flex justify-center">
        <img src="../public/images/Star.svg" alt="">
        <img src="../public/images/Star.svg" alt="">
        <img src="../public/images/Star.svg" alt="">
        <img src="../public/images/Star.svg" alt="">
        <img src="../public/images/Star.svg" alt="">
        <img src="../public/images/Star.svg" alt="">
      </div>
      <div class="py-3">
        <p class="py-3 pb-4 leading-8">
        "The online interaction IAP system is undeniably the best. Its blend of practical learning, real-time engagement, and valuable experiences is truly exceptional. A commendable platform!"
        </p>
      </div>
      <div>
        <div class="flex justify-center items-center gap-1.5">
          <img src="../public/images/avatar/1.png" alt="" class="w-12">
          <h3 class="font-bold">Olivier</h3>
        </div>
      </div>
    </div>

    <!-- card1 -->
    <div class="w-1/4 shadow rounded p-5">
      <div class="flex justify-center">
        <img src="../public/images/Star.svg" alt="">
        <img src="../public/images/Star.svg" alt="">
        <img src="../public/images/Star.svg" alt="">
        <img src="../public/images/Star.svg" alt="">
        <img src="../public/images/Star.svg" alt="">
        <img src="../public/images/Star.svg" alt="">
      </div>
      <div class="py-3">
        <p class="py-3 pb-4 leading-8">
        "The online interaction IAP system is undeniably the best. Its blend of practical learning, real-time engagement, and valuable experiences is truly exceptional. A commendable platform!"
        </p>
      </div>
      <div>
        <div class="flex justify-center items-center gap-1.5">
          <img src="../public/images/avatar/1.png" alt="" class="w-12">
          <h3 class="font-bold">Jessca</h3>
        </div>
      </div>
    </div>

    <!-- card1 -->
    <div class="w-1/4 shadow rounded p-5">
      <div class="flex justify-center">
        <img src="../public/images/Star.svg" alt="">
        <img src="../public/images/Star.svg" alt="">
        <img src="../public/images/Star.svg" alt="">
        <img src="../public/images/Star.svg" alt="">
        <img src="../public/images/Star.svg" alt="">
        <img src="../public/images/Star.svg" alt="">
      </div>
      <div class="py-3">
        <p class="py-3 pb-4 leading-8">
        "The online interaction IAP system is undeniably the best. Its blend of practical learning, real-time engagement, and valuable experiences is truly exceptional. A commendable platform!"
        </p>
      </div>
      <div>
        <div class="flex justify-center items-center gap-1.5">
          <img src="../public/images/avatar/1.png" alt="" class="w-12">
          <h3 class="font-bold">Honore</h3>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- Footer -->

<section class="md:px-20">
  <div class="md:flex justify-center md:gap-10 md:pt-20 md:pb-10 border-b border-gray-600 ">
      <div class="w-1/3" >
        <img src="../public/images/rplogo.png" alt="" class="w-60 ">
        <p class="text-gray-100 leading-10 py-5 font-light">An online interaction system for internships offers real-time engagement, flexible learning, and global networking, empowering participants with dynamic skill development and valuable professional connections.</p>
      </div>

      <div class="w-1/6">
          <div class="pb-5">
              <h2 class="text-2xl pb-3 text-gray-50 font-bold">Quicklinks</h2>
              <ul>
                 <li class="text-gray-100 font-light leading-10 hover:text-gray-50"><a href="/">Home</a></li>
                 <li class="text-gray-100 font-light leading-10 hover:text-gray-50"><a href="/">About</a></li>
                 <li class="text-gray-100 font-light leading-10 hover:text-gray-50"><a href="register">Request Partnership</a></li>
                 <li class="text-gray-100 font-light leading-10 hover:text-gray-50"><a href="/">Contact Us</a></li>
              </ul>
          </div>
      </div>

      <div class="w-1/4">
        <div class="pb-3">
          <h1 class="text-2xl pb-3 text-gray-50 font-bold">Documentation </h1>
          <ul>
                 <li class="text-blue-500 font-light leading-6 hover:text-blue-50"><a href="/">Mission</a></li>
                 <li class="text-blue-500 font-light leading-6 hover:text-blue-50"><a href="/">How it works</a></li>
                 <li class="text-blue-500 font-light leading-6 hover:text-blue-50"><a href="/">Get Started</a></li>
          </ul>

        </div>
        <h1 class="text-2xl pb-3 text-gray-50 font-bold">Mission </h1>
        <p class="text-gray-100">The system's mission is to offer interns a boundary-defying learning journey, cultivating connections, skills, and cross-cultural collaboration to shape future leaders and innovators.</p>
      </div>
  </div>
  <div class="flex justify-center py-4 text-gray-100">
    <p>IAP Monitoring, Tracking and Online Interaction System</p>
  </div>
</section>


</body>
</html>