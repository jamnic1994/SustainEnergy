<?php
  session_start();

  # Redirect if not logged in.
  if ( !isset( $_SESSION[ 'user_id' ] ) ) { require ( 'login_tools.php' ) ; load() ; }

  $user_id = $_SESSION[ 'user_id' ];

  # Open database connection.
  require('ConnectDB.php');

  require('tools.php');

  # Fetch the active users details
  $user_details = fetchUserDetails($link, $user_id);
  
  # Access these details here
  if ($user_details != null) {

    $points = $user_details['points'];
    $sub_active = $user_details['sub_active'];
    $award = $user_details['award'];

    if($award == null){
      $award = "None Achieved";
    }

    # Define thresholds for bronze, silver, and gold
    $bronze_threshold = 50;
    $silver_threshold = 75;
    $gold_threshold = 100;

    # Calculate widths for each progress bar then round to the nearest integer
    $bronze_width = round(($points / $bronze_threshold) * 100);
    $silver_width = round(($points / $silver_threshold) * 100);
    $gold_width = round(($points / $gold_threshold) * 100);

  } else {
    echo "<script>alert('There is no account with that user ID!');</script>";
  }

  # Close the database connection
  mysqli_close($link);

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SustainEnergy</title>
  <link href="https:#cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https:#maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https:#cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="main_styles.css">
</head>

<body>

  <div id="page-container">

    <div id="content_wrap">

      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
        <a class="navbar-brand" href="#">
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
      <div class="container col-md-6 pt-5" style="border-radius: 10px;">
        <div class="row">
          <div class="text-center mt-3 d-flex justify-content-between text-black">
            <a href="sustainability.php" class="text-black link-no-underline"><h2>Sustainability</h2></a>
            <h2>|</h2>
            <a href="account.php" class="text-black link-no-underline"><h2>My Account</h2></a>
            <h2>|</h2>
            <a href="contact_us.php" class="text-black link-no-underline"><h2>Contact Us</h2></a>
          </div>
        </div>
      </div>

      <div class="container p-5">
          <div class="row justify-content-center">
              <div class="col-md-12">
                  <div class="card text-black p-4 shadow" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">
                    <h1>Welcome to SustainEnergy!</h1>

                    <hr style='border-top: 2px dotted #000;'>

                    <p>This is a platform built, in cooperation with Edinburgh College, to further the conversation around sustainability and how businesses can help the fight against climate change.</p> 
                    <p>Using SustainEnergy, you can ensure your business gets the recognition it deserves.</p>
                  </div>
              </div>
          </div>
      </div>
      
      <div class="container p-5">
          <div class="row justify-content-center">

              <!-- Points Tally Container -->
              <div class="col-md-6">
                  <div class="card text-black p-4 shadow" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">
                      
                    <?php
                      # Check the value of $sub_active and display different content accordingly
                      if ($sub_active == 0) { 

                        echo "<h3 style ='text-align: center'>Start a basic subscription from your account page to see your points tally!</h2>";
                      
                      } else {
                        
                        echo "<h2>Points: </h2>";
                        echo "<h3 style='text-align: right'>$points</h3>";
                        echo "<hr style='border-top: 2px dotted #000;'>";
                        echo "<p style='text-align: center'>You can add more points to your account through your account page.</p>";
                      }
                    ?>

                  </div>
              </div>
              <!-- End of Points Tally Container -->
              
              <!-- Award Info Container -->
              <div class="col-md-6">
                  <div class="card text-black p-4 shadow" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">
                      
                  <?php
                    # Check the value of $sub_active and display different content accordingly
                    if ($sub_active == 0) { 
                      
                      echo "<h3 style ='text-align: center'>Start a basic subscription from your account page to see your awards progress!</h3>";

                    } else if ($sub_active == 1) {
           
                      echo "<h2>Award: </h1>";
                      echo "<h3 style='text-align: right'>" . $award . "</h3>";
                      echo "<hr style='border-top: 2px dotted #000;'>";
                      echo "<h2>Progress to Bronze: </h2>";
                  ?>

                      <div class="progress shadow">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $points ?>" aria-valuemin="0" aria-valuemax="50" style="width: <?php echo $bronze_width ?>%; background-color: #CD7F32"><?php if($bronze_width <= 100){echo $bronze_width . "%";} else {echo "100%";}?></div>
                      </div>

                      <?php 
                        echo "<hr style='border-top: 2px dotted #000;'>";
                        echo "<h2>Progress to Silver: </h2>";
                      ?> 

                      <div class="progress shadow">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $points ?>" aria-valuemin="0" aria-valuemax="75" style="width: <?php echo $silver_width ?>%; background-color: #C0C0C0"><?php if($silver_width <= 100){echo $silver_width . "%";} else {echo "100%";}?></div>
                      </div>

                      <?php 
                        echo "<hr style='border-top: 2px dotted #000;'>";
                        echo "<h2>Progress to Gold: </h2>";                      
                      ?>  

                      <div class="progress shadow">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $points ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $gold_width ?>%; background-color: #FFD700"><?php if($gold_width <= 100){echo $gold_width . "%";} else {echo "100%";}?></div>
                      </div>

                      <?php
                    }
                    ?>

                  </div>
              </div>
              <!-- End of Award Info Container -->
          </div>
      </div>

      

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
  </div>

  <!-- Bootstrap JS and jQuery links -->
  <script src="https:#cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="https:#code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https:#cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https:#maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>