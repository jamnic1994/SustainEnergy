<?php
  session_start();

  # Open database connection.
  require('ConnectDB.php');

  require('tools.php');

  # Redirect if not logged in.
  if ( !isset( $_SESSION[ 'user_id' ] ) ) { require ( 'login_tools.php' ) ; load() ; }

  $user_details = fetchUserDetails($link, $_SESSION['user_id']);

  $org = $user_details['org'];
  $first_name = $user_details['first_name'];
  $last_name = $user_details['last_name'];

  // Close the database connection
  mysqli_close($link);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Silver Certificate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="main_styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
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

        <!-- Header -->
        <div class="container p-4 col-md-5">
            <div class="card text-black shadow" style="text-align: center; border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">  
                <h1 style="padding-top: 2%">Silver Certificate</h1>
            </div>
        </div>
        <!-- End of Header -->

        <br><br>

        <!-- Certificate to Download -->
        <div id="certificate" class="container col-md-8">
            <div class="card text-black shadow" style="text-align: center; border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8; border: 4px solid #C0C0C0;">  
                <h1>Certificate of Achievement</h1>
                <hr style='border-top: 2px dotted #000;'>

                <p>This is to certify that <strong><?php echo $org ?></strong></p>
                <p>has successfully achieved a <strong>SILVER</strong> certification from SustainEnergy for their commitment to sustainable practices.</p>
                <p class="pl-3" style="text-align: left;">User: <strong><?php echo $first_name . " " . $last_name ?></strong></p>
            </div>
        </div>
        <!-- End of Certificate -->

        <!-- Download Certificate Button -->
        <div class="container col-md-2 mt-5">
            <div class="card text-black shadow p-3" style="text-align: center; border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">  
                <button id="download_btn" class="btn btn-sm btn-primary">Download Certificate as PDF</button>
            </div>
        </div>
        <!-- End of Certificate Button -->
    </div>

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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
    
    <!-- Script to allow the user to download their certificate -->
    <script>
      jQuery(document).ready(function() {
        $('#download_btn').click(function () {
          console.log('Button Clicked!!');
          
          // Get the width and height of the certificate container
          let containerWidth = $('#certificate').outerWidth();
          let containerHeight = $('#certificate').outerHeight();

          // Create a new PDF with dimensions matching the container
          let pdf = new jsPDF('l', 'px', [containerWidth, containerHeight]);
          
          // Use html2canvas to capture the content of the container as an image
          html2canvas(document.querySelector('#certificate')).then((canvas) => {
              // Convert the canvas to base64 image data
              let base64image = canvas.toDataURL('image/png');

              // Add the image to the PDF
              pdf.addImage(base64image, 'PNG', 0, 0, containerWidth, containerHeight);

              // Save the PDF
              pdf.save('silver_certificate.pdf');
          });
        });
      });
    </script>

</body>
</html>