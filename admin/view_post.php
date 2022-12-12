<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   header('location:login.php');
}

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:post.php');
}

if(isset($_POST['delete_post'])){
   $delete_id = $_POST['post_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
   $delete_post_thumb = $conn->prepare("SELECT * FROM `post` WHERE id = ? LIMIT 1");
   $delete_post_thumb->execute([$delete_id]);
   $fetch_thumb = $delete_post_thumb->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_files/'.$fetch_thumb['thumb']);
   $delete_bookmark = $conn->prepare("DELETE FROM `bookmark` WHERE post_id = ?");
   $delete_bookmark->execute([$delete_id]);
   $delete_post = $conn->prepare("DELETE FROM `post` WHERE id = ?");
   $delete_post->execute([$delete_id]);
   header('locatin:posts.php');
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>post Details</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">
   <link rel="stylesheet" href="../css/modification.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>
   
<section class="post-details">

   <h1 class="heading">advertisment details</h1>

   <?php
      $select_post = $conn->prepare("SELECT * FROM `post` WHERE id = ? AND admin_id = ?");
      $select_post->execute([$get_id, $admin_id]);
      if($select_post->rowCount() > 0){
         while($fetch_post = $select_post->fetch(PDO::FETCH_ASSOC)){
            $post_id = $fetch_post['id'];
            
   ?>
   <div class="row">
      <div class="thumb">
        
         <img src="../uploaded_files/<?= $fetch_post['thumb']; ?>" alt="">
      </div>
      <div class="details">
         <h3 class="title"><?= $fetch_post['title']; ?></h3>
         <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_post['date']; ?></span></div>
         <div class="description"><?= $fetch_post['description']; ?></div>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="post_id" value="<?= $post_id; ?>">
            <a href="update_post.php?get_id=<?= $post_id; ?>" class="option-btn">update advertisment</a>
            
         </form>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no post found!</p>';
      }
   ?>

</section>

















<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>