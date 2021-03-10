<!Doctype html>
<html>
<head>
    <meta property="og:locale" content="en_US">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title><?= page_title(@$page_title) ?></title>
    <link href="<?= LIB_TEMPLATE ?>assets/css/master.css" rel="stylesheet">
    <link href="<?= LIB_TEMPLATE ?>assets/plugins/switcher/css/switcher.css" rel="stylesheet" id="switcher-css" media="all">
    <link href="<?= LIB_TEMPLATE ?>assets/plugins/switcher/css/color1.css" rel="alternate stylesheet" title="color1" media="all">
    <link href="<?= LIB_TEMPLATE ?>assets/plugins/switcher/css/color2.css" rel="alternate stylesheet" title="color2" media="all">
    <link href="<?= LIB_TEMPLATE ?>assets/plugins/switcher/css/color3.css" rel="alternate stylesheet" title="color3" media="all">
    <link href="<?= LIB_TEMPLATE ?>assets/plugins/switcher/css/color4.css" rel="alternate stylesheet" title="color4" media="all">
    <link href="<?= LIB_TEMPLATE ?>assets/plugins/switcher/css/color5.css" rel="alternate stylesheet" title="color5" media="all">
    <script src="<?= LIB_TEMPLATE ?>assets/plugins/jquery/jquery-1.11.3.min.js"></script>

</head>
<body>

<div class="layout-theme animated-css"  data-header="sticky" data-header-top="200">

    <div id="wrapper">

        <!-- HEADER -->
        <header class="header">
            <div class="top-header">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="header-login">
                                <a class="header-login__item" href="login.php"><i class="icon stroke icon-User"></i>Student Login</a>
                                <a class="header-login__item" href="teacher.php"><i class="icon stroke icon-User"></i>Teacher Login</a>
                            </div>
                        </div>
                        <!-- end col  -->
                    </div>
                    <!-- end row  -->
                </div>
                <!-- end container  -->
            </div>
            <!-- end top-header  -->

            <div class="container">
                <div class="row">
                    <div class="col-xs-12"> <a class="header-logo" href="javascript:void(0);"><img class="header-logo__img" src="<?= image_url('logo.png    ') ?>" height="50" width="50" alt="Logo"></a>
                        <div class="header-inner">
                            <nav class="navbar yamm">
                                <div class="navbar-header hidden-md  hidden-lg  hidden-sm ">
                                    <button type="button" data-toggle="collapse" data-target="#navbar-collapse-1" class="navbar-toggle"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                                </div>
                                <div id="navbar-collapse-1" class="navbar-collapse collapse">
                                    <ul class="nav navbar-nav">
                                        <li><a href="index.php">Home </a>
                                        <li><a href="about.php">About Developer</a>
                                        <li><a href="contact.php">CONTACT US</a></li>
                                    </ul>
                                </div>
                            </nav>
                            <!--end navbar -->

                        </div>
                        <!-- end header-inner -->
                    </div>
                    <!-- end col  -->
                </div>
                <!-- end row  -->
            </div>
            <!-- end container-->
        </header>
        <!-- end header -->