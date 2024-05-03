<?php
    # Connect to the database
    require_once "ConnectDB.php";

    # Get the organisation from the Ajax request
    $org = $_POST["org"];

    # Query the database to check if the organisation exists
    $q = "SELECT COUNT(*) AS count FROM users WHERE LOWER(org) = LOWER('$org')";
    $result = mysqli_query($link, $q);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row['count'] > 0) {
            # Organisation already exists
            $response = array('error' => true, 'message' => 'This organisation already has an account. <a href="login.html">Sign In Now.</a>');
        } else {
            # Organisation does not exist
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