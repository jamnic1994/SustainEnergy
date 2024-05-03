<?php
  session_start();

  # Redirect if not logged in.
  if ( !isset( $_SESSION[ 'user_id' ] ) ) { require ( 'login_tools.php' ) ; load() ; }
  
  # Open database connection.
  require('ConnectDB.php');

  require('tools.php');

  $user_data = fetchUserDetails($link, $_SESSION['user_id']);

  # Get account details for the tables
  if($user_data) {

    $user_id = $user_data['user_id'];
    $first_name = $user_data['first_name'];
    $last_name = $user_data['last_name'];
    $email = $user_data['email'];
    $org = $user_data['org'];
    $reg_date = $user_data['reg_date'];

    # Format register date 
    $reg_day = substr($reg_date, 8,2);
    $reg_month = substr($reg_date, 5,2);
    $reg_year = substr($reg_date, 0,4);

    $points = $user_data['points'];
    $award = $user_data['award'];

    $points_to_purchase = 100 - $points;
    $cost_of_points = $points_to_purchase * 100;

    if ($award == null){
      $award = "None Achieved";
    }
    
    # Translate the 1 or 0 output from the database into a true and false
    if($user_data['sub_active'] == 0){
      $sub_status = "No Subscription";
    } else {
      $sub_status = "Basic Subscription Active";
    }

    $sub_details = fetchSubscriptionDetails($link, $user_id);
    
    # If subscription details are available then load them into variables
    if($sub_details != null){

      $sub_date = $sub_details['date_of_sub'];
      $sub_ending = $sub_details['sub_ending'];

      # Format subscription dates 
      $sub_day = substr($sub_date, 8,2);
      $sub_month = substr($sub_date, 5,2);
      $sub_year = substr($sub_date, 0,4);
      
      # Format renewal dates
      $ending_day = substr($sub_ending, 8,2);
      $ending_month = substr($sub_ending, 5,2);
      $ending_year = substr($sub_ending, 0,4);

      # Fetch payment details for user
      $payment_details = fetchPaymentDetails($link, $user_id);    

      # If payment details are available then load them into variables
      if($payment_details != null){

        $card_id = $payment_details['card_id'];
        $card_num = $payment_details['card_num'];
        $sub_card_num = substr($card_num,-4);


        $expiry = $payment_details['expiry'];
        $csv = $payment_details['csv'];
        $ch_name = $payment_details['ch_name'];

      }
    }

  } else {
    echo '<script>alert("Unable to fetch user data, please try again later.")</script>';
  }

  # Define thresholds for bronze, silver, and gold for progress bars
  $bronze_threshold = 50;
  $silver_threshold = 75;
  $gold_threshold = 100;

  // Calculate widths for each progress bar then round to the nearest integer
  $bronze_width = round(($points / $bronze_threshold) * 100);
  $silver_width = round(($points / $silver_threshold) * 100);
  $gold_width = round(($points / $gold_threshold) * 100);

  # If a form has been submitted
  if ($_SERVER["REQUEST_METHOD"] === "POST") {

    # Check which form was submitted based on the value of the hidden input field
    if ($_POST['form_type'] === 'details_form') {

      # Load data from the form into variables
      $new_f_name = $_POST['first_name']; 
      $new_l_name = $_POST['last_name']; 
      $new_email = $_POST['email']; 
      $new_org = $_POST['org']; 
      
      # Call updateAccountDetails function with new data
      $update_account_details = updateAccountDetails($link, $user_id, $new_f_name, $new_l_name, $new_email, $new_org);
      
      # Interpret results from function call
      if ($update_account_details = true){

        # If the change is successful
        echo "<script>alert('Account details changed successfully.');</script>";
        header("Refresh:0");
      } else {
        # If there has been an error alert the user
        echo "<script>alert('Error changing account details, please try again later. If this issue persists please inform us through the contact form on the contact us page.');</script>";
      }
    # If the user wants to change their password
    } else if ($_POST['form_type'] === 'password_form') {

      # Load data from the form into variables
      $pass = $_POST['old_pass'];
      $new_pass = $_POST['new_pass1'];
      
      # Check that the old password is valid
      $pass_valid = validatePassword($link, $user_id, $pass);

      # Interpret the validation
      if ($pass_valid == true){

        # If validation is successful then call the changePassword function  
        $password_change = changePassword($email, $new_pass);

        # Interpret the results from function call
        if($password_change == true){

          # Successful change
          echo "<script>alert('Password changed successfully.');</script>";

        } else {
          # Alert the user of an error changing their password
          echo "<script>alert('Password change failed, please try again later. If this issue persists please inform us through the contact form on the contact us page.');</script>";
        }
      } else {
        # The user has entered their current password wrong
        echo "<script>alert('Password change failed. Your password is wrong.');</script>";
      }
    # If the user wants to change their payment details
    } else if ($_POST['form_type'] === 'payment_form') {
      
      # Load data from the form into variables
      $new_card_num = $_POST['new_card_num'];
      $new_expiry = $_POST['new_expiry'];
      $new_csv = $_POST['new_csv'];
      $new_ch_name = $_POST['new_ch_name'];

      # Call the function from tools.php to change the password
      $payment_update = updatePaymentDetails($link, $user_id, $new_card_num, $new_expiry, $new_csv, $new_ch_name);

      # If the payment details update was successful alert the user and refresh the page to show the new details
      if ($payment_update == true){
        
        echo "<script>alert('Payment details update successful.');</script>";
        header("Refresh:0");
      
      # If there has been an error then alert the user 
      } else {

        echo "<script>alert('Payment details update failed, please try again later. If this issue persists please inform us through the contact form on the contact us page.');</script>";
      }
    
    # Logic to delete the users account if requested
    } else if ($_POST['form_type'] === 'delete_account') {

      # Call the delete account function from tools.php
      deleteAccount($link, $user_id);
      header("Refresh:0");
      echo "<script>alert('Account deleted successfully');</script>";
      
      # Destroy session to log out
      session_destroy();
    
    # Logic to allow the user to add points to their account
    } else if ($_POST['form_type'] === 'points_form'){
      
      # All of the users input for the various sustainability efforts they have engaged in
      $meth1 = $_POST['carbon_reduction'];
      $meth2 = $_POST['renewable_energy'];
      $meth3 = $_POST['waste_reduction'];
      $meth4 = $_POST['water_conservation'];
      $meth5 = $_POST['transport_sustainability'];
      $meth6 = $_POST['sustainable_packaging'];
      $meth7 = $_POST['community_engagement'];
      $meth8 = $_POST['ee_infrastructure'];
      $meth9 = $_POST['eco_products_services'];
      $meth10 = $_POST['carbon_offset'];
      
      # Total their points
      $total_points = $meth1 + $meth2 + $meth3 + $meth4 + $meth5 + $meth6 + $meth7 + $meth8 + $meth9 + $meth10;
      
      # Call the function from tools.php to add the points to their account
      $add_points = addPoints($link, $user_id, $total_points);

      # If successful, inform the user and refresh the page to update the progress bars + show the new points tally 
      if($add_points == true){

        echo "<script>alert('Points added successfully. You can use the form below to purchase any points that may be outstanding.');</script>";
        header("refresh:0");
      } else {
        # If there was an error inform the user
        echo "<script>alert('Error occurred when adding points. Please try again later or if the issue persists contact us through the contact form available on the contact page.');</script>";
      }
    # If the user wants to purchase points
    } else if ($_POST['form_type'] === 'purchase_form'){

      # Load the csv input from the form for payment validation
      $input_csv = $_POST['purchase_csv'];

      # If the csv matches
      if($input_csv == $csv) {

        # Call the purchase points function from tools.php
        $points_purchase = purchasePoints($link, $user_id, $card_id, $points_to_purchase, $cost_of_points, $points);

        # If successful, inform the user and refresh the page to update the progress bars + show the new points tally 
        if($points_purchase == true){
          echo "<script>alert('Purchase successful.');</script>";
          header("refresh:0");
        
        # If there was an error with the purchase inform the user
        } else {
          echo "<script>alert('Purchase failed. Please try again later.');</script>";
        }
      # If the CSV values do not match inform the user
      } else {
        echo "<script>alert('Purchase stopped. The CSV you input doesn't match the one on record do not match.');</script>";
      }
    }
  }
  
  # Close the database connection
  mysqli_close($link);

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My Account</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="main_styles.css">
</head>

<body>

  <div id="page-container">

    <div id="content_wrap">

      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
        <a class="navbar-brand" href="home.php">
          <img src="img/navbar_logo.png" alt="logo" style="width: 100px; height: auto;">
        </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <?php if ($_SESSION['role'] == "admin") { ?>

                  <a class="nav-link" href="admin.php">Admin Panel</a>

                <?php } ?>
              </li>
            </ul>

            <h1>SustainEnergy</h1>

            <ul class="navbar-nav ms-auto">
              <li class="nav-item">

                <a class="nav-link" href="account.php"><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?></a>

              </li>

              <form action="logout.php" method="post" >
                <button type="submit" class="btn btn-danger">Logout</button>
              </form>

            </ul>  
          </div>
        </div>
      </nav>
      <!-- End of Navbar -->

      <!-- Main Page Content -->

      <!-- Header -->
      <div class="container p-4 col-md-5">
        <div class="card text-black shadow" style="text-align: center; border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">  
            <h1 style="padding-top: 2%">My Account</h1>
        </div>
      </div>
      <!-- End of Header -->

      <!-- Account Details Table -->
      <div class="container pt-2">
        <div class="row justify-content-center">

          <div class="col-md-6">
              <div class="card text-black p-4 shadow" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">
                <h1>Account Details:</h1>
                <hr style='border-top: 2px dotted #000;'>

                <table class="table table-hover table-borderless">
                  <tbody>

                    <tr>
                      <th scope="row">User ID:</th>
                      <td class="text-right"><?php echo $user_id ?></td>
                    </tr>

                    <tr>
                      <th scope="row">First Name:</th>
                      <td class="text-right"><?php echo $first_name ?></td>
                    </tr>

                    <tr>
                      <th scope="row">Last Name:</th>
                      <td class="text-right"><?php echo $last_name ?></td>
                    </tr>

                    <tr>
                      <th scope="row">Email: </th>
                      <td class="text-right"><?php echo $email ?></td>
                    </tr>

                    <tr>
                      <th scope="row">Organisation: </th>
                      <td class="text-right"><?php echo $org ?></td>
                    </tr>

                    <tr>
                      <th scope="row">Date of Registration: </th>
                      <td class="text-right"><?php echo $reg_day . '/' . $reg_month . '/' . $reg_year ?></td>
                    </tr>

                    <tr>
                      <th scope="row">Subscription Status: </th>
                      <td class="text-right"><?php echo $sub_status ?></td>
                    </tr>

                    <?php
                      if($sub_status == "Basic Subscription Active") { ?>

                        <tr>
                          <th scope="row">Date of Subscription: </th>
                          <td class="text-right"><?php echo $sub_day . '/' . $sub_month . '/' . $sub_year ?></td>
                        </tr>

                        <tr>
                          <th scope="row">Subscription Renewal Date: </th>
                          <td class="text-right"><?php echo $ending_day . '/' . $ending_month . '/' . $ending_year ?></td>
                        </tr>

                    <?php } ?>
                
                  </tbody>
                </table>

                <button class="btn btn-sm btn-primary mt-1" onclick="openDetailsForm(); closePasswordForm(); closePaymentForm(); closePointsForm()">Change Account Details</button>
                
                <!-- Delete the users account -->
                <form action="account.php" method="post" class="pt-1">

                  <input type="hidden" name="form_type" value="delete_account">

                  <!-- Add a checkbox for confirmation -->
                  <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="confirmDelete" required>
                      <label class="form-check-label" for="confirmDelete">
                          I confirm that I want to delete my account.
                      </label>
                  </div>

                  <button type="submit" class="btn btn-danger mt-2 col-md-12">Delete Account</button>
                </form>
                <!-- End Delete Users Account -->

                <hr style='border-top: 2px dotted #000;'>
                
                <!-- Password Section -->
                <table class="table table-hover table-borderless">
                  <tbody>

                    <tr>
                      <th scope="row">Password:</th>
                      <td class="text-right">
                          <div class="d-flex flex-column align-items-end">
                              <span>***********</span>
                          </div>
                      </td>
                    </tr>

                  </tbody>
                </table>

                <button class="btn btn-sm btn-primary mt-1 col-md-12" onclick="openPasswordForm(); closeDetailsForm(); closePaymentForm(); closePointsForm()">Change Password</button>
                <!-- End of Password Section -->

              </div>
          </div>
          <!-- End of Account Details Table -->

          <!-- Payment details Table -->
          <div class="col-md-6">
              <div class="card text-black p-4 shadow" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">
                <h1>Payment Details:</h1>

                <hr style='border-top: 2px dotted #000;'>
                
                <!-- If the user doesn't have a subscription then give them the option to sign up -->
                <?php
                  if($sub_status == "No Subscription") { ?>

                    <h4 class="mb-4">You have no subcription. Click below if you would like to start a new subscription and save a payment method.</h4>
                    <a class="btn btn-primary" href="payment.php" role="button">Start Subscription</a>
                  
                  <!-- If the user does have a subscription and a payment method saved then output their details -->
            <?php } else { ?>

                      <table class="table table-hover table-borderless">
                        <tbody>

                          <tr>
                            <th scope="row">Card Holder:</th>
                            <td class="text-right"><?php echo $ch_name ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Card Number:</th>
                            <td class="text-right"><?php echo "**** **** **** " . $sub_card_num ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Expiry:</th>
                            <td class="text-right"><?php echo $expiry ?></td>
                          </tr>

                        </tbody>
                      </table>

                    <button class="btn btn-sm btn-primary mt-1" onclick="openPaymentForm(); closeDetailsForm(); closePasswordForm(); closePointsForm()">Change Payment Details</button>

            <?php } ?>

              </div>
              <br>
              <!-- End of Payment Details table -->

              <!-- Points and Awards Interface -->
              <div class="card text-black p-4 shadow" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">

                <h1>Points and Awards:</h1>
                <hr style='border-top: 2px dotted #000;'>

                <!-- If the user doesn't have a subscription then point them to the button above -->
                <?php if($sub_status == "No Subscription") { ?>

                  <h4 class="mb-4">Start a basic subscription above to start earning points and awards!</h4>
                
                <!-- If the user has a subscription then output the details -->
                <?php } else { ?>

                  <table class="table table-hover table-borderless">
                    <tbody>

                      <tr>
                        <th scope="row">Points:</th>
                        <td class="text-right">
                            <div class="d-flex flex-column align-items-end">
                                <span><?php echo $points ?></span>
                            </div>
                        </td>
                      </tr>

                      <tr>
                        <th scope="row">Award Achieved:</th>
                        <td class="text-right">
                            <div class="d-flex flex-column align-items-end">
                                <span><?php echo $award ?></span>
                            </div>
                        </td>
                      </tr>

                      <!-- Output for bronze, with certificate link -->
                      <?php if ($award == "Bronze") { ?>

                              <tr>
                                <th scope="row">View Certificate:</th>
                                <td class="text-right">
                                    <div class="d-flex flex-column align-items-end">
                                      <div class="d-flex flex-column align-items-end">
                                        <a style="color: #343a40;" href="bronze.php">View Bronze Certificate</a>
                                      </div>
                                    </div>
                                </td>
                              </tr> 

                      <!-- Output for silver, with certificate link -->  
                      <?php } else if ($award == "Silver") { ?>

                              <tr>
                                <th scope="row">View Certificate:</th>
                                <td class="text-right">
                                  <div class="d-flex flex-column align-items-end">
                                    <a style="color: #343a40;" href="silver.php">View Silver Certificate</a>
                                  </div>
                                </td>
                              </tr> 

                      <!-- Output for gold, with certificate link -->  
                      <?php } else if ($award == "Gold") { ?>

                              <tr>
                                <th scope="row">View Certificate:</th>
                                <td class="text-right">
                                    <div class="d-flex flex-column align-items-end">
                                      <a style="color: #343a40;" href="gold.php">View Gold Certificate</a>
                                    </div>
                                </td>
                              </tr>

                      <?php } ?>

                    </tbody>
                  </table>
                    
                    <!-- Progress Bars -->
                    <h2>Progress to Bronze:</h2>
                    <div class="progress shadow">
                      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $points ?>" aria-valuemin="0" aria-valuemax="50" style="width: <?php echo $bronze_width ?>%; background-color: #CD7F32"><?php if($bronze_width <= 100){echo $bronze_width . "%";} else {echo "100%";}?></div>
                    </div>

                    <h2 class="pt-2">Progress to Silver:</h2>
                    <div class="progress shadow">
                      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $points ?>" aria-valuemin="0" aria-valuemax="75" style="width: <?php echo $silver_width ?>%; background-color: #C0C0C0"><?php if($silver_width <= 100){echo $silver_width . "%";} else {echo "100%";}?></div>
                    </div>

                    <h2 class="pt-2">Progress to Gold:</h2>                      
                    <div class="progress shadow">
                      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $points ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $gold_width ?>%; background-color: #FFD700"><?php if($gold_width <= 100){echo $gold_width . "%";} else {echo "100%";}?></div>
                    </div>
                    <!-- End of Progress Bars -->

                    <button class="btn btn-sm btn-primary mt-3" onclick="openPointsForm(); closeDetailsForm(); closePasswordForm(); closePaymentForm()">Add Points</button>

            <?php } ?> 
              <!-- End of Points and Awards Interface -->

          </div>
          

        </div>
      </div>
      

    </div>
    </div>
    <!-- End of Main Page Content -->

    <!-- Hidden pop-up forms -->

    <!-- Update Account Details -->
    <div class=" card form-popup shadow" id="details_form" style="border-radius: 10px; background-color: #BFD8D8">
      
      <form action="account.php" class="form-container p-3" method="post">

        <h1>Change Account Details</h1>
        <hr style='border-top: 2px dotted #000;'>

        <div class="form-group">
          <label for="first_name">First Name:</label>
          <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $first_name ?>" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $last_name ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email ?>" required>
            <div id="emailError" class="text-danger"></div>
        </div>

        <div class="form-group">
            <label for="org">Organisation:</label>
            <input type="text" class="form-control" id="org" name="org" value="<?php echo $org ?>" required>
            <div id="orgError" class="text-danger"></div>
        </div>
        
        <input type="hidden" name="form_type" value="details_form">
        
        <div style="display: flex; justify-content: left">
          <button type="submit" class="btn btn-primary" onclick="return validateDetailsForm()">Submit</button>
        
      </form>

          <button type="button" class="btn btn-danger ml-1" onclick="closeDetailsForm()">Close</button>
      </div>
    </div>
    <!-- End of Account Details Form -->

    <!-- Update Password Form -->
    <div class="card form-popup shadow col-md-4" id="password_form" style="border-radius: 10px; background-color: #BFD8D8">

      <form action="account.php" class="form-container p-3" method="post">

        <h1>Change Password</h1>

        <hr style='border-top: 2px dotted #000;'>

          <label for="old_pass"><b>Enter your old password: </b></label>
          <input type="text" placeholder="Old Password" name="old_pass" id="old_pass" required>

        <hr style='border-top: 2px dotted #000;'>

          <label for="new_pass1"><b>New password:</b></label>
          <input type="password" placeholder="Enter New Password" name="new_pass1" id="new_pass1" required>

          <label for="new_pass2"><b>Confirm new password:</b></label>
          <input type="password" placeholder="Confirm New Password" name="new_pass2" id="new_pass2" required>

        <input type="hidden" name="form_type" value="password_form">

        <div class="pt-2" style="display: flex; justify-content: left">
          <button type="submit" class="btn btn-primary" onclick="passwordsMatch()">Submit</button>

      </form>

          <button type="button" class="btn btn-danger ml-1" onclick="closePasswordForm()">Close</button>
        </div>

    </div>
    </div>
    <!-- End of Update Password Form -->

    <!-- Change Payment Details -->
    <div class="card form-popup shadow col-md-4" id="payment_form" style="border-radius: 10px; background-color: #BFD8D8">

      <form action="account.php" class="form-container p-3" method="post">

        <h1>Change Payment Details</h1>

        <hr style='border-top: 2px dotted #000;'>

          <label for="new_card_num"><b>Enter your new card Number: </b></label>
          <input type="text" placeholder="New Card Number" name="new_card_num" id="new_card_num" required>

          <label for="new_expiry"><b>New Expiry Date:</b></label>
          <input type="text" placeholder="MM/YY" name="new_expiry" id="new_expiry" required>

          <label for="new_csv"><b>New CSV number:</b></label>
          <input type="text" placeholder="New CSV Number" name="new_csv" id="new_csv" required>

          <label for="new_ch_name"><b>New Cardholder Name:</b></label>
          <input type="text" placeholder="New Cardholder Name" name="new_ch_name" id="new_ch_name" required>

        <hr style='border-top: 2px dotted #000;'>

        <input type="hidden" name="form_type" value="payment_form">

        <div style="display: flex; justify-content: left">
          <button type="submit" class="btn btn-primary" onclick="validatePaymentForm()">Submit</button>

      </form>

      <button type="button" class="btn btn-danger ml-1" onclick="closePaymentForm()">Close</button>

      </div>
    </div>
    <!-- End of Change Payment Details -->

    <!-- Points Interface -->
    <div class="card form-popup shadow col-md-4 pb-2" id="points_form" style="border-radius: 10px; background-color: #BFD8D8">
      <div class="scrollable-content">
        
        <!-- Add Points Section -->
        <div class="d-flex justify-content-between align-items-center">
          <h1 class="mx-2">Add Points:</h1>
          
          <button class="btn btn-secondary mx-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContainerAdd" aria-expanded="true" aria-controls="collapseContainerAdd">
              Expand
          </button>           
        </div>
        <hr style='border-top: 2px dotted #000;'>
        
        <!-- If the user still has points to earn then output the green calculator -->
        <?php if ($points < 100) { ?>
          <form action="account.php" class="form-container p-3" method="post">

            <div class="collapse" id="collapseContainerAdd">
            
            <p>
              You must gauge your organisations improvement in the ten outlined 
              areas over the past year. No improvement
              ges you 0pts, for 5% improvement you gain 5pts, and 
              for 10% improvement you gain 10pts.
            </p>
              
            <!-- Green Calculator -->
            <table class="table table-hover table-borderless">
              
              <!-- Header for the table -->
              <thead>
                <tr>
                  <th scope="col">Action</th>
                  <th scope="col" style="color: red;">0%</th>
                  <th scope="col" style="color: orange;">5%</th>
                  <th scope="col" style="color: green;">10%</th>
                </tr>
              </thead>
              <!-- End of the table header -->

              <!-- Body of the table -->
              <tbody>
                
                <!-- First Method -->
                <tr>
                  <th scope="row">1. Carbon Emissions Reduction: </th>
                  <td>
                    <input type="radio" class="btn-check" name="carbon_reduction" id="cr_no_improvement" value="0">
                    <label class="btn btn-outline-danger" for="cr_no_improvement"></label>
                  </td>
                  <td>
                    <input type="radio" class="btn-check" name="carbon_reduction" id="cr_slight_improvement" value="5" style="background-color: #FF8C42">
                    <label class="btn btn-outline-warning" for="cr_slight_improvement"></label>
                  </td>
                  <td>
                    <input type="radio" class="btn-check" name="carbon_reduction" id="cr_good_improvement" value="10">
                    <label class="btn btn-outline-success" for="cr_good_improvement"></label>
                  </td>
                </tr>
                <!-- End of First Method -->

                <!-- Second Method -->
                <tr>
                  <th scope="row">2. Renewable Energy Usage: </th>
                  <td>
                    <input type="radio" class="btn-check" name="renewable_energy" id="reu_no_improvement" value="0">
                    <label class="btn btn-outline-danger" for="reu_no_improvement"></label>
                  </td>
                  <td>
                    <input type="radio" class="btn-check" name="renewable_energy" id="reu_slight_improvement" value="5">
                    <label class="btn btn-outline-warning" for="reu_slight_improvement"></label>
                  </td>
                  <td>
                    <input type="radio" class="btn-check" name="renewable_energy" id="reu_good_improvement" value="10">
                    <label class="btn btn-outline-success" for="reu_good_improvement"></label>
                  </td>
                </tr>
                <!-- End of Second Method -->

                <!-- Third Method -->
                <tr>
                  <th scope="row">3. Waste Reduction: </th>
                  <td>
                    <input type="radio" class="btn-check" name="waste_reduction" id="wr_no_improvement" value="0">
                    <label class="btn btn-outline-danger" for="wr_no_improvement"></label>
                  </td>
                  <td>
                    <input type="radio" class="btn-check" name="waste_reduction" id="wr_slight_improvement" value="5">
                    <label class="btn btn-outline-warning" for="wr_slight_improvement"></label>
                  </td>
                  <td>
                    <input type="radio" class="btn-check" name="waste_reduction" id="wr_good_improvement" value="10">
                    <label class="btn btn-outline-success" for="wr_good_improvement"></label>
                  </td>
                </tr>
                <!-- End of Third Method -->

                <!-- Fourth Method -->
                <tr>
                  <th scope="row">4. Water Conservation: </th>
                  <td>
                    <input type="radio" class="btn-check" name="water_conservation" id="wc_no_improvement" value="0">
                    <label class="btn btn-outline-danger" for="wc_no_improvement"></label>
                  </td>
                  <td>
                    <input type="radio" class="btn-check" name="water_conservation" id="wc_slight_improvement" value="5">
                    <label class="btn btn-outline-warning" for="wc_slight_improvement"></label>
                  </td>
                  <td>
                    <input type="radio" class="btn-check" name="water_conservation" id="wc_good_improvement" value="10">
                    <label class="btn btn-outline-success" for="wc_good_improvement"></label>
                  </td>
                </tr>
                <!-- End of Fourth Method -->

                <!-- Fifth Method -->
                <tr>
                  <th scope="row">5. Transportation Sustainability: </th>
                  <td>
                    <input type="radio" class="btn-check" name="transport_sustainability" id="ts_no_improvement" value="0">
                    <label class="btn btn-outline-danger" for="ts_no_improvement"></label>
                  </td>
                  <td>
                    <input type="radio" class="btn-check" name="transport_sustainability" id="ts_slight_improvement" value="5">
                    <label class="btn btn-outline-warning" for="ts_slight_improvement"></label>
                  </td>
                  <td>
                    <input type="radio" class="btn-check" name="transport_sustainability" id="ts_good_improvement" value="10">
                    <label class="btn btn-outline-success" for="ts_good_improvement"></label>
                  </td>
                </tr>
                <!-- End of Fifth Method -->

                <!-- Sixth Method -->
                <tr>
                  <th scope="row">6. Sustainable Packaging: </th>
                  <td>
                    <input type="radio" class="btn-check" name="sustainable_packaging" id="sp_no_improvement" value="0">
                    <label class="btn btn-outline-danger" for="sp_no_improvement"></label>
                  </td>
                  <td>
                    <input type="radio" class="btn-check" name="sustainable_packaging" id="sp_slight_improvement" value="5">
                    <label class="btn btn-outline-warning" for="sp_slight_improvement"></label>
                  </td>
                  <td>
                    <input type="radio" class="btn-check" name="sustainable_packaging" id="sp_good_improvement" value="10">
                    <label class="btn btn-outline-success" for="sp_good_improvement"></label>
                  </td>
                </tr>
                <!-- End of Sixth Method -->

                <!-- Seventh Method -->
                <tr>
                  <th scope="row">7. Community Engagement: </th>
                  <td>
                    <input type="radio" class="btn-check" name="community_engagement" id="ce_no_improvement" value="0">
                    <label class="btn btn-outline-danger" for="ce_no_improvement"></label>
                  </td>
                  <td>
                    <input type="radio" class="btn-check" name="community_engagement" id="ce_slight_improvement" value="5">
                    <label class="btn btn-outline-warning" for="ce_slight_improvement"></label>
                  </td>
                  <td>
                    <input type="radio" class="btn-check" name="community_engagement" id="ce_good_improvement" value="10">
                    <label class="btn btn-outline-success" for="ce_good_improvement"></label>
                  </td>
                </tr>
                <!-- End of Seventh Method -->

                <!-- Eighth Method -->
                <tr>
                  <th scope="row">8. Energy-Efficient Infrastructure: </th>
                  <td>
                    <input type="radio" class="btn-check" name="e_e_infrastructure" id="eei_no_improvement" value="0">
                    <label class="btn btn-outline-danger" for="eei_no_improvement"></label>
                  </td>
                  <td>
                    <input type="radio" class="btn-check" name="e_e_infrastructure" id="eei_slight_improvement" value="5">
                    <label class="btn btn-outline-warning" for="eei_slight_improvement"></label>
                  </td>
                  <td>
                    <input type="radio" class="btn-check" name="e_e_infrastructure" id="eei_good_improvement" value="10">
                    <label class="btn btn-outline-success" for="eei_good_improvement"></label>
                  </td>
                </tr>
                <!-- End of Eighth Method -->

                <!-- Ninth Method -->
                <tr>
                  <th scope="row">9.  Eco-friendly Products/Services: </th>
                  <td>
                    <input type="radio" class="btn-check" name="eco_products_services" id="efps_no_improvement" value="0">
                    <label class="btn btn-outline-danger" for="efps_no_improvement"></label>
                  </td>
                  <td>
                    <input type="radio" class="btn-check" name="eco_products_services" id="efps_slight_improvement" value="5">
                    <label class="btn btn-outline-warning" for="efps_slight_improvement"></label>
                  </td>
                  <td>
                    <input type="radio" class="btn-check" name="eco_products_services" id="efps_good_improvement" value="10">
                    <label class="btn btn-outline-success" for="efps_good_improvement"></label>
                  </td>
                </tr>
                <!-- End of Ninth Method -->

                <!-- Tenth Method -->
                <tr>
                  <th scope="row">10. Carbon Offsetting: </th>
                  <td>
                    <input type="radio" class="btn-check" name="carbon_offset" id="co_no_improvement" value="0">
                    <label class="btn btn-outline-danger" for="co_no_improvement"></label>
                  </td>
                  <td>
                    <input type="radio" class="btn-check" name="carbon_offset" id="co_slight_improvement" value="5">
                    <label class="btn btn-outline-warning" for="co_slight_improvement"></label>
                  </td>
                  <td>
                    <input type="radio" class="btn-check" name="carbon_offset" id="co_good_improvement" value="10">
                    <label class="btn btn-outline-success" for="co_good_improvement"></label>
                  </td>
                </tr>
                <!-- End of Tenth Method -->

                <!-- Output for the total from the calculator -->
                <tr>
                  <th scope="row">Total:</th>
                  <td></td>
                  <td></td>
                  <td id="total_points" class="text-right"></td>
                </tr>
                <!-- End of output -->

              </tbody>
              <!-- End of table body -->
            </table>
            <!-- End of Green Calculator -->

            <input type="hidden" name="form_type" value="points_form">
            
            <button type="submit" class="btn btn-primary col-md-12">Submit</button>
            
          </form>
          <hr style='border-top: 2px dotted #000;'>
        </div>
        <!-- If the user already has 100 points -->
        <?php } else { ?>

          <div class="collapse" id="collapseContainerAdd">
            <h2>Congratulations, you already have full points.</h2>
            <hr style='border-top: 2px dotted #000;'>
          </div>
        <?php } ?>
        <!-- End of Add Points Section -->

        <!-- Purchase Points Section -->
        <div class="d-flex justify-content-between align-items-center">
          <h1 class="mx-2">Purchase Points:</h1>
          <button class="btn btn-secondary mx-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContainerBuy" aria-expanded="true" aria-controls="collapseContainerBuy">
              Expand
          </button>           
        </div>

        <hr style='border-top: 2px dotted #000;'>
        
        <!-- If the user needs more points then they can purchase -->
        <?php if($points < 100) { ?>
          
          <div class="collapse" id="collapseContainerBuy">
            <table class="table table-hover table-borderless">
              <tbody>

                <!-- Number of points the user still needs -->
                <tr>
                  <th scope="row">Points left to acquire: </th>
                  <td class="text-right">
                    <?php echo "$points_to_purchase" ?>
                  </td>
                </tr>

                <!-- The total cost of the points the user needs -->
                <tr>
                  <th scope="row">Cost of points (1pt = £100):</th>
                  <td class="text-right">
                    <?php echo "£$cost_of_points" ?>
                  </td>
                </tr>

                  <!-- Form to take the users CSV for validation -->
                  <form action="account.php" class="form-container p-3" method="post">
                    <tr>
                      <th scope="row">Please enter CSV for card ending <?php echo "$sub_card_num" ?>:</th>
                      <td class="text-right">
                        <input type="text" placeholder="CSV" name="purchase_csv" id="purchase_csv" maxlength="3" required>
                      </td>
                    </tr>
                    <input type="hidden" name="form_type" value="purchase_form">
                </tbody>
              </table>

                    <!-- Check box as a confirmation of purchase -->
                    <div class="form-check pb-2">
                        <input class="form-check-input" type="checkbox" id="confirm_purchase" required>
                        <label class="form-check-label" for="confirm_purchase">
                            I confirm that I wish to purchase the number of points shown above at the listed price.
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary col-md-12">Submit</button>
                  </form>

            <hr style='border-top: 2px dotted #000;'>
          </div>
          <!-- If the user already has full points -->
        <?php } else { ?>

                <div class="collapse" id="collapseContainerBuy">
                  <h2>Congratulations, you already have full points.</h2>
                  <hr style='border-top: 2px dotted #000;'>
                </div>
      
        <?php } ?>


        <!-- End of Purchase Points Section -->

        <button type="button" class="btn btn-danger" onclick="closePointsForm()">Close</button>
      </div>
    </div>
    <!-- End of Points Interface -->

    <!-- End of hidden pop-ups -->

    <!-- Footer -->
    <br>
    <footer id="footer" class="text-dark py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8">
                                <p>Endorsed by:</p>
                            </div>
                        </div>
                        <!-- Carousel -->
                        <div id="carouselControls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="img/climate_coalition_logo.png" class="d-block carousel-img" alt="Image 1">
                                </div>
                                <div class="carousel-item">
                                    <img src="img/Edinburgh_College_logo.png" class="d-block carousel-img" alt="Image 2">
                                </div>
                                <div class="carousel-item">
                                    <img src="img/Unesco.png" class="d-block carousel-img" alt="Image 3">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
                
              <div class="col-md-6 text-right p-4">
                <div class="d-inline-flex">
                    <!-- About Us Link -->
                    <h5 class="mb-0"><a href="about_us.php" class="black-link">About Us</a></h5>
                    <!-- Separator -->
                    <span class="mx-2">|</span>
                    <!-- Privacy Statement Link -->
                    <h5 class="mb-0"><a href="privacy_statement.php" class="black-link">Privacy Statement</a></h5>
                    <!-- Separator -->
                    <span class="mx-2">|</span>
                    <!-- Terms and Conditions Link -->
                    <h5 class="mb-0"><a href="terms.php" class="black-link">Terms and Conditions</a></h5>
                </div>
                <!-- Copyright notice -->
                <p class="mt-3">SustainEnergy 2024 &#169; All Rights Reserved</p>
              </div>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->
  </div>

  
  <script>

    // Get all radio buttons from the green calculator
    const radioButtons = document.querySelectorAll('input[type="radio"]');

    // Add event listener to each radio button
    radioButtons.forEach(button => {
        button.addEventListener('change', updateTotalPoints);
    });

    // Function to update total points when radio buttons are changed
    function updateTotalPoints() {
        let total = 0;
        radioButtons.forEach(button => {
            if (button.checked) {
                total += parseInt(button.value);
            }
        });
        document.getElementById('total_points').textContent = total + "pts";
    }

    // Validating all fields are filled when changing account details
    function validateDetailsForm() {
      // Get form inputs
      var first_name = document.getElementById("first_name").value;
      var last_name = document.getElementById("last_name").value;
      var email = document.getElementById("email").value;
      var org = document.getElementById("org").value;

      // Check if any field is empty
      if (first_name.trim() === "" || last_name.trim() === "" || email.trim() === "" || org.trim() === "") {

        // Display error message
        alert("Please fill in all fields.");
        return false; // Prevent form submission
      }
      
      // All fields are filled, allow form submission
      return true;
    }

    // Validating all fields are filled when changing payment details
    function validatePaymentForm() {

      // Get form inputs
      var card_num = document.getElementById("new_card_num").value;
      var expiry = document.getElementById("new_expiry").value;
      var csv = document.getElementById("new_csv").value;
      var ch_name = document.getElementById("new_ch_name").value;

      // Check if any field is empty
      if (card_num.trim() === "" || expiry.trim() === "" || csv.trim() === "" || ch_name.trim() === "") {

        // Display error message
        alert("Please fill in all fields.");
        return false; // Prevent form submission
      }
      
      // All fields are filled, allow form submission
      return true;
    }

    // Validating new passwords match
    function passwordsMatch() {

      var pass1 = document.getElementById("new_pass1").value;
      var pass2 = document.getElementById("new_pass2").value;

      if (pass1 !== pass2) {
          alert("Passwords do not match!");
          event.preventDefault();
          return false; // Prevent form submission
      }
      return true; // Allow form submission
    }

    // Opening and closing pop up forms
    function openDetailsForm() {
      document.getElementById("details_form").style.display = "block";
    }

    function openPasswordForm() {
      document.getElementById("password_form").style.display = "block";
    }

    function openPaymentForm() {
      document.getElementById("payment_form").style.display = "block";
    }
    
    function openPointsForm() {
      document.getElementById("points_form").style.display = "block";
    }

    function closeDetailsForm() {
      document.getElementById("details_form").style.display = "none";
    }

    function closePasswordForm() {
      document.getElementById("password_form").style.display = "none";
    }

    function closePaymentForm() {
      document.getElementById("payment_form").style.display = "none";
    }
    
    function closePointsForm() {
      document.getElementById("points_form").style.display = "none";
    }
  </script>

  <!-- Bootstrap JS and jQuery links -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>