<?php
    # Connect to the database
    require_once "ConnectDB.php";

    # Get the email from the Ajax request
    $email = $_POST["email"];

    # Query the database to check if the email exists
    $q = "SELECT COUNT(*) AS count FROM users WHERE email = '$email'";
    $result = mysqli_query($link, $q);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row['count'] > 0) {
            # Email already exists
            $response = array('error' => true, 'message' => 'This email is already in use. <a href="login.html">Sign In Now.</a>');
        } else {
            # Email does not exist
            $response = array('error' => false, 'message' => null);
        }
    } else {
        # Error in database query
        $response = array('error' => true, 'message' => 'Error checking email: ' . mysqli_error($link));
    }

    # Close the database connection
    mysqli_close($link);

    # Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
?>