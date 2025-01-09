 <?php 
if (!isset($_SESSION)) session_start();
// 30 * 60;
     $expiry = 1800 ;//session expiry required after 30 mins
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $expiry)) {
           session_regenerate_id(true);
        echo "Your session has expired! <span >Redirecting ...</span>";
        echo '<meta http-equiv="refresh" content="2;url=./logout">';
    exit(0);
    }
    $_SESSION['LAST_ACTIVITY'] = time();