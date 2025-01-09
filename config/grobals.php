<?php
if(!isset($_SESSION)){
    session_start();
}
require_once("config.php"); 
require_once("database.php"); 
error_reporting(0);
date_default_timezone_set('Africa/kigali');