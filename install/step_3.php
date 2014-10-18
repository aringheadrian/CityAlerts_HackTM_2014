<?php

//Include library
require_once('../TreeWeb/libraries/Session.php');

use TreeWeb\libraries as lib;

//Initialize objects
$session = new lib\Session();

if (!$session->get('step_3')) header("Location: step_2.php");
	
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Installation (step 3)</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Admin Panel Template">
        <!-- styles -->
        <link href="assets/css/bootstrap.css" rel="stylesheet">
        <link href="assets/css/font-alpona.css" rel="stylesheet">
        <link href="assets/css/prettify.css" rel="stylesheet">
        <link href="assets/css/styles.css" rel="stylesheet">
        <link href="assets/css/bootstrap-reset.css" rel="stylesheet">
        <script src="assets/js/jquery.js"></script>
        <!--[if lt IE 9]>
        <script src="assets/js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="main-wrapper">
            <div class="scroll-top">
                <a href="#" class="tip-top" title="Go Top"><i class="icon-arrow-up"></i></a>
            </div>
            <!-- SITE CONTAINER -->
            <div class="main-container">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 widget-module">
                            <div class="square-widget widget-collapsible">
                                <div class="widget-head clearfix">
                                     <h1><i class="icon-file"></i> 2. Finished</h1>
                                    <span class="pull-right widget-action"><a href="#" class="widget-collapse"><i class="icon-arrow-down"></i></a><a href="#" class="widget-remove"><i class=" icon-remove-sign"></i></a></span>
                                </div>
               <div class="widget-container">
			   <div class="alert alert-block alert-success fade in">
                   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
                    <p>
						Congratulations on installing and configuring this Site as your online solution!
					</p>
					<p>
						Please log into the admin panel with the following details.
					</p>
               </div>
				<p><strong>Email:</strong> <?php echo $session->get('user_email'); ?></p>
				<p><strong>Password:</strong> <?php echo $session->get('user_password'); ?></p>
				
				<?php $session->destroy(); ?>
			<p>
				<a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . rtrim(rtrim(dirname($_SERVER['PHP_SELF']), 'install'), '/.\\'). '/'; ?>" class="btn btn-info">Site</a>
				<a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . rtrim(rtrim(dirname($_SERVER['PHP_SELF']), 'install'), '/.\\'). '/admin'; ?>" class="btn btn-info">Admin panel</a>
			</p>
		</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="assets/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/prettify.js"></script>
        <!--jQuery touch scroll -->
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src='assets/js/jquery.hoverIntent.minified.js'></script>
        <!--jQuery leftbar navigation accordion -->
        <script src='assets/js/jquery.dcjqaccordion.2.7.js'></script>
        <!-- Theme common script -->
        
        <script src='assets/js/common-script.js'></script>
        <!--[if lte IE 7]>
                        <script src="assets/js/font-alpona-ie7.js"></script>
                        <![endif]-->
    </body>
</html>
