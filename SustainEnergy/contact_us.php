<?php
    session_start();

    # Redirect if not logged in.
    if ( !isset( $_SESSION[ 'user_id' ] ) ) { require ( 'login_tools.php' ) ; load() ; }

    # Open database connection.
    require('ConnectDB.php');

    require('tools.php');

    # If a form has been submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        # Check which form was submitted based on the value of the hidden input field
        if ($_POST['form_type'] === 'contact_form') {

            $user_id = $_SESSION['user_id'];
            $subject = $_POST['subject'];
            $comments = $_POST['comments'];

            sendContactForm($link, $user_id, $subject, $comments);

        } else if ($_POST['form_type'] === 'feedback_form') {
            
            $user_id = $_SESSION['user_id'];
            $rating = $_POST['rating'];
            $comments = $_POST['comments'];

            sendFeedbackForm($link, $user_id, $rating, $comments);
        }
    }

    // Close the database connection
    mysqli_close($link);

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact Us</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&family=Roboto+Slab:wght@300&display=swap" rel="stylesheet">
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
            <div class="container p-5">
                
                <div class="text-black p-3 shadow" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">

                    <div class="accordion accordion-flush" id="accordion">

                        <!-- Contact Us Form -->
                        <div class="accordion-item">

                            <h1 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed border border-primary" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne" style="background-color: #BFD8D8;">
                                    Contact Us
                                </button>
                            </h1>

                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <h1 class="mt-2">Contact Us</h1>

                                    <p>Here you can contact us with any questions you may have or issues you may be experiencing. Please be respectful at all times, any accounts determined to be sending harassment or abuse to our colleagues will be banned.</p>
                                    <hr style='border-top: 1px dotted #000;'>

                                    <form action="contact_us.php" method="post">

                                        <div class="form-group mt-3">
                                            <label for="subject">Subject:</label>
                                            <input type="text" class="form-control" id="subject" name="subject" maxlength="150" required>
                                            <small class="form-text text-muted">Maximum 150 characters.</small>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="comments">Comments:</label>
                                            <textarea class="form-control" id="comments" name="comments" rows="5" maxlength="500" required></textarea>
                                            <small class="form-text text-muted">Maximum 500 characters.</small>
                                        </div>
                                        
                                        <input type="hidden" name="form_type" value="contact_form">
                                        
                                        <button type="submit" class="btn btn-primary">Submit</button>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End of Contact Form -->

                        <!-- Feedback Form -->
                        <div class="accordion-item">

                            <h1 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed border border-primary" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo" style="background-color: #BFD8D8">
                                    Leave Feedback
                                </button>
                            </h1>

                            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordion">
                                <div class="accordion-body">

                                    <h1 class="mt-2">Leave Feedback</h1>

                                    <p>Here you can leave feedback that will be posted to our testimonials section on the About Us page linked in the footer for future users to read through. Please be respectful at all times, any accounts determined to be sending harassment or abuse to our colleagues will be banned.</p>
                                    <hr style='border-top: 1px dotted #000;'>

                                    <h5 class="m-3">Rating (1-5):</h5>

                                    <form action="contact_us.php" method="post">

                                        <div class="rating form-control">

                                            <div class="rating" required>
                                                <input id="rating1" type="radio" name="rating" value="1">
                                                <label for="rating1">1</label>
                                                <input id="rating2" type="radio" name="rating" value="2">
                                                <label for="rating2">2</label>
                                                <input id="rating3" type="radio" name="rating" value="3">
                                                <label for="rating3">3</label>
                                                <input id="rating4" type="radio" name="rating" value="4">
                                                <label for="rating4">4</label>
                                                <input id="rating5" type="radio" name="rating" value="5">
                                                <label for="rating5">5</label>
                                            </div>

                                        </div>
                                    
                                        <div class="form-group mt-5" required>
                                            <label for="comments">Comments:</label>
                                            <textarea class="form-control" id="comments" name="comments" rows="5" maxlength="500" required></textarea>
                                            <small class="form-text text-muted">Maximum 500 characters.</small>
                                        </div>
                                        
                                        <input type="hidden" name="form_type" value="feedback_form">

                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <!-- End of Feedback Form -->

                    </div>

                </div>
            </div>
            
            <div class="container p-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="text-black p-4 shadow" style="border-radius: 10px; padding-bottom: 2%;  background-color: #BFD8D8;">
                            <h2 class="text-center">Contact By Mail</h2>
                            <hr style='border-top: 2px dotted #000;'>
                            <h2>Address:</h2>
                            <ul class="text-right" style="list-style-type: none; padding-left: 0;">
                                <li>SustainEnergy</li>
                                <li>Sighthill Campus</li>
                                <li>Bankhead Avenue</li>
                                <li>Edinburgh.</li>
                                <li>EH11 4DE</li> 
                            </ul>
                        </div>     
                    </div>
                    <div class="col-md-6">
                        <div class="text-black p-4 shadow" style="border-radius: 10px; padding-bottom: 2%;  background-color: #BFD8D8;">
                            <h2 class="text-center">Other Contact Details</h2>
                            <hr style='border-top: 2px dotted #000;'>
                            <h2>Phone Number:</h2>
                            <p class="text-right">07409303393</p>
                            <hr style='border-top: 2px dotted #000;'>
                            <h2>Email:</h2>
                            <p class="text-right">ec2039228@edinburghcollege.ac.uk</p>
                        </div>
                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>