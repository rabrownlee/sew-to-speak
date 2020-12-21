<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <!--updated title-->
  <title>Create Account</title>

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
    </div>
  </nav>
  
  
  <!-- Page Content -->
  <div class="container">
    <div class="row">

      <!-- Create account content and form -->
      <div class="col-lg-8">
        <br>
        <h1>Create Your Account</h1>
        <p>If you do not have a user account, create one below:</p>

        <div class="card my-4">
          <h5 class="card-header">Please fill out the form below</h5>
          <div class="card-body">
            <form method="post">
              <div class="form-group">
                <label for="n">Name</label>
                <input type="n" class="form-control" id="n" placeholder="Name" name="n" required><br>
                <label for="username">Username</label>
                <input type="username" class="form-control" id="username" placeholder="Please pick a username" name="username" required>
                <br>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                <input type="password" class="form-control" id="password2" name="password2" placeholder="Confirm password" required>
              </div>
              <p>If your registration is successful, you will be re-routed to the login screen.</p>
              <input type="submit" name="formSubmit" class="btn btn-primary" value="Continue to Paypal">
            </form>
          </div>
          <input type="submit" class="btn btn-primary" value="Return to Log In" onclick="window.location='/index.php';" />
        </div>

        <?php
        //linking database login code
          require_once('login.php');

          //setting variable to use later
          $last_id="";

          //connecting to the database
          $conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_database) or die ("Error: Unable to connect to MySQL.".mysqli_connect_error());

          //first query
          $myquery = "SELECT*FROM Users";

          //result of first query being ran
          $result = $conn->query($myquery);
          $hash = "";

          //checking to see if POST or GET
          $myvar=$_SERVER['REQUEST_METHOD'];

          //if the form submit is set, and the value is set to Submit, store all of the data needed in variables. 
          if (isset($_POST['formSubmit'])){
            if($_POST['formSubmit'] == 'Submit'){
              $username=$_POST['username'];
              $name=$_POST['n'];
              $password=$_POST['password'];
              $confirm=$_POST['password2'];
              //$about=$_POST['about'];
              //$image=$_POST['image'];

              // Validate password strength
              $uppercase = preg_match('@[A-Z]@', $password);
              $number    = preg_match('@[0-9]@', $password);
              $specialChars = preg_match('@[^\w]@', $password);

              if(!$uppercase || !$number || !$specialChars || strlen($password) < 8) {
                echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
                die; 
              }else{
                echo 'Strong password.';
              }

              //second query to get username 
              $stmt = "SELECT * FROM Login WHERE username = '".$username."'"; 

              //sending the query to the database
              $usernameresult = $conn->query($stmt);

              //if a result is returned and provides 1 or more rows, the user name is already in the database
              if(mysqli_num_rows($usernameresult)>=1){
                echo"Username already exists";
              } else {
              //if the results are less than 1, i.e. 0, it does not exist. 
                //check to see if the two passwords are the same 
                if ($password == $confirm) {

                  //insert statement to Create user information in database
                  $sql = "INSERT INTO Users (Name) VALUES ('$name')";

                  //if the query is successfully inserted, show the user account is created
                  if (mysqli_query($conn, $sql)) {
                      echo "New User record created successfully<br>";
                      $last_id = $conn->insert_id;
                      //echo "$last_id";

                      //for some reason, my database wouldn't let me execute the next query without closing and reconnecting to the database
                      $conn -> close();

                      //accessing login.php again 
                      require_once('login.php');

                      //reconnecting
                      $conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_database) or die ("Error: Unable to connect to MySQL.".mysqli_connect_error());

                      //selecting information from the database 
                      $myquery = "SELECT * FROM Users WHERE Name = $name";

                      //going into another loop to makingsure everything is set
                      //had to do a second check due to the reconnection of the database 
                      if (isset($_POST['formSubmit'])){
                        if($_POST['formSubmit'] == 'Submit'){
                          $username=$_POST['username'];
                          $password=$_POST['password'];
                          $confirm=$_POST['password2'];


                          $hash = password_hash($password,PASSWORD_DEFAULT); 

                          //storing result into a variable 
                          $result = $conn->query($myquery);


                          //insert statement
                          $sql = "INSERT INTO Login (UserID, username, password)VALUES ('$last_id','$username','$hash')";

                          //if to see if it was inserted correctly, shows user if it was created successfully.
                          if (mysqli_query($conn, $sql)) {
                            echo "New Login record created successfully";

                            //sets session variables if the passwords are the same and username isnt taken (check above)
                            $_SESSION['username']=$username;
                            $_SESSION['loggedin']=true; 
                            //redirect to homepage
                            header('location: index.php');
                            exit();

                          } else {
                            //prints error if sql is not qorking correctly 
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                          }
                        }
                      }
                    } else {
                      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                  } else {
                    echo "Passwords do not match.";
                    //stops executing if passwords do not match
                    die();
                }
              }
            }
          }

          //closing the connection for good this time 
          $conn -> close();
        ?>
      
        <br>
        <br>
        <br>
        
      </div>
      </div>

      <!--widgets removed from bootstrap template-->

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
