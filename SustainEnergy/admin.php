<?php
    session_start();

    # Redirect if not logged in.
    if ($_SESSION['role'] !== "admin" )  { require ( 'home.php' ) ; load() ; }

    # Open database connection.
    require('ConnectDB.php');

    # Load custom functions from tools.php 
    require('tools.php');

    # Load user data and contact forms from database
    $users = fetchAllUsers($link);
    $contact_forms = fetchAllContactForms($link);

    # If a form has been submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        # load the specific users ID the admin has selected
        $user_id = $_POST['user_id'];
        
        # If the admin has chosen to remove a users subscription
        if ($_POST['form_type'] === 'remove_sub') {

            # Call the function from tools.php
            $remove_sub = removeSub($link, $user_id);

            # If successful then inform the admin and refresh the page to update cards
            if($remove_sub == true){
                echo "<script>alert('Subscription removed successfully.');</script>";
                header("Refresh:0");
            
            # If an error has occurred then alert the admin
            } else {
                echo "<script>alert('Subscription removal failed.');</script>";
            }

        # If the admin wants to give a subscription
        } else if ($_POST['form_type'] === 'give_sub') {
            
            # Call the give sub function from tools.php
            $give_sub = giveSub($link, $user_id);
            
            # If the function was successful then inform the admin
            if ($give_sub == true ) {

                echo "<script>alert('Subscription added successfully.');</script>";
                header("Refresh:0");
            
            # These are all alerts for the admin of various errors 
            } else if ($give_sub == "Failed creating subscription record.") {

                echo "<script>alert('Failed creating subscription record.');</script>";

            } else if ($give_sub == "User must have a saved payment method to give subscription.") {

                echo "<script>alert('User must have a saved payment method to give subscription.');</script>";

            } else if ($give_sub == "Failed to update users subscription status.") {
            
                echo "<script>alert('Failed to update users subscription status.');</script>";

            }
        
        # If the admin wants to suspend a users account
        } else if ($_POST['form_type'] === 'suspend_account') {
            
            # Call the function from tools.php
            $suspend_acc = suspendAccount($link, $user_id);

            # If the function was successful then inform the admin
            if($suspend_acc == true){
                echo "<script>alert('Account suspended.');</script>";

            # Alert the admin in the event of an error
            } else {
                echo "<script>alert('Account suspension failed.');</script>";
            }

        # If the admin wants to reinstate a users account after suspension
        } else if ($_POST['form_type'] === 'reinstate_account') {
            
            # Call the function from tools.php
            $reinstate_account = reinstateAccount($link, $user_id);

            # If the function was successful inform the admin and refresh the page
            if($reinstate_account == true){
                echo "<script>alert('Account reinstated successfully');</script>";
                header("Refresh:0");

            # Alert the admin in the event of an error
            } else {
                echo "<script>alert('Failed to reinstate users account.');</script>";
            }

        # If the admin wants to delete a users account
        } else if ($_POST['form_type'] === 'delete_account') {
            
            # Call the function from tools.php
            $delete_account = deleteAccount($link, $user_id);

            # If the function was successful inform the admin and refresh the page
            if($delete_account == true) {
                echo "<script>alert('Account deleted successfully');</script>";
                header("Refresh:0");
            } else {
                echo "<script>alert('Error occurred while deleting account. Please try again later.');</script>";
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
  <title>Admin Panel</title>
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
            <div class="container p-4">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="card text-black p-2 shadow" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">
                            <h2 class="text-center">Admin Panel</h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Header -->

            <!-- Users List -->
            <div class="container p-4">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card text-black p-4 shadow" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">
                            <div class="d-flex align-items-center justify-content-between">
                                <h1 class="mx-2">Users List:</h1>
                                <button class="btn btn-secondary mx-2" type="button" data-bs-toggle="collapse" data-bs-target="#users_list" aria-expanded="true" aria-controls="users_list">
                                    Expand
                                </button>
                            </div>

                            <hr style='border-top: 2px dotted #000;'>

                            <!-- Collapsed Container -->
                            <div class="collapse" id="users_list">

                                <!-- If there are users then loop through the array -->
                                <?php if($users != null) {
                                        foreach($users as $user) { 
                                            # Change the boolean value from the database into a more readable format for the admin
                                            if($user['sub_active'] == 1){
                                                $user['sub_active'] = "Basic Subscription active";

                                            } else {
                                                $user['sub_active'] = "No Subscription";
                                            }
                                            ?>

                                            <div class="card my-3">
                                                <div class="card-body">

                                                    <!-- Table to output the users details -->
                                                    <table class="table table-hover table-borderless">

                                                        <tbody>
                                                            <tr>
                                                                <th>User ID:</th>
                                                                <td class="text-right"><?php echo $user['user_id']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Name:</th>
                                                                <td class="text-right"><?php echo $user['first_name'] . " " . $user['last_name']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Email:</th>
                                                                <td class="text-right"><?php echo $user['email']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Organisation:</th>
                                                                <td class="text-right"><?php echo $user['org']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Registration Date:</th>
                                                                <td class="text-right">
                                                                    <?php 
                                                                        $reg_date = $user['reg_date'];

                                                                        # Format register date 
                                                                        $reg_day = substr($reg_date, 8,2);
                                                                        $reg_month = substr($reg_date, 5,2);
                                                                        $reg_year = substr($reg_date, 0,4);

                                                                        echo $reg_day . '/' . $reg_month . '/' . $reg_year;
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Sub Status:</th>
                                                                <td class="text-right"><?php echo $user['sub_active']; ?></td>
                                                            </tr>
                                                            
                                                            <?php if($user['sub_active'] == "Basic Subscription active") { ?>

                                                                    <tr>
                                                                        <th>Points:</th>
                                                                        <td class="text-right"><?php echo $user['points']; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Award:</th>
                                                                        <td class="text-right">
                                                                            <?php
                                                                            
                                                                                if($user['award'] == null){
                                                                                    $user['award'] = "None Achieved";
                                                                                } 

                                                                                echo $user['award']; 
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                            <?php } ?>
                                                            
                                                            <tr>
                                                                <th>Account Status:</th>
                                                                <td class="text-right"><?php echo $user['account_status']; ?></td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                    <hr style='border-top: 2px dotted #000;'>
                                                    
                                                    <div class="container">
                                                        <div class="row justify-content-center">
                                                            <div class="col-md-12">

                                                                <!-- Buttons for admin actions -->
                                                                <div class="text-center d-flex justify-content-center">

                                                                    <?php if($user['sub_active'] == "Basic Subscription active") { ?>

                                                                        <form method="post" action="admin.php">
                                                                            <input type="hidden" name="form_type" value="remove_sub">
                                                                            <input type="hidden" name="user_id" value="<?php echo $user['user_id'] ?>">
                                                                            <button type="submit" class="btn btn-warning mx-2">Remove Subscription</button>
                                                                        </form>

                                                                    <?php } else { ?>

                                                                        <form method="post" action="admin.php">
                                                                            <input type="hidden" name="form_type" value="give_sub">
                                                                            <input type="hidden" name="user_id" value="<?php echo $user['user_id'] ?>">
                                                                            <button type="submit" class="btn btn-success mx-2">Give Subscription</button>
                                                                        </form>

                                                                    <?php } ?>

                                                                    <?php if($user['account_status'] == "Active") { ?>

                                                                        <form method="post" action="admin.php">
                                                                            <input type="hidden" name="form_type" value="suspend_account">
                                                                            <input type="hidden" name="user_id" value="<?php echo $user['user_id'] ?>">
                                                                            <button type="submit" class="btn btn-warning mx-2">Suspend Account</button>
                                                                        </form>

                                                                    <?php } else if($user['account_status'] == "Suspended") { ?>

                                                                        <form method="post" action="admin.php">
                                                                            <input type="hidden" name="form_type" value="reinstate_account">
                                                                            <input type="hidden" name="user_id" value="<?php echo $user['user_id'] ?>">
                                                                            <button type="submit" class="btn btn-success mx-2">Activate Account</button>
                                                                        </form>

                                                                    <?php } ?>

                                                                    <form method="post" action="admin.php">
                                                                        <input type="hidden" name="form_type" value="delete_account">
                                                                        <input type="hidden" name="user_id" value="<?php echo $user['user_id'] ?>">
                                                                        <button type="submit" class="btn btn-danger mx-2">Delete Account</button>
                                                                    </form>
                                                                </div>
                                                                <!-- End of Buttons for Admin Actions -->

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                  <?php } 
                                      } else { ?>
                                        <p>User details unavailable at this time.</p>
                                <?php } ?>
                            </div>
                            <!-- End of Collapsed Container -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Users List -->

            <!-- Messages from Contact Form -->
            <div class="container p-4">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card text-black p-4 shadow" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">
                            <div class="d-flex align-items-center justify-content-between">
                                <h1 class="mx-2">Submitted Contact Forms:</h1>
                                <button class="btn btn-secondary mx-2" type="button" data-bs-toggle="collapse" data-bs-target="#contact_forms" aria-expanded="true" aria-controls="contact_forms">
                                    Expand
                                </button>
                            </div>

                            <hr style='border-top: 2px dotted #000;'>

                            <!-- Collapsed Container -->
                            <div class="collapse" id="contact_forms">
                                <!-- If there are users then loop through the array -->
                                <?php if($contact_forms != null) {
                                        foreach($contact_forms as $contact_form) { ?>
                                            <div class="card my-3">
                                                <div class="card-body">
                                                    <table class="table table-hover table-borderless">

                                                        <tbody>
                                                            <tr>
                                                                <th>Contact ID:</th>
                                                                <td class="text-right"><?php echo $contact_form['contact_id']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>User ID:</th>
                                                                <td class="text-right"><?php echo $contact_form['user_id']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Subject:</th>
                                                                <td class="text-right"><?php echo $contact_form['subject']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Comments:</th>
                                                                <td class="text-right"><?php echo $contact_form['comments']; ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                  <?php } 
                                      } else { ?>
                                        <p>No contact forms available at this time.</p>
                                <?php } ?>
                            </div>
                            <!-- End of Collapsed Container -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Messages From Contact Form -->
        
        </div>
        <!-- End of Main Page Content -->
        
            <!-- Footer -->
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
                            <h5 class="mb-0"><a href="about_us.html" class="black-link">About Us</a></h5>
                            <!-- Separator -->
                            <span class="mx-2">|</span>
                            <!-- Privacy Statement Link -->
                            <h5 class="mb-0"><a href="privacy_statement.html" class="black-link">Privacy Statement</a></h5>
                            <!-- Separator -->
                            <span class="mx-2">|</span>
                            <!-- Terms and Conditions Link -->
                            <h5 class="mb-0"><a href="terms.html" class="black-link">Terms and Conditions</a></h5>
                        </div>
                        <!-- Copyright notice -->
                        <p class="mt-3">SustainEnergy 2024 &#169; All Rights Reserved</p>
                    </div>
                    </div>
                </div>
            </footer>
    </div>

   <!-- Bootstrap JS and jQuery links -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
</body>
</html>