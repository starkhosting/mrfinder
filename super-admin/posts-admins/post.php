<?php

include '../../components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:home.php');
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>post</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="/group/css/style.css">
   <link rel="stylesheet" href="/groupcss/iconfix.css">
   <link rel="stylesheet" href="/group/css/modification.css">

</head>
<body>

<?php include '../../components/user_header.php'; ?>

<!-- post section starts  -->

<section class="post">

   <h1 class="heading">Details </h1>

   <div class="row">

      <?php
         $select_post = $conn->prepare("SELECT * FROM `post` WHERE id = ? and status = ? LIMIT 1");
         $select_post->execute([$get_id, 'active']);
         if($select_post->rowCount() > 0){
            $fetch_post = $select_post->fetch(PDO::FETCH_ASSOC);

            $post_id = $fetch_post['id'];

            

            $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE id = ? LIMIT 1");
            $select_admin->execute([$fetch_post['admin_id']]);
            $fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC);

            $select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ? AND post_id = ?");
            $select_bookmark->execute([$user_id, $post_id]);

      ?>

      <div class="col">
        
         <div class="thumb">
           
            <img src="uploaded_files/<?= $fetch_post['thumb']; ?>" alt="">
         </div>
      </div>

      <div class="col">
         <div class="admin">
            <img src="uploaded_files/<?= $fetch_admin['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_admin['name']; ?></h3>
               <div><i class="fas fa-briefcase"></i><span><?= $fetch_admin['profession']; ?></span></div>
               <div><i class="fas fa-map-marker-alt"></i><span><?= $fetch_admin['location']; ?></span></div>
            </div>
         </div>
         <div class="details">
            <h3><?= $fetch_post['title']; ?></h3>

            <!-- <h2><span>Rs</span><?= $fetch_post['fees']; ?></h2> -->

            <p><?= $fetch_post['description']; ?></p>
            
            <!-- <a class="inline-option-btn" ><?= $fetch_admin['contact']; ?></a> -->

            <!-- contact info button -->

                  <div class="col">
                     <form action="" method="post" class="save-list">
                        <input type="hidden" name="list_id" value="<?= $post_id; ?>">
                        <?php
                           if($select_bookmark->rowCount() > 0){
                        ?>
                        <a class="inline-option-btn" ><?= $fetch_admin['contact']; ?></a>
                        <a class="inline-view-btn" ><?= $fetch_admin['email']; ?></a>
                        <?php
                           }else{
                        ?>
                           <button class="inline-btn" type="submit"  name="save_list"><span>view contact info</span></button>
                        <?php
                           }
                        ?>
                  </form>
            <!-- end contact info button -->
            
            <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_post['date']; ?></span></div>
         </div>
      </div>

      <?php
         }else{
            echo '<p class="empty">this post was not found!</p>';
         }  
      ?>

   </div>

</section>

<!-- post section ends -->












<?php include '../../components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>