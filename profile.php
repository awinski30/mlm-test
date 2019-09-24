<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>MLM Test | Profile</title>
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

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />

</head>

<body class="theme-red">
    <?php include_once('include/include_header.php'); ?>

    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-3">
                    <div class="card profile-card">
                        <div class="profile-header">&nbsp;</div>
                        <div class="profile-body">
                            <div class="image-area">
                                <img src="images/user-lg.jpg" alt="AdminBSB - Profile Image" />
                            </div>
                            <div class="content-area">
                                <h3><?php echo $glob->uinfo($_SESSION[SESUSER], 'fullname'); ?></h3>
                                <p>Email: <?php echo $glob->uinfo($_SESSION[SESUSER], 'email'); ?></p>
                                <p>Date Registered: <?php $dc = date_create($glob->uinfo($_SESSION[SESUSER], 'date_input'));
                                    echo date_format($dc, "M/d/Y");

                                 ?></p>
                                 <p>Upline: <?php 

                                 if($glob->uinfo($_SESSION[SESUSER], 'usertype') == '0'){
                                    echo "Main Line";
                                 }else{
                                    echo $glob->uinfo($glob->uinfo($_SESSION[SESUSER], 'parent_1'), 'fullname'); 
                                 }

                                 

                                 ?></p>
                                <p>Position Number: <?php echo $glob->uinfo($_SESSION[SESUSER], 'id'); ?></p>
                                <p>Referral Code: <?php echo $glob->uinfo($_SESSION[SESUSER], 'refferal_code'); ?></p>
                            </div>
                        </div>
                        
                    </div>

                </div>
                <div class="col-xs-12 col-sm-9">
                    <div class="card">
                        <div class="body">
                            <h4>Direct Refferals</h4>
                            <div class="row">
                                <?php echo $glob->output_downline($_SESSION[SESUSER], 'direct', 'output'); ?>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">   
                                    <hr>
                                    <h4>2nd Generation</h4>
                                </div>
                            </div>
                            <div class="row">
                            <?php  echo $glob->output_downline($_SESSION[SESUSER], '2ndgen', 'output'); ?>
                            </div>
                            <div class="row">
                                <div class="col-xs-12"> 
                                    <hr>
                                    <h4>3rd Generation</h4>
                                </div>
                            </div>
                            <div class="row">
                            <?php echo $glob->output_downline($_SESSION[SESUSER], '3rdgen', 'output'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/examples/profile.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>
</body>

</html>
