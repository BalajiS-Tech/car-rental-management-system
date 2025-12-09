<?php 
session_start();
include('includes/config.php');
error_reporting(0);

// Small Day-2 Improvement: Avoid undefined variable warnings in case DB returns null
$results = [];
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">

<!-- Improved SEO for Day 2 commit -->
<title>Online Car Rental Management System</title>
<meta name="description" content="Book cars easily with our Online Car Rental Management System. Browse vehicles, compare features, and rent your ideal car with secure and user-friendly booking.">

<!-- CSS Files -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<link href="assets/css/slick.css" rel="stylesheet">
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<link href="assets/css/font-awesome.min.css" rel="stylesheet">

<!-- Theme Color Switcher -->
<link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />

<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">

<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">

</head>

<body>

<!-- Start Switcher -->
<?php include('includes/colorswitcher.php'); ?>
<!-- Header -->
<?php include('includes/header.php'); ?>

<!-- Banner Section -->
<section id="banner" class="banner-section">
  <div class="container">
    <div class="div_zindex">
      <div class="row">
        <div class="col-md-5 col-md-push-7">
          <div class="banner_content">
            <h1>Find the ideal car for you.</h1>
            <p>Choose from a wide range of vehicles suitable for every journey.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Recent Cars Section -->
<section class="section-padding gray-bg">
  <div class="container">
    <div class="section-header text-center">
      <h2>Find the Best <span>Car For You</span></h2>
      <p>Your comfort, safety, and satisfaction are our top priorities.</p>
    </div>

    <div class="row">
      <div class="recent-tab">
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#resentnewcar" role="tab" data-toggle="tab">New Cars</a></li>
        </ul>
      </div>

      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="resentnewcar">

<?php 
// Fetch Vehicles
$sql = "SELECT tblvehicles.VehiclesTitle,tblbrands.BrandName,tblvehicles.PricePerDay,
tblvehicles.FuelType,tblvehicles.ModelYear,tblvehicles.id,tblvehicles.SeatingCapacity,
tblvehicles.VehiclesOverview,tblvehicles.Vimage1 
FROM tblvehicles 
JOIN tblbrands ON tblbrands.id=tblvehicles.VehiclesBrand";

$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

// Day-2 improvement: Added comments for clarity
if ($query->rowCount() > 0) {
  foreach ($results as $result) {
?>

<div class="col-list-3">
  <div class="recent-car-list">
    <div class="car-info-box">

      <!-- Day-2 improvement: Fallback image -->
      <?php
      $image = !empty($result->Vimage1) ? htmlentities($result->Vimage1) : "default-car.png";
      ?>

      <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
        <img src="admin/img/vehicleimages/<?php echo $image; ?>" class="img-responsive" alt="Car Image">
      </a>

      <ul>
        <li><i class="fa fa-car" aria-hidden="true"></i><?php echo htmlentities($result->FuelType); ?></li>
        <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($result->ModelYear); ?> Model</li>
        <li><i class="fa fa-user" aria-hidden="true"></i><?php echo htmlentities($result->SeatingCapacity); ?> seats</li>
      </ul>
    </div>

    <div class="car-title-m">
      <h6>
        <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
        <?php echo htmlentities($result->BrandName); ?> , <?php echo htmlentities($result->VehiclesTitle); ?>
        </a>
      </h6>
      <span class="price">$<?php echo htmlentities($result->PricePerDay); ?> /Day</span>
    </div>

    <div class="inventory_info_m">
      <p><?php echo substr($result->VehiclesOverview, 0, 70); ?>...</p>
    </div>

  </div>
</div>

<?php } } ?>

        </div>
      </div>

    </div>
  </div>
</section>

<!-- Fun Facts Section -->
<section class="fun-facts-section">
  <div class="container div_zindex">
    <div class="row">

      <div class="col-lg-3 col-xs-6 col-sm-3">
        <div class="fun-facts-m">
          <div class="cell">
            <h2><i class="fa fa-calendar"></i>40+</h2>
            <p>Years In Business</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6 col-sm-3">
        <div class="fun-facts-m">
          <div class="cell">
            <h2><i class="fa fa-car"></i>1200+</h2>
            <p>New Cars Available</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6 col-sm-3">
        <div class="fun-facts-m">
          <div class="cell">
            <h2><i class="fa fa-car"></i>1000+</h2>
            <p>Used Cars For Sale</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6 col-sm-3">
        <div class="fun-facts-m">
          <div class="cell">
            <h2><i class="fa fa-user-circle-o"></i>600+</h2>
            <p>Satisfied Customers</p>
          </div>
        </div>
      </div>

    </div>
  </div>
  <div class="dark-overlay"></div>
</section>

<!-- Testimonials -->
<section class="section-padding testimonial-section parallex-bg">
  <div class="container div_zindex">
    <div class="section-header white-text text-center">
      <h2>Our Satisfied <span>Customers</span></h2>
    </div>
    <div class="row">
      <div id="testimonial-slider">

<?php 
$tid = 1;
$sql = "SELECT tbltestimonial.Testimonial,tblusers.FullName 
FROM tbltestimonial 
JOIN tblusers ON tbltestimonial.UserEmail = tblusers.EmailId 
WHERE tbltestimonial.status = :tid";

$query = $dbh->prepare($sql);
$query->bindParam(':tid', $tid, PDO::PARAM_STR);
$query->execute();
$testimonials = $query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() > 0) {
  foreach ($testimonials as $result) {
?>

<div class="testimonial-m">
  <div class="testimonial-img"><img src="assets/images/cat-profile.png" alt=""></div>
  <div class="testimonial-content">
    <div class="testimonial-heading">
      <h5><?php echo htmlentities($result->FullName); ?></h5>
      <p><?php echo htmlentities($result->Testimonial); ?></p>
    </div>
  </div>
</div>

<?php } } ?>

      </div>
    </div>
  </div>
  <div class="dark-overlay"></div>
</section>

<!-- Footer -->
<?php include('includes/footer.php'); ?>

<!-- Back to top -->
<div id="back-top" class="back-top">
  <a href="#top"><i class="fa fa-angle-up"></i></a>
</div>

<!-- Login/Register/Forgot Forms -->
<?php include('includes/login.php'); ?>
<?php include('includes/registration.php'); ?>
<?php include('includes/forgotpassword.php'); ?>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/interface.js"></script>
<script src="assets/switcher/js/switcher.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>

</body>
</html>
