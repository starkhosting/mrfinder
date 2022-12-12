<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   header('location:login.php');
}

if(isset($_POST['delete'])){
   $delete_id = $_POST['post_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_post = $conn->prepare("SELECT * FROM `post` WHERE id = ? AND admin_id = ? LIMIT 1");
   $verify_post->execute([$delete_id, $admin_id]);

   if($verify_post->rowCount() > 0){

   

   $delete_post_thumb = $conn->prepare("SELECT * FROM `post` WHERE id = ? LIMIT 1");
   $delete_post_thumb->execute([$delete_id]);
   $fetch_thumb = $delete_post_thumb->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_files/'.$fetch_thumb['thumb']);
   $delete_bookmark = $conn->prepare("DELETE FROM `bookmark` WHERE post_id = ?");
   $delete_bookmark->execute([$delete_id]);
   $delete_post = $conn->prepare("DELETE FROM `post` WHERE id = ?");
   $delete_post->execute([$delete_id]);
   $message[] = 'post deleted!';
   }else{
      $message[] = 'post already deleted!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>posts</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">
   <!-- <link rel="stylesheet" href="../css/modification.css"> -->

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="posts">

   <h1 class="heading">added Advertisments</h1>

   <div class="box-container">
   
      

      <?php
         $select_post = $conn->prepare("SELECT * FROM `post` WHERE admin_id = ? ORDER BY date DESC");
         $select_post->execute([$admin_id]);
         if($select_post->rowCount() > 0){
         while($fetch_post = $select_post->fetch(PDO::FETCH_ASSOC)){
            $post_id = $fetch_post['id'];
           
      ?>
      <div class="box">
         <div class="flex">
            <div><i class="fas fa-circle-dot" style="<?php if($fetch_post['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"></i><span style="<?php if($fetch_post['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"><?= $fetch_post['status']; ?></span></div>
            <div><i class="fas fa-calendar"></i><span><?= $fetch_post['date']; ?></span></div>
         </div>
         <div class="thumb">
            
            <img src="../uploaded_files/<?= $fetch_post['thumb']; ?>" alt="">
         </div>
         <h3 class="title"><?= $fetch_post['title']; ?></h3>
         <p class="description"><?= $fetch_post['description']; ?></p>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="post_id" value="<?= $post_id; ?>">
            <a href="update_post.php?get_id=<?= $post_id; ?>" class="option-btn">update</a>
            <input type="submit" value="delete" class="delete-btn" onclick="return confirm('delete this post?');" name="delete">
         </form>
         <a href="view_post.php?get_id=<?= $post_id; ?>" class="btn">view</a>
      </div>
      <?php
         } 
      }else{
         echo '<p class="empty">no advertisment added yet!</p>';
      }
      ?>

   </div>

</section>













<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

<script>
   document.querySelectorAll('.posts .box-container .box .description').forEach(content => {
      if(content.innerHTML.length > 100) content.innerHTML = content.innerHTML.slice(0, 100);
   });
</script>

</body>
</html>