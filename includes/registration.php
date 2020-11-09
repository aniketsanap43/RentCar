<?php

//index.php

//Include Configuration File
include('config-gmail.php');
include('config.php');

$login_button = '';


if(isset($_GET["code"]))
{

 $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);


 if(!isset($token['error']))
 {
 
  $google_client->setAccessToken($token['access_token']);

 
  $_SESSION['access_token'] = $token['access_token'];


  $google_service = new Google_Service_Oauth2($google_client);

  $data = $google_service->userinfo->get();
  
  if(!empty($data['given_name']))
  {
    $_SESSION['user_first_name'] = $data['given_name'];
  }
  if(!empty($data['email']))
  {
    $_SESSION['user_email_address'] = $data['email'];
  }
  $fname= $_SESSION['user_first_name'];
  $email= $_SESSION['user_email_address'];

  //query to check email availabilty
  $sql_email_check ="SELECT EmailId FROM tblusers WHERE EmailId=:email";
$query= $dbh -> prepare($sql_email_check);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
  echo "<script type='text/javascript'>alert('User from this email id already exists.');</script>"; 
  echo "<script>";
  echo "setTimeout(function(){ ";
  echo "   document.location='http://localhost/web1/';";
  echo "});";  // redirect after 3 seconds
  echo "</script>";
   //header("Location:index.php");
    $google_client->revokeToken();

    //Destroy entire session data.
    session_destroy();
}else{
  
  //inserting data into sql fetched from gmail-client
  $sql="INSERT INTO  tblusers(FullName,EmailId) VALUES(:fname,:email)";
  $query = $dbh->prepare($sql);
  $query->bindParam(':fname',$fname,PDO::PARAM_STR);
  $query->bindParam(':email',$email,PDO::PARAM_STR);
  $query->execute();
  $lastId = $dbh->lastInsertId();
  if($lastId)
    {
       echo "<script>alert('Registration successfull. Now you can login');</script>";
       echo "<script>";
      echo "setTimeout(function(){ ";
      echo "   document.location='http://localhost/web1/';";
      echo "});";  // redirect after 3 seconds
      echo "</script>";
   //header("Location:index.php");
    $google_client->revokeToken();

    //Destroy entire session data.
    session_destroy(); 
    }else 
    {
      echo "<script>alert('Something went wrong. Please try again');</script>";
      echo "<script>";
      echo "setTimeout(function(){ ";
      echo "   document.location='http://localhost/web1/';";
      echo "});";  // redirect after 3 seconds
      echo "</script>";
        //header("Location:index.php");
        $google_client->revokeToken();
        //Destroy entire session data.
        session_destroy();
    }
}

}

}else if(isset($_POST['signup']))
{
$fname=$_POST['fullname'];
$email=$_POST['emailid']; 
$mobile=$_POST['mobileno'];
$password=md5($_POST['password']); 
$sql="INSERT INTO  tblusers(FullName,EmailId,ContactNo,Password) VALUES(:fname,:email,:mobile,:password)";
$query = $dbh->prepare($sql);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':mobile',$mobile,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->execute();
$lastId = $dbh->lastInsertId();
if($lastId)
{
echo '<script type="text/javascript">alert("Registration successfull. Now you can login");</script>';
}
else 
{
echo "<script>alert('Something went wrong. Please try again');</script>";
}
}
if(!isset($_SESSION['access_token']))
{
  $login_button = '<div class="google-signup-link"><a class="google-img-style" href="'.$google_client->createAuthUrl().'">
  <img src="./assets/images/google_png.png" style="width:25px;height: 25px;" />Signup With Google</a></div>';
}

?>

<script>
function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#emailid").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>

<script type="text/javascript">
function valid()
{
if(document.signup.password.value!= document.signup.confirmpassword.value)
{
alert("Password and Confirm Password Field do not match  !!");
document.signup.confirmpassword.focus();
return false;
}
return true;
}
</script>

<div class="modal fade" id="signupform">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <span aria-hidden="true" class="close" data-dismiss="modal">&times;</span> 
        <h3 class="modal-title">SignUp</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="signup_wrap">
            <div class="col-md-12 col-sm-6">
              <form  method="post" name="signup" onSubmit="return valid();">
                <div class="form-group">
                  <input type="text" class="form-control" name="fullname" placeholder="Full Name" required="required">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="mobileno" placeholder="Mobile Number" maxlength="10" required="required">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" name="emailid" id="emailid" placeholder="Email Address" required="required">

                   <span id="user-availability-status" style="font-size:12px;"></span> 
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" onClick="checkAvailability()" name="password" placeholder="Password" required="required">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm Password" required="required">
                </div>
                <div class="form-group checkbox">
                  <input type="checkbox" id="terms_agree" required="required" checked="">
                  <label for="terms_agree">I Agree with <a href="#">Terms and Conditions</a></label>
                </div>
                <div class="form-group">
                  <input type="submit" value="Sign Up" name="signup" id="submit" class="btn btn-info btn-block">
                </div>
              </form>
              <div>
                <label class="using-social">Sign Up With:</label>  
              </div>  
              <div class="g-btn">
              <?php
                echo '<div align="center">'.$login_button . '</div>';
              ?>
              </div> 
            </div>
          </div>    
        </div>
      </div>
        <div class="modal-foot text-center">
          <p>Already got an account? <a href="#loginform" data-toggle="modal" data-dismiss="modal">Login Here</a></p>
        </div>
      </div>
    </div>
  </div>
</div>