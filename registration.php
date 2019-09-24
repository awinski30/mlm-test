<?php 
    session_start();
    include "phpfunc/globalfunc.php";
    include "db/auth.php";
    include "db/incDB.php";

    $ses = Globalfunc::session_handler();
    if($ses != null){
        echo Globalfunc::header_type('dashboard');
    }
 ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>MLM Test | Login</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">
    <?php include "include/include_header_cred.php"; ?>
</head>

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);">Admin Test<b>MLM</b></a>
        </div>
        <div class="card">
            <div class="body">
                <form id="data-form" role="form">
                    <div class="msg">Refferal Form</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="uname" id="uname" placeholder="Username" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">portrait</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="fname" id="fname" placeholder="Fullname" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="pass" id='pass' placeholder="Password" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">fingerprint</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="ref_code" id='ref_code' placeholder="Refferal Code" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <a href="login">User Login</a>
                            <!-- <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                            <label for="rememberme">Remember Me</label> -->
                        </div>
                        <div class="col-xs-4">
                            <button  id='regbutton' type="button" class="btn btn-block bg-pink waves-effect" >Register</button>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="status"></div>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="plugins/jquery-validation/jquery.validate.js"></script>

    <script type="text/javascript">
        //submit
        $(document).on('click', '#regbutton', function(){
            var data = $('#data-form').serialize();
            
            $.post('phpfunc/createdata.php?t=register', data ,function(d){
              $('.status').html(d);
          });

        });
    </script>


</body>

</html>