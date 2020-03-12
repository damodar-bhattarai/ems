<!DOCTYPE html>
<html>
<head>
  <title>Modify Password</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"  crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<style type="text/css">
  body {
    font-family: "Lato", sans-serif;
}



.main-head{
    height: 150px;
    background: #FFF;
   
}

.sidenav {
    height: 100%;
    background-color: #000;
    overflow-x: hidden;
    padding-top: 20px;
}


.main {
    padding: 0px 10px;
}

@media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
}

@media screen and (max-width: 450px) {
    .login-form{
        margin-top: 10%;
    }

    .register-form{
        margin-top: 10%;
    }
}

@media screen and (min-width: 768px){
    .main{
        margin-left: 40%; 
    }

    .sidenav{
        width: 40%;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
    }

    .login-form{
        margin-top:20%;
    }

    .register-form{
        margin-top: 20%;
    }
}


.login-main-text{
    margin-top: 20%;
    padding: 60px;
    color: #fff;
}

.login-main-text h2{
    font-weight: 300;
}

.btn-black{
    background-color: #000 !important;
    color: #fff;
}

</style>
</head>

<body>
<div class="sidenav">
         <div class="login-main-text">
            <h2>EMS</h2><br> <p>Reset/Modify Password</p>
         </div>
      </div>
      <div class="main">
         <div class="col-md-6 col-sm-12" style="margin: auto;">
            <div class="login-form">
                <form method="POST" action="changePassword">
                  <p class="text-danger"><?php if(isset($error)) echo $error;?> </p>
                  <p class="text-warning"><?php if(isset($_SESSION['changePasswordMsg'])) echo $_SESSION['changePasswordMsg'];?> </p>
                <div class="form-group">
                  <label for="exampleInputEmail1">Employee ID</label>
                  <input type="text" class="form-control" disabled="true" value="<?php if(isset($_SESSION['user_id'])) echo $_SESSION['user_id']; else redirect('login');?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Current Password</label>
                  <input type="password" class="form-control" value="<?php if(isset($cp)) echo $cp;?>" name="cp" id="cp" placeholder="Current Password">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">New Password</label>
                  <input type="password" class="form-control" value="<?php if(isset($np)) echo $np;?>" name="np" id="np" placeholder="New Password">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Repeat New Password</label>
                  <input type="password" class="form-control" value="<?php if(isset($rnp)) echo $rnp;?>" name="rnp" id="rnp" placeholder="Repeat New Password">
                </div>

              <input type="submit" name="submit" class="btn btn-success" value="Change Password">
                <a  href="<?php echo site_url();?>" class="btn btn-info" > Cancel </a>
              </form>

            </div>
         </div>
      </div>


</body>
</html>