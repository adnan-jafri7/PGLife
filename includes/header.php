<?php
session_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <script src="./js/common.js"></script>
    <script src="./js/login.js"></script>
    <?php
    include "includes/signup_modal.php";
    include "includes/login_modal.php";
    ?>

<div class="header sticky-top">

    <nav class="navbar navbar-expand-md navbar-light">
        <a class="navbar-brand" href="index.php">
            <img src="img/logo.png"/>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#my-navbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="my-navbar">
            <ul class="navbar-nav">
              <?php
              if(!isset($_SESSION['user_id'])){ ?>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#signup-modal">
                        <i class="fas fa-user"></i>Signup
                    </a>
                </li>
                <div class="nav-vl"></div>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#login-modal">
                        <i class="fas fa-sign-in-alt"></i>Login
                    </a>
                </li>
                <?php
              }else{ ?>
                <div class='nav-name'>
                        Hi, <?php echo $_SESSION['full_name'] ?>
                    </div>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="fas fa-user"></i>Dashboard
                        </a>
                    </li>
                    <div class="nav-vl"></div>
                    <li class="nav-item">
                        <a class="nav-link" id ="" href="./api/logout.php">
                            <i class="fas fa-sign-out-alt"></i>Logout
                        </a>
                    </li>
                    <?php }?>
            </ul>
        </div>
    </nav>
</div>




</body>
</html>
