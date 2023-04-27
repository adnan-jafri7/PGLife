<?php
require "includes/database_connect.php";

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
$property_id=$_GET["property_id"];
$sql_1 = "SELECT * FROM properties WHERE id = '$property_id'";
$sql_2 = "SELECT * FROM amenities a INNER JOIN properties_amenities p ON a.id=p.id WHERE p.property_id = '$property_id'";
$sql_3="SELECT * FROM testimonials WHERE property_id='$property_id'";
$sql_4="SELECT COUNT(property_id) as count FROM interested_users_properties WHERE property_id='$property_id'";
$sql_5="SELECT * FROM interested_users_properties WHERE property_id='$property_id'";
$result_1 = mysqli_query($conn,$sql_1);
$result_2=mysqli_query($conn,$sql_2);
$result_3=mysqli_query($conn,$sql_3);
$result_4=mysqli_query($conn,$sql_4);
$result_5=mysqli_query($conn,$sql_5);
if(!$result_1 || !$result_2 || !$result_3 || !$result_4 || !$result_5){
  echo "Something went wrong";
  return;
}
$amenities=mysqli_fetch_all($result_2, MYSQLI_ASSOC);
$row = mysqli_fetch_assoc($result_1);
$testimonials=mysqli_fetch_all($result_3, MYSQLI_ASSOC);
$iup=mysqli_fetch_assoc($result_4);
$interested_users=mysqli_fetch_all($result_5,MYSQLI_ASSOC);
//print_r($interested_users);
?>


 <!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php  echo $row['name']." "; ?>| PG Life</title>

    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet" />
    <link href="css/common.css" rel="stylesheet" />
    <link href="css/property_detail.css" rel="stylesheet" />
</head>

<body>
<?php include "includes/header.php";   ?>

    <div id="loading">
    </div>
    <script type="text/javascript" src="js/property_detail.js">

    </script>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="property_list.php?city=Mumbai">Mumbai</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <?php echo $row['name']; ?>
            </li>
        </ol>
    </nav>

    <div id="property-images" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#property-images" data-slide-to="0" class="active"></li>
            <li data-target="#property-images" data-slide-to="1" class=""></li>
            <li data-target="#property-images" data-slide-to="2" class=""></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="img/properties/1/1d4f0757fdb86d5f.jpg" alt="slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="img/properties/1/46ebbb537aa9fb0a.jpg" alt="slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="img/properties/1/eace7b9114fd6046.jpg" alt="slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#property-images" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#property-images" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="property-summary page-container">
        <div class="row no-gutters justify-content-between">
          <?php
          $total_rating = ($row['rating_clean'] + $row['rating_food'] + $row['rating_safety']) / 3;
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
            <div class="interested-container">
              <?php
              $is_interested = false;
              foreach ($interested_users as $interested_user) {
                  if ($interested_user['user_id'] == $user_id) {
                      $is_interested = true;
                  }
              }

              if ($is_interested) {
              ?>
                  <i class="is-interested-image fas fa-heart"></i>
              <?php
              } else {
              ?>
                  <i class="is-interested-image far fa-heart"></i>
              <?php
              }
              ?>
                <div class="interested-text">
                    <span class="interested-user-count"><?php echo $iup['count']; ?></span> interested
                </div>
            </div>
        </div>
        <div class="detail-container">
            <div class="property-name"><?php echo $row['name']; ?></div>
            <div class="property-address"><?php echo $row['address']; ?></div>
            <div class="property-gender">
              <?php if($row['gender']=="unisex"){ ?>
                <img src="img/unisex.png" />
              <?php }else if($row['gender']=="female"){ ?>
                <img src="img/female.png" alt="">
              <?php }else{ ?>
                <img src="img/male.png" alt="">
              <?php } ?>
            </div>
        </div>
        <div class="row no-gutters">
            <div class="rent-container col-6">
                <div class="rent">₹ <?= number_format($row['rent']) ?></div>
                <div class="rent-unit">per month</div>
            </div>
            <div class="button-container col-6">
                <a href="#" class="btn btn-primary">Book Now</a>
            </div>
        </div>
    </div>

    <div class="property-amenities">
        <div class="page-container">
            <h1>Amenities</h1>
            <div class="row justify-content-between">
                <div class="col-md-auto">
                  <h5>Building</h5>
                  <?php foreach($amenities as $amenity){
                    if($amenity['type']=="Building"){?>
                      <div class="amenity-container">
                      <?php $img_path="img/amenities/" . $amenity['icon'] . ".svg"; ?>
                        <img src="<?php echo $img_path; ?>"/>
                        <span><?php echo $amenity['name'];?></span>
                    </div>
                  <?php } }?>
                </div>

                <div class="col-md-auto">
                    <h5>Common Area</h5>
                    <?php foreach($amenities as $amenity){
                      if($amenity['type']=="Common Area"){?>
                        <div class="amenity-container">
                        <?php $img_path="img/amenities/" . $amenity['icon'] . ".svg"; ?>
                          <img src="<?php echo $img_path; ?>"/>
                          <span><?php echo $amenity['name'];?></span>
                      </div>
                    <?php } }?>

                </div>

                <div class="col-md-auto">
                    <h5>Bedroom</h5>
                    <?php foreach($amenities as $amenity){
                      if($amenity['type']=="Bedroom"){?>
                        <div class="amenity-container">
                        <?php $img_path="img/amenities/" . $amenity['icon'] . ".svg"; ?>
                          <img src="<?php echo $img_path; ?>"/>
                          <span><?php echo $amenity['name'];?></span>
                      </div>
                    <?php } }?>
                </div>

                <div class="col-md-auto">
                    <h5>Washroom</h5>
                    <?php foreach($amenities as $amenity){
                      if($amenity['type']=="Washroom"){?>
                        <div class="amenity-container">
                        <?php $img_path="img/amenities/" . $amenity['icon'] . ".svg"; ?>
                          <img src="<?php echo $img_path; ?>"/>
                          <span><?php echo $amenity['name'];?></span>
                      </div>
                    <?php } }?>
                </div>
            </div>
        </div>
    </div>

    <div class="property-about page-container">
        <h1>About the Property</h1>
        <p><?php echo $row['description']?></p>
    </div>

    <div class="property-rating">
        <div class="page-container">
            <h1>Property Rating</h1>
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6">
                    <div class="rating-criteria row">
                        <div class="col-6">
                            <i class="rating-criteria-icon fas fa-broom"></i>
                            <span class="rating-criteria-text">Cleanliness</span>
                        </div>
                        <div class="rating-criteria-star-container col-6" title="<?= $row['rating_clean'] ?>">
                          <?php
                          $rating = $row['rating_clean'];
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

                    <div class="rating-criteria row">
                        <div class="col-6">
                            <i class="rating-criteria-icon fas fa-utensils"></i>
                            <span class="rating-criteria-text">Food Quality</span>
                        </div>
                        <div class="rating-criteria-star-container col-6" title="<?= $row['rating_food'] ?>">
                          <?php
                          $rating = $row['rating_food'];
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

                    <div class="rating-criteria row">
                        <div class="col-6">
                            <i class="rating-criteria-icon fa fa-lock"></i>
                            <span class="rating-criteria-text">Safety</span>
                        </div>
                        <div class="rating-criteria-star-container col-6" title="<?= $row['rating_safety'] ?>">
                          <?php
                          $rating = $row['rating_safety'];
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
                </div>

                <div class="col-md-4">
                    <div class="rating-circle">
                        <div class="total-rating"><?php echo $total_rating; ?></div>
                        <div class="rating-circle-star-container">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="property-testimonials page-container">
        <h1>What people say</h1>
        <?php foreach($testimonials as $testimonial){

         ?>
        <div class="testimonial-block">
            <div class="testimonial-image-container">
                <img class="testimonial-img" src="img/man.png">
            </div>
            <div class="testimonial-text">
                <i class="fa fa-quote-left" aria-hidden="true"></i>
                <p><?php echo $testimonial['content'];?></p>
            </div>
            <div class="testimonial-name">- <?php echo $testimonial['user_name']; ?></div>
        </div>
      <?php } ?>
    </div>




  <?php
  include "includes/footer.php";
  include "includes/signup_modal.php";
  include "includes/login_modal.php";  ?>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>

</html>
