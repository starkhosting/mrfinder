<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   header('location:login.php');
}



$select_posts = $conn->prepare("SELECT * FROM `post` WHERE admin_id = ?");
$select_posts->execute([$admin_id]);
$total_posts = $select_posts->rowCount();





?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">
   <link rel="stylesheet" href="../css/modification.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>
   
<section class="dashboard">

   <h1 class="heading">dashboard</h1>

   <div class="box-container">

      <!-- <div class="box">
         <h3>welcome!</h3>
         <p><?= $fetch_profile['name']; ?></p>
         <p>Admin</p>
         <a href="profile.php" class="btn">view profile</a>
      </div> -->

      
      
      <div class="box">
         <h3><?= $total_posts; ?></h3>
         <p>total Ads</p>
         <a href="add_post.php" class="btn">Add new advertisment</a>
      </div>

      
      

      
      
      <div class="box">
         <h3><?= $total_posts; ?></h3>
         <p>total Posts</p>
         <a href="posts.php" class="btn">view posts</a>
      </div>

   </div>

</section>















<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>