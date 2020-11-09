<?php

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
  if(!empty($data['email']))
  {
    $_SESSION['user_email_address'] = $data['email'];
  }
  $email= $_SESSION['user_email_address'];
  $sql_login_email_check ="SELECT EmailId,FullName FROM tblusers WHERE EmailId=:email";
  $query= $dbh -> prepare($sql_login_email_check);
  $query-> bindParam(':email', $email, PDO::PARAM_STR);
  $query-> execute();
  $results=$query->fetchAll(PDO::FETCH_OBJ);
  $cnt=1;
  if($query->rowCount() > 0)
  {
  $_SESSION['login']=$_POST['email'];
  $_SESSION['fname']=$results->FullName;
  $currentpage=$_SERVER['REQUEST_URI'];
  echo "<script type='text/javascript'> document.location = '$currentpage'; </script>";
  } else{
    echo "<script>alert('Invalid Details');</script>";
  }
}
}else if(isset($_POST['login']))
{
  $email=$_POST['email'];
  $password=md5($_POST['password']);
  $sql ="SELECT EmailId,Password,FullName FROM tblusers WHERE EmailId=:email and Password=:password";
  $query= $dbh -> prepare($sql);
  $query-> bindParam(':email', $email, PDO::PARAM_STR);
  $query-> bindParam(':password', $password, PDO::PARAM_STR);
  $query-> execute();
  $results=$query->fetchAll(PDO::FETCH_OBJ);
  if($query->rowCount() > 0)
  {
  $_SESSION['login']=$_POST['email'];
  $_SESSION['fname']=$results->FullName;
  $currentpage=$_SERVER['REQUEST_URI'];
  echo "<script type='text/javascript'> document.location = '$currentpage'; </script>";
  } else{
    echo "<script>alert('Invalid Details');</script>";
  }
}

if(!isset($_SESSION['access_token']))
{
  $login_button = '<div class="google-signup-link"><a class="google-img-style" href="'.$google_client->createAuthUrl().'">
  <img src="./assets/images/google_png.png" style="width:25px;height: 25px;" />Login With Google</a></div>';
}

?>

<div class="modal fade" id="loginform">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <span aria-hidden="true" class="close" data-dismiss="modal">&times;</span>
        <h3 class="modal-title">Login</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="login_wrap">
            <div class="col-md-12 col-sm-6">
              <form method="post">
                <div class="form-group">
                  <input type="email" class="form-control" name="email" placeholder="Email address">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <div class="form-group checkbox">
                  <input type="checkbox" id="remember">
                </div>
                <div class="form-group">
                  <input type="submit" name="login" value="Login" class="btn btn-block btn-info">
                </div>
                <div class="g-btn">
                <label class="using-social">Log in With:</label>
                <?php
                  echo '<div align="center">'.$login_button .'</div>';
                ?>
                </div>
              </form> 
            </div>
           </div>
        </div>
        <div class="modal-foot text-center">
          <p>Don't have an account? 
            <a href="#signupform" data-toggle="modal" data-dismiss="modal">Signup Here</a>
            <br>
            <a href="#forgotpassword" data-toggle="modal" data-dismiss="modal">Forgot Password ?</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
