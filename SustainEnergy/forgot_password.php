<?php
    require('tools.php');
    require('connectDB.php');

    # Close database connection.
    mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
        <!-- Main Page Content -->
        <div id="content_wrap">
            
            <br>
            <br>
            
            <!-- Header -->
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="text-black p-4 shadow" style="border-radius: 10px; padding-bottom: 2%;  background-color: #BFD8D8;">
                            <h2 class="text-center">Forgot My Password</h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Header -->

            <br>
            <br>
            
            <!-- This form acts as validation to protect a users account -->
            <div class="container">
                <form id="forgotPassForm" class="mt-4" method="post" action="change_password.php">
                    
                    <div class="row justify-content-center">

                        <!-- Input for the users email -->
                        <div class="col-md-6">
                            <div class="text-black p-3 shadow" style="border-radius: 10px;  background-color: #BFD8D8;">
                                <h2>Please enter your email:</h2>
                                <br>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div id="emailError" class="text-danger text-center py-2"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Input for the users memorable questions and answers -->
                        <div class="col-md-6">
                            <div class="text-black p-4 shadow" style="border-radius: 10px; padding-bottom: 2%;  background-color: #BFD8D8;">
                                <h2>Memorable Questions</h2>
                                
                                <br>

                                <div class="form-group">
                                    <label for="mem_ques1">Memorable Question 1:</label>
                                    <select class="form-control" id="mem_ques1" name="mem_ques1" required>
                                        <option value="">Select a memorable question</option>
                                        <option id="ques1" value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                                        <option id="ques2" value="What city were you born in?">What city were you born in?</option>
                                        <option id="ques3" value="What is the name of your first pet?">What is the name of your first pet?</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="mem_ans1">Answer to Memorable Question 1:</label>
                                    <input type="text" class="form-control" id="mem_ans1" name="mem_ans1" required>
                                </div>

                                <hr style="border-top: 2px dotted #000;">

                                <div class="form-group">
                                    <label for="mem_ques2">Memorable Question 2:</label>
                                    <select class="form-control" id="mem_ques2" name="mem_ques2" required>
                                        <option value="">Select a memorable question</option>
                                        <option id="ques4" value="What is your favourite movie?">What is your favorite movie?</option>
                                        <option id="ques5" value="What was the name of your first school?">What was the name of your first school?</option>
                                        <option id="ques6" value="What is your favourite book?">What is your favorite book?</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="mem_ans2">Answer to Memorable Question 2:</label>
                                    <input type="text" class="form-control" id="mem_ans2" name="mem_ans2" required>
                                </div>
                                <div id="ansError" class="text-danger text-center py-2"></div>
                            </div>
                        </div>   
                    </div>
                    <!-- End of memorable questions -->
                    
                    <!-- Button to submit form -->
                    <div class="container-fluid">
                        <div class="row justify-content-center mt-5">
                            <div class="col-md-6">
                                <div class="text-black p-3 shadow" style="border-radius: 10px;  background-color: #BFD8D8;">
                                    <button id="submitBtn" type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
                                </div>  
                            </div>
                        </div>
                    </div>

                </form>
                <!-- End of the form -->
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
    
    <script>
        // Get the button that submits the form
        var btn = document.getElementById("submitBtn");

        btn.onclick = function(event) {
            // Prevent default form submission
            event.preventDefault();

            // Get form data
            var email = document.getElementById("email").value;
            var mem_ques1 = document.getElementById("mem_ques1").value;
            var mem_ans1 = document.getElementById("mem_ans1").value;
            var mem_ques2 = document.getElementById("mem_ques2").value;
            var mem_ans2 = document.getElementById("mem_ans2").value;

            // Send AJAX request to verify details
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "verify_details.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {

                if (xhr.readyState == 4) {
                    if (xhr.status == 200){

                        // Variable to hold the response
                        var response = JSON.parse(xhr.responseText);

                        // If the response contains an error then handle it
                        if (response.error) {
                            if (response.message == "This email doesn't exist") {
                                
                                document.getElementById("emailError").innerHTML = response.message; // Show error message
                            } else if (response.message == 'Invalid memorable questions or answers') {

                                document.getElementById("ansError").innerHTML = response.message; // Show error message
                            }
                        // If the response doesn't contain an error
                        } else {
                            // Proceed with form submission
                            document.getElementById('forgotPassForm').submit();
                        }
                    } else {
                        // Handle HTTP error
                        alert("HTTP error: " + xhr.status);
                    }
                }
            }
            // Send form data to verify_details.php
            xhr.send("email=" + email + "&mem_ques1=" + mem_ques1 + "&mem_ans1=" + mem_ans1 + "&mem_ques2=" + mem_ques2 + "&mem_ans2=" + mem_ans2);
        };
    </script>

    <!-- Bootstrap JS and jQuery links -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
</body>
</html>