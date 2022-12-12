<?php 
  session_start();
  
  if(!isset($_SESSION['adminname'])){
    header("location: admins/login-admins.php");
  }
?>
<?php require "db/config.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
    <title>Super-Admin Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
     <link href="styles/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>

<?php require "layouts/header.php"; ?>
<?php

  // displaying data in dashbord

  // admin
  $select_superadmin = $conn->query("SELECT COUNT(*) AS admins_number FROM super_admin");
  $select_superadmin->execute();
  $admins =$select_superadmin->fetch(PDO::FETCH_OBJ);

  // providers
  $select_provider = $conn->query("SELECT COUNT(*) AS providers_number FROM admin");
  $select_provider-> execute();
  $provider = $select_provider->fetch(PDO::FETCH_OBJ);

  // customer
  $select_customer = $conn->query("SELECT COUNT(*) AS customers_number FROM users");
  $select_customer-> execute();
  $customer = $select_customer->fetch(PDO::FETCH_OBJ);

  // post
  $select_post = $conn->query("SELECT COUNT(*) AS posts_number FROM post");
  $select_post-> execute();
  $post = $select_post->fetch(PDO::FETCH_OBJ);

?>
            
      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Posts</h5>
              <!-- <h6 class="card-subtitle mb-2 text-muted">Bootstrap 4.0.0 Snippet by pradeep330</h6> -->
              <p class="card-text">number of posts: <?php echo $post->posts_number; ?> </p>
             
            </div>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Providers</h5>
              <p class="card-text">number of Providers: <?php echo $provider->providers_number; ?> </p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Customers</h5>
              <p class="card-text">number of customers: <?php echo $customer->customers_number; ?> </p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Admins</h5>
              <p class="card-text">number of admins: <?php echo $admins->admins_number; ?> </p>
            </div>
          </div>
        </div>
      </div>
     <!--  <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Card title</h5>
              <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Larry</td>
      <td>the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table> -->
<?php require "layouts/footer.php"; ?>  
