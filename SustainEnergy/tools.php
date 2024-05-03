<?php

    function loadUserId($email, $link)
    {
        # Retrieve items from users database table.
        $q = "SELECT user_id FROM users WHERE email = '$email'";
        $r = mysqli_query($link, $q);

        if ($r && mysqli_num_rows($r) > 0)
        {
            $row = mysqli_fetch_assoc($r);
            $user_id = $row['user_id'];
            echo "User ID fetched: " . $user_id . "<br>";
            return $user_id;
        } else {
            echo "Error fetching user ID: " . mysqli_error($link) . "<br>";
        }

        return false;
    }

    function changePassword($email, $new_password){
        require('connectDB.php');
    
        # Hash the new password
        $hP = password_hash($new_password, PASSWORD_DEFAULT);
    
        # SQL statement to update the password
        $q = "UPDATE users SET pass = '$hP' WHERE email = '$email'";
    
        # Execute the query
        $r = mysqli_query($link, $q);
    
        # Check if the query was successful
        if($r && mysqli_affected_rows($link) > 0) {
            mysqli_close($link);
            return true; # Password changed successfully
        } else {
            mysqli_close($link);
            return false; # Failed to change password
        }
    }

    function processPaymentAndSub($user_id, $card_num, $expiry, $CSV, $ch_name){
        require('connectDB.php');
    
        # Insert payment details
        $query_p = "INSERT INTO payment (user_id, card_num, expiry, CSV, ch_name)
                    VALUES ('$user_id', '$card_num', '$expiry', '$CSV', '$ch_name')";
        $result_p = mysqli_query($link, $query_p);
    
        # Check if the payment insertion was successful
        if ($result_p) {
            # Retrieve the card_id for the inserted payment record
            $card_id_q = "SELECT card_id FROM payment WHERE user_id = '$user_id'";
            $card_id_r = mysqli_query($link, $card_id_q);
    
            # Check if the card_id query was successful
            if ($card_id_r) {
                # Fetch the row from the result
                $row = mysqli_fetch_assoc($card_id_r);
                # Extract the card_id from the row
                $card_id = $row['card_id'];
            } else {
                # Error with the the card_id query
                return null;
            }
        } else {
            # Error with the payment insertion query
            return null;
        }

        # Create a subscription record for this user
        $query_s = "INSERT INTO subscription (user_id, card_id, date_of_sub, sub_ending)
            VALUES ('$user_id', '$card_id', NOW(), DATE_ADD(NOW(), INTERVAL 1 YEAR))";
        $result_s = mysqli_query($link, $query_s);    
        
        # Update sub_active field in the user table
        $query_update_user = "UPDATE users SET sub_active = 1 WHERE user_id = '$user_id'";
        $result_update_user = mysqli_query($link, $query_update_user);

        # Check if all queries were successful
        if ($result_s && $result_update_user) {
            return true;
        } else if ($result_s)  {
            # Error creating subscription record
            return null;
        } else {
            # Error updating sub status
            return null;
        }
    }

    function fetchUserDetails($link, $user_id){

        # Select user details
        $q = "SELECT * FROM users WHERE user_id = '$user_id'";
        $r = mysqli_query($link, $q);

        # Check if query was successful
        if($r) {
            # Fetch user details as an associative array
            $user_details = mysqli_fetch_assoc($r);
            # Free the result set
            mysqli_free_result($r);
            # Return the user details array
            return $user_details;
        } else {
            # Query failed, return null or handle error as needed
            return null;
        }
    }

    function sendContactForm ($link, $user_id, $subject, $comments){

        # Create a subscription record for this user
        $q = "INSERT INTO contact_us (user_id, subject, comments)
            VALUES ('$user_id', '$subject', '$comments')";
        $r = mysqli_query($link, $q); 

        if ($r) {
            # Purchase successful
            echo "<script>alert('Thank you for your time. We will get back to you as soon as possible.');</script>";
        } else {
            echo "<script>alert('Error submitting contact form. Please try again later.');</script>";
        }
    }

    function sendFeedbackForm ($link, $user_id, $rating, $comments){

        # Create a subscription record for this user
        $q = "INSERT INTO feedback (user_id, rating, comments)
            VALUES ('$user_id', '$rating', '$comments')";
        $r = mysqli_query($link, $q); 

        if ($r) {
            # Purchase successful
            echo "<script>alert('Thank you for your feedback. We are always aiming to improve and value your input as a valued user.');</script>";
        } else {
            echo "<script>alert('Error submitting feedback form. Please try again later.');</script>";
        }
    }

    function fetchFeedback($link){
        # Select feedback records
        $q = "SELECT * FROM feedback";
        $r = mysqli_query($link, $q);
    
        $feedbacks = array(); # Initialize an array to store all feedback records
    
        if($r){
            # Fetch feedback records as associative arrays and store them in $feedbacks array
            while($row = mysqli_fetch_assoc($r)) {
                # Extract user ID from feedback data
                $user_id = $row['user_id'];
                
                # Get the name of the user that left feedback
                $user_details = fetchUserDetails($link, $user_id);
    
                # Add user details to the current feedback record
                $row['first_name'] = $user_details['first_name'];
                $row['last_name'] = $user_details['last_name'];
    
                # Add the modified feedback record to the $feedbacks array
                $feedbacks[] = $row;
            }
    
            # Free the result set
            mysqli_free_result($r);
            
            # Return the array of feedback records
            return $feedbacks;
        } else {
            return null;
        }  
    }

    function fetchSubscriptionDetails($link, $user_id){

        # Select subscription record for user
        $q = "SELECT * FROM subscription WHERE user_id = '$user_id'";
        $r = mysqli_query($link, $q);

        if($r) {
            $sub_details = mysqli_fetch_assoc($r);

            return $sub_details;
        } else {
            return null;
        }
    }

    function validatePassword ($link, $user_id, $input_pass) {

        # Select password record
        $q = "SELECT pass FROM users WHERE user_id = '$user_id'";
        $r = mysqli_query($link, $q);

        # Check for errors during query execution
        if (!$r) {
            # Log the error
            error_log("MySQL Error: " . mysqli_error($link));
            return false;
        }

        if (@mysqli_num_rows($r) == 1) {
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
            $storedHashedPwd = trim($row['pass']);
            $tP = trim($input_pass);

            # Compare the hashed password from the database with the user input password.
            if (password_verify($tP, $storedHashedPwd)) {
                return true;
            } else {
                return false;
            }
        } else {
            # No matching user found
            return false;
        }
    }

    function updateAccountDetails($link, $user_id, $first_name, $last_name, $email, $org){
        # Update users record
        $q = "UPDATE users SET 
            first_name = '$first_name', 
            last_name = '$last_name', 
            email = '$email', 
            org = '$org' 
        WHERE user_id = '$user_id'";
        $r = mysqli_query($link, $q);

        # Check if the query was successful
        if ($r) {
            return true; # Updated successfully
        } else {
            # Query failed, handle error
            echo "Error updating record: " . mysqli_error($link);
            return false; # Failed to update
        }
    }

    function updatePaymentDetails($link, $user_id, $card_num, $expiry, $csv, $ch_name){
        # Update users record
        $q = "UPDATE payment SET 
            card_num = '$card_num', 
            expiry = '$expiry', 
            csv = '$csv', 
            ch_name = '$ch_name' 
        WHERE user_id = '$user_id'";
        $r = mysqli_query($link, $q);

        # Check if the query was successful
        if ($r) {
            return true; # Updated successfully
        } else {
            # Query failed, handle error
            echo "Error updating record: " . mysqli_error($link);
            return false; # Failed to update
        }
    }

    function fetchPaymentDetails($link, $user_id){

        # Select payment details for user
        $q = "SELECT * FROM payment WHERE user_id = '$user_id'";
        $r = mysqli_query($link, $q);

        if($r) {
            $payment_details = mysqli_fetch_assoc($r);

            return $payment_details;
        } else {
            return null;
        }
    }

    function deleteAccount($link, $user_id){

        # Delete users account
        $q = "DELETE FROM users WHERE user_id = '$user_id'";
        $r = mysqli_query($link, $q);

        # If the delete is successful
        if($r){
            return true;
        } else {
            return null;
        }
    }

    function addPoints($link, $user_id, $points){
        # Get current points of the user
        $q = "SELECT points FROM users WHERE user_id = '$user_id'";
        $r = mysqli_query($link, $q);

        if($r && mysqli_num_rows($r) > 0) {
            $row = mysqli_fetch_assoc($r);
            $current_points = $row['points'];

            # Calculate new points by adding the given points to current points
            $new_points = $current_points + $points;

            if($new_points > 100){
                $new_points = 100;
            }

            # Update points in the database
            $q = "UPDATE users SET points = '$new_points' WHERE user_id = '$user_id'";
            $r = mysqli_query($link, $q);

            # If query is successful
            if($r){
                return true;
            } else {
                return false; # Return false if update query fails
            }
        } else {
            return false; # Return false if user not found or query fails
        }
    }

    function purchasePoints($link, $user_id, $card_id, $num_points, $cost_points, $current_points){
        $q = "INSERT INTO purchase (user_id, card_id, points_purchased, total_cost)
              VALUES ('$user_id', '$card_id', '$num_points', '$cost_points')";
        $r = mysqli_query($link, $q);

        # Check if the insert query was successful
        if ($r) {
            # Update the points in the users table
            $new_points = $current_points + $num_points;

            if($new_points > 100){
                $new_points = 100;
            }

            $update_query = "UPDATE users SET points = '$new_points' WHERE user_id = '$user_id'";
            $update_result = mysqli_query($link, $update_query);

            # Check if the update query was successful
            if ($update_result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function fetchAllUsers($link){
        $q = "SELECT * FROM users";
        $r = mysqli_query($link, $q);
    
        $users = array(); # Initialize an array to store all users
    
        if($r){
            # Loop through the result set and fetch each row
            while($row = mysqli_fetch_assoc($r)){
                $users[] = $row; # Add each row to the $users array
            }
            return $users; # Return the array containing all users
        } else {
            return false;
        }
    }

    function fetchAllContactForms($link){
        $q = "SELECT * FROM contact_us";
        $r = mysqli_query($link, $q);
    
        $contact_forms = array(); # Initialize an array to store all submitted contact forms
    
        if($r){
            # Loop through the result set and fetch each row
            while($row = mysqli_fetch_assoc($r)){
                $contact_forms[] = $row; # Add each row to the $contact_forms array
            }
            return $contact_forms; # Return the array containing all contact forms
        } else {
            return false;
        }
    }

    function removeSub($link, $user_id){
        # Update subscription status in the users table
        $q = "UPDATE users SET sub_active = '0', points = '0' WHERE user_id = '$user_id'";
        $r = mysqli_query($link, $q);

        if($r){
            # Delete this users subscription record and payment details from the subscription table
            $q = "DELETE FROM subscription WHERE user_id = '$user_id'";
            $q .= "DELETE FROM payment WHERE user_id='$user_id'";
            $r = mysqli_query($link, $q);

            if($r){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function giveSub($link, $user_id){
        # Update subscription status in the users table
        $q = "UPDATE users SET sub_active = '1' WHERE user_id = '$user_id'";
        $r = mysqli_query($link, $q);
    
        if($r){
            $q = "SELECT card_id FROM payment WHERE user_id = '$user_id'";
            $r = mysqli_query($link, $q);
    
            if($r) {
                # Fetch the row from the result set
                $row = mysqli_fetch_assoc($r);
                
                # Check if a row was retrieved
                if($row) {
                    # Retrieve the card_id from the fetched row
                    $card_id = $row['card_id'];
    
                    # Create a subscription record for this user
                    $q = "INSERT INTO subscription (user_id, card_id, date_of_sub, sub_ending)
                    VALUES ('$user_id', '$card_id', NOW(), DATE_ADD(NOW(), INTERVAL 1 YEAR))";
                    $r = mysqli_query($link, $q);

                    if($r){
                        return true;
                    } else {
                        return "Failed creating subscription record.";
                    }
                }
            } else {
                return "User must have a saved payment method to give subscription.";
            }   
        } return "Failed to update users subscription status.";
    }

    function suspendAccount($link, $user_id){
        # Update account status in the users table
        $q = "UPDATE users SET account_status = 'Suspended' WHERE user_id = '$user_id'";
        $r = mysqli_query($link, $q);

        if($r){
            return true;
        } else {
            return false;
        }
    }

    function reinstateAccount($link, $user_id){
         # Update account status in the users table
         $q = "UPDATE users SET account_status = 'Active' WHERE user_id = '$user_id'";
         $r = mysqli_query($link, $q);
 
         if($r){
             return true;
         } else {
             return false;
         }
    }
?>