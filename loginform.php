<?php
  $login = false;
  $showError = false;

  $servername="localhost";
  $username="root";
  $password="";
  $database="dnyanu3";

  $conn=mysqli_connect($servername,$username,$password,$database,);


  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $password = $_POST["password"]; 
    // $sql = "Select * from users where username='$username' AND password='$password'";
    $sql = "Select * from users where username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num ==1){
      $login = true;
      session_start();
      $_SESSION['loggedin'] = true;
      $_SESSION['username'] = $username;
      header("location: index.php");
    } 
    else{
        $showError = " Wrong Password and username!";
    }
  }   
?>


<style>
  .gradient-custom {
    /* fallback for old browsers */
    background: #6a11cb;

    /* Chrome 10-25, Safari 5.1-6 */
    background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

    /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
  }

  .logo{
    flex-basis: 20%;
  }
  .logo img{
    width: 150px;
  }
</style>


<?php
    if($login){
      echo ' <div class="alert alert-success alert-dismissible fade     show" role="alert">
        <strong>Success!</strong> You are logged in
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div> ';
    }
    if($showError){
      echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> '. $showError.'
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div> ';
    }
  ?>

<section class="vh-50 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
              <p class="text-white-50 mb-5">Please enter your username and password!</p>

              <form action="/loginSystem/login.php" method="post">
                <div class="form-group">
                  <label for="username"><h4>Username</h4></label>
                  <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
            
                </div>
                <div class="form-group">
                  <label for="password"><h4>Password</h4></label>
                  <input type="password" class="form-control" id="password" name="password">
                </div>
       
                <br>
                <button type="submit" class="btn btn-primary">Login</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>