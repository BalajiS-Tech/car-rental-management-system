<?php 
session_start();
include('includes/config.php');
error_reporting(0);

// Handle Booking Form Submission
if (isset($_POST['submit'])) {
    $fromdate  = $_POST['fromdate'];
    $todate    = $_POST['todate'];
    $message   = $_POST['message'];
    $useremail = $_SESSION['login'];
    $status    = 0;
    $vhid      = $_GET['vhid'];

    $sql = "INSERT INTO tblbooking(userEmail,VehicleId,FromDate,ToDate,message,Status) 
            VALUES(:useremail,:vhid,:fromdate,:todate,:message,:status)";

    $query = $dbh->prepare($sql);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
    $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
    $query->bindParam(':todate', $todate, PDO::PARAM_STR);
    $query->bindParam(':message', $message, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);

    $query->execute();
    $lastInsertId = $dbh->lastInsertId();

    if ($lastInsertId) {
        echo "<script>alert('Booking successful.');</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again');</script>";
    }
}

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Car Rental Portal | Vehicle Details</title>

<!-- CSS FILES -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/owl.carousel.css">
<link rel="stylesheet" href="assets/css/slick.css">
<link rel="stylesheet" href="assets/css/bootstrap-slider.min.css">
<link rel="stylesheet" href="assets/css/font-awesome.min.css">

<!-- Color Switcher -->
<link rel="stylesheet" href="assets/switcher/css/switcher.css">
<link rel="alternate stylesheet" href="assets/switcher/css/red.css"    title="red" data-default-color="true">
<link rel="alternate stylesheet" href="assets/switcher/css/orange.css" title="orange">
<link rel="alternate stylesheet" href="assets/switcher/css/blue.css"   title="blue">
<link rel="alternate stylesheet" href="assets/switcher/css/pink.css"   title="pink">
<link rel="alternate stylesheet" href="assets/switcher/css/green.css"  title="green">
<link rel="alternate stylesheet" href="assets/switcher/css/purple.css" title="purple">
</head>

<body>

<!-- Color Switcher -->
<?php include('includes/colorswitcher.php');?>

<!-- Header -->
<?php include('includes/header.php');?>

<?php 
$vhid = intval($_GET['vhid']);
$sql  = "SELECT tblvehicles.*, tblbrands.BrandName, tblbrands.id as bid 
         FROM tblvehicles 
         JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
         WHERE tblvehicles.id = :vhid";

$query = $dbh->prepare($sql);
$query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() > 0) {
    foreach ($results as $result) {
        $_SESSION['brndid'] = $result->bid;
?>

<!-- Vehicle Image Slider -->
<section id="listing_img_slider">
  <?php 
    $images = [$result->Vimage1, $result->Vimage2, $result->Vimage3, $result->Vimage4, $result->Vimage5];
    foreach ($images as $img) {
        if (!empty($img)) {
            echo '<div><img src="admin/img/vehicleimages/'.htmlentities($img).'" class="img-responsive" alt="Car Image" width="900" height="560"></div>';
        }
    }
  ?>
</section>

<!-- Vehicle Details -->
<section class="listing-detail">
  <div class="container">

    <div class="listing_detail_head row">
      <div class="col-md-9">
        <h2><?php echo htmlentities($result->BrandName); ?>,
            <?php echo htmlentities($result->VehiclesTitle); ?></h2>
      </div>
      <div class="col-md-3">
        <div class="price_info">
          <p>$<?php echo htmlentities($result->PricePerDay); ?></p>Per Day
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-9">

        <!-- Main Features -->
        <div class="main_features">
          <ul>
            <li><i class="fa fa-calendar"></i><h5><?php echo htmlentities($result->ModelYear); ?></h5><p>Reg. Year</p></li>
            <li><i class="fa fa-cogs"></i><h5><?php echo htmlentities($result->FuelType); ?></h5><p>Fuel Type</p></li>
            <li><i class="fa fa-user-plus"></i><h5><?php echo htmlentities($result->SeatingCapacity); ?></h5><p>Seats</p></li>
          </ul>
        </div>

        <!-- Tabs -->
        <div class="listing_more_info">
          <ul class="nav nav-tabs gray-bg">
            <li class="active"><a href="#vehicle-overview" data-toggle="tab">Vehicle Overview</a></li>
            <li><a href="#accessories" data-toggle="tab">Accessories</a></li>
          </ul>

          <div class="tab-content">

            <!-- Overview -->
            <div class="tab-pane active" id="vehicle-overview">
              <p><?php echo nl2br(htmlentities($result->VehiclesOverview)); ?></p>
            </div>

            <!-- Accessories -->
            <div class="tab-pane" id="accessories">
              <table>
                <thead><tr><th colspan="2">Accessories</th></tr></thead>
                <tbody>
                  <?php 
                    $acc = [
                      "Air Conditioner" => $result->AirConditioner,
                      "ABS" => $result->AntiLockBrakingSystem,
                      "Power Steering" => $result->PowerSteering,
                      "Power Windows" => $result->PowerWindows,
                      "CD Player" => $result->CDPlayer,
                      "Leather Seats" => $result->LeatherSeats,
                      "Central Locking" => $result->CentralLocking,
                      "Door Locks" => $result->PowerDoorLocks,
                      "Brake Assist" => $result->BrakeAssist,
                      "Driver Airbag" => $result->DriverAirbag,
                      "Passenger Airbag" => $result->PassengerAirbag,
                      "Crash Sensor" => $result->CrashSensor
                    ];

                    foreach ($acc as $name => $status) {
                      echo "<tr><td>{$name}</td><td>";
                      echo ($status == 1) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>';
                      echo "</td></tr>";
                    }
                  ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>

      </div>

      <!-- Sidebar -->
      <aside class="col-md-3">
        <div class="share_vehicle">
          <p>Share:
            <a href="#"><i class="fa fa-facebook-square"></i></a>
            <a href="#"><i class="fa fa-twitter-square"></i></a>
            <a href="#"><i class="fa fa-linkedin-square"></i></a>
          </p>
        </div>

        <div class="sidebar_widget">
          <h5><i class="fa fa-envelope"></i> Book Now</h5>

          <form method="post">
            <input type="text" class="form-control" name="fromdate" placeholder="From Date" required>
            <input type="text" class="form-control" name="todate" placeholder="To Date" required>
            <textarea class="form-control" name="message" placeholder="Message" required></textarea>

            <?php if ($_SESSION['login']) { ?>
              <input type="submit" class="btn btn-block" name="submit" value="Book Now">
            <?php } else { ?>
              <a href="#loginform" class="btn btn-xs" data-toggle="modal">Login To Book</a>
            <?php } ?>
          </form>
        </div>
      </aside>

    </div>

    <div class="divider"></div>

    <!-- Similar Cars -->
    <div class="similar_cars">
      <h3>Similar Cars</h3>
      <div class="row">

        <?php 
          $bid = $_SESSION['brndid'];
          $sql = "SELECT tblvehicles.*, tblbrands.BrandName 
                  FROM tblvehicles 
                  JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
                  WHERE tblvehicles.VehiclesBrand = :bid";

          $query = $dbh->prepare($sql);
          $query->bindParam(':bid', $bid, PDO::PARAM_STR);
          $query->execute();
          $cars = $query->fetchAll(PDO::FETCH_OBJ);

          foreach ($cars as $car) {
        ?>

        <div class="col-md-3 grid_listing">
          <div class="product-listing-m gray-bg">
            <a href="vehical-details.php?vhid=<?php echo htmlentities($car->id); ?>">
              <img src="admin/img/vehicleimages/<?php echo htmlentities($car->Vimage1); ?>" class="img-responsive" alt="Car Image">
            </a>
            <div class="product-listing-content">
              <h5><?php echo htmlentities($car->BrandName); ?>,
                  <?php echo htmlentities($car->VehiclesTitle); ?></h5>
              <p class="list-price">$<?php echo htmlentities($car->PricePerDay); ?></p>
            </div>
          </div>
        </div>

        <?php } ?>

      </div>
    </div>

  </div>
</section>

<!-- Footer -->
<?php include('includes/footer.php');?>

<a href="#top" id="back-top"><i class="fa fa-angle-up"></i></a>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/interface.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>

</body>
</html>
