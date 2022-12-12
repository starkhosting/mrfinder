<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>view_posts</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/iconfix.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- view_posts section starts  -->

<section class="view_posts">

   <h1 class="heading">all Ads</h1>

   <div class="box-container">

      <?php
         $select_view_posts = $conn->prepare("SELECT * FROM `post` WHERE status = ? ORDER BY date DESC");
         $select_view_posts->execute(['active']);
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
               <i class="fas fa-map-marker-alt"></i><span><?= $fetch_admin['location']; ?></span> <br>
               <span><?= $fetch_post['date']; ?></span>
            </div>
         </div>
         <img src="uploaded_files/<?= $fetch_post['thumb']; ?>" class="thumb" alt="">
         <center><h3 class="title"><?= $fetch_post['title']; ?></h3>
         <a href="post.php?get_id=<?= $post_id; ?>" class="inline-btn">view</a></center>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no Ads added yet!</p>';
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