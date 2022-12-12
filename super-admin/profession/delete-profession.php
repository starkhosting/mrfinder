<?php //require "../includes/navbar.php"; ?>
<?php require "../db/config.php" ?>
<?php 

    if(isset($_GET['de_id'])) {
        $id = $_GET['de_id'];

        $delete = $conn->prepare("DELETE FROM profession WHERE id = :id");
        $delete->execute([
            ':id' => $id
        ]);
       
       header('location: /super-admin/profession/show-profession.php');

        
    }  else {
        header("location: http://localhost/clean-blog/404.php");
       
    }  

?>