
<?php require "../db/config.php" ?>

<?php 

    if(isset($_GET['po_id'])) {
        $id = $_GET['po_id'];

        $delete = $conn->prepare("DELETE FROM post WHERE id = :id");
        $delete->execute([
            ':id' => $id
        ]);
       
       header('location: /group/super-admin/posts-admins/show-posts.php');

        
    }  else {
        header("location: http://localhost/clean-blog/404.php");
       
    }  

?>