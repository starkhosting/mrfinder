
<div id="wrapper">
    <nav class="navbar header-top fixed-top navbar-expand-lg  navbar-dark bg-dark">
      <div class="container">
      <a class="navbar-brand" href="#">Super Admin</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <?php if(isset($_SESSION['adminname'])) : ?>

          <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav side-nav" >
              <li class="nav-item">
                <a class="nav-link text-white" style="margin-left: 20px;" href="/super-admin/index.php">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/super-admin/admins/admins.php" style="margin-left: 20px;">Admins</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/super-admin/profession/show-profession.php" style="margin-left: 20px;">provider professions</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/super-admin/posts-admins/show-posts.php" style="margin-left: 20px;">Posts</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/super-admin/posts-admins/show-posts.php" style="margin-left: 20px;">Approved Posts</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/super-admin/posts-admins/show-posts.php" style="margin-left: 20px;">Pending Posts</a>
              </li>

      <?php endif; ?>

         <!--  <li class="nav-item">
            <a class="nav-link" href="#" style="margin-left: 20px;">Comments</a>
          </li> -->
        </ul>

        <ul class="navbar-nav ml-md-auto d-md-flex">

          <?php if(isset($_SESSION['adminname'])) : ?>

            <li class="nav-item">
              <a class="nav-link" href="/super-admin/index.php">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo $_SESSION['adminname']; ?>
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="/super-admin/admins/logout.php">Logout</a>
              </div>
            </li>
           
          <?php else : ?>

            <li class="nav-item">
              <a class="nav-link" href="/super-admin/admins/login-admins.php">login
                <span class="sr-only">(current)</span>
              </a>
            </li>
          <?php endif; ?>
                          
          
        </ul>
      </div>
    </div>
    </nav>
    <div class="container">