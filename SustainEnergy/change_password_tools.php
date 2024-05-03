<?php

    require('tools.php');

    $email = $_POST['email'];
    $new_pass = $_POST['pass1'];

    if (changePassword($email, $new_pass)) {
        
        # Password changed successfully
        echo "<script>alert('Password change successful. Go to login page?');</script>";
        
        # Redirect to login page after showing the alert
        echo "<script>window.location.href = 'login.html';</script>";
    } else {

        # Failed to change password
        echo "<script>alert('Password change unsuccessful. Please try again.');</script>";

        # Redirect to login page after showing the alert
        echo "<script>window.location.href = 'login.html';</script>";
    }
    
?>
