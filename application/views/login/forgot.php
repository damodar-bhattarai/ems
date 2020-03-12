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
        margin-top:50%;
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
         <div class="col-md-6 col-sm-12 " style="margin: auto;">
            <div class="login-form">
                <form method="POST" action="forgot">
                  <p class="text-danger"><?php if(isset($error)) echo $error;?> </p>
                  <p class="text-success"><?php if(isset($success)) echo $success;?> </p>
                <div class="form-group">
                  <label for="emp_id">Employee ID</label>
                  <input type="text" placeholder="Enter your employee id" name="emp_id" id="emp_id" class="form-control">
                </div>
  
              <input type="submit" name="request" class="btn btn-success" value="Request Reset">
                <a  href="<?php echo site_url();?>" class="btn btn-info" > Cancel </a>
              </form>

            </div>
         </div>
      </div>


</body>
</html>