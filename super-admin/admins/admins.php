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

  $admins =$conn->query("SELECT * FROM super_admin LIMIT 5");
  $admins->execute();
  $rows = $admins->fetchAll(PDO::FETCH_OBJ);

?>

      <div class="row">
          <div class="col">
            <div class="card">
              <div class="card-body">

              <h5 class="card-title mb-4 d-inline">Admins</h5>
              <a  href="create-admins.php" class="btn btn-primary mb-4 text-center float-right">Create Admins</a>
              
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">admin name</th>
                    <th scope="col">email</th>
                  </tr>
                </thead>

                <tbody>

                <?php foreach($rows as $row) :  ?>
                  <tr>
                    <th scope="row"> <?php echo $row->id; ?> </th>
                    <td> <?php echo $row->adminname; ?> </td>
                    <td> <?php echo $row->email; ?> </td>
                  </tr>
                <?php endforeach; ?>

                </tbody>
              </table> 
            </div>
          </div>
        </div>
      </div>



      <?php require "../layouts/footer.php"; ?>  