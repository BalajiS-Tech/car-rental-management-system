<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<header>
  <div class="default-header">
    <div class="container">
      <div class="row">
        <div class="col-sm-3 col-md-2">
          <div class="logo">
            <a href="index.php"><img src="assets/images/logg.png" alt="Car Rental Logo"/></a>
          </div>
        </div>

        <div class="col-sm-9 col-md-10">
          <div class="header_info">
            <div class="header_widgets">

              <?php if (empty($_SESSION['login'])) { ?>
                  <div class="login_btn">
                    <a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal">
                      Login / Register
                    </a>
                  </div>
              <?php } else { ?>
                  <div class="welcome-text">
                    Welcome, <strong>
                      <?php 
                        echo htmlentities($_SESSION['login']); 
                      ?>
                    </strong>
                  </div>
              <?php } ?>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Navigation -->
  <nav id="navigation_bar" class="navbar navbar-default">
    <div class="container">

      <div class="navbar-header">
        <button id="menu_slide" data-target="#navigation" data-toggle="collapse" 
                class="navbar-toggle collapsed" type="button">
          <span class="sr-only">Toggle navigation</span> 
          <span class="icon-bar"></span> 
          <span class="icon-bar"></span> 
          <span class="icon-bar"></span>
        </button>
      </div>

      <div class="header_wrap">

        <!-- User Profile Dropdown -->
        <div class="user_login">
          <ul>
            <li class="dropdown">
              <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user-circle"></i>

                <?php
                if (!empty($_SESSION['login'])) {
                    $email = $_SESSION['login'];
                    $sql = "SELECT FullName FROM tblusers WHERE EmailId=:email";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':email', $email, PDO::PARAM_STR);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    if ($query->rowCount() > 0) {
                        foreach ($results as $result) {
                            echo htmlentities($result->FullName);
                        }
                    }
                } else {
                    echo "Guest";
                }
                ?>

                <i class="fa fa-angle-down"></i>
              </a>

              <ul class="dropdown-menu">
                <?php if (!empty($_SESSION['login'])) { ?>

                  <li><a href="profile.php">Profile Settings</a></li>
                  <li><a href="update-password.php">Update Password</a></li>
                  <li><a href="my-booking.php">My Booking</a></li>
                  <li><a href="post-testimonial.php">Post a Testimonial</a></li>
                  <li><a href="my-testimonials.php">My Testimonial</a></li>
                  <li><a href="logout.php">Sign Out</a></li>

                <?php } else { ?>

                  <li><a href="#loginform" data-toggle="modal">Profile Settings</a></li>
                  <li><a href="#loginform" data-toggle="modal">Update Password</a></li>
                  <li><a href="#loginform" data-toggle="modal">My Booking</a></li>
                  <li><a href="#loginform" data-toggle="modal">Post a Testimonial</a></li>
                  <li><a href="#loginform" data-toggle="modal">My Testimonial</a></li>
                  <li><a href="#loginform" data-toggle="modal">Sign Out</a></li>

                <?php } ?>
              </ul>

            </li>
          </ul>
        </div>

        <!-- Search Box -->
        <div class="header_search">
          <div id="search_toggle"><i class="fa fa-search"></i></div>
          <form action="#" method="get" id="header-search-form">
            <input type="text" placeholder="Search..." class="form-control">
            <button type="submit"><i class="fa fa-search"></i></button>
          </form>
        </div>

      </div>

      <!-- Navigation Links -->
      <div class="collapse navbar-collapse" id="navigation">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Home</a></li>
          <li><a href="page.php?type=aboutus">About Us</a></li>
          <li><a href="car-listing.php">Car Listing</a></li>
          <li><a href="page.php?type=faqs">FAQs</a></li>
          <li><a href="contact-us.php">Contact Us</a></li>
        </ul>
      </div>

    </div>
  </nav>
</header>
