<?php

# Check form submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Open database connection.
    require('ConnectDB.php');

    # Get connection, load, and validate functions.
    require('login_tools.php');

    # Initialize an array to store error messages.
    $errors = array();

    # Check login.
    list($check, $data) = validateLogin($link, $_POST['email'], $_POST['pass']);

    # Validation for the suspension system
    if($data['account_status'] == "Active"){
        
        # On success set session data and display logged in page.
        if ($check) {
            # Access session.
            session_start();
            $_SESSION['user_id'] = $data['user_id'];
            $_SESSION['first_name'] = $data['first_name'];
            $_SESSION['last_name'] = $data['last_name'];
            $_SESSION['role'] = $data['role'];
            load('home.php');
        } else {
            # On failure set errors.
            $errors = $data;

            # Close database connection.
            mysqli_close($link);
        }
    
    # If the user has been suspended then deny them access and inform them
    } else if ($data['account_status'] == "Suspended"){

        echo "<script>alert('This account has been suspended. Returning to login page'); window.location='login.html';</script>";
    }
}

# Continue to display login page on failure.
include('login.html');

# If there are errors, you can display them to the user on the login form.
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo '<p>' . $error . '</p>';
    }
}
?>