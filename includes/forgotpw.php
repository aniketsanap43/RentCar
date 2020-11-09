<?php
if(isset($_POST['update']))
{
    $email=$_POST['email'];
    $mobile=$_POST['mobile'];
    $newpassword=md5($_POST['newpassword']);
    $sql = "SELECT EmailId FROM tblusers WHERE EmailId=:email and ContactNo=:mobile";
    $query=$dbh -> prepare($sql);
    $query-> bindParam(':email',$email, PDO::PARAM-STR);
    $query-> bindParam(':mobile',$mobile, PDO::PARAM_STR);
    $query-> execute();
    $results = $query-> fetchAll(PDO::FETCH_OBJ);
    if($query -> rowCount() > 0)
    {
        $con = "UPDATE tblusers SET Password=:newpassword WHERE EmailId=:email and ContactNo=:mobile";
        $changepw = $dbh -> prepare($con);
        $changepw-> bindParam(':email',$email, PDO::PARAM_STR);
        $changepw-> bindParam(':mobile',$mobile, PDO::PARAM_STR);
        $changepw-> bindParam(':newpassword',$newpassword, PDO::PARAM_STR);
        $changepw->execute();
        echo "<script>alert('Your Password Updated Succesfully.');</script>";
    }
    else{
        echo "<script>alert('Email Id or Mobile No is Incorrect.');</script>";
    }
}
?>
<script type="text/javascript">
    function valid()
    {
        if(document.changepw.newpassword.value!=document.changepw.confirmpassword.value)
        {
            alert("New Password and Confirm Password Field do not match !!");
            document.changepw.confirmpassword.focus();
            return false;
        }
        return true;
    }
</script>


<div class="modal fade" id="forgotpassword">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Password Recovery</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="forgotpassword_wrap">
            <div class="col-md-12">
              <form name="changpw" method="post" onSubmit="return valid();">
                <div class="form-group">
                  <input type="email" name="email" class="form-control" placeholder="Your Email address*" required="">
                </div>
                <div class="form-group">
                  <input type="text" name="mobile" class="form-control" placeholder="Your Reg. Mobile*" required="">
                </div>
                <div class="form-group">
                  <input type="password" name="newpassword" class="form-control" placeholder="New Password*" required="">
                </div>
                <div class="form-group">
                  <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password*" required="">
                </div>
                <div class="form-group">
                  <input type="submit" value="Reset My Password" name="update" class="btn btn-block btn-info">
                </div>
              </form>
              <div class="text-center">
                <p class="gray_text">For security reasons we don't store your password. Your password will be reset and a new one will be send.</p>
                <p><a href="#loginform" data-toggle="modal" data-dismiss="modal"><i class="fa fa-angle-double-left" aria-hidden="true"></i> Back to Login</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>