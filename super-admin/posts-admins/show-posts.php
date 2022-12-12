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
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="../styles/style.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>

<?php require "../layouts/header.php"; ?>
<?php require "../db/config.php" ?>
<?php

  if(!isset($_SESSION['adminname'])){
    header("location: /group/super-admin/admins/login-admins.php");
  }

  $posts = $conn->query(" SELECT p.approval AS approval, p.id AS id, p.no AS  no , p.title AS title, a.email AS email, p.date AS date, p.status AS status FROM admin AS a INNER JOIN post AS  p ON a.id = p.admin_id; ");
  $posts->execute();
  $rows = $posts->fetchAll(PDO::FETCH_OBJ);

  // $select_provider = $conn->query("SELECT COUNT(*) AS providers_number FROM admin");
  // $select_provider-> execute();
  // $provider = $select_provider->fetch(PDO::FETCH_OBJ);

?>


<!-- Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Admin Deatails</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- end model -->

      
 <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Posts</h5>
            
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Email</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                    <th scope="col">Status</th>
                    <th scope="col">Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $c=0; foreach($rows as $row) : ?>
                  <tr>
                    <th scope="row"> <?php  echo ++$c; ?> </th>
                    <td><?php echo $row->title; ?></td>
                    <td><?php echo $row->email; ?></td>
                    <td><?php echo $row->date; ?></td>
                    <td>
                    <button data-id='<?php echo $row->id; ?>' type="button" class="userinfo btn btn-success" data-toggle="modal" data-target="#viewModal">View</button>
                      <!-- <a href="/group/post.php?get_id=<?php echo $row->id; ?>" class="btn btn-success  text-center ">View</a> -->
                    </td>
                    <?php if($row->approval == 0) : ?>
                      <td><a href="approve-posts.php?approval=<?php echo $row->approval; ?>&id=<?php echo $row->id; ?>" class="btn btn-danger  text-center ">deactivated</a></td>
                    <?php else : ?>
                      <td><a href="approve-posts.php?approval=<?php echo $row->approval; ?>&id=<?php echo $row->id; ?>" class="btn btn-primary  text-center ">approved</a></td>
                    <?php endif; ?>

                    <td><a href="delete-posts.php?po_id=<?php echo $row->id; ?>" class="btn btn-danger  text-center ">delete</a></td>
                  </tr>
                 <?php endforeach; ?>
                </tbody>
              </table> 
            </div>
          </div>
        </div>
      </div>



  </div>
  <?php require "../layouts/footer.php"; ?>  