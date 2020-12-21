<!--Template used from Bootstrap. 
Updates/Adaptations are commented on. 
Name: Kaitrin Harnish, Rachel Brownlee
Student Number: B00579658, B00738899
For: CSCI 3172
Fall 2020 
-->

<!--session starting on page-->
<?php
  session_start();

  //if session loggedin variable is not set, redirect to signin page and stop code on page
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

  <!--updated title-->
  <title>Add Post</title>

  <!-- Bootstrap core CSS -->
  <!--updated href to appropriate location-->
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
          <li class="nav-item active">
            <a class="nav-link" href="addPost.php">Add Post
            <span class="sr-only">(current)</span>
            </a>
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
        <br>
        <!--adapted form from create account page to do this page-->
        <h1>Add A Post</h1>

        <div class="card my-4">
          <h5 class="card-header">Sign In</h5>
          <div class="card-body">
            <form method="post">
              <div class="form-group">
                <label for="Title">Title</label>
                <input type="Title" class="form-control" id="Title" placeholder="Title" name="Title" required>
                <label for="Post">Your Post</label><br>
                <textarea placeholder="Add your content here" cols="50" rows="10" name="Post"></textarea><br>
                <label for="ImageFName">Image Name</label>
                <input type="ImageFName" class="form-control" id="ImageFName" placeholder="Enter image name" name="ImageFName" required>
              </div>
              <input type="submit" name="formSubmit" class="btn btn-primary" value="Submit">
            </form>
          </div>
        </div>

        <?php
          //set username var to session username, i.e. whoever is logged in
          $username=$_SESSION['username'];
          
          //access login.php to connect to database
          require_once('login.php');

          //connection script to database
          $conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_database) or die ("Error: Unable to connect to MySQL.".mysqli_connect_error());

          //query to getting userid from login 
          $id = "SELECT * FROM Login"; 

          //variable to store result in eventually
          $userid="";
         
          //result of query above
          $result = $conn->query($id);

          //if a result is returned, store result in array
          if($result->num_rows>0){
            while ($row = $result->fetch_assoc()){
              //if usernames are equal to session and database, set the userid to the result returned
              if ($username === $row['username']){
                $userid=$row['UserID'];
              }
            }

          //if nothing was retrieved from the database, post the following message 
          } else {
            echo "Nothing here to display! Sorry!";
          }

          //if submit button is clicked via form, run the following code
          if (isset($_POST['formSubmit'])){
            //if the value is also equal to submit
            if($_POST['formSubmit'] == 'Submit'){

              //set variables as the data inputted from the form 
              $Title=$_POST['Title'];
              $Post=$_POST['Post'];
              $ImageFName=$_POST['ImageFName'];

              //insert statement to put into database
              $sql = "INSERT INTO Posts (UserID, Title, Post, ImageFName) VALUES ('$userid','$Title','$Post','$ImageFName')";

              //if the query was run and executed without an errors, let the user know
              if (mysqli_query($conn, $sql)) {
                echo "New Post created successfully";
              } else {
                //otherwise tell them the error
                echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
              }
            }
          }

          //close the connection
          $conn -> close();
        ?>
      

        <br>
        <br>
        <br>
        
      </div>
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
