<?php
session_start();
define('DB_USERNAME', 'root');
define('DB_PASSWORD','');
define('DB_NAME','johms_online_boutique');
define('LOCALHOST','localhost');
define('SITEURL','http://localhost/chrimass_gift/');
define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'] . '/chrimass_gift/images/');
//conection to the database 
$conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD);
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));

?>