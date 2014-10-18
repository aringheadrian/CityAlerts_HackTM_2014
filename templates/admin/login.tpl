<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>AdminLTE | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo cfg('template', 'site_url'); ?>templates/admin/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo cfg('template', 'site_url'); ?>templates/admin/assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo cfg('template', 'site_url'); ?>templates/admin/assets/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">Sign In</div>
             
			 <?php if ($error->hasErrors()): ?>
				<div class="alert alert-danger alert-dismissable">
				    <i class="fa fa-ban"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<?php foreach ($error->displayErrors() as $value): ?>		
					    <p><?php echo $value; ?></p>
					<?php endforeach; ?>
				</div>
			 <?php $error->clearErrors(); endif; ?>
			 
			 <?php if (isset($failed)): ?>
				<div class="alert alert-danger alert-dismissable">
					<i class="fa fa-ban"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<b>Alert!</b> Login failed.
				</div>
			<?php endif; ?>
			
			<form action="" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="email" class="form-control" placeholder="Email"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>          
                    <div class="form-group">
                        <input type="checkbox" name="remember" value="1"/> Remember me
                    </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" name="submit" class="btn bg-olive btn-block">Sign me in</button>  
                </div>
            </form>

        </div>


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?php echo cfg('template', 'site_url'); ?>templates/admin/assets/js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>