<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['admin_fetch'])){

   $admin_email = $_POST['admin_email'];
   $admin_email = filter_var($admin_email, FILTER_SANITIZE_STRING);
   $select_admin = $conn->prepare('SELECT * FROM `admin` WHERE email = ?');
   $select_admin->execute([$admin_email]);

   $fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC);
   $admin_id = $fetch_admin['id'];

   $count_posts = $conn->prepare("SELECT * FROM `post` WHERE admin_id = ?");
   $count_posts->execute([$admin_id]);
   $total_posts = $count_posts->rowCount();

   

}else{
   header('location:teachers.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin's profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- teachers profile section starts  -->

<section class="admin-profile">

   <h1 class="heading">profile details</h1>

   <div class="details">
      <div class="admin">
         <img src="uploaded_files/<?= $fetch_admin['image']; ?>" alt="">
         <h3><?= $fetch_admin['name']; ?></h3>
         <span><?= $fetch_admin['profession']; ?></span>
      </div>
      <div class="flex">
         <p>total posts : <span><?= $total_posts; ?></span></p>
         
      </div>
   </div>

</section>

<!-- teachers profile section ends -->

<section class="view_posts">

   <h1 class="heading">latest courese</h1>

   <div class="box-container">

      <?php
         $select_view_posts = $conn->prepare("SELECT * FROM `post` WHERE admin_id = ? AND status = ?");
         $select_view_posts->execute([$admin_id, 'active']);
         if($select_view_posts->rowCount() > 0){
            while($fetch_post = $select_view_posts->fetch(PDO::FETCH_ASSOC)){
               $post_id = $fetch_post['id'];

               $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
               $select_admin->execute([$fetch_post['admin_id']]);
               $fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC);
      ?>
      <div class="box">
         <div class="admin">
            <img src="uploaded_files/<?= $fetch_admin['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_admin['name']; ?></h3>
               <span><?= $fetch_post['date']; ?></span>
            </div>
         </div>
         <img src="uploaded_files/<?= $fetch_post['thumb']; ?>" class="thumb" alt="">
         <h3 class="title"><?= $fetch_post['title']; ?></h3>
         <a href="post.php?get_id=<?= $post_id; ?>" class="inline-btn">view post</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no view_posts added yet!</p>';
      }
      ?>

   </div>

</section>

<!-- view_posts section ends -->










<?php include 'components/footer.php'; ?>    

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>