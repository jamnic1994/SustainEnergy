<?php 

# Connect  on 'localhost' for user to database. (xampp)
$link = mysqli_connect('localhost','root','','sustain_energy');

# This is to be used by UwAmp when in college
# $link = mysqli_connect("localhost","root","root","crud_db");

if (!$link) { 

# Otherwise fail gracefully and explain the error. 
die('Could not connect to MySQL: ' . mysqli_error($mysql)); 
} 
?>