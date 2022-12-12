<?php 

session_start();

if(isset($_SESSION['adminname'])){
  header("location: /super-admin/index.php");
}
?>

<?php require "../db/config.php" ?>

<?php
if(isset($_POST['submit'])) {
  if($_POST['email'] == '' OR $_POST['password'] == '') {
      echo "<div class='alert alert-danger  text-center  role='alert'>
            enter data into the inputs
        </div>";
  } else {
      $email = $_POST['email'];
      $password = $_POST['password'];

      $login = $conn->query("SELECT * FROM super_admin WHERE email = '$email'");

      $login->execute();

      $row = $login->FETCH(PDO::FETCH_ASSOC);

       if($login->rowCount() > 0) {

          if(password_verify($password, $row['mypassword'])){
              
              /* declare session name and variable */
              $_SESSION['adminname'] = $row['adminname'];
              $_SESSION['admin_id'] = $row['id'];
              header('location: /super-admin/index.php');
          } else {

            echo "<div class='alert alert-danger  text-center text-white role='alert'>
                      the email or password is wrong
                  </div>";
           }


       } else {

        echo "<div class='alert alert-danger  text-center  role='alert'>
                  the email or password is wrong
              </div>";
       }
  }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
    <title>Super-Admin Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
     <link href="../styles/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>

<?php require "../layouts/header.php"; ?>



      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mt-5">Login</h5>
              <form method="POST" class="p-auto" action="login-admins.php">
                  <!-- Email input -->
                  <div class="form-outline mb-4">
                    <input type="email" name="email" id="form2Example1" class="form-control" placeholder="Email" />
                   
                  </div>

                  
                  <!-- Password input -->
                  <div class="form-outline mb-4">
                    <input type="password" name="password" id="form2Example2" placeholder="Password" class="form-control" />
                    
                  </div>



                  <!-- Submit button -->
                  <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Login</button>

                 
                </form>

            </div>
       </div>
     </div>
    </div>
  <?php require "../layouts/footer.php"; ?>