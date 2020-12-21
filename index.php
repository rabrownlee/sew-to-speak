<!--Template used from Bootstrap. 
Updates/Adaptations are commented on. 
Name: Kaitrin Harnish, Rachel Brownlee
Student Number: B00579658, B00738899
For: CSCI 3172
Fall 2020 
-->

<?php
  session_start();

  //if loggedin session variable not set, redirect to signin page
  if(!isset($_SESSION["loggedin"])){
    header('location: signin.php');
    die();
  }
  //following lines were used for debugging
  //$username="$_SESSION['username']";
  //printf("%s",$username);
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>HomePage</title>


  <!-- Bootstrap core CSS 
  href updated to reflect relocation of the vendor folder-->
  <link href="misc/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/blog-home.css" rel="stylesheet">

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
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Home
            <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
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

      <!-- Blog Entries Column -->
      <div class="col-md-8">

        <h1 class="my-4">Sew to Speak</h1>

        <!-- Blog Post-->
        <!-- this is the php code for displaying the blog posts-->
        <?php 
          //retrieving information from login.php
          require_once('login.php');

          //establishing a connection with the database through the local server
          //prints an error message and code if it fails to connect. 
          $conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_database) or die ("Error: Unable to connect to MySQL.".mysqli_connect_error());

          //sending the query to the database. It is retrieving all items from the Posts table and ordering them by date in descending order (i.e. from newest to oldest)
          $myquery = "SELECT*FROM Posts ORDER BY Date DESC";

          //sending the query to the database and storying the results in a variable
          $result = $conn->query($myquery);

          //check to see if any results are returned 
          if($result->num_rows>0) {
            //storing all row results into an associate array 
            while ($row = $result->fetch_assoc()) {
              //printing the first div of the card for each blog post
              printf("<div class='card mb-4'>"); 
              
                //storing the file location in a variable for easy access 
                $img = 'files/'.$row['ImageFName'];
                
                //printing the image within the blog post card, at the top        
                printf("<img class='card-img-top' src='$img'/>");
                //creating a div w/i a div for the rest of the post 
                printf("<div class='card-body'>");
                  //printing the title of the blog post based on the result from the mysql query
                  printf("<h2 class='card-title'> %s </h2>",$row["Title"]);
                  //creating a substr of the Post content to print ~3 lines worth of text
                  $text = substr($row["Post"],0,275)."...";
                  //printing that substring variable 
                  printf("<p class='card-text'> %s </p>", $text);
                  //retrieving the PostID to use as a querystring
                  $postid = $row['PostID'];

                  //putting the querystring into the href url to bring to the post.php page based on the link that was clicked
                  printf('<a href="post.php?title=%s" class="btn btn-primary">'."Read More &rarr;</a>",$postid);

                printf("</div>");

                //footer of the post box 
                printf("<div class='card-footer text-muted'>");

                $username=$_SESSION['username'];
                  if ($row["UserID"] == 1){
                    $author = "Lorem Ipsum";
                  } else {
                    $author=$username;
                  }
                  //printing the date and author link 
                  printf("Posted on %s", $row["Date"]);
                printf("</div>");
              printf("</div>");
            }
          //if there was no information in the table, then it displays this message
          } else {
            echo "Nothing here to display! Sorry!";
          }

          //closing the connection to the database 
          $conn  -> close(); 
        ?>

      </div>

      <!-- Sidebar Widgets Column -->
      <div class="col-md-4">

        <!-- Search Widget -->
        <br>
        <br>
        <br>

        <!-- Categories Widget -->
        

        <!-- Side Widget -->
        <div class="card my-4">
          <h5 class="card-header">Login/Logout</h5>
          <div class="card-body">
            <?php
            //if session user name is set, print and provide logout link that connect to logout script
              if (isset($_SESSION['username'])){
                $username = $_SESSION['username'];
                printf("%s is logged in.<br>",$username);
                printf('<a href="logout.php">Logout</a>');
              //failself left in from debugging 
              } else {
                printf("Nobody is logged in.<br>");
                printf('<a href="signin.php">Sign In</a>');
              }
            ?>
            
            <br>      
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container 
    this was the "Older" / "Newer" buttons that were not implemented at the bottom. 
    as per assignment, these have been removed-->


  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Your Website 2020</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript
  locations updated to correct file location -->
  <script src="misc/vendor/jquery/jquery.min.js"></script>
  <script src="misc/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
