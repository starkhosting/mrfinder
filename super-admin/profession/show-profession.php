<?php 

  session_start();

?>

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
<?php require "../db/config.php" ?>

<?php

if(!isset($_SESSION['adminname'])){
  header("location: /group/super-admin/admins/login-admins.php");
}

  $profession = $conn->query("SELECT * FROM profession");
  $profession->execute();
  $rows= $profession->fetchAll(PDO::FETCH_OBJ);

?>

          <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Professions</h5>
             <a  href="/super-admin/profession/create-profession.php" class="btn btn-primary mb-4 text-center float-right">Create profession</a>
              <table class="table">
                <thead>
                  <tr>
                    <!-- <th scope="col">#</th> -->
                    <th scope="col">Name</th>
                    <th scope="col">Update</th>
                    <th scope="col">Delete</th>
                  </tr>
                </thead>
                <tbody>

                <?php foreach($rows as $row) : ?>
                  <tr>
                    <!-- <th scope="row">1</th> -->
                    <td><?php echo $row->name ?></td>
                    <td><a  href="/super-admin/profession/update-profession.php?up_id=<?php echo $row->id; ?>" class="btn btn-warning text-white text-center ">Update</a></td>
                    <td><a href="/super-admin/profession/delete-profession.php?de_id=<?php echo $row->id; ?>" class="btn btn-danger  text-center ">Delete</a></td>
                  </tr>
                  <?php endforeach; ?>
                 
                </tbody>
              </table> 
            </div>
          </div>
        </div>
      </div>



  </div>
<script type="text/javascript">

</script>
</body>
</html>