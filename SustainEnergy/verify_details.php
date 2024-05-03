<?php

    require('connectDB.php');

    # Retrieve the form data
    $input_email = $_POST["email"];
    $input_mem_ques1 = $_POST["mem_ques1"];
    $input_mem_ans1 = $_POST["mem_ans1"];
    $input_mem_ques2 = $_POST["mem_ques2"];
    $input_mem_ans2 = $_POST["mem_ans2"];

    # Validate the email against your database
    # Query (assuming you have a 'users' table with column 'email')
    $q_email = "SELECT * FROM users WHERE email = '$input_email'";
    $r_email = mysqli_query($link, $q_email);

    if ($r_email && mysqli_num_rows($r_email) > 0) {
        # Email is correct, proceed with question and answer validation
        
        # Query to SELECT questions and answers
        $q_qa = "SELECT mem_ques1, mem_ans1, mem_ques2, mem_ans2 FROM users WHERE email = '$input_email'";
        $r_qa = mysqli_query($link, $q_qa);

        $row = mysqli_fetch_assoc($r_qa);

        # Extract values into individual variables
        $db_mem_ques1 = $row['mem_ques1'];
        $db_mem_ans1 = $row['mem_ans1'];
        $db_mem_ques2 = $row['mem_ques2'];
        $db_mem_ans2 = $row['mem_ans2'];

        # If all the questions and answers are correct
        if ($db_mem_ques1 == $input_mem_ques1 &&
            $db_mem_ans1 == $input_mem_ans1 &&
            $db_mem_ques2 == $input_mem_ques2 &&
            $db_mem_ans2 == $input_mem_ans2) {
            # Details are correct
            $response = array('error' => false, 'message' => 'Details verified');
        } else {
            # Question and answer details are incorrect
            $response = array('error' => true, 'message' => 'Invalid memorable questions or answers');
        }
    } else {
        # Email is incorrect
        $response = array('error' => true, 'message' => "This email doesn't exist");
    }

    $responseString = print_r($response, true);
    error_log($responseString);

    # Close the database connection
    mysqli_close($link);

    # Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
?>