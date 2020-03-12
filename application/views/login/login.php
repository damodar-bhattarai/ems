<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
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
        margin-top: 80%;
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
            <h2>EMS</h2><br> <h3>Login Page</h3>
            <p>Login from here to access.</p>
         </div>
      </div>
      <div class="main">
         <div class="col-md-6 col-sm-12" style="margin: auto;">
            <div class="login-form">
                <?php
                //invalid credentials message
                if(isset($_SESSION['error_msg']) && $_SESSION['error_msg']!='')
                {
                    echo '<div class="alert alert-danger">'.$_SESSION['error_msg'].' </div>';
                    unset($_SESSION['error_msg']);
                }
                if(isset($_SESSION['success_msg']) && $_SESSION['success_msg']!='')
                {
                    echo '<div class="alert alert-success">'.$_SESSION['success_msg'].' </div>';
                    unset($_SESSION['success_msg']);
                }
                ?>
              
               <form action="checkLogin" method="POST">
                  <div class="form-group">
                     <label>Login ID</label>
                     <input type="text" class="form-control" placeholder="User Id" name="user_id">
                     <!-- error message under the label -->
                     <span class="text-danger"><?php echo form_error('user_id'); ?></span>
 
                  </div>
                  <div class="form-group">
                     <label>Password</label>
                     <input type="password" class="form-control" placeholder="Password" name="password">
                    <span class="text-danger"><?php echo form_error('password'); ?></span>
                  </div>
                  <button type="submit" name="submit" class="btn btn-black">Login</button>
                  <a style="float: right; text-decoration: none" class="text-danger" href="<?= site_url('forgot');?>">Forgot Password</a>
               
               </form>
            </div>
         </div>
      </div>
</body>
</html>