<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{
if(isset($_POST['updateprofile']))
  {
$name=$_POST['fullname'];
$mobileno=$_POST['mobilenumber'];
$dob=$_POST['dob'];
$adress=$_POST['address'];
$city=$_POST['city'];
$country=$_POST['country'];
$email=$_SESSION['login'];
$sql="update tblusers set FullName=:name,ContactNo=:mobileno,dob=:dob,Address=:adress,City=:city,Country=:country where EmailId=:email";
$query = $dbh->prepare($sql);
$query->bindParam(':name',$name,PDO::PARAM_STR);
$query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
$query->bindParam(':dob',$dob,PDO::PARAM_STR);
$query->bindParam(':adress',$adress,PDO::PARAM_STR);
$query->bindParam(':city',$city,PDO::PARAM_STR);
$query->bindParam(':country',$country,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->execute();
$msg="Profile Updated Successfully";
}

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width initial-scale=1">
	<!-- My CSS -->
	<link rel="stylesheet" href="assets/css/style.css" type="text/css">

	<link rel="stylesheet" href="assets/css/footer.css" type="text/css">
	<link rel="stylesheet" href="assets/css/Login-Reg.css" type="text/css">
  	<link rel="stylesheet" href="assets/css/Form.css" type="text/css">
  	<link rel="stylesheet" href="assets/css/modal.css" type="text/css">
  	<link rel="stylesheet" href="assets/css/header.css" type="text/css">
  	<link rel="stylesheet" href="assets/css/profile.css" type="text/css">



	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://kit.fontawesome.com/a8442dd671.js" crossorigin="anonymous"></script>

	<!--Google Font Poppins-->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
	<!--Font Awesome-->
	<link rel="stylesheet" href="assets/css/all.min.css">

	<title>RentCar</title>
</head>

<body scroll="no">

<?php include('includes/header.php'); ?>

<div class="profile-main">
	<div class="profile-head-name "> <h1 class="text-center">Your Profile</h1></div>
		<div class="profile-design">

<?php 
$useremail=$_SESSION['login'];
$sql = "SELECT * from tblusers where EmailId=:useremail";
$query = $dbh -> prepare($sql);
$query -> bindParam(':useremail',$useremail, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{ ?>
		<div  class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-12 ">
					<div class="row profile-row">
						<div class="col-lg-3 col-md-3 col-12">
							<div class="user-profile text-center">
								<div class="user-photo"><i class="far fa-user"></i></div>
								<h5><?php echo htmlentities($result->FullName); ?></h5>
								<p><?php  echo htmlentities($result->EmailId);?></p>
							</div>
							<div class="credit-bal text-center">
								<h4>Credit Balance: 0</h4>
							</div>
							<div class="user-prof-listing">
								<div><a href="#">My Bookings</a></div>
								<div><a href="#">Saved Cards</a></div>
								<div><a href="profile.php">Account</a></div>
								<div><a href="#">Profile Verification</a></div>
								<div><a href="#">Co-Driver</a></div>
							</div>
						</div>
						<div class="col-lg-9 col-md-9 col-12 profile-col">
							<div class="profile-col2-header text-center">
								<h2>MY<b> ACCOUNT</b></h2>
								<hr class="groove">
							</div>
							<?php  
         if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
         					<div class="profile-update">
         						<form method="post">
         							<div class="form-group">
					              		<label class="control-label">Reg Date -</label>
					            	 <?php echo htmlentities($result->RegDate);?>
					            	</div>
						             <?php if($result->UpdationDate!=""){?>
						            <div class="form-group">
						              <label class="control-label">Last Update at  -</label>
						             <?php echo htmlentities($result->UpdationDate);?>
						            </div>
						            <?php } ?>
						            <div class="form-group">
						              <label class="control-label">Full Name</label>
						              <input class="form-control white_bg" name="fullname" value="<?php echo htmlentities($result->FullName);?>" id="fullname" type="text"  required>
						            </div>
						            <div class="form-group">
						              <label class="control-label">Email Address</label>
						              <input class="form-control white_bg" value="<?php echo htmlentities($result->EmailId);?>" name="emailid" id="email" type="email" required readonly>
						            </div>
						            <div class="form-group">
						              <label class="control-label">Phone Number</label>
						              <input class="form-control white_bg" name="mobilenumber" value="<?php echo htmlentities($result->ContactNo);?>" id="phone-number" type="text" required>
						            </div>
						            <div class="form-group">
						              <label class="control-label">Date of Birth&nbsp;(dd/mm/yyyy)</label>
						              <input class="form-control white_bg" value="<?php echo htmlentities($result->dob);?>" name="dob" placeholder="dd/mm/yyyy" id="birth-date" type="text" >
						            </div>
						            <div class="form-group">
						              <label class="control-label">Your Address</label>
						              <textarea class="form-control white_bg" name="address" rows="4" ><?php echo htmlentities($result->Address);?></textarea>
						            </div>
						            <div class="form-group">
						              <label class="control-label">Country</label>
						              <input class="form-control white_bg"  id="country" name="country" value="<?php echo htmlentities($result->Country);?>" type="text">
						            </div>
						            <div class="form-group">
						              <label class="control-label">City</label>
						              <input class="form-control white_bg" id="city" name="city" value="<?php echo htmlentities($result->City);?>" type="text">
						            </div>
						            <?php }} ?>
						           
						            <div class="form-group">
						              <button type="submit" name="updateprofile" class="btn">Save Changes <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
						            </div>
					         	 </form>
         					</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php include('foter.php');?>

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
<?php } ?>