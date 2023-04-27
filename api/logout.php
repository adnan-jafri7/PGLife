<?php
session_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    session_destroy();
    $response = array("success" => true, "message" => "You are successfully logged out.");
  	echo json_encode($response);
    ?>  <script >
      alert('You are successfully logged out!');

      </script>
      <?php
    header('Location: ../index.php');
    return;
  ?>


  </body>
</html>
