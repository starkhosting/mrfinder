<?php
  session_start();
?>
<?php require "../db/config.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
    <title>Super-Admin Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
     <link href="../styles/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
<?php require "../layouts/header.php"; ?>
<!-- update code start -->
<?php
if(isset($_GET['up_id'])) {
  $id = $_GET['up_id'];

  if(!isset($_SESSION['adminname'])){
    header("location: /super-admin/admins/login-admins.php");
  }

  

  //second query
  if(isset($_POST['submit'])) {
    if($_POST['name'] == '') {
        echo "<div class='alert alert-danger text-center role='alert'>
                enter data into the inputs
            </div>";
    } else {
      $name = $_POST['name'];
      $update = $conn->prepare("UPDATE profession SET name = :name  WHERE id = '$id'");
      $update->execute([
          ':name' => $name,
          ]);
          header('location: /super-admin/profession/show-profession.php');
      }
  }
} else {
  header("location: /super-admin/404.php");
}
    //first query
    $select = $conn->query("SELECT * FROM profession WHERE id = '$id'");
    $select->execute();
    $rows = $select->fetch(PDO::FETCH_OBJ);
?>
<!-- update code end -->
       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Update Categories</h5>
          <form method="POST" action="update-profession.php?up_id=<?php echo $rows->id; ?>" enctype="multipart/form-data">
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                  <input type="text" value="<?php echo $rows->name; ?>" name="name" id="form2Example1" class="form-control" placeholder="name" />
                 
                </div>

      
                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">update</button>

          
              </form>

            </div>
          </div>
        </div>
      </div>
  </div>
<script type="text/javascript">

</script>
</body>
</html>