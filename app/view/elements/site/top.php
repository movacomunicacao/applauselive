<header class="container-fluid">
  <?php include('../../../../app/config/directories.php'); ?>
  <div class="row justify-content-center px-5 py-4 mb-lg-0 mb-5">
    <div class="col-lg-3 col-12 text-lg-start text-center pt-lg-0 pt-5">
      <a href="SERVER_DIR">
        <img src="FILES_DIRlogo.webp" alt="logo" class="col-lg-5 col-5 logo">
      </a>
    </div>
    <nav class="col-9 text-end my-auto">
        <?php include 'menu.php'; ?>
    </nav>
  </div>

  <?php
      // HERE YOU CONTROL WHICH PAGES YOU WANT THE MAIN BANNER TO SHOW UP
      $pagename = $_GET['page'];
      if($pagename == 'home'){ include 'banners.php'; }
  ?>

</header>
