<?php

# Function to load specified or default URL.
function load( $page = 'login.html' )
{
    # Begin URL with protocol, domain, and current directory.
    $url = 'http:#' . $_SERVER[ 'HTTP_HOST' ] . dirname( $_SERVER[ 'PHP_SELF' ] ) ;

    # Remove trailing slashes then append page name to URL.
    $url = rtrim( $url, '/\\' ) ;
    $url .= '/' . $page ;

    # Execute redirect then quit. 
    header( "Location: $url" ) ; 
    exit() ;
}

# Function to check email address and password. 
function validateLogin($link, $email, $pwd)
{
    # Initialize errors array.
    $errors = array();

    # Check email field.
    if (empty($email)) {
        $errors[] = 'Enter your email address.';
    } else {
        $e = mysqli_real_escape_string($link, trim($email));
    }

    # Check password field.
    if (empty($pwd)) {
        $errors[] = 'Enter your password.';
    } else {
        # On success, retrieve user_id, first_name, and last name from 'users' database.
        if (empty($errors)) {
            $q = "SELECT user_id, first_name, last_name, pass, org, role, account_status FROM users WHERE email='$e'";
            $r = mysqli_query($link, $q);

            if (@mysqli_num_rows($r) == 1) {
                $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
                $storedHashedPwd = trim($row['pass']);
                $tP = trim($pwd);

                # Compare the hashed password from the database with the user input password.
                if (password_verify($tP, $storedHashedPwd)) {
                    return array(true, $row);
                } else {
                    echo "<script>alert('Email and or Password is Incorrect.');</script>";
                    $errors[] = 'Password is incorrect.';
                }
            } else {
                echo "<script>alert('Email and or Password is Incorrect.');</script>";
                $errors[] = 'Email address is not found.';
            }
        }
    }

    # On failure, retrieve error message(s).
    return array(false, $errors);
}
?>