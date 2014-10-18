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

if (!$session->get('step_1')) header("Location: index.php");

//Check if the form has been submitted
if (isset($_POST['submit'])) {

	$validate->required($_POST['hostname'], 'Enter your hostname.');
	$validate->required($_POST['username'], 'Enter your username.');
	$validate->required($_POST['dbname'], 'Enter your database name.');
	
	if (!$error->hasErrors()) {

		$session->set('hostname', $_POST['hostname']);
		$session->set('username', $_POST['username']);
		$session->set('password', $_POST['password']);
		$session->set('dbname', $_POST['dbname']);
				
		if (isset($_POST['create_db'])) {
			
			$session->set('create_db', true);
			
			if (@mysql_connect($_POST['hostname'], $_POST['username'], $_POST['password']))
				header("Location: step_2.php");
			else
				$failed = true;
			
		} else {
			
			$session->set('create_db', false);

			if (@mysql_connect($_POST['hostname'], $_POST['username'], $_POST['password']) && mysql_select_db($_POST['dbname']))
				header("Location: step_2.php");
			else
				$failed = true;	
			
		}
		
		if (!$failed) $session->set('step_2', true);
			
	}

}

?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Installation (step 1)</title>
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
                                     <h1><i class="icon-file"></i> 2. Please enter your database information</h1>
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

				<?php if (isset($failed)): ?>
					<div class="alert alert-block alert-danger fade in">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
						<span>
							<strong>An error occurred while processing request</strong>
						</span>	
						<p>Problem connecting to the database: <?php echo mysql_error(); ?></p>
					</div>
				<?php endif; ?>
				<form class="form-horizontal" action="" method="post">
					<div class="form-group">
						<label class="col-lg-2 control-label">Server</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="hostname" value="<?php if (isset($_POST['hostname'])) echo $_POST['hostname']; ?>">
							<span class="help-block">The address of the database server in the form of a hostname or IP address.</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">Username</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="username" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>">
							<span class="help-block">The username used to connect to the database server.</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">Password</label>
						<div class="col-lg-10">
							<input type="password"  class="form-control" name="password" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>">
						    <span class="help-block">The password that is used together with the username to connect to the database server.</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">Database name</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="dbname" value="<?php if (isset($_POST['dbname'])) echo $_POST['dbname']; ?>">
							<span class="help-block">The name of the database.</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">Create database</label>
						<div class="col-lg-10">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="create_db" value="true">
									(You may need to create it yourself) </label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">&nbsp;</label>
						<div class="col-lg-10">
							<div class="form-actions">
								<button type="submit" name="submit" class="btn btn-info"><i class="icon-ok"></i> Next step</button>
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
