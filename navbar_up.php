<?php

?>

<div class="banner"> <div id="banner-image"></div> 
<h3> <font color="#fff"> AMIU - Gestione bilaterale </font></h3>
</div>
<nav class="navbar navbar-inverse navbar-fixed-top navbar-expand-lg navbar-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
    <img class="pull-left" src="img\amiu_small_white.png" alt="SIT" width="85px">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <!--li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li-->
        <li class="nav-item">
          <a class="nav-link" href="./percorsi_bilaterali.php">Calcolo percorso</a>
        </li>
        <!--li class="nav-item">
          <a class="nav-link" href="#">Pricing</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li-->
      </ul>
      <!--ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link disabled" href="#"  tabindex="-1" aria-disabled="true"><i class="fas fa-user"></i> User.  <?php echo $_SESSION['username'];?></a>
        </li>
      </ul-->
      <span class="navbar-text ma-auto justify-content-end navbar-right">
      <ul class="navbar-nav ms-auto navbar-right">
          <i class="fas fa-user"></i> User  <?php echo $_SESSION['username'];?>
      </ul>
        </span>
    </div>
  </div>
</nav>
