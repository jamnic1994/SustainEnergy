<?php
    # Check form submitted.
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        session_start();
        
        # Connect to the database.
        require('ConnectDB.php');

        # Load tools file to use the functions
        require('tools.php');

        # Initialize an error array.
        $errors = array();

        # Check for a first name.
        if (empty($_POST['first_name'])) {        
            $errors[] = 'Enter your first name.';
        
        } else {        
            $fn = mysqli_real_escape_string($link, trim($_POST['first_name']));
        }

        # Check for a last name.
        if (empty($_POST['last_name'])) {       
            $errors[] = 'Enter your last name.';
        
        } else {       
            $ln = mysqli_real_escape_string($link, trim($_POST['last_name']));
        }

        # Check for an email address:
        if (empty($_POST['email'])) {       
            $errors[] = 'Enter your email address.';
        
        } else {       
            $e = mysqli_real_escape_string($link, trim($_POST['email']));
        }

        # Check for an organisation:
        if (empty($_POST['org'])) {       
            $errors[] = 'Enter your organisation name.';
            
        } else {       
            $o = mysqli_real_escape_string($link, trim($_POST['org']));
        }

        # Check for a password and matching input passwords.
        if (!empty($_POST['pass1'])) {
            
            if ($_POST['pass1'] != $_POST['pass2']) {
                $errors[] = 'Passwords do not match.';        
            
            } else {           
                $p = mysqli_real_escape_string($link, trim($_POST['pass1']));
                
                # Hash password
                $hP = password_hash($p, PASSWORD_DEFAULT);
            }
        } else {        
            $errors[] = 'Enter your password.';
        }

        # Check for first memorable answer:
        if (empty($_POST['mem_ques1'])) {       
            $errors[] = 'Choose your first memorable question.';

        } else {       
            $mem_ques1 = mysqli_real_escape_string($link, trim($_POST['mem_ques1']));
        }

        # Check for first memorable answer:
        if (empty($_POST['mem_ans1'])) {       
            $errors[] = 'Enter your first memorable answer.';

        } else {       
            $mem_ans1 = mysqli_real_escape_string($link, trim($_POST['mem_ans1']));
        }

        # Check for first memorable answer:
        if (empty($_POST['mem_ques2'])) {       
            $errors[] = 'Choose your second memorable question.';

        } else {       
            $mem_ques2 = mysqli_real_escape_string($link, trim($_POST['mem_ques2']));
        }
            
        # Check for second memorable answer:
        if (empty($_POST['mem_ans2'])) {       
            $errors[] = 'Enter your second memorable answer.';
                        
        } else {       
            $mem_ans2 = mysqli_real_escape_string($link, trim($_POST['mem_ans2']));
        }

        # If there are any errors, halt the execution
        if (!empty($errors)) {
            
            // Output errors
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
            
            // Halt execution
            exit();
        }

        # Check if email address is already registered.
        if (empty($errors)) {
            $q = "SELECT user_id FROM users WHERE email='$e'";
            $r = mysqli_query($link, $q);
            
            if (mysqli_num_rows($r) != 0) {
                $_SESSION['error_message'] = 'Email address already registered. Sign In Now';
                header("Location: register.php");
                exit();
            }
        }

        # On success, register user by inserting into 'users' database table.
        if (empty($errors)) {
            $q = "INSERT INTO users (first_name, last_name, email, pass, org, mem_ques1, mem_ans1, mem_ques2, mem_ans2, reg_date) 
                VALUES ('$fn', '$ln', '$e', '$hP', '$o','$mem_ques1', '$mem_ans1', '$mem_ques2', '$mem_ans2', NOW())";
            $r = mysqli_query($link, $q);
            
            if ($r) {
                $_SESSION['user_id'] = loadUserId($e, $link);
                header("Location: login.html"); // Redirect to login page on successful registration
                exit();
            } else {
                $_SESSION['error_message'] = "Error inserting user: " . mysqli_error($link);
                header("Location: register.php"); // Redirect back to registration page on database error
                exit();
            }
        }
    }
?>