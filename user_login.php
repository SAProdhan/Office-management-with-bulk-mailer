<?php
session_start();
require_once 'config/config.php';
$token = bin2hex(openssl_random_pseudo_bytes(16));

// If User has already logged in, redirect to dashboard page.
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === TRUE)
{
	include BASE_PATH.'/includes/header.php'; ?>
    <div id="page-" class="col-md-4 col-md-offset-4">
        <form class="form loginform" method="POST" action="authenticate.php">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">Please Sign in</div>
                <div class="panel-body">
                    <!-- <div class="form-group">
                        <label class="control-label">Enter Your OTP</label>
                        <input type="text" name="username" class="form-control" required="required" >
                    </div> -->
                    <div class="form-group">
                        <label class="control-label">Enter Your OTP</label>
                        <input type="text" name="otp" class="form-control" required="required">
                    </div>
                    <!-- <div class="checkbox">
                        <label>
                            <input name="remember" type="checkbox" value="1">Remember Me
                        </label>
                    </div> -->
                    <?php if (isset($_SESSION['otp_failure'])): ?>
                    <div class="alert alert-danger alert-dismissable fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <?php
                        echo $_SESSION['otp_failure'];
                        unset($_SESSION['otp_failure']);
                        ?>
                    </div>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-success loginField">Verify</button>
                </div>
            </div>
        </form>
    </div>
    <?php include BASE_PATH.'/includes/footer.php'; 
}
else{
    header('Location: login.php');
}
// If user has previously selected "remember me option": 

?>


