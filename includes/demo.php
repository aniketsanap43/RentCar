<header>
  <div class="topnav" id="myTopnav">
    <a class="navbar-brand" href="index.php">RentCar</a>
      <?php if(strlen($_SESSION['login'])==0)
{
?>              
                   <a class="nav-link" data-toggle="modal" href="#loginform" data-dismiss="modal">Login</a>
                   <a class="nav-link" data-toggle="modal" href="#signupform" data-dismiss="modal">SignUp </a>
<?php 
}
else{
?>
                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle" aria-hidden="true"></i>
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
                    <li><a href="profile.php">My Profile</a></li>
                    <li><a href="my-booking.php">My Bookings</a></li>
                    <li><a href="update-password.php">Update Password</a></li>
                    <li><a href="supermiler-club.php">Supermiler Club</a></li>
                    <li><a href="my-referrels.php">My Referrals</a></li>
                    <li><a href="logout.php">Sing Out</a></li>
                 </ul>
            <?php } ?>
    <a class="nav-link" href="#">RC Subscribe</a>
    <a class="nav-link" href="#">Offers</a>
    <a class="nav-link" href="#">Online Booking<span class="sr-only">(current)</span></a>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
      <i class="fa fa-bars"></i>
    </a>
  </div>
  
  <div class="topheader">
    <div class="center-div ">
      <h1 class="font-weight-bold text-uppercase text-black">drive in the city and outstation</h1>
      <p class="text-uppercase">self drive car rental</p>
    </div>
  </div>

<script>
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>
</header>

