<?php
require_once('constants.php');
//check if a user is currently loged in
    if (isset($_SESSION['user'])) {
        #then all is well
    }else {
        #redirect to login page
        header('location:'.SITEURL.'login.php');
        exit();
       
    }

?>