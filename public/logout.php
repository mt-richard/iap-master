<?php 
if(!isset($_SESSION)){
    session_start();
}
    // Delete everything:
    foreach (array_keys($_SESSION) as $key) {
        unset($_SESSION[$key]);
    }
    header('location:./');
?>