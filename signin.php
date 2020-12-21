<!--Template used from Bootstrap. 
Updates/Adaptations are commented on. 
Name: Kaitrin Harnish, Rachel Brownlee
Student Number: B00579658, B00738899
For: CSCI 3172
Fall 2020 
-->

<?php 
  session_start(); 
 
  //if session is set to logged in or logged in is equal to true, do not let the user go to the signin page
  if(isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === true){
    //redirect
    header("location: index.php");
    //stops executing rest of code
    exit();
  }
  
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- title-->
  <title>Contact</title>

  <!-- Bootstrap core CSS -->
  <!-- updated href to appropriate location-->
  <link href="misc/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/blog-post.css" rel="stylesheet">

</head>
<body>

 <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.php">Sew to Speak</a>
    </div>
  </nav>


  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <!-- Post Content Column -->
      <div class="col-lg-8">
        <br>
        <h1>Sign In</h1>
        <p>If you have a user account, sign in below:</p>

        <div class="card my-4">
          <h5 class="card-header">Sign In</h5>
          <div class="card-body">
            <form method="post">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="Name" class="form-control" id="username" placeholder="Enter username" name="username" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
              </div>
              <input type="submit" name="formSubmit" class="btn btn-primary" value="Submit">
            </form>
          </div>
        </div>


        <?php
          //retrieving code from login.php
          require_once('login.php');

          //connecting to database
          $conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_database) or die ("Error: Unable to connect to MySQL.".mysqli_connect_error());

          //if formSubmit is set to true
          if (isset($_POST['formSubmit'])){
            //if the value of formSubmit is equal to Submit
            if($_POST['formSubmit'] == 'Submit'){

              //store submitted username and password in variables
              $username = $_POST['username'];
              $password = $_POST['password'];

              //query to see if username and password exist in the login table together
              $myquery = "SELECT * FROM Login ";

              //storing the userid 
              $userid="";

              //storing result
              $result = $conn->query($myquery);

          //retrieving userid from result of the connection
          if($result->num_rows>0 ) {
            //while there is a nother row, it stores the data within an associative array 
            while ($row = $result->fetch_assoc()) {
              if ($username != $row['username']){
                continue;
              } else { 
                $hashedpw=$row['password'];
                //printf("%s",$hashedpw);
              }
            }
            
          //if there is nothing found via the query, it shows a failsafe message
          } else {
            echo "Nothing here to display! Sorry!";
          }

              if (password_verify($password, $hashedpw)) {        
                //if the result is returned, start the session
                session_start();

                //set logged in and username session variables to true/the input username
                $_SESSION["loggedin"]=true;
                $_SESSION["username"]=$username;    
                                      
                // Redirect user to welcome page
                header("location: index.php");
                //stop code execution
                exit();
              } else { 
                echo "Password incorrect.";
                
              }
            }
          }
          //closing the connection 
          $conn -> close(); 
        ?>

        <hr>
        <br>

        <!-- create account page section and link-->
        <h1>Create Account</h1>
        <p>If you do not have a user account, create one by following the link below:</p>
        <form action="account.php" > 
          <button type="submit" class="form-control">Create Account</button>
        </form> 

        <br>
        <br>
        <br>
       
      </div>
      <!--widgets removed from bootstrap template-->
      </div>

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Your Website 2020</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="misc/vendor/jquery/jquery.min.js"></script>
  <script src="misc/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
