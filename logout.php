<!-- 
Name: Kaitrin Harnish, Rachel Brownlee
Student Number: B00579658, B00738899
For: CSCI 3172
Fall 2020 
-->

<?php
//starting session on this php page
session_start();

//unsetting the session variables
unset($_SESSION['username']);
unset($_SESSION['loggedin']);

//destroying session
session_destroy();

//redirecting user to signin after successfully logging out
header('Location: signin.php');
?>