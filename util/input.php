<?php
defined("USER_TOKEN") ? NULL : DEFINE("USER_TOKEN", "crt_token");
include_once("session.php");
class input
{
	public static function exists($type = 'REQUEST')
	{
		if ($type == "POST")  return (!empty($_POST)) ? true : false;
		if ($type == "GET")  return (!empty($_GET)) ? true : false;
		if ($type == "REQUEST")  return (!empty($_REQUEST)) ? true : false;
		return false;
	}
	public static function get($item)
	{
		if (isset($_POST[$item])) {
			return $_POST[$item];
		} else if (isset($_GET[$item])) {
			return $_GET[$item];
		} else if (isset($_REQUEST[$item])) {
			return $_REQUEST[$item];
		}
	}
	public static function sanitize($item)
	{
		return htmlspecialchars(self::get($item));
	}
	public static function getFileName($item)
	{
		if (isset($_FILES[$item]['name'])) {
			return $_FILES[$item]['name'];
		}
		return null;
	}

	public static function getFileTemporaryName($item)
	{
		if (isset($_FILES[$item]['tmp_name'])) {

			return $_FILES[$item]['tmp_name'];
		}

		return null;
	}
	public static function enc_dec($action, $string)
	{
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$secret_key = '@Secrety key PMS';
		$secret_iv = '@Secrety key PMS iv';
		// hash
		$key = hash('sha256', $secret_key);

		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		if ($action == 'e') {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		} else if ($action == 'd') {
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
		return $output;
	}
	public static function required($params = array())
	{
		foreach ($params as $key => $value) {
			if (!isset($_REQUEST[$value]) || empty($_REQUEST[$value])) {
				return false;
			}
		}
		return true;
	}
	public static function generate_string($len = 16, $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
	{
		$input_length = strlen($chars);
		$random_string = '';
		for ($i = 0; $i < $len; $i++) {
			$random_character = $chars[mt_rand(0, $input_length - 1)];
			$random_string .= $random_character;
		}
		return date('Ymdhisa') . '_' . $random_string;
	}
	public static function getCurrentDateTime()
	{
		//date_default_timezone_set("Asia/Calcutta");
		return date("Y-m-d H:i:s");
	}
	public static function getDateString($date)
	{
		$dateArray = date_parse_from_format('Y/m/d', $date);
		$monthName = DateTime::createFromFormat('!m', $dateArray['month'])->format('F');
		return $dateArray['day'] . " " . $monthName  . " " . $dateArray['year'];
	}
	public static function timeAgo($datetime)
	{
		$currentDateTime = new DateTime(self::getCurrentDateTime());
		$passedDateTime = new DateTime($datetime);
		$interval = $currentDateTime->diff($passedDateTime);
		//$elapsed = $interval->format('%y years %m months %a days %h hours %i minutes %s seconds');
		$day = $interval->format('%a');
		$hour = $interval->format('%h');
		$min = $interval->format('%i');
		$seconds = $interval->format('%s');

		if ($day > 7)
			return self::getDateString($datetime);
		else if ($day >= 1 && $day <= 7) {
			if ($day == 1) return $day . " day ago";
			return $day . " days ago";
		} else if ($hour >= 1 && $hour <= 24) {
			if ($hour == 1) return $hour . " hour ago";
			return $hour . " hours ago";
		} else if ($min >= 1 && $min <= 60) {
			if ($min == 1) return $min . " minute ago";
			return $min . " minutes ago";
		} else if ($seconds >= 1 && $seconds <= 60) {
			if ($seconds == 1) return $seconds . " second ago";
			return $seconds . " seconds ago";
		}
	}
	public static function generateToken(){
		return session::put(USER_TOKEN,self::generate_string(32));
	}
	public static function check($token){
		if(session::exists(USER_TOKEN) && $token === session:: get(USER_TOKEN)){
			session::delete(USER_TOKEN);
			return true;
		}
		return false;
	}
	public static function getHash($pswd){
		return password_hash($pswd,PASSWORD_DEFAULT);
	}
	public static  function removeSpaceWith($str,$sep=''){
		$str=preg_replace('/\s+/', "$sep", $str);
		return $str;
	}
	public static function getClientIp() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
	public static function getPageName(){
		return explode(".",basename($_SERVER['PHP_SELF']))[0];
	}
	public static function add_days_to_date($date1,$number_of_days,$return_format='Y-m-d H:i:s'){
		$str =' + '. $number_of_days. ' days';
		$date2= date($return_format, strtotime($date1. $str));
		return $date2; //$date2 is a string
	}
	public static function reformatDate($date, $difference_str, $return_format='Y-m-d H:i:s')
{

	/*
	$str['+ 1 months','+  2 days','+ 1 year']
echo $this->reformatDate('2021-10-8', '+ 15 minutes', 'Y-m-d H:i:s');
echo $this->reformatDate('2021-10-8', '+ 1 hour', 'Y-m-d H:i:s');
echo $this->reformatDate('2021-10-8', '+ 1 day', 'Y-m-d H:i:s');
	*/
    return date($return_format, strtotime($date. ' ' . $difference_str));
}
public static function valid_email($email) 
{
    if(is_array($email) || is_numeric($email) || is_bool($email) || is_float($email) || is_file($email) || is_dir($email) || is_int($email))
        return false;
    else
    {
        $email=trim(strtolower($email));
        if(filter_var($email, FILTER_VALIDATE_EMAIL)!==false) return $email;
        else
        {
            $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
            return (preg_match($pattern, $email) === 1) ? $email : false;
        }
    }
}
public static function extractNumbers($string){
	$int = (int) filter_var($string, FILTER_SANITIZE_NUMBER_INT);
	return $int;
	// return preg_replace('/[^0-9]/', '', $string);
}
//  remaining datetime
public static function getRemainingDateTime($dt1,$dt2,$ft="%a"){
	$date1 = new DateTime($dt1);  //current date or any date
	$date2 = new DateTime($dt2);   //Future date
	$diff = $date2->diff($date1)->format($ft);  //find difference
	$days = intval($diff);   //rounding days
	return $days;
	// echo $days;
}
public static function isStrongPasssword($password,$atLeast=8){
	$number = preg_match('@[0-9]@', $password);
	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$specialChars = preg_match('@[^\w]@', $password);
	if(strlen($password) < $atLeast || !$number || !$uppercase || !$lowercase || !$specialChars) {
	 return "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
	} else {
		return "ok";
	}
	}
}
