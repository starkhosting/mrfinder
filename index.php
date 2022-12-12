<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}








$select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ?");
$select_bookmark->execute([$user_id]);
$total_bookmarked = $select_bookmark->rowCount();

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

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

   <h1 class="heading">latest posts</h1>

   <div class="box-container">

      <?php
         
         $select_view_posts = $conn->prepare("SELECT * FROM `post` WHERE status = ? AND approval = ? ORDER BY date DESC LIMIT 6");
         $select_view_posts->execute(['active','1']);
         
         
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
         <a href="post.php?get_id=<?= $post_id; ?>" class="inline-btn">view advertisment</a></center>
         </div>
         <?php
            }
         }else{
            echo '<p class="empty">no posts added yet!</p>';
         }
         ?>

   </div>

   

</section>

<!-- view_posts section ends -->












<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>