<?php
session_start();
include('config.php');

//below stat is very imp,it took me 4 days
//below stat. saves the address of this file into variable which is used in index
//file for deleting  $_SESSION["url_for_redirect"]
$_SESSION['previous'] = basename($_SERVER['PHP_SELF']);

$_SESSION["url_for_redirect"] = 'http://localhost/web1/includes/book_car.php';

error_reporting(0);
?>

<!DOCTYPE HTML>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width initial-scale=1">
    <!-- My CSS -->
	  <link rel="stylesheet" href="../assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="../assets/css/header.css" type="text/css">
    <link rel="stylesheet" href="../assets/css/Login-Reg.css" type="text/css">
  	<link rel="stylesheet" href="../assets/css/Form.css" type="text/css">
  	<link rel="stylesheet" href="../assets/css/modal.css" type="text/css">
	<link rel="stylesheet" href="../assets/css/book_car.css" type="text/css">


	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://kit.fontawesome.com/a8442dd671.js" crossorigin="anonymous"></script>

	<!--Google Font Poppins-->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
	<!--Font Awesome-->
	<link rel="stylesheet" href="assets/css/all.min.css">
    
	<title>RentCar</title>
</head>
<body>

<!-- includes header files-->
  <!--------------Registration Form----------------->

  <?php include('registration.php');?>

  <!----------------Login Form---------------------->

  <?php include('login.php');?>

  <!----------------Forgot Password---------------------->

  <?php include('forgotpw.php');?>

  <!--------------Email Availability---------------->

  <?php include('./check_availabilty.php');?>

  
<header>
    <!-- Navbar Section Started -->
     <nav class="navbar navbar-expand-lg bg-dark ">

          <a class="navbar-brand active" href="http://localhost/web1/index.php">RentCar</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
		  aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fa fa-bars"></i>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav  ml-auto">
                <?php if(strlen($_SESSION['login'])==0)
  {
  ?>              
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" href="#loginform" data-dismiss="modal">Login</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" href="#signupform" data-dismiss="modal">SignUp </a>
                  </li>
  <?php 
  }
  else{
  ?>
                <li class="nav-item dropdown">
                  <a class="nav-link" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
  <?php
  $email=$_SESSION['login'];
  $sql ="SELECT FullName FROM tblusers WHERE EmailId=:email ";
  $query= $dbh -> prepare($sql);
  $query-> bindParam(':email', $email, PDO::PARAM_STR);
  $query-> execute();
  $results=$query->fetchAll(PDO::FETCH_OBJ);
  if($query->rowCount() > 0)
  {
  foreach($results as $result)
    {

    echo htmlentities($result->FullName); }}?></a>
                    <ul class="dropdown-menu">
                      <li><a href="../profile.php">My Account</a></li>
                      <li><a href="my-booking.php">My Bookings</a></li>
                      <li><a href="update-password.php">Update Password</a></li>
                      <li><a href="supermiler-club.php">Supermiler Club</a></li>
                      <li><a href="my-referrels.php">My Referrals</a></li>
                      <li class="last-li"><a href="../logout.php">Sing Out</a></li>
                  </ul>
                </li>
              <?php } ?>
                </ul>
              </div>
        </nav>
      </div>
    <!-- Navbar Section Ended-->
</header>

<div class="book-car-row">
  <section class="book-car-col pre-journey-details">
    <h6>Your location</h6>
    <div class="location-on-book-car">
      <div class="starting-point">Your Starting Point is <div id="starting_point_val"></div></div>
      <div class="doorstep-delivery">Doorstep Delivery : Currently Unavailable</div>
      <div class="drop-off-on-diff-city">Drop off on a Different City : N/A</div>
    </div>
    <div class="selected-dates">
      <h6>Selected Date and Time for Your Trip</h6>
    <div class="dates-on-book-car">
      <section class="date-of-journey pickup-time">PICKUP-TIME 
        <p id="start_date_data"></p>
      </section>
      <section class="date-of-journey dropup-time">DROPUP-TIME 
        <p id="end_date_data"></p>
      </section>
    </div>  
  </section>

  <section class="book-car-col car-select">
    <p class="slogo-1">Get an amazing rides.....</p>
    <div class="row product-list-m">
    <?php $sql = "SELECT tblvehicles.*,tblbrands.BrandName,tblbrands.id as bid  
      from tblvehicles join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand";
  $query = $dbh -> prepare($sql);
  $query->execute();
  $results=$query->fetchAll(PDO::FETCH_OBJ);
  $cnt=1;
  if($query->rowCount() > 0)
  {
  foreach($results as $result)
  {  ?>
                <div class="col-md-6">
                  <div class="card">
                    <img class="card-img-top" src="../assets/images/<?php echo htmlentities($result->Vimage1);?>" 
                            alt="Image" />
                    <div class="card-body">
                      <div class="product-listing-content">
                        <h4 class="card-title"><?php echo htmlentities($result->VehiclesTitle);?></h4>
                        <p class="list-price">$<?php echo htmlentities($result->PricePerDay);?> Per Day</p>
                        <ul>
                          <li><i class="fa fa-user book-car-icons" aria-hidden="true"></i><?php echo htmlentities($result->SeatingCapacity);?> seats</li>
                          <li><i class="fa fa-calendar book-car-icons" aria-hidden="true"></i><?php echo htmlentities($result->ModelYear);?> model</li>
                          <li><i class="fa fa-car book-car-icons" aria-hidden="true"></i><?php echo htmlentities($result->FuelType);?></li>
                        </ul>
                        <a href="#" class="btn">Privacy Policies<span class="angle_arrow">
                        <i class="fas fa-file-alt" aria-hidden="true"></i></span>
                        </a>
                        <?php if(strlen($_SESSION['login'])==0)
{
?>
                        <p class="book-btn1"><a data-toggle="modal" href="#loginform" data-dismiss="modal" 
                       class="btn btn-success">Book Now</a></p>
                        <p>deactive</p>
<?php 
}
else{
?>
                       <p class="book-btn1"><a class="btn btn-success">Book Now</a></p>
                       <p>active</p>
<?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
        <?php }} ?>
            </div> 
  </section>
</div>

<!-- Always use this jQuery link just above of closing tag of body -->
  <!-- Scripts --> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<script type="text/javascript">
  //data send by journey is stored in array
  var queryString = new Array();
  $(function () {
    if (queryString.length == 0) {
        if (window.location.search.split('?').length > 1) {
            var params = window.location.search.split('?')[1].split('&');
            for (var i = 0; i < params.length; i++) {
                var key = params[i].split('=')[0];
                var value = decodeURIComponent(params[i].split('=')[1]);
                queryString[key] = value;
            }
        }
    }
    if (queryString["country_val"] != null && queryString["state_val"] != null
        && queryString["city_val"] != null && queryString["start_date_val"] != null
        && queryString["end_date_val"] != null ) {
        //here we are parsing data (country,state and city) 
        //from JSON to normal form
        //and this data is send to their respective ids
      $.getJSON('../country_state_city.json', function(json_data){
        var location_data = json_data[queryString["country_val"]-1].name + " > " 
        + json_data[queryString["state_val"]-1].name + " > "
        + json_data[queryString["city_val"]-1].name;
        $("#starting_point_val").html(location_data);
      });
      var date1 = queryString["start_date_val"];
      $("#start_date_data").html(date1);
      var date2 = queryString["end_date_val"];
      $("#end_date_data").html(date2);
    }
  });

</script>