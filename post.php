<?php

include 'components/connect.php';

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


if(isset($_POST['like_content'])){

   if($user_id != ''){

      $post_id = $_POST['post_id'];
      $post_id = filter_var($post_id, FILTER_SANITIZE_STRING);

      $select_post = $conn->prepare("SELECT * FROM `post` WHERE id = ? LIMIT 1");
      $select_post->execute([$post_id]);
      $fetch_post = $select_post->fetch(PDO::FETCH_ASSOC);

      $admin_id = $fetch_post['admin_id'];

      $select_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ? AND post_id = ?");
      $select_likes->execute([$user_id, $post_id]);

      if($select_likes->rowCount() > 0){
         $remove_likes = $conn->prepare("DELETE FROM `likes` WHERE user_id = ? AND post_id = ?");
         $remove_likes->execute([$user_id, $post_id]);
         $message[] = 'removed from likes!';
      }else{
         $insert_likes = $conn->prepare("INSERT INTO `likes`(user_id, admin_id, post_id) VALUES(?,?,?)");
         $insert_likes->execute([$user_id, $admin_id, $post_id]);
         $message[] = 'added to likes!';
      }

   }else{
      $message[] = 'please login first!';
   }
}


if(isset($_POST['add_comment'])){

   if($user_id != ''){

      $id = unique_id();
      $comment_box = $_POST['comment_box'];
      $comment_box = filter_var($comment_box, FILTER_SANITIZE_STRING);
      $post_id = $_POST['post_id'];
      $post_id = filter_var($post_id, FILTER_SANITIZE_STRING);

      $select_post = $conn->prepare("SELECT * FROM `post` WHERE id = ? LIMIT 1");
      $select_post->execute([$post_id]);
      $fetch_post = $select_post->fetch(PDO::FETCH_ASSOC);

      $admin_id = $fetch_post['admin_id'];

      if($select_post->rowCount() > 0){

         $select_comment = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ? AND user_id = ? AND admin_id = ? AND comment = ?");
         $select_comment->execute([$post_id, $user_id, $admin_id, $comment_box]);

         if($select_comment->rowCount() > 0){
            $message[] = 'comment already added!';
         }else{
            $insert_comment = $conn->prepare("INSERT INTO `comments`(id, post_id, user_id, admin_id, comment) VALUES(?,?,?,?,?)");
            $insert_comment->execute([$id, $post_id, $user_id, $admin_id, $comment_box]);
            $message[] = 'new comment added!';
         }

      }else{
         $message[] = 'something went wrong!';
      }

   }else{
      $message[] = 'please login first!';
   }

}

if(isset($_POST['delete_comment'])){

   $delete_id = $_POST['comment_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ?");
   $verify_comment->execute([$delete_id]);

   if($verify_comment->rowCount() > 0){
      $delete_comment = $conn->prepare("DELETE FROM `comments` WHERE id = ?");
      $delete_comment->execute([$delete_id]);
      $message[] = 'comment deleted successfully!';
   }else{
      $message[] = 'comment already deleted!';
   }

}

if(isset($_POST['update_now'])){

   $update_id = $_POST['update_id'];
   $update_id = filter_var($update_id, FILTER_SANITIZE_STRING);
   $update_box = $_POST['update_box'];
   $update_box = filter_var($update_box, FILTER_SANITIZE_STRING);

   $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ? AND comment = ?");
   $verify_comment->execute([$update_id, $update_box]);

   if($verify_comment->rowCount() > 0){
      $message[] = 'comment already added!';
   }else{
      $update_comment = $conn->prepare("UPDATE `comments` SET comment = ? WHERE id = ?");
      $update_comment->execute([$update_box, $update_id]);
      $message[] = 'comment edited successfully!';
   }

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
      }else{
         $insert_bookmark = $conn->prepare("INSERT INTO `bookmark`(user_id, post_id) VALUES(?,?)");
         $insert_bookmark->execute([$user_id, $list_id]);
         $message[] = 'Done!';
      }

   }else{
      $message[] = 'please login first! ';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>post</title>

   <!-- swiper awesome cdn link  -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/iconfix.css">
   <link rel="stylesheet" href="css/modification2.css">
   <link rel="stylesheet" href="css/comment.css">
   
</head>
<body>

<?php include 'components/user_header.php'; ?>

<?php
   if(isset($_POST['edit_comment'])){
      $edit_id = $_POST['comment_id'];
      $edit_id = filter_var($edit_id, FILTER_SANITIZE_STRING);
      $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ? LIMIT 1");
      $verify_comment->execute([$edit_id]);
      if($verify_comment->rowCount() > 0){
         $fetch_edit_comment = $verify_comment->fetch(PDO::FETCH_ASSOC);
?>
<section class="edit-comment">
   <h1 class="heading">edti comment</h1>
   <form action="" method="post">
      <input type="hidden" name="update_id" value="<?= $fetch_edit_comment['id']; ?>">
      <textarea name="update_box" class="box" maxlength="1000" required placeholder="please enter your comment" cols="30" rows="10"><?= $fetch_edit_comment['comment']; ?></textarea>
      <div class="flex">
         <a href="post.php?get_id=<?= $get_id; ?>" class="inline-option-btn">cancel edit</a>
         <input type="submit" value="update now" name="update_now" class="inline-btn">
      </div>
   </form>
</section>
<?php
   }else{
      $message[] = 'comment was not found!';
   }
}
?>

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

            $select_likes = $conn->prepare("SELECT * FROM `likes` WHERE post_id = ?");
            $select_likes->execute([$post_id]);
            $total_likes = $select_likes->rowCount();

            $verify_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ? AND post_id = ?");
            $verify_likes->execute([$user_id, $post_id]);

            $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE id = ? LIMIT 1");
            $select_admin->execute([$fetch_post['admin_id']]);
            $fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC);

            $select_profession = $conn->prepare("SELECT name FROM `profession` WHERE id = ? LIMIT 1");
            $select_profession->execute([$fetch_admin['profession_id']]);
            $fetch_profession = $select_profession->fetch(PDO::FETCH_ASSOC);

            $select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ? AND post_id = ?");
            $select_bookmark->execute([$user_id, $post_id]);

      ?>

      <div class="col">
        
      <div class="thumb">
           
           <img src="uploaded_files/<?= $fetch_post['thumb']; ?>" alt="">
           <p><span><?= $total_likes; ?> likes</span></p>
        </div>
      </div>

      <div class="col">
         <div class="admin">
            <img src="uploaded_files/<?= $fetch_admin['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_admin['name']; ?></h3>
               <div><i class="fas fa-briefcase"></i><span><?= $fetch_profession['name']; ?></span></div>
               <div><i class="fas fa-map-marker-alt"></i><span><?= $fetch_admin['location']; ?></span></div>
            </div>
         </div>
         <div class="details">
            <h3><?= $fetch_post['title']; ?></h3>

            <!-- <h2><span>Rs</span><?= $fetch_post['fees']; ?></h2> -->

            <p><?= $fetch_post['description']; ?></p>
            <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_post['date']; ?></span>
            
            </div>
            
            <!-- <a class="inline-option-btn" ><?= $fetch_admin['contact']; ?></a> -->

            <!-- contact info button -->

                  <div class="col">
                     <form action="" method="post" class="save-list">
                        <input type="hidden" name="list_id" value="<?= $post_id; ?>">
                        <?php
                           if($select_bookmark->rowCount() > 0){
                        ?>
                        <div class="date"><i class="fas fa-phone"></i><span><?= $fetch_admin['contact']; ?></span></div>
                        <div class="date"><i class="fas fa-envelope"></i><span><?= $fetch_admin['email']; ?></span></div>
                        <form action="" method="post" class="flex">
                              <input type="hidden" name="post_id" value="<?= $post_id; ?>">
                              
                              <?php
                                 if($verify_likes->rowCount() > 0){
                              ?>
                              <button type="submit" name="like_content"><i class="fas fa-heart"></i><span>liked</span></button>
                              <?php
                              }else{
                              ?>
                              <button type="submit" name="like_content"><i class="far fa-heart"></i><span>like</span></button>
                              <?php
                                 }
                              ?>
                           </form>
                        <?php
                           }else{
                        ?>
                           <button class="inline-btn" type="submit"  name="save_list"><span>view contact info</span></button>
                           <form action="" method="post" class="flex">
                              <input type="hidden" name="post_id" value="<?= $post_id; ?>">
                              
                              <?php
                                 if($verify_likes->rowCount() > 0){
                              ?>
                              <button type="submit" name="like_content"><i class="fas fa-heart"></i><span>liked</span></button>
                              <?php
                              }else{
                              ?>
                              <button type="submit" name="like_content"><i class="far fa-heart"></i><span>like</span></button>
                              <?php
                                 }
                              ?>
                           </form>
                        <?php
                           }
                        ?>
                  </form>
            <!-- end contact info button -->
            
            
            
            </div>
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


<!-- comments section starts  -->

<section class="comments">

   <h1 class="heading">add a comment</h1>

   <form action="" method="post" class="add-comment">
      <input type="hidden" name="post_id" value="<?= $get_id; ?>">
      <textarea name="comment_box" required placeholder="write your comment..." maxlength="1000" cols="30" rows="10"></textarea>
      <input type="submit" value="add comment" name="add_comment" class="inline-btn">
   </form>

   <h1 class="heading">user comments</h1>

   
   <div class="show-comments">
      <?php
         $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
         $select_comments->execute([$get_id]);
         if($select_comments->rowCount() > 0){
            while($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)){   
               $select_commentor = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
               $select_commentor->execute([$fetch_comment['user_id']]);
               $fetch_commentor = $select_commentor->fetch(PDO::FETCH_ASSOC);
      ?>
      <div class="box" style="<?php if($fetch_comment['user_id'] == $user_id){echo 'order:-1;';} ?>">
         <div class="user">
            <img src="uploaded_files/<?= $fetch_commentor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_commentor['name']; ?></h3>
               <span><?= $fetch_comment['date']; ?></span>
            </div>
         </div>
         <p class="text"><?= $fetch_comment['comment']; ?></p>
         <?php
            if($fetch_comment['user_id'] == $user_id){ 
         ?>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
            <button type="submit" name="edit_comment" class="inline-option-btn">edit comment</button>
            <button type="submit" name="delete_comment" class="inline-delete-btn" onclick="return confirm('delete this comment?');">delete comment</button>
         </form>
         <?php
         }
         ?>
      </div>
      <?php
       }
      }else{
         echo '<p class="empty">no comments added yet!</p>';
      }
      ?>
      </div>
   
</section>

<!-- comments section ends -->











<?php include 'components/footer.php'; ?>

<!-- swiper js file link  -->
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>