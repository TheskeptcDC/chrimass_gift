<?php
include('config/constants.php');
 # send to login check for authentication
 $errors = array(); 
// require('config/constants.php');
 if (isset($_POST['login'])) {
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        // we check the submittend details
        //check if the email is set 
        if (!isset($_POST['admin_name'])) {
            # email can not be empty.. create message ..redirect
            $errors[] = "you have no name ?";
        }else {
            # email is set.. assign it a variable
            $admin_name = $_POST['admin_name']; 
        }
        // check if the password is set 
        if (!isset($_POST['admin_password']) && !empty($_POST['admin_password'])) {
            # password can not be empty.. create message and rediect
            $errors[] = "enter your (correct) password";
        }else {
            # password is set ..assign it a valuable
            $admin_password = trim($_POST['admin_password']);
        }
        if(empty($errors)){
        if (isset($admin_name) && !empty($admin_password)) {
           
//---------------------------------------------------------------USE PREPARED STATEMENTS HERE
            //create sql query ..execute it ..authenticate
            $sql ="SELECT * FROM `admin` WHERE admin_name = '$admin_name' AND admin_password = '$admin_password'  ";
            $res = mysqli_query($conn,$sql);
                if ($res) {
                    $count = mysqli_num_rows($res);
                    echo $admin_name, $admin_password;
                        if ($count>0) {
                            # one matching account was found
                            $rows = mysqli_fetch_assoc($res);
                                #create session variable 
                                $_SESSION['user'] = $rows['admin_name'];
                                #redirect to index page
                               header('location:'.SITEURL.'admins/index.php');
                               exit();
                        }else {
                            # more or less accounts where found
                            $errors[]= "login failed recheck your input";
                            # redirect 
                           //header('location:'.SITEURL.'login.php');
                        }
                }else {
                    # then system error
                    $errors[] = "failed to log in ..system error";
                }
        }
    }
    }
    else {
        // # method must be post.. redirect
        // header('location:'.SITEURL.'login.php');
    }
    
}

 ?>
    <div class="login_container">
    <div class="login_top_img">
        <img src="images\iyf-full-logo.png" alt="">
    </div>
    
    <div class="login_welcome">
        <p class="login_welcome_text">Welcome!</p>
        <p class="login_warning"> 
            <?php if (!empty($errors)) {
                # display error messages
                for ($i=0; $i < 4; $i++) { 
                    if (empty($errors[$i])) {
                        continue;
                    }else {
                        echo "<p> $errors[$i]</p>";
                    }
                    
                }
            }
            ?>
    </div>
    <div class="home">
    <div class="login_form latest">
        <form action="login.php" method="POST">
            <label for="admin_name">Name</label>
            <p>
            <input type="text" name="admin_name" class="user_input" >
                                                       
                                                      
            </p>
            <label for="admin_password">Password</label>
            <p>
            <input type="password" name="admin_password" class="user_input">
            </p>
        <div class="forgot_password">
            <!-- <a href="#">Forgot password?</a> -->
        </div>
            
            <p>
            <input type="submit" name="login" value="login" class="btn">
            </p>
            <!-- <p>Or sign in with</p> -->
            <!-- <p class="button_login google">
                <a href="#">Google</a> -->
            </p>
            
        </form>
    </div>
        </div>
    </div>
    
</body>
</html>
<?php

// LETS PROCESS THE SUBMITIONS FOR AUTHENTICATION AND LOGIN

//check if the login button has been clicked 
