<?php
$errors = array(); 

if (isset($_POST['login'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Check and validate admin name
        if (!isset($_POST['admin_name'])) {
            $errors[] = "you have no name ?";
        } else {
            $admin_name = $_POST['admin_name']; 
        }

        // Check and validate password
        if (!isset($_POST['admin_password']) || empty($_POST['admin_password'])) {
            $errors[] = "enter your (correct) password";
        } else {
            $admin_password = trim($_POST['admin_password']);
        }

        if (empty($errors)) {
            if (isset($admin_name) && !empty($admin_password)) {
                // Use prepared statement (recommended for security)
                $sql = "SELECT * FROM `admin` WHERE admin_name = ? AND admin_password = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ss", $admin_name, $admin_password);
                mysqli_stmt_execute($stmt);
                $res = mysqli_stmt_get_result($stmt);

                if ($res) {
                    $count = mysqli_num_rows($res);
                    if ($count > 0) {
                        $rows = mysqli_fetch_assoc($res);
                        $_SESSION['user'] = $rows['admin_name'];
                        header('location:'.SITEURL.'admins/index.php');
                        exit();
                    } else {
                        $errors[] = "login failed recheck your input";
                    }
                } else {
                    $errors[] = "failed to log in ..system error";
                }
            }
        }
    }
}
?>