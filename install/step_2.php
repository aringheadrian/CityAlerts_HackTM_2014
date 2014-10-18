<?php

//Include libraries
require_once('../TreeWeb/libraries/Error.php');
require_once('../TreeWeb/libraries/Session.php');
require_once('../TreeWeb/libraries/Validate.php');

use TreeWeb\libraries as lib;

//Initialize objects
$error = new lib\Error();
$session = new lib\Session();
$validate = new lib\Validate();

if (!$session->get('step_2')) header("Location: step_1.php");

//Check if the form has been submitted	
if (isset($_POST['submit'])) {

	$validate->required($_POST['site_title'], 'Enter your site title.');
	$validate->email($_POST['user_email'], 'User email address not valid.');
	$validate->required($_POST['user_password'], 'Enter your password.');
	$validate->required($_POST['first_name'], 'Enter your first name.');
	$validate->required($_POST['last_name'], 'Enter your last name.');
	$validate->email($_POST['admin_email'], 'Admin email address not valid.');
	
	if (!$error->hasErrors()) {

		define('DIR_APPLICATION', str_replace('\'', '/', realpath(dirname(__FILE__) . '/../')) . '/');
		define('HTTP_SERVER', 'http://' . $_SERVER['HTTP_HOST'] . rtrim(rtrim(dirname($_SERVER['PHP_SELF']), 'install'), '/.\\'). '/');

		$config_authentication = file_get_contents('../config/authentication.php');	
		
		$replace = array(
			'__SITE_TITLE__'		=> $_POST['site_title'],
			'__HTTP_SERVER__' 		=> HTTP_SERVER,
			'__DIR_APPLICATION__'	=> DIR_APPLICATION,
			'__ADMIN_EMAIL__' 		=> $_POST['admin_email'],
			'__SECRET_WORD__' 		=> substr(md5(rand() . rand()), 0, 8)
		);
		
		if ($_POST['type_registration'] == 0) {
			
			$replace['__EMAIL_ACTIVATION__'] = "false";
			$replace['__APPROVE_REGISTRATION__'] = "false";
		
		} else if ($_POST['type_registration'] == 1) {
			
			$replace['__EMAIL_ACTIVATION__'] = "true";
			$replace['__APPROVE_REGISTRATION__'] = "false";
			
		} else if ($_POST['type_registration'] == 2) {
		
			$replace['__EMAIL_ACTIVATION__'] = "false";
			$replace['__APPROVE_REGISTRATION__'] = "true";
		
		}
		
		$output	= str_replace(array_keys($replace), $replace, $config_authentication);
		
		$file = fopen('../config/authentication.php', 'w');
		fwrite($file, $output);
		fclose($file);
		
		$config_base = file_get_contents('../config/base.php');
		
		$replace = array(
			'__SITE_TITLE__'		=> $_POST['site_title'],
			'__HTTP_SERVER__' 		=> HTTP_SERVER,
			'__DIR_APPLICATION__'	=> DIR_APPLICATION,
		);

		$output	= str_replace(array_keys($replace), $replace, $config_base);
		
		$file = fopen('../config/base.php', 'w');
		fwrite($file, $output);
		fclose($file);
				
		$config_database = file_get_contents('../config/database.php');
		
		$replace = array(
			'__HOSTNAME__' 	=> $session->get('hostname'),
			'__USERNAME__' 	=> $session->get('username'),
			'__PASSWORD__' 	=> $session->get('password'),
			'__DBNAME__' 	=> $session->get('dbname')
		);
		
		$output	= str_replace(array_keys($replace), $replace, $config_database);
		
		$file = fopen('../config/database.php', 'w');
		fwrite($file, $output);
		fclose($file);
		
		$config_integration = file_get_contents('../config/integration.php');
		
		$replace = array(
			'__HTTP_SERVER__' 		=> HTTP_SERVER,
			'__DIR_APPLICATION__'	=> DIR_APPLICATION,
		);

		$output	= str_replace(array_keys($replace), $replace, $config_integration);
		
		$file = fopen('../config/integration.php', 'w');
		fwrite($file, $output);
		fclose($file);
		
		$config_language = file_get_contents('../config/language.php');
		
		$replace = array(
			'__DIR_APPLICATION__'	=> DIR_APPLICATION,
		);

		$output	= str_replace(array_keys($replace), $replace, $config_language);
		
		$file = fopen('../config/language.php', 'w');
		fwrite($file, $output);
		fclose($file);
				
		$config_upload = file_get_contents('../config/upload.php');
		
		$replace = array(
			'__DIR_APPLICATION__'	=> DIR_APPLICATION
		);
		
		$output	= str_replace(array_keys($replace), $replace, $config_upload);
		
		$file = fopen('../config/upload.php', 'w');
		fwrite($file, $output);
		fclose($file);
		
		$config_template = file_get_contents('../config/template.php');
		
		$replace = array(
			'__HTTP_SERVER__'		=> HTTP_SERVER,
			'__DIR_APPLICATION__'	=> DIR_APPLICATION
		);
		
		$output	= str_replace(array_keys($replace), $replace, $config_template);
		
		$file = fopen('../config/template.php', 'w');
		fwrite($file, $output);
		fclose($file);

		$connection = mysql_connect($session->get('hostname'), $session->get('username'), $session->get('password'));
		
		if ($session->get('create_db'))
			mysql_query('CREATE DATABASE IF NOT EXISTS ' . $session->get('dbname'), $connection);

		mysql_select_db($session->get('dbname'), $connection);

		$sql = explode(';', file_get_contents(DIR_APPLICATION . 'install/database.sql'));

		foreach($sql as $query) mysql_query($query);
		
		mysql_query("INSERT INTO ct_users VALUES (1, 1, '" . $_POST['user_email'] . "', SHA1('" . $_POST['user_password'] . "'), 1, '1', '', '', '', '', '')");	
		mysql_query("INSERT INTO ct_user_profiles VALUES (1, 1, '" . $_POST['first_name'] . "', '" . $_POST['last_name'] . "', '')");	
		
		mysql_close($connection);
		
		$session->set('user_email', $_POST['user_email']);
		$session->set('user_password', $_POST['user_password']);
		$session->set('step_3', true);
		
		header("Location: step_3.php");
													
	}

}

?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Installation (step 2)</title>
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
                                     <h1><i class="icon-file"></i> 3. Site settings</h1>
                                    <span class="pull-right widget-action"><a href="#" class="widget-collapse"><i class="icon-arrow-down"></i></a><a href="#" class="widget-remove"><i class=" icon-remove-sign"></i></a></span>
                                </div>
               <div class="widget-container">

				<?php if ($error->hasErrors()): ?>
				
					<div class="alert alert-block alert-danger in">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
						<span>
							<strong>An error occurred while processing request</strong>
						</span>
						<?php foreach ($error->displayErrors() as $value): ?>		
							<p><?php echo $value; ?></p>
						<?php endforeach; ?>
					</div>
				
				<?php $error->clearErrors(); endif; ?>
				<form class="form-horizontal" action="" method="post">		
                 <div class="form-group">
						<label class="col-lg-2 control-label">Site title</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="site_title" value="<?php if (isset($_POST['site_title'])) echo $_POST['site_title']; ?>">
							<span class="help-block">The name of the website that will be used to send email.</span>
						</div>
				 </div>
				 <div class="form-group">
						<label class="col-lg-2 control-label">First name</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="first_name" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>">
							<span class="help-block">Your first name.</span>
						</div>
				 </div>
				 <div class="form-group">
						<label class="col-lg-2 control-label">Last name</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="last_name" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>">
							<span class="help-block">Your last name.</span>
						</div>
				 </div>
				 <div class="form-group">
						<label class="col-lg-2 control-label">User email address</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="user_email" value="<?php if (isset($_POST['user_email'])) echo $_POST['user_email']; ?>">
							<span class="help-block">The email address that will be used to login in the admin panel.</span>
						</div>
				 </div>
				 <div class="form-group">
						<label class="col-lg-2 control-label">User password</label>
						<div class="col-lg-10">
							<input type="password" class="form-control" name="user_password" value="<?php if (isset($_POST['user_password'])) echo $_POST['user_password']; ?>">
							<span class="help-block">The password that is used together with the user email address to login in the admin panel.</span>
						</div>
				 </div>
				 <div class="form-group">
						<label class="col-lg-2 control-label">Owner email address</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="admin_email" value="<?php if (isset($_POST['admin_email'])) echo $_POST['admin_email']; ?>">
							<span class="help-block">The owner email address that will be used to send email.</span>
						</div>
				 </div>
				 <div class="form-group">
						<label class="col-lg-2 control-label">User registration</label>
						<div class="col-lg-10">
							<select class="form-control" name="type_registration">
						     <option value="0">Immediate registration</option>
						     <option value="1">Activation by email</option>
						     <option value="2">Approval by the administrator</option>
					        </select>
				        </div>
				 </div>
		       
				<div class="form-group">
					<label class="col-lg-2 control-label">&nbsp;</label>
					<div class="col-lg-10">
						<div class="form-actions">
							<button type="submit" name="submit" class="btn btn-info">Install</button>
						</div>
					</div>
				</div>
		        </form>
						
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
