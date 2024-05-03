<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&family=Roboto+Slab:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="preLoginStyles.css">
</head>
<body>
    <div id="page-container">
        
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
            
            <br>
            
            <!-- Header -->
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="card text-black p-2 shadow" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">
                            <h2 class="text-center">Terms & Conditions</h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Header -->

            <br>
            <br>
            
            <!-- Left Container -->
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card text-black p-4 shadow" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">

                            <p>Welcome to SustainEnergy. If you continue to browse and use this website, you are agreeing to comply with and be bound by the following terms and conditions of use, which together with our privacy policy govern our relationship with you in relation to this website.</p>
                
                            <p>The term 'company' or 'us' or 'we' refers to the owner of the website whose registered office is: </p> 
                            
                            <ul>
                                <li>SustainEnergy</li>
                                <li>Sighthill Campus</li>
                                <li>Bankhead Avenue</li>
                                <li>Edinburgh</li>
                                <li>EH11 4DE</li> 
                            </ul>
                            
                            <p>Our company registration number is <b>SC021213</b>. The term 'you' refers to the user or viewer of our website.</p>
                        
                            <p>The use of this website is subject to the following terms of use:</p>
                            
                            <ul>
                                <li>The content of the pages of this website is for your general information and use only. It is subject to change without notice.</li>
                                <li>Neither we nor any third parties provide any warranty or guarantee as to the accuracy, timeliness, performance, completeness or suitability of the information and materials found or offered on this website for any particular purpose. You acknowledge that such information and materials may contain inaccuracies or errors and we expressly exclude liability for any such inaccuracies or errors to the fullest extent permitted by law.</li>
                                <li>Your use of any information or materials on this website is entirely at your own risk, for which we shall not be liable. It shall be your own responsibility to ensure that any products, services or information available through this website meet your specific requirements.</li>
                            </ul>

                        </div>
                    </div>
                    <!-- End of Left Container -->

                    <!-- Right Container -->
                    <div class="col-md-6 pb-3">
                        <div class="card text-black p-4 shadow" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">

                            <h2>1. Acceptance of Terms</h2>
                            <p>By creating an account and using this website, you agree to be bound by these Terms and Conditions and all applicable laws and regulations. If you do not agree with any of these terms, you are prohibited from using or accessing this site.</p>
                        
                            <h2>2. Changes to Terms</h2>
                            <p>We reserve the right to modify or replace these Terms and Conditions at any time without prior notice. It is your responsibility to review these terms periodically for any changes. Your continued use of the website after any modifications to the terms constitutes acceptance of those changes.</p>
                        
                            <h2>3. Intellectual Property Rights</h2>
                            <p>All content included on this website, such as text, graphics, logos, images, audio clips, video clips, digital downloads, data compilations, and software, is the property of the website owner or its content suppliers and is protected by international copyright laws.</p>
                        
                            <h2>4. Limitation of Liability</h2>
                            <p>In no event shall the website owner or its suppliers be liable for any damages arising out of the use or inability to use the materials on the website, even if the website owner has been notified orally or in writing of the possibility of such damage.</p>
                        
                            <h2>5. Governing Law</h2>
                            <p>These Terms and Conditions shall be governed by and construed in accordance with the laws of Scotland, without regard to its conflict of law provisions.</p>
                        
                            <h2>6. Contact Information</h2>
                            <p>If you have any questions about these Terms and Conditions, please contact us at <b>ec2039228@edinburghcollege.ac.uk</b>.</p>

                        </div>
                    </div>
                    <!-- End of right container -->
                    
                </div>
            </div>
        </div>

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
                            <h5 class="mb-0"><a href="privacy_statement.php" class="black-link">Privacy Statement</a></h5>
                            <!-- Separator -->
                            <span class="mx-2">|</span>
                            <!-- Terms and Conditions Link -->
                            <h5 class="mb-0"><a href="#" class="black-link">Terms and Conditions</a></h5>
                        </div>
                        <!-- Copyright notice -->
                        <p class="mt-3">SustainEnergy 2024 &#169; All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- End of Footer-->
        
    </div>  
    
    <!-- Add Bootstrap JS and jQuery links here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>