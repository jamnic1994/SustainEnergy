<?php

  session_start();

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sustainability</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="main_styles.css">
    <link rel="stylesheet" href="gallery_css.scss">
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
      <div class="container p-5 col-md-12">
          <div class="card text-black shadow p-3" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">
            <h3>What is sustainability?</h3>
            <hr style='border-top: 2px dotted #000;'>

            <p>  
              Sustainability is a broad concept that extends beyond conservation efforts. It's a holistic approach to addressing 
              global challenges by considering the relation of human, social, economic, and environmental factors. Each dimension — the human, social, economic, 
              and environmental pillar — play a crucial role in shaping sustainable practices and policies, ensuring the well-being of current and future generations.
            </p>
          </div>
      </div>
      <!-- End of Header -->
      
      <!-- Image Gallery -->
      <div class="custom_container">
        
        <!-- First Pillar of Sustainability -->
        <div class="box">
          <div class="card shadow">

            <img src="img/human_sustainability.jpg" class="card-img-top" alt="Human Sustainability">

            <div class="card-body">
              <h5 class="card-title">Human Sustainability</h5>
              <hr style='border-top: 2px dotted #000;'>
              <p class="card-text">
                <strong>Human Sustainability</strong> is all about boosting people's well-being by investing in health, education, and access to services. 
                It's about finding the right balance between economic growth and taking care of folks. 
                Businesses also play a big role here by promoting values that respect people and communities. 
                This approach helps everyone grow their skills, keeps organizations running smoothly, 
                and ensures communities thrive.
              </p>
            </div>

          </div>
        </div>
        <!-- End of First Pillar of Sustainability -->
        
        <!-- Second Pillar of Sustainability -->
        <div class="box">
          <div class="card shadow">

            <img src="img/social_sustainability.jpg" class="card-img-top">

            <div class="card-body">
              <h5 class="card-title">Social Sustainability</h5>
              <hr style='border-top: 2px dotted #000;'>
              <p class="card-text">
                <strong>Social Sustainability</strong> focuses on building and supporting communities. It's about making sure we leave a better 
                world for future generations and understanding how our actions affect others. This means fostering strong relationships, 
                fairness, and equality, and working towards goals like the ones set by the United Nations. It's about creating a balance 
                where everyone can thrive while taking care of our planet.
              </p>
            </div>

          </div>
        </div>
        <!-- End of Second Pillar of Sustainability -->
        
        <!-- Third Pillar of Sustainability -->
        <div class="box">
          <div class="card shadow">

            <img src="img/economic_sustainability.jpg" class="card-img-top">

            <div class="card-body">
              <h5 class="card-title">Economic Sustainability</h5>
              <hr style='border-top: 2px dotted #000;'>
              <p class="card-text">
                <strong>Economic Sustainability</strong> looks at smart money management to enhance lives while maintaining consistent profits. 
                However, traditional economics quite often overlooks the true cost of harming the environment in its considerations. New economics considers nature 
                and social relationships alongside financial growth, emphasizing the crucial need to balance progress with environmental and social well-being.
              </p>
            </div>

          </div>
        </div>
        <!-- End of Third Pillar of Sustainability -->

        <!-- Fourth Pillar of Sustainability -->
        <div class="box">
          <div class="card shadow">

            <img src="img/wind_turbines.jpg" class="card-img-top">

            <div class="card-body">
              <h5 class="card-title">Environmental Sustainability</h5>
              <hr style='border-top: 2px dotted #000;'>
              <p class="card-text">
                <strong>Environmental Sustainability</strong> prioritizes the well-being of present and future generations by safeguarding natural resources. It emphasizes 
                economic prosperity while minimizing environmental impact. Balance in environmental sustainability is crucial for long-term prosperity. Businesses 
                must tailor their sustainability strategies to their specific characteristics, integrating them into their operations and policies.
              </p>
            </div>

          </div>
        </div>
        <!-- End of Fourth Pillar of Sustainability -->

      </div>
      <!-- End of Gallery -->

      

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

  <!-- Add Bootstrap JS and jQuery links here -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>