<?php 
if(!isset($_SESSION)){
    session_start();
}
// Make sure we have a canary set
if (!isset($_SESSION['canary'])) {
    session_regenerate_id(true);
    $_SESSION['canary'] = [
        'birth' => time(),
        'IP' => $_SERVER['REMOTE_ADDR']
    ];
}
if ($_SESSION['canary']['IP'] !== $_SERVER['REMOTE_ADDR']) {
    session_regenerate_id(true);
    // Delete everything:
    foreach (array_keys($_SESSION) as $key) {
        unset($_SESSION[$key]);
    }
    $_SESSION['canary'] = [
        'birth' => time(),
        'IP' => $_SERVER['REMOTE_ADDR']
    ];
}
// Regenerate session ID every five minutes:
if ($_SESSION['canary']['birth'] < time() - 300) {
    session_regenerate_id(true);
    $_SESSION['canary']['birth'] = time();
}
// 30 * 60;
$expiry = 1800 ;//session expiry required after 30 mins
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $expiry)) {
       session_regenerate_id(true);
    echo "Your session has expired! <span >Redirecting ...</span>";
    echo '<meta http-equiv="refresh" content="2;url=./logout">';
exit(0);
}
$_SESSION['LAST_ACTIVITY'] = time();
?>