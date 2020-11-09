  
<header>
    <!-- Navbar Section Started -->
     <nav class="navbar navbar-expand-lg bg-dark ">

          <a class="navbar-brand" href="index.php">RentCar</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fa fa-bars"></i>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav  ml-auto">
                <li class="nav-item active">    
                  <a class="nav-link" href="#">Online Booking<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Offers</a>
                </li>
                 <li class="nav-item">
                  <a class="nav-link" href="#">RC Subscribe</a>
                </li>
                <?php if(strlen($_SESSION['login'])==0 )
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
$email = $_SESSION['login'];
/*
if(strlen($_SESSION['login'])!=0)
{
  $email=$_SESSION['login'];
} else{
  $email=$_SESSION['code'];
}*/

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
                    <li><a href="profile.php">My Account</a></li>
                    <li><a href="my-booking.php">My Bookings</a></li>
                    <li><a href="update-password.php">Update Password</a></li>
                    <li><a href="supermiler-club.php">Supermiler Club</a></li>
                    <li><a href="my-referrels.php">My Referrals</a></li>
                    <li class="last-li"><a href="logout.php">Sing Out</a></li>
                 </ul>
              </li>
            <?php } ?>
              </ul>
            </div>
      </nav>
    </div>
  <!-- Navbar Section Ended-->

</header>
