<!--Template used from Bootstrap. 
Updates/Adaptations are commented on. 
Name: Kaitrin Harnish, Rachel Brownlee
Student Number: B00579658, B00738899
For: CSCI 3172
Fall 2020 
-->

<?php
//start session
  session_start();
//if not logged in redirect to login page
  if(!isset($_SESSION["loggedin"])){
      header('location: signin.php');
      die();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- title of page changed-->
  <title>Post</title>

  <!-- Bootstrap core CSS, href updated to new vendor file location -->
  <link href="misc/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/blog-post.css" rel="stylesheet">

</head>
<body>
    
<!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.php">Sew to Speak</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item ">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="addPost.php">Add Post</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="#">Admin View</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="#">Settings</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="signin.php">Sign In</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <!-- Post Content Column -->
      <div class="col-lg-8">

<!--php code to retrieve information from the database and post it on the respective page-->
<?php
  //retrieving querystring from the url, storing it in a variable for later use
  $postid = $_GET['title'];

  //retrieving informatino from the login.php file
  require_once('login.php');

  //connecting to database based on info from the login.php file or it quits and prints a connection error and reason 
  $conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_database) or die ("Error: Unable to connect to MySQL.".mysqli_connect_error());

  //saving the mysql query in a variable 
  $myquery = "SELECT*FROM Posts WHERE PostID = $postid";
  //querying the connected database via the mysql variable above, and saving the results in a new variable
  $result = $conn->query($myquery);
     
  //if the connection brought back results go into the while loop 
  if($result->num_rows>0){
    //while there is information to get, go through each row of the database's query results and store in an associative array 
    while ($row = $result->fetch_assoc()){
      //retrieve the title and print 
      printf("<h1>%s</h1>",$row['Title']);
      //printing username
      $author = $_SESSION['username'];

      //printing the date that was retrieved from the database
      printf("<p> Posted on %s</p><hr>",$row['Date']);
      
      //saving the image file location as a variable for easy access
      $img = 'files/'.$row['ImageFName'];

      //printing the img via the location variable 
      printf("<img class='img-fluid rounded' src='$img'/><hr>");
      //printing the actual text content 
      printf("<p>%s</p>",$row['Post']);
    }

  //if nothing was retrieved from the database, post the following message 
  } else {
    echo "Nothing here to display! Sorry!";
  }
 

  //retrieving the querystring from the url to determine what the postid is so that when a comment is save, it is saved to the correct post 
  $postid = $_GET['title'];

  //connecting to the database else printing an error msg + error reason 
  mysqli_select_db($conn,$db_database) or die ("Unable to select database: ");

  //storing username for check later
  $username=$_SESSION['username'];

  //creating variable for future storage
  $userid="";

  //query to get info from login 
  $useridquery = "SELECT * from Login";

  //result of above query
  $useridresult = $conn->query($useridquery);

  //if there is a result, store result in array
  if($useridresult->num_rows>0){
    while ($row = $useridresult->fetch_assoc()){
      //if user name of session is equaly to the retrived row
      if ($username === $row['username']){
        //set user id to the value of the retrieved row
        $userid=$row['UserID'];
      }
    }
    //else, print result msg
  } else {
    echo "There was no result";
  }

  //if the form name is set to formsubmit
  if (isset($_POST['formSubmit'])){
    //and if the value/action is Submit
    if($_POST['formSubmit'] == 'Submit'){
      //take the comment and retrieve that information from the input box
      //this line was used for testing but did not work when inserting values. 
      $comment = $_POST['Comment'];

      //insert the important values into the table
      //inserting the $_POST line through values as per advice from a TA in the learning centre 
      //for some reason, the userid is not being stored as what is retrieved. 
      $sql = "INSERT INTO Comments (Comment,PostID, UserID) VALUES ('".$_POST["Comment"]."','$postid','$userid')"; 

      echo "<br>"; 

      //if the comment is saved to the database, express that feedback 
      if ($conn->query($sql) === TRUE){
        echo "New record created successfully"; 
      //else, show them that there was an error and what the error is 
      } else {
        echo "Error: ".$sql. "<br>" .$conn->error; 
      }
    }
  }
  //close the database connection 
  $conn -> close();  
?>

  <input type="submit" name="download" value="Download">
  <input type="submit" name="report" value="Report">

        <hr>

        <!-- Comments Form -->
        <div class="card my-4">
          <h5 class="card-header">Leave a Comment:</h5>
          <div class="card-body">
            <form method="post">
              <div class="form-group">
                <input type="text" name ="Comment" class="form-control" rows="3">
              </div>
              <input type="submit" name="formSubmit" value="Submit">
            </form>
          </div>
        </div>

<!--this is to show the comments for the respective post--> 
<?php
  //retrieving information from the login.php file 
  require_once('login.php');
  //getting the querystring from the url 
  $postid = $_GET['title'];
  //connecting to the database based on the information retrieved from login.php. if there is an error in the connection, the error message and reason gets printed 
  $conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_database) or die ("Error: Unable to connect to MySQL.".mysqli_connect_error());
  //the mysql query to retrieve all of the results from the Comments table where the PostID in the database is equal to the querystring variable we retrieved earlier, and is then ordered by date from newest to oldest 
  $myquery = "SELECT*FROM Comments WHERE PostID = $postid ORDER BY Date DESC";
  //querying the database and saving that information into a variable 
  $result = $conn->query($myquery); 

  //sees if anything is returned from the query 
  if($result->num_rows>0) {
    //if something is returned, store all values into an associative array 
    while ($row = $result->fetch_assoc()) {
      //retrieving and printing the data of the comment 
      printf("<h4>Date: %s</h4>", $row['Date']);
      //retrieving and printing the actual comment
      printf("<p>%s</p><br>",$row['Comment']);
    }
  //if nothing is found via the database query, let the user know
  } else {
    echo "Be the first to comment!";

  }
  //closing the connection 
  $conn -> close(); 
?>
    </div>

      <!-- Sidebar Widgets Column -->
      <div class="col-md-4">
        <br>
        <br>
        <br>
        <!-- Search Widget -->
        <!-- Categories Widget -->

        <!-- logout side Widget -->
        <div class="card my-4">
          <h5 class="card-header">Login/Logout</h5>
          <div class="card-body">

            <?php
            //if session is set
            if (isset($_SESSION['username'])){
              //store username
              $username = $_SESSION['username'];
              //print the logged in username for user
              printf("%s is logged in.<br>",$username);
              //print outout button with connection to logout script
              printf('<a href="logout.php">Logout</a>');
            } else {
              //if nobody is logged in, and if for some reason they can view the page without it being redirected, 
              //show that nobody is logged in and give them the option to log in
              //this was primarily used for login checks when redirecting was not working properly
              //leaving in code as failsafe
              printf("Nobody is logged in.<br>");
              printf('<a href="signin.php">Sign In</a>');
            }
            ?>
            
            <br> 
          </div>
        </div>

        <!--report widget-->
        <div class="card my-4">
          <h5 class="card-header">Report Post</h5>
          <div class="card-body">
            <form method="post">
              <input type="text" name="Reason" class="form-control" rows="5">
          </div>
          <input type="submit" name="reportSubmit" class="btn btn-primary" value="Submit Report">
        </div>
      </div>
    </div>

    
    <!--php code to retrieve information from the database and post it on the respective page-->
    
  <?php
    //retrieving querystring from the url, storing it in a variable for later use
    $postid = $_GET['title'];

    //retrieving information from the login.php file
    require_once('login.php');

    //connecting to database based on info from the login.php file or it quits and prints a connection error and reason 
    $conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_database) or die ("Error: Unable to connect to MySQL.".mysqli_connect_error());

    //if submit report button is clicked via form, run the following code: 
    if (isset($_POST['reportSubmit'])){
      
      //if the value is also is equal to what it should be continue 
      if($_POST['reportSubmit'] == 'Submit Report'){
        //this did not work when testing however it is supposed to set variables as the data input from the form 

        $reason = $_POST['Reason'];

        //insert statement to put into database
        $sql = "INSERT INTO Reports (PostID, Reason) VALUES ('$postid', '".$_POST["Reason"]."')";

        echo "<br>";

        if ($conn->query($sql) == TRUE){
        echo "Post reported successfully"; 
        //else, show them that there was an error and what the error is 
        } else {
          echo "Error connecting to the database."; 
        }
      }
    }
    $conn -> close();
  ?>
    
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