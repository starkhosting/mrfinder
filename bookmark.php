<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
}


if(isset($_POST['save_list'])){

   if($user_id != ''){
      
      $list_id = $_POST['list_id'];
      $list_id = filter_var($list_id, FILTER_SANITIZE_STRING);

      $select_list = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ? AND post_id = ?");
      $select_list->execute([$user_id, $list_id]);

      if($select_list->rowCount() > 0){
         $remove_bookmark = $conn->prepare("DELETE FROM `bookmark` WHERE user_id = ? AND post_id = ?");
         $remove_bookmark->execute([$user_id, $list_id]);
         $message[] = 'removed!';
      }

   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>bookmarks</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/modification.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="view_posts">

   <h1 class="heading">bookmarked posts</h1>

   <div class="box-container">

      <?php
         $select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ?");
         $select_bookmark->execute([$user_id]);
         if($select_bookmark->rowCount() > 0){
            while($fetch_bookmark = $select_bookmark->fetch(PDO::FETCH_ASSOC)){
               $select_view_posts = $conn->prepare("SELECT * FROM `post` WHERE id = ? AND status = ? ORDER BY date DESC");
               $select_view_posts->execute([$fetch_bookmark['post_id'], 'active']);
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
         
         <div class="admin">
            
            <a href="post.php?get_id=<?= $post_id; ?>" class="inline-btn">view post</a>
            <!-- button remove -->
            <form action="" method="post" class="save-list">
               <input type="hidden" name="list_id" value="<?= $post_id; ?>">
               <?php
                  if($select_bookmark->rowCount() > 0){
               ?>
               <button class="inline-btn" type="submit" name="save_list">remove</button>
               <?php
                  }
               ?>
            </form>
            <!-- end button remove -->
         </div>

      </div>
      <?php
               }
            }else{
               // echo '<p class="empty">no viewed posts found!</p>';
            }
         }
      }else{
         echo '<p class="empty">nothing viewed yet!</p>';
      }
      ?>

   </div>

</section>










<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>