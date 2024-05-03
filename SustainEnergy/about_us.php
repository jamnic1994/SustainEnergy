<?php 
    session_start();

    # Connect to database
    require('ConnectDB.php');

    # Load custom function list
    require('tools.php');

    # Load the feedback from users for the carousel
    $feedbacks = fetchFeedback($link);

    # Close the database connection
    mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
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
            <div class="container p-5 col-md-3">
                <div class="card text-black shadow" style="text-align: center; border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">  
                    <h1 style="padding-top: 2%">About Us</h1>
                </div>
            </div>
            <!-- End of Header -->

            <div class="container">
                <div class="row justify-content-center">
                    
                    <!-- Mission Statement -->
                    <div class="col-md-6">
                        <div class="card text-black p-4 shadow" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">
                            <h1>Mission Statement:</h1>
                            <hr style='border-top: 2px dotted #000;'>
                            <p>
                                At SustainEnergy, our mission is to empower and reward businesses embracing sustainability as a core value and drive positive environmental change.<br><br>
                                In collaboration with Edinburgh College, we provide a platform where businesses can sign up and participate in initiatives that promote sustainability practices. 
                                Through our innovative point-based system, businesses earn accreditation by demonstrating their commitment to sustainable actions, fostering a culture of environmental responsibility. 
                                By recognizing and celebrating their achievements, we inspire businesses to continuously strive towards a greener future, creating a more sustainable world for generations to come.
                            </p>
                        </div>
                    </div>
                    <!-- End of Mission Statement -->

                    <!-- FAQs -->
                    <div class="col-md-6">
                        <div class="card text-black p-4 shadow" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">
                        
                            <h1>FAQs</h1>
                            <hr style='border-top: 2px dotted #000;'>
                            
                            <!-- Start of Accordion -->
                            <div class="accordion" id="accordion">
                                
                                <!-- First FAQ -->
                                <div class="accordion-item">

                                    <h2 class="accordion-header" id="headingOne">   
                                        <button class="accordion-button collapsed border border-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="background-color: #BFD8D8">
                                            What does SustainEnergy do?
                                        </button>
                                    </h2>

                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordion">
                                        <div class="accordion-body">
                                            <p>
                                                We are a platform that allows businesses to record and earn points for their efforts to push sustainable practices.
                                                Once member businesses have reached certain point thresholds they earn bronze, silver or, gold levels of accreditation from SustainEnergy
                                                that they can use in promotional materials or on their website. 
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of First FAQ -->
                                
                                <!-- Second FAQ -->
                                <div class="accordion-item">

                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed border border-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="background-color: #BFD8D8">
                                            How does SustainEnergy give back to the community?
                                        </button>
                                    </h2>

                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion">
                                        <div class="accordion-body">
                                            <p>
                                                Member businesses have the opportunity to purchase points with money if they fail to reach their points thresholds.<br><br>
                                                We currently donate <strong>50%</strong> of all profits from these points purchases to sustainable charities and local initiatives, 
                                                although we are aiming to increase this percentage over time. 
                                            </p> 
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Second FAQ -->
                                
                                <!-- Third FAQ -->
                                <div class="accordion-item">

                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed border border-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" style="background-color: #BFD8D8">
                                            How can I contact SustainEnergy if I need to?
                                        </button>
                                    </h2>

                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordion" >
                                        <div class="accordion-body">
                                            <p>
                                                We have a contact us page available through the homepage that members can use to find our contact details. You are welcome to use this or any of the other contact details listed on this page.<br><br>
                                                Also available on this page is a feedback form you can use to leave testimonials and reviews of our service for future members thinking of joining the platform. We would really love to hear from you.<br><br>

                                                Here is a link:
                                            </p>
                                            
                                            <a href="contact_us.php">Contact Us</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Third FAQ -->
                                
                                <!-- Fourth FAQ -->
                                <div class="accordion-item">

                                    <h2 class="accordion-header" id="headingFour">
                                        <button class="accordion-button collapsed border border-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapsefour" style="background-color: #BFD8D8">
                                            Are there any major organisations you work with?
                                        </button>
                                    </h2>

                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordion">
                                        <div class="accordion-body">
                                            <h4>Unesco:</h4>

                                            <p>
                                                We work with Unesco to ensure that the actions we encourage businesses to engage in exchange for points are as effective as possible.
                                                We believe wholeheartedly in their mission to leave a better planet to our children and want to do everything possible to make a difference. You can find more information about this on our page all about sustainability<br><br>

                                                Here is a link to their website for more information:
                                            </p>
                                                <a href="https://www.unesco.org/en">UNESCO</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Fourth FAQ -->

                            </div>
                            <!-- End of Accordion -->

                        </div>
                    </div>
                    <!-- End of FAQs -->
                    
                    <!-- Reviews -->
                    <div class="container p-5 col-md-12">
                        <div class="card text-black shadow p-3" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">  
                            <h1>Reviews:</h1>

                            <hr style='border-top: 2px dotted #000;'>
                            
                            <!-- Carousel -->
                            <div id="carouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php
                                    if (!empty($feedbacks) && is_array($feedbacks)) {
                                        # Determine active class for the first item
                                        $active_class = 'active';

                                        # Iterate over each feedback record
                                        foreach ($feedbacks as $feedback) {
                                            # Ensure $feedback is an array
                                            if (!is_array($feedback)) {
                                                echo "<p>No feedback available.</p>";
                                                continue;
                                            } ?>

                                            <!-- Output Feedback Item -->
                                            <div class="carousel-item <?php echo $active_class; ?>">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-4">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h5 class="card-title"><?php echo $feedback['first_name'] . " " . $feedback['last_name'] . "  |  " . $feedback['rating'] . "/5"; ?></h5>
                                                                <p class="card-text"><?php echo $feedback['comments']; ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End of Feedback Item -->
                                            <?php
                                            # Remove the active class for subsequent items
                                            $active_class = '';
                                        }
                                    } else {
                                        # Handle case when no feedbacks are available or $feedbacks is not an array
                                        echo "<p class='text-center'>No feedback available.</p>";
                                    }
                                    ?>
                                </div>
                                
                                <!-- Carousel Controls -->
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>

                                <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                                <!-- End of Carousel Controls -->

                            </div>
                            <!-- End of Carousel -->

                        </div>
                    </div>
                    <!-- End of Reviews -->
                </div>
            </div>

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
                            <!-- End of Carousel -->
                            
                        </div>
                    </div>
                    <div class="col-md-6 text-right p-4">
                        <div class="d-inline-flex">
                            <!-- About Us Link -->
                            <h5 class="mb-0"><a href="#" class="black-link">About Us</a></h5>
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
        <!-- End of Footer-->

    </div>  
    
    <!-- Bootstrap JS and jQuery links -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>