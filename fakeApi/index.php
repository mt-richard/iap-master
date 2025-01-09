<?php 
require_once '../vendor/autoload.php';

require("../config/grobals.php");
require("../util/input.php");
$action=input::get("action");
if(!isset($_SESSION)){
    session_start();
}
if(!isset($_SESSION['ht_userId'])){
  echo json_encode(["isOk"=>false,"data"=>"Access denied"]); 
  exit();
}
$faker = Faker\Factory::create();

$action=input::get("action");
switch ($action) {
  case 'FAKE_DATA_FOR_LOG_BOOK':
    $randomEnd=$faker->numberBetween(3,20);
    $inserted=0;
    $stIds=[];
      // for ($i = 0; $i <$randomEnd; $i++) {
      //   $formData=["name"=>$faker->]
      // }
    break;
  case 'FAKE_DATA_FOR_PARTNER':
    try {
      $randomEnd=$faker->numberBetween(3,20);
     $inserted=0;
       for ($i = 0; $i <$randomEnd; $i++) {
          $phone=$faker->numerify('078#######');
          $email=$faker->companyEmail;
          $name=$faker->company;
        $isInserted=$database->insert("a_partner_tb",[
            "name"=>$name,
            "tin"=>$faker->numerify('#########'),
            "email"=>$email,
            "phone"=>$phone,
            "place"=>$faker->city,
            "is_active"=>"yes",
            "c_profile"=>$faker->text
            ]);
            // insert into user account
            if($isInserted>0){
           $isThere=$database->create("a_users",[
            "names"=>$name,
            "phone"=>$phone,
            "username"=>$faker->userName,
            "level"=>"PARTNER",
            "secret"=>password_hash("@123",PASSWORD_DEFAULT),
            "status"=>"active"
          ]);
        }
      }
        echo json_encode(["isOk"=>true, "data"=>$randomEnd]);
    } catch (\Throwable $e) {
      echo json_encode(["isOk"=>false, "data"=>$e->getMessage()]);
    }
    break;
  case 'FAKE_DATA_FOR_SUPPERVISIOR':
    try {
      $randomEnd=$faker->numberBetween(3,10);
     $inserted=0;
       for ($i = 0; $i <$randomEnd; $i++) {
          $gender=$faker->randomElement(['male','female']);
          $phone=$faker->numerify('078#######');
          $name=$faker->name($gender);
          $email=$faker->email;
        $isInserted=$database->insert("a_suppervisior_tb",[
            "names"=>$name,
            "gender"=>$gender,
            "email"=>$email,
            "phone"=>$phone,
            "department"=>$faker->randomElement(['IT','BUSSINESS','THEOLOGY','HEALTH SCIENCE'])
            ]);
            // insert into user account
            if($isInserted){
            $supperVisiorAccount=[
            "names"=>$name,
            "phone"=>$phone,
            "level"=>"SUPERVISIOR",
            "username"=>$faker->userName,
            "secret"=>password_hash("@123",PASSWORD_DEFAULT),
            "status"=>"active"
          ];
          $database->insert("a_users",$supperVisiorAccount);
        }
      }
        echo json_encode(["isOk"=>true, "data"=>$randomEnd]);
    } catch (\Throwable $e) {
      echo json_encode(["isOk"=>false, "data"=>$e->getMessage()]);
    }
  break;
  case 'NEW_INTERNASHIP_STUDENTS':
    try {
      $y=date('y');
      $randomEnd=$faker->numberBetween(10,20);
      $intern=(int)input::get("i");
     $inserted=0;
       for ($i = 0; $i <$randomEnd; $i++) {
          $gender=$faker->randomElement(['male','female']);
          $rId=$faker->randomElement([($y-3),($y-2),($y-4),($y-5)]);
          $cardId ='20'.$faker->numerify('#####');
          if($database->count_all("a_student_tb where internaship_periode_id=$intern AND card_id=$cardId")==0){
          $fname=$database->escape_value($faker->firstName($gender));
         $lname= $database->escape_value($faker->lastName($gender));
         $phone=$faker->e164PhoneNumber;
        $isInserted=$database->insert("a_student_tb",[
            "internaship_periode_id"=>$intern,
            "card_id"=>$cardId,
            "first_name"=>$fname,
            "last_name"=>$lname,
            "gender"=>$gender,
            "email"=>$faker->email,
            "phone"=>$phone,
            "major_in"=>$faker->randomElement([
                'Information and Communication technology',
                'Transport and Logistics Department',
                'Mechanical Engineering',
                'Mining Engineering',
                'Civil Engineering',
                'Creative Arts Department',
                'Electrical and Electronics Engineering',
                ])
            ]);
            // open account for student
            $database->create("a_users",[
            "names"=>$fname ." ". $lname,
            "username"=>$cardId,"phone"=>$phone,
            "secret"=>input::getHash($cardId),
            "level"=>"STUDENT",
            "status"=>"active"
          ]);
            if($isInserted){
              $inserted++;
            }
        }
      }
      // update internaship students
      $database->query("update a_internaship_periode set total_student=total_student+$inserted where id=$intern");
      // $database->update("a_internaship_periode","id=$intern",["total_student"=>])
        echo json_encode(["isOk"=>true, "data"=>$inserted]);

    } catch (\Throwable $e) {
      echo json_encode(["isOk"=>false, "data"=>$e->getMessage()]);
    }

    break;
  default:
  echo json_encode(["isOk"=>false,"data"=> $action." as Action not found"]); 
    break;
}

?>