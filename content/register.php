<div class="container col-sm-4 col-md-offset-4">
    <div class="row main">
      <h2 class="form-signin-heading"><center>Night Sky Monitoring - Register</center></h2>
      <div class="main-login main-center">
        <form class="form-horizontal" method="post" action="index.php?p=register">

          <?php

          if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $U = new User($DB);

            if ($U->checkUserAmmount() === true) {
              $U->registerUser($_POST['username'],$_POST['email'],$_POST['password'],$_POST['password_confirm'],$_POST['code']);
            }


            if ($U->getlastError() == "") {
              $_POST = array();
            }

          }

           ?>

          <div class="form-group">
            <label for="username" class="cols-sm-2 control-label">Username</label>
            <div class="cols-sm-10">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
                <input type="text" value="<?php echo page::escape($_POST['username']); ?>" class="form-control" name="username" placeholder="Enter your Username"/>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="email" class="cols-sm-2 control-label">Your Email</label>
            <div class="cols-sm-10">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                <input type="text" value="<?php echo page::escape($_POST['email']); ?>" class="form-control" name="email" placeholder="Enter your Email"/>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="password" class="cols-sm-2 control-label">Password</label>
            <div class="cols-sm-10">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                <input type="password" class="form-control" name="password" placeholder="Enter your Password"/>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
            <div class="cols-sm-10">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                <input type="password" class="form-control" name="password_confirm" placeholder="Confirm your Password"/>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="confirm" class="cols-sm-2 control-label">Code</label>
            <div class="cols-sm-10">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-qrcode fa-lg" aria-hidden="true"></i></span>
                <input type="text" value="<?php echo page::escape($_POST['code']); ?>" class="form-control" name="code" placeholder="Enter your Code"/>
              </div>
            </div>
          </div>

          <?php

          if ($_SERVER['REQUEST_METHOD'] == 'POST') {

             if ($U->getlastError() == "") {
               echo '<div class="alert alert-success" role="alert"><center>Success, confirm your email to enable your Account.</center></div>';
             } else {
               echo '<div class="alert alert-danger" role="alert"><center>'.$U->getLastError().'</center></div>';
             }

          }

          ?>

          <div class="form-group ">
            <button type="submit" class="btn btn-primary btn-lg btn-block login-button">Register</button>
          </div>
          <div class="login-register">
                  <center><a href="index.php">Login</a></center>
               </div>
        </form>
      </div>
    </div>
  </div>
