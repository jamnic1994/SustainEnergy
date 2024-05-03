<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Statement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="preLoginStyles.css">
</head>
<body>
    <div id="page-container">

        <!-- Main Page Content -->
        <div id="content_wrap">

            <?php
                # If the user if logged in show the navbar.
                if ( isset( $_SESSION[ 'user_id' ] ) ) { ?>

                    <link rel="stylesheet" type="text/css" href="main_styles.css">

                    <!-- Navbar -->
                    <nav class="navbar navbar-expand-lg" style="background-color: #C1D9A9">
                        <div class="container-fluid">
                            <a class="navbar-brand" href="home.php">
                                <img src="img/navbar_logo.png" alt="logo" style="width: 100px; height: auto;">
                            </a>

                            <div class="navbar-nav">
                                <ul class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <?php if ($_SESSION['role'] == "admin") { ?>

                                            <a class="nav-link" href="admin.php">Admin Panel</a>

                                        <?php } ?>
                                    </li>
                                </ul>
                            </div>

                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <h1 class="mx-auto">SustainEnergy</h1>
                            <div class="navbar-nav">
                                <ul class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a class="nav-link" href="account.php"><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <form action="logout.php" method="post" class="nav-link">
                                            <button type="submit" class="btn btn-danger">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <!-- End of Navbar -->
            <?php  } ?>


            <!-- Header -->
            <div class="container p-5 col-md-4">
                <div class="card text-black shadow" style="text-align: center; border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">  
                    <h1 style="padding-top: 2%">Privacy Statement</h1>
                </div>
            </div>
            <!-- End of Header -->
            
            <!-- Privacy Statement -->
            <div class="container">
                <div class="row justify-content-center">

                    <!-- Left Container -->
                    <div class="col-md-6 p-3">
                        <div class="card text-black p-4 shadow" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">

                            <p>This Privacy Statement outlines the policies regarding the collection, use, and disclosure of personal information for <b>SustainEnergy</b> ("we", "us", or "our") website or application.</p>
                
                            <h2>1. Information Collection and Use</h2>
                            <p>We may collect personal information, such as names, email addresses, and phone numbers, voluntarily provided by users for the purpose of registration and subscription to our service.</p>
                        
                            <h2>2. Use of Data</h2>
                            <p>Any personal information collected will be used solely for the purpose for which it was provided. We may use this information to keep track of users accounts and actions within our service.</p>
                        
                            <h2>3. Disclosure of Data</h2>
                            <p>We do not disclose personal information to third parties unless required by law or with explicit consent from the user.</p>
                        
                            <h2>4. Security of Data</h2>
                            <p>We are committed to protecting the security of personal information. We implement appropriate technical and organizational measures to safeguard the information collected.</p>

                            <h2>5. Cookies</h2>
                            <p>We may use cookies or similar technologies to enhance user experience and track usage patterns. Users may choose to disable cookies in their web browsers, but this may affect the functionality of the website or application.</p>
                        
                            <h2>6. Links to Other Sites</h2>
                            <p>Our website or application may contain links to third-party websites. We are not responsible for the privacy practices or content of these websites. Users should review the privacy policies of these third-party sites.</p>
                        
                        </div>
                    </div>
                    <!-- End of Left Container -->

                    <!-- Right Container -->
                    <div class="col-md-6 p-3">
                        <div class="card text-black p-4 shadow" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">

                            <h2>7. Processing your Data</h2>
                            <p>The General Data Protection Regulation (GDPR) and UK GDPR require us to explain the valid legal basis we rely on in order to process your personal information. 
                                As such, we may rely on the following legal bases to process your personal information:
                            </p>

                            <ul>
                                <li><strong>Consent.</strong> We may process your information if you have given us permission (i.e. consent) to use your personal information for a specific purpose. you can withdraw your consent at any time by deleting your account.</li>
                                <li><strong>Performance of a Contract.</strong>  We may process your information where we believe it is necessary for compliance with our legal obligations, such as to cooperate with a law enforcement body or regulatory agency, exercise or defend our legal rights, or disclose your information as evidence in litigation in which we are involved.</li>
                                <li><strong>Vital Interests.</strong> We may process your information where we believe it is necessary to protect your vital interests or the vital interests of a third party, such as situations involving potential threats to the safety of any person.</li>
                            </ul>
                        
                            <h2>8. Changes to This Privacy Statement</h2>
                            <p>We reserve the right to update or change this Privacy Statement at any time. Users will be notified of any changes by posting the updated Privacy Statement on the website or application.</p>
                        
                            <h2>9. Contact Us</h2>
                            <p>If you have any questions or concerns about this Privacy Statement, please contact us at <b>EC2039228@edinburghcollege.ac.uk</b>.</p>
                        
                        </div>
                    </div>
                    <!-- End of Right Container -->
                </div>
            </div>
            <!-- End of Privacy Statement -->

        </div>
        <!-- End of Main Page Content -->

        <!-- Footer -->
        <footer id="footer" class="py-3">
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
                            <h5 class="mb-0"><a href="#" class="black-link">Privacy Statement</a></h5>
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
        <!-- End of Footer-->
    </div>  
    
    <!-- Bootstrap JS and jQuery links -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>