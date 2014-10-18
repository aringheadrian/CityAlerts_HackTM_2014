<?php

//Include library
require_once('../TreeWeb/libraries/Session.php');

use TreeWeb\libraries as lib;

//Initialize object
$session = new lib\Session();

define('DIR_APPLICATION', realpath(dirname(__FILE__) . '/../') . '/');

$writeable_directories = array(
	DIR_APPLICATION . 'config',
	DIR_APPLICATION . 'logs',
	DIR_APPLICATION . 'uploads/files',
	DIR_APPLICATION . 'uploads/images'
);

$writeable_files = array(
	DIR_APPLICATION . 'config/authentication.php',
	DIR_APPLICATION . 'config/base.php',
	DIR_APPLICATION . 'config/contact.php',
	DIR_APPLICATION . 'config/database.php',
	DIR_APPLICATION . 'config/integration.php',
	DIR_APPLICATION . 'config/language.php',
	DIR_APPLICATION . 'config/social.php',
	DIR_APPLICATION . 'config/upload.php',
	DIR_APPLICATION . 'config/template.php'
);

//Check settings server
function check_settings() {
	
	global $writeable_directories, $writeable_files;
	
	$error = array();
	
	if (phpversion() < '5.2')
		$error['warning'] = true;
		
	if (!ini_get('file_uploads'))
		$error['warning'] = true;
		
	if (!extension_loaded('session'))
		$error['warning'] = true;
	
	if (!extension_loaded('PDO'))
		$error['warning'] = true;
		
	if (!extension_loaded('gd'))
		$error['warning'] = true;

	if (ini_get('register_globals'))
		$error['warning'] = true;
		
	foreach ($writeable_directories as $value) {
		
		if (!is_writable($value))
			$error['warning'] = true;
		
	}

	foreach ($writeable_files as $value) {
		
		if (!is_writable($value))
			$error['warning'] = true;
		
	}
	
	if (!$error)
		return true;
	else
		return false;
    		
}	

if (check_settings()) $session->set('step_1', true);

?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Installer</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Admin Panel Template">
        <!-- styles -->
        <link href="assets/css/bootstrap.css" rel="stylesheet">
        <link href="assets/css/font-alpona.css" rel="stylesheet">
        <link href="assets/css/prettify.css" rel="stylesheet">
        <link href="assets/css/styles.css" rel="stylesheet">
        <link href="assets/css/bootstrap-reset.css" rel="stylesheet">
        <!--fav and touch icons -->
        <link rel="shortcut icon" href="ico/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
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
                                     <h1><i class="icon-file"></i> 1. Requirements</h1>
                                    <span class="pull-right widget-action"><a href="#" class="widget-collapse"><i class="icon-arrow-down"></i></a><a href="#" class="widget-remove"><i class=" icon-remove-sign"></i></a></span>
                                </div>
               <div class="widget-container">
               <table class="table table-striped table-hover responsive">
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th>Expected value</th>
						<th>Server value</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><strong>Required settings</strong></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>PHP version</td>
						<td>5.2 or higher</td>
						<td><?php echo phpversion(); ?></td>
					</tr>
					<tr>
						<td>File uploads</td>
						<td>On</td>
						<td>
							<?php if (ini_get('file_uploads')): ?> 
								<h4 style="color:#5cb85c;"><i class="icon-checkmark-2"></i></h4>
							<?php else: ?>
								<h4 style="color:#bc2328;"><i class="icon-close"></i></h4>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td>Session</td>
						<td>On</td>
						<td>
							<?php if (extension_loaded('session')): ?> 
								<h4 style="color:#5cb85c;"><i class="icon-checkmark-2"></i></h4>
							<?php else: ?>
								<h4 style="color:#bc2328;"><i class="icon-close"></i></h4>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td>Register globals</td>
						<td>Off</td>
						<td>
							<?php if (!ini_get('register_globals')): ?>
								<h4 style="color:#5cb85c;"><i class="icon-checkmark-2"></i></h4>
							<?php else: ?>
								<h4 style="color:#bc2328;"><i class="icon-close"></i></h4>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td><strong>PHP Extensions</strong></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>PDO</td>
						<td>Loaded</td>
						<td>
							<?php if (extension_loaded('PDO')): ?> 
								<h4 style="color:#5cb85c;"><i class="icon-checkmark-2"></i></h4>
							<?php else: ?>
								<h4 style="color:#bc2328;"><i class="icon-close"></i></h4>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td>GD library</td>
						<td>Loaded</td>
						<td>
							<?php if (extension_loaded('gd')): ?> 
								<h4 style="color:#5cb85c;"><i class="icon-checkmark-2"></i></h4>
							<?php else: ?>
								<h4 style="color:#bc2328;"><i class="icon-close"></i></h4>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td><strong>Folder permissions</strong></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><?php echo DIR_APPLICATION . 'config'; ?></td>
						<td>Writable</td>
						<td>
							<?php if (is_writable(DIR_APPLICATION . 'config')): ?>
								<h4 style="color:#5cb85c;"><i class="icon-checkmark-2"></i></h4>
							<?php else: ?>
								<h4 style="color:#bc2328;"><i class="icon-close"></i></h4>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td><?php echo DIR_APPLICATION . 'logs'; ?></td>
						<td>Writable</td>
						<td>
							<?php if (is_writable(DIR_APPLICATION . 'logs')): ?>
								<h4 style="color:#5cb85c;"><i class="icon-checkmark-2"></i></h4>
							<?php else: ?>
								<h4 style="color:#bc2328;"><i class="icon-close"></i></h4>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td><?php echo DIR_APPLICATION . 'uploads/files'; ?></td>
						<td>Writable</td>
						<td>
							<?php if (is_writable(DIR_APPLICATION . 'uploads/files')): ?>
								<h4 style="color:#5cb85c;"><i class="icon-checkmark-2"></i></h4>
							<?php else: ?>
								<h4 style="color:#bc2328;"><i class="icon-close"></i></h4>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td><?php echo DIR_APPLICATION . 'uploads/images'; ?></td>
						<td>Writable</td>
						<td>
							<?php if (is_writable(DIR_APPLICATION . 'uploads/images')): ?>
								<h4 style="color:#5cb85c;"><i class="icon-checkmark-2"></i></h4>
							<?php else: ?>
								<h4 style="color:#bc2328;"><i class="icon-close"></i></h4>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td><strong>File permissions</strong></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><?php echo DIR_APPLICATION . 'config/authentication.php'; ?></td>
						<td>Writable</td>
						<td>
							<?php if (is_writable(DIR_APPLICATION . 'config/authentication.php')): ?>
								<h4 style="color:#5cb85c;"><i class="icon-checkmark-2"></i></h4>
							<?php else: ?>
								<h4 style="color:#bc2328;"><i class="icon-close"></i></h4>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td><?php echo DIR_APPLICATION . 'config/base.php'; ?></td>
						<td>Writable</td>
						<td>
							<?php if (is_writable(DIR_APPLICATION . 'config/base.php')): ?>
								<h4 style="color:#5cb85c;"><i class="icon-checkmark-2"></i></h4>
							<?php else: ?>
								<h4 style="color:#bc2328;"><i class="icon-close"></i></h4>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td><?php echo DIR_APPLICATION . 'config/contact.php'; ?></td>
						<td>Writable</td>
						<td>
							<?php if (is_writable(DIR_APPLICATION . 'config/contact.php')): ?>
								<h4 style="color:#5cb85c;"><i class="icon-checkmark-2"></i></h4>
							<?php else: ?>
								<h4 style="color:#bc2328;"><i class="icon-close"></i></h4>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td><?php echo DIR_APPLICATION . 'config/database.php'; ?></td>
						<td>Writable</td>
						<td>
							<?php if (is_writable(DIR_APPLICATION . 'config/database.php')): ?>
								<h4 style="color:#5cb85c;"><i class="icon-checkmark-2"></i></h4>
							<?php else: ?>
								<h4 style="color:#bc2328;"><i class="icon-close"></i></h4>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td><?php echo DIR_APPLICATION . 'config/integration.php'; ?></td>
						<td>Writable</td>
						<td>
							<?php if (is_writable(DIR_APPLICATION . 'config/integration.php')): ?>
								<h4 style="color:#5cb85c;"><i class="icon-checkmark-2"></i></h4>
							<?php else: ?>
								<h4 style="color:#bc2328;"><i class="icon-close"></i></h4>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td><?php echo DIR_APPLICATION . 'config/language.php'; ?></td>
						<td>Writable</td>
						<td>
							<?php if (is_writable(DIR_APPLICATION . 'config/language.php')): ?>
								<h4 style="color:#5cb85c;"><i class="icon-checkmark-2"></i></h4>
							<?php else: ?>
								<h4 style="color:#bc2328;"><i class="icon-close"></i></h4>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td><?php echo DIR_APPLICATION . 'config/social.php'; ?></td>
						<td>Writable</td>
						<td>
							<?php if (is_writable(DIR_APPLICATION . 'config/social.php')): ?>
								<h4 style="color:#5cb85c;"><i class="icon-checkmark-2"></i></h4>
							<?php else: ?>
								<h4 style="color:#bc2328;"><i class="icon-close"></i></h4>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td><?php echo DIR_APPLICATION . 'config/upload.php'; ?></td>
						<td>Writable</td>
						<td>
							<?php if (is_writable(DIR_APPLICATION . 'config/upload.php')): ?>
								<h4 style="color:#5cb85c;"><i class="icon-checkmark-2"></i></h4>
							<?php else: ?>
								<h4 style="color:#bc2328;"><i class="icon-close"></i></h4>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td><?php echo DIR_APPLICATION . 'config/template.php'; ?></td>
						<td>Writable</td>
						<td>
							<?php if (is_writable(DIR_APPLICATION . 'config/template.php')): ?>
								<h4 style="color:#5cb85c;"><i class="icon-checkmark-2"></i></h4>
							<?php else: ?>
								<h4 style="color:#bc2328;"><i class="icon-close"></i></h4>
							<?php endif; ?>
						</td>
					</tr>
				</tbody>
			</table>

			 <?php if (check_settings()): ?>
				<div class="alert alert-block alert-success fade in">
                   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
                    <p>
						Your server meets all the requirements for Installer to run properly, go to the next step by
						clicking the button below.
					</p>
               </div>
			<?php else: ?>
				<div class="alert alert-block alert-danger fade in">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
                     <p>
						It seems that your server failed to meet the requirements to run the Installer. Please contact 
						your server administrator or hosting company to get this resolved.
					 </p>
                    </div>
			<?php endif; ?>

			<?php if (check_settings()): ?>
				<a href="step_1.php" class="pull-right" style="margin-bottom:20px;"><button class="btn btn-info" type="button"><i class="icon-ok"></i> Next step</button></a>	
			<?php else: ?>
				<a href="index.php" class="pull-right" style="margin-bottom:20px;"><button class="btn btn-warning" type="button"><i class="icon-lightbulb"></i> Try again</button></a>
			<?php endif; ?>                 

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
