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
   <link rel="stylesheet" href="css/modification.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- view_posts section starts  -->

<section class="view_posts">

   <h1 class="heading">search results</h1>

   <div class="box-container">

      <?php
         if(isset($_POST['search_post']) or isset($_POST['search_post_btn'])){
         $search_post = $_POST['search_post'];
         $select_view_posts = $conn->prepare("SELECT * FROM `post` WHERE title LIKE '%{$search_post}%' AND status = ?");
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
               <span><?= $fetch_post['date']; ?></span>
            </div>
         </div>
         <img src="uploaded_files/<?= $fetch_post['thumb']; ?>" class="thumb" alt="">
         <h3 class="title"><?= $fetch_post['title']; ?></h3>
         <a href="post.php?get_id=<?= $post_id; ?>" class="inline-btn">view</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no posts found!</p>';
      }
      }else{
         echo '<p class="empty">please search something!</p>';
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