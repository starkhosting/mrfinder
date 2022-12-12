<?php 

  session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
    <title>Super-Admin Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
     <link href="../styles/style.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>

<?php require "../layouts/header.php"; ?>
<?php require "../db/config.php"; ?>


<?php  

    if(!isset($_SESSION['adminname'])) {
      header("location: /group/super-admin/admins/login-admins.php");
    }



    if(isset($_POST['submit'])) {

        if($_POST['email'] == '' OR $_POST['adminname'] == '' OR $_POST['password'] == '') {
          echo "<div class='alert alert-danger  text-center  role='alert'>
                  enter data into the inputs
                </div>";
        } else {
          $email = $_POST['email'];
          $adminname = $_POST['adminname'];
          $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

          $insert  = $conn->prepare("INSERT INTO super_admin (email, adminname, mypassword) VALUES
          (:email, :adminname, :mypassword)");

          $insert->execute([
            ':email' => $email,
            ':adminname' => $adminname,
            ':mypassword' => $password
          ]);

          header("location: /group/super-admin/admins/admins.php");



        }
      
    }


?>


  
       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Create Admins</h5>
          <form method="POST" action="" enctype="multipart/form-data">
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                  <input type="email" name="email" id="form2Example1" class="form-control" placeholder="email" />
                 
                </div>

                <div class="form-outline mb-4">
                  <input type="text" name="adminname" id="form2Example1" class="form-control" placeholder="admin name" />
                </div>
                <div class="form-outline mb-4">
                  <input type="password" name="password" id="form2Example1" class="form-control" placeholder="password" />
                </div>

               
            
                
              


                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>

          
              </form>

            </div>
          </div>
        </div>
      </div>
  </div>
<script type="text/javascript">

</script>
</body>
</html>