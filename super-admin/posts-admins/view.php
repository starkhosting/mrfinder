<?php

// $get_id = $_POST['get_id'];

if(isset($_POST['get_id'])){
  $get_id = $_POST['get_id'];
}else{
  $get_id = '';
  header('location:home.php');
}

// echo $get_id;
?>

<?php require "../db/config.php" ?>

<?php
         $select_post = $conn->prepare("SELECT * FROM `post` WHERE id = ? and status = ? LIMIT 1");
         $select_post->execute([$get_id, 'active']);
         if($select_post->rowCount() > 0){
            $fetch_post = $select_post->fetch(PDO::FETCH_ASSOC);

            $post_id = $fetch_post['id'];

            

            $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE id = ? LIMIT 1");
            $select_admin->execute([$fetch_post['admin_id']]);
            $fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC);

            $select_profession = $conn->prepare("SELECT name FROM `profession` WHERE id = ? LIMIT 1");
            $select_profession->execute([$fetch_admin['profession_id']]);
            $fetch_profession = $select_profession->fetch(PDO::FETCH_ASSOC);

            // $select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ? AND post_id = ?");
            // $select_bookmark->execute([$user_id, $post_id]);

      ?>
      <!-- table start -->
   <table class="table">
  <thead>
      <tr>
         <th scope="col">Admin Name</th>
         <td><?= $fetch_admin['name']; ?></td>
      </tr>

      <tr>
         <th>Contact No </th>
         <td><?= $fetch_admin['contact']; ?></td>
      </tr>

      <tr>
         <th>Profession</th>
         <td><?= $fetch_admin['profession_id']; ?></td>
      </tr>

  </thead>
</table>

      <!-- table end -->
      


      <?php
         }else{
            echo '<p class="empty">this post was not found!</p>';
         }  
      ?>

