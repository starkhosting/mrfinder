
<?php require "../db/config.php" ?>

<?php

if(isset($_GET['id']) AND isset($_GET['approval'])) {

  $id = $_GET['id'];
  $approval = $_GET['approval'];

  
            if($approval == 0) {

                    $update = $conn->prepare("UPDATE post SET approval = 1  WHERE id = '$id'");
                    $update->execute();
                    header('location: /group/super-admin/posts-admins/show-posts.php');

                }else{

                    $update = $conn->prepare("UPDATE post SET approval = 0  WHERE id = '$id'");
                    $update->execute();
                    header('location: /group/super-admin/posts-admins/show-posts.php');
                    }

    }else{

        header("location: /group/super-admin/404.php");

         }

?>
