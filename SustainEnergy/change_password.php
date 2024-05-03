<?php
    require('connectDB.php');

    $email = $_POST['email'];
    
    # Close database connection.
    mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="preLoginStyles.css">
</head>
<body>
    <div id="page-container">
        <!-- Main Page Content -->
        <div id="content_wrap">
            <br>
            <br>
            
            <!-- Header -->
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="text-black p-4 shadow" style="border-radius: 10px; padding-bottom: 2%;  background-color: #BFD8D8;">
                            <h2 class="text-center">Change Password</h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Header -->

            <!-- Container with form to update password -->
            <div class="container">
                <form id="newPassForm" class="mt-4" method="post" action="change_password_tools.php" onsubmit="return validatePasswords()">    
                    <div class="row justify-content-center">
                        <div class="col-md-8 p-5">
                            <div class="text-black p-3 shadow" style="border-radius: 10px;  background-color: #BFD8D8;">
                                <h2>Please enter your new password:</h2>
                                <br>
                                <div class="form-group">
                                    <label for="pass1">New Password:</label>
                                    <input type="password" class="form-control" id="pass1" name="pass1" required>
                                </div>
                                <div class="form-group">
                                    <label for="pass2">Confirm New Password:</label>
                                    <input type="password" class="form-control" id="pass2" name="pass2" required>
                                </div>
                                <input type="hidden" id="email" name="email" value="<?php echo $email ?>">

                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>    
                </form>
            </div>

            <br>
            <br>

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

    <script>
        // Validate the passwords in the form match
        function validatePasswords() {
            var pass1 = document.getElementById("pass1").value;
            var pass2 = document.getElementById("pass2").value;

            if (pass1 !== pass2) {
                alert("Passwords do not match!");
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }
    </script>

    <!-- Bootstrap JS and jQuery links -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
</body>
</html>