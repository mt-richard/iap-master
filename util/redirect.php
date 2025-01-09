<?php
class redirect{
	public static function to($link){
		header('location:'.$link);
	}
	public static function back(){
		if(isset($_SERVER['HTTP_REFERER'])){
		header('Location: ' . $_SERVER["HTTP_REFERER"]);exit;
		}
	}
	
}
?>