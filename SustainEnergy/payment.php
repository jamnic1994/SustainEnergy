<?php
    session_start();
    
    # Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        # Form is submitted, process the data
        $user_id = $_SESSION['user_id'];
        $card_num = $_POST['card_num'];
        $expiry = $_POST['expiry'];
        $CSV = $_POST['csv'];
        $ch_name = $_POST['ch_name'];

        require('tools.php');

        if(processPaymentAndSub($user_id, $card_num, $expiry, $CSV, $ch_name)){
            # Purchase successful
            echo "<script>alert('Purchase successful. Redirecting to the login page.'); window.location.href = 'login.html';</script>";
            # Destroy the session.
            session_destroy() ;
        } else {
            # Purchase failed
            echo "<script>alert('Subscription could not be purchased. Try again later');</script>";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Registration</title>
    <!-- Bootstrap CSS link -->
    <link href="https:#cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https:#maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="preLoginStyles.css">
</head>

<body>
    <div id="page-container">
        <div id="content_wrap">
            <!-- Header -->
            <div class="container col-md-3 p-5">
                <div class="card text-black shadow" style=" text-align: center; border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">  
                    <h1 style="padding-top: 2%">SustainEnergy</h1>
                </div>
            </div>
            <!-- End of Header -->

            <!-- Form to take the users payment info -->
            <div class="container p-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card text-black p-4 shadow" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">
                            <form method="post" action="payment.php" onsubmit="return validateForm()">
                                <div class="form-group">
                                    <label for="card_num">Card Number:</label>
                                    <input type="text" class="form-control" id="card_num" name="card_num" placeholder="Enter card number" required>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="expiry">Expiry Date:</label>
                                        <input type="text" class="form-control" id="expiry" name="expiry" placeholder="MM/YY" required>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="csv">CSV:</label>
                                        <input type="text" class="form-control" id="csv" name="csv" placeholder="Enter CSV" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="ch_name">Cardholder's Name:</label>
                                    <input type="text" class="form-control" id="ch_name" name="ch_name" placeholder="Enter cardholder's name" required>
                                </div>
                                <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $user_id ?>" required>
                                <button type="submit" class="btn btn-primary btn-block">Submit Payment</button>
                            
                        </div>
                    </div>
                                <!-- Subscription Details Container -->
                                <div class="col-md-6" style="padding-top: 8%">
                                    <div class="card text-black p-4 shadow" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">
                                        <h5>Subscription Details</h5>
                                        <p>You are purchasing a one-year basic SustainEnergy subscription for £99.99/year.</p>

                                        <div class="form-group px-4 border border-info rounded-3">
                                            <input class="form-check-input" type="checkbox" value="true" id="check_box" required>
                                            <label class="form-check-label" for="check_box">
                                                By checking this box you agree to the purchase of the subscription detailed above   
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
    <script src="https:#cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https:#code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https:#cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https:#maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
</body>
</html>