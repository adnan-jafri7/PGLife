
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | PG Life</title>

    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet" />
    <link href="css/common.css" rel="stylesheet" />
    <link href="css/dashboard.css" rel="stylesheet" />
</head>

<body>
  <script type="text/javascript" src="js/dashboard.js">

  </script>
<?php include "includes/header.php";
      require "includes/database_connect.php";
      $user_id=$_SESSION['user_id'];
      $sql="SELECT * FROM properties p INNER JOIN interested_users_properties iup ON iup.property_id = p.id WHERE iup.user_id='$user_id'";
      $result=mysqli_query($conn,$sql);
      if (!$result) {
          echo "Something went wrong!";
          return;
      }
      $iups=mysqli_fetch_all($result,MYSQLI_ASSOC);
      //print_r($iups);

 ?>
    <div id="loading">
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Dashboard
            </li>
        </ol>
    </nav>

    <div class="my-profile page-container">
        <h1>My Profile</h1>
        <div class="row">
            <div class="col-md-3 profile-img-container">
                <i class="fas fa-user profile-img"></i>
            </div>
            <div class="col-md-9">
                <div class="row no-gutters justify-content-between align-items-end">
                    <div class="profile">
                        <div class="name"><?php echo $_SESSION['full_name']; ?></div>
                        <div class="email"><?php echo $_SESSION['email']; ?></div>
                        <div class="phone"><?php echo $_SESSION['phone']; ?></div>
                        <div class="college"><?php echo $_SESSION['college']; ?></div>
                    </div>
                    <div class="edit">
                        <div class="edit-profile">Edit Profile</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="my-interested-properties">
        <div class="page-container">
            <h1>My Interested Properties</h1>
            <?php foreach($iups as $iup){
              //echo $iup['name'];
            ?>

            <div class="property-card property-id-<?php echo $iup['property_id']  ?> row">
                <div class="image-container col-md-4">
                  <?php $property_images =glob("img/properties/" . $iup['property_id'] . "/*"); ?>
                    <img src="<?= $property_images[0] ?>" />
                </div>
                <div class="content-container col-md-8">
                    <div class="row no-gutters justify-content-between">
                        <div class="star-container" title="4.8">
                          <?php
                          $total_rating = ($iup['rating_clean'] + $iup['rating_food'] + $iup['rating_safety']) / 3;
                          $total_rating = round($total_rating, 1);
                          ?>
                            <div class="star-container" title="<?= $total_rating ?>">
                              <?php
                              $rating = $total_rating;
                              for ($i = 0; $i < 5; $i++) {
                                  if ($rating >= $i + 0.8) {
                              ?>
                                      <i class="fas fa-star"></i>
                                  <?php
                                  } elseif ($rating >= $i + 0.3) {
                                  ?>
                                      <i class="fas fa-star-half-alt"></i>
                                  <?php
                                  } else {
                                  ?>
                                      <i class="far fa-star"></i>
                              <?php
                                  }
                              }
                              ?>
                            </div>
                        </div>
                        <div class="interested-container">
                            <i class="is-interested-image fas fa-heart" property_id="<?= $iup['property_id'] ?>"></i>
                        </div>
                    </div>
                    <div class="detail-container">
                        <div class="property-name"><?php echo $iup['name']; ?></div>
                        <div class="property-address"><?php echo $iup['address']; ?></div>
                        <div class="property-gender">
                          <?php if($iup['gender']=="unisex"){ ?>
                            <img src="img/unisex.png">
                          <?php }else if($iup['gender']=="female"){ ?>
                            <img src="img/female.png">
                          <?php }else{ ?>
                            <img src="img/male.png">
                          <?php } ?>

                        </div>
                    </div>
                    <div class="row no-gutters">
                        <div class="rent-container col-6">
                            <div class="rent">₹<?php echo number_format($iup['rent']); ?></div>
                            <div class="rent-unit">per month</div>
                        </div>
                        <div class="button-container col-6">
                            <a href="property_detail.php?property_id=<?php echo $iup['property_id']; ?>" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
            </div>
          <?php
        }

        if (count($iups) == 0) {
        ?>
            <div class="no-property-container">
                <p>No PG to list</p>
            </div>
        <?php
        }
        ?>
    </div>




        </div>
    </div>

    <?php
    include "includes/footer.php";   ?> ?>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>

</html>
