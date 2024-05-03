<?php
    require('registerTools.php');
    session_start();
    
    $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : array();
    unset($_SESSION['errors']); # Remove the errors from session after displaying them
    
    # After handling validation and setting errors array
    $response = array();
    
    if (!empty($errors)) {
        # Errors exist
        $response = array('error' => true, 'message' => 'Errors exist');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="preLoginStyles.css">
</head>

<body>
    <div id="page-container">

        <!-- Main Page Content -->
        <div id="content_wrap">
            <div class="container p-5 col-md-3">
                <div class="card text-black" style="text-align: center; border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">  
                    <h1 style="padding-top: 2%">SustainEnergy</h1>
                </div>
            </div>
            
            <!-- Registration Form -->
            
            <!-- Details Section --> 
            <form id="registrationForm" class="mt-2" method="post" action="registerTools.php">
            <div class="container p-5">
                <div class="row">
                    <div class="col-md-6">
                    <div class="card text-black shadow" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">    
                            <div class="container">
                                <h2 class="mt-4" style="text-align: center">Account Details</h2>

                                <div class="form-group">
                                    <label for="first_name">First Name:</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>

                                <div class="form-group">
                                    <label for="last_name">Last Name:</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email Address:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div id="emailError" class="text-danger"></div>
                                </div>

                                <div class="form-group">
                                    <label for="org">Organisation:</label>
                                    <input type="text" class="form-control" id="org" name="org" required>
                                    <div id="orgError" class="text-danger"></div>
                                </div>

                                <div class="form-group">
                                    <label for="pass1">Password:</label>
                                    <input type="password" class="form-control" id="pass1" name="pass1" required>
                                </div>

                                <div class="form-group">
                                    <label for="pass2">Confirm Password:</label>
                                    <input type="password" class="form-control" id="pass2" name="pass2" required>
                                </div>

                                <div class="form-group px-4 border border-info rounded-3">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        By checking this box you agree to both the terms & conditions and the privacy statement linked in the footer.   
                                    </label>
                                </div>

                                <button id="registerBtn" type="submit" class="btn btn-primary btn-block">Register</button>
                            </div>
                        </div>
                    </div>
                    <!-- End of Details Section -->
                    
                    <!-- Memorable Questions -->
                    <div class="col-md-6">
                    <div class="card text-black shadow" style="border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">    
                            <div class="container">
                                <h2 class="mt-4" style="text-align: center">Memorable Questions</h2>

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
                            </div>
                        </div>
            </form>
            <!-- End of Form -->
                        <br>

                        <div class="card text-black shadow" style="text-align: center; border-radius: 10px; padding-bottom: 2%; background-color: #BFD8D8;">  
                        
                            <h1 style="padding-top: 8%"><center>Already Have an Account?</center></h1>
                            
                            <form class="mt-4; px-3" method="post" action="login.html">
                                <center><button type="primary" class="btn btn-primary">Login</button></center>
                            </form>
                        </div>
                    </div>
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

        <!-- The Confirm Payment Modal -->
        <div id="confirmPaymentModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Confirm Payment</h2>
                </div>

                <div class="modal-body">
                    <p>Would you like to add payment information and pay the subscription now?</p>
                </div>

                <div class="modal-footer">
                    <button id="confirmPaymentBtn" class="btn btn-primary" onclick="submitFormPayment()">Yes</button>
                    <button id="cancelPaymentBtn" class="btn btn-secondary" onclick="submitFormLogin()">No</button>
                </div>
            </div>
        </div>
    </div>    

    <script>

        // Get the modal
        var modal = document.getElementById("confirmPaymentModal");

        // Get the button that opens the modal
        var btn = document.getElementById("registerBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // Function to disable the register button
        function hideBtn() {
            btn.style.display = "none";
        }

        // Function to show the register button
        function showBtn(){
            btn.style.display = "block";
        }

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
            // Prevent default form submission
            event.preventDefault();
            
            // Check if all form fields are filled
            if (validateForm()) {
                modal.style.display = "block"; // Display the modal if all fields are filled
            } else {
                alert("Please fill in all fields."); // Display an alert if any field is empty
                resetForm();
            }
        }

        // Function to validate form fields
        function validateForm() {
            
            // Select all text inputs, text areas, and checkboxes in the form
            var inputs = document.querySelectorAll(
                'form input[type="text"], form input[type="email"], form input[type="password"], form textarea, form input[type="checkbox"]'
            ); 
            
            // For loop to loop through all the forms inputs
            for (var i = 0; i < inputs.length; i++) {

                if (inputs[i].type === 'checkbox') {

                    // Check if checkbox is checked
                    if (!inputs[i].checked) {

                        return false; // Return false if any checkbox is unchecked
                    }
                } else {

                    // Check if text input or textarea is empty
                    if (inputs[i].value.trim() === '') {
                        return false; // Return false if any field is empty
                    }
                }
            }
            return true; // Return true if all fields are filled
        }

        // Reset the form if the user submits a form with an empty field
        function resetForm() {

            var inputs = document.querySelectorAll(
                'form input[type="text"], form input[type="email"], form input[type="password"], form textarea, form input[type="checkbox"]'
            );
            
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].value = ''; // Reset text inputs and textareas
                if (inputs[i].type === 'checkbox') {
                    inputs[i].checked = false; // Uncheck checkboxes
                }
            }
        }

        // Function to submit the form and redirect to Login.html
        function submitFormLogin() {

            if (!hasErrors()) {

                document.getElementById('registrationForm').submit();

                // Add a delay before redirecting to ensure the form is submitted
                setTimeout(function() {

                    // Redirect to login.html
                    window.location.href = "login.html";

                }, 10); // Adjust the delay time as needed (in milliseconds)
            }
        }

        // Function to submit the form and redirect to payment.php
        function submitFormPayment() {

            // If there are no errors then submit the form
            if (!hasErrors()) {

                document.getElementById('registrationForm').submit();

                // Add a delay before redirecting to ensure the form is submitted
                setTimeout(function() {

                    // Redirect to payment.php
                    window.location.href = "payment.php";

                }, 10); // Adjust the delay time as needed (in milliseconds)
            }
        }

        // Function to check for errors
        function hasErrors() {
            
            // Check if there are any error messages displayed
            var errorDiv = document.getElementById('error-messages');
            var errorsExist = errorDiv && errorDiv.innerHTML.trim() !== '';
            console.log('Errors exist:', errorsExist);
            
            if (errorsExist) {
                hideBtn(); // Call hideBtn() if errors exist
            }
            return errorsExist;
        }

        // Dynamically check the database for the email the user is typing
        document.getElementById("email").addEventListener("keyup", function() {
            // Load the email into a variable
            var email = this.value;

            // Send Ajax request
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "check_email.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Load the response into a variable
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById("emailError").innerHTML = response.message; // Display the message to the user
                    
                    // Check errors after receiving response
                    checkErrors();

                    // Output the errors to the browsers console
                    if (response.error) {
                        console.log('Errors exist:', response.message);
                    } else {
                        console.log('No errors:', response.message);
                    }
                }
            }
            xhr.send("email=" + email);
        });

        // Dynamically check the database for the organisation the user is typing
        document.getElementById("org").addEventListener("keyup", function() {
            var org = this.value;
            console.log(org);

            // Send Ajax request
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "check_org.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Load the response into a variable
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById("orgError").innerHTML = response.message; // Display the message to the user
                    
                    // Check errors after receiving response
                    checkErrors();

                    // Output the errors to the browsers console
                    if (response.error) {
                        console.log('Errors exist:', response.message);
                    } else {
                        console.log('No errors:', response.message);
                    }
                }
            };
            xhr.send("org=" + org);
        });
        
        // Check content of the elements under the organisation and email inputs
        function checkErrors() {

            var emailErrorDiv = document.getElementById("emailError");
            var orgErrorDiv = document.getElementById("orgError");
            var btn = document.getElementById("registerBtn");

            // If the elements don't contain any errors then show the register button
            if (emailErrorDiv && orgErrorDiv &&
                emailErrorDiv.innerHTML.trim() === "" &&
                orgErrorDiv.innerHTML.trim() === "") {
                showBtn();
            // If the elements do contain any errors then hide the register button
            } else {
                hideBtn();
            }
        }
    </script>
    
    <!-- Add Bootstrap JS and jQuery links here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
</body>
</html>