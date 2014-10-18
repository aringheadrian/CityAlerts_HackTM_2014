<!DOCTYPE html>
<html>
    
	<?php require_once('head' . cfg('template', 'template_extension')); ?>
    
	<body class="skin-black">
        
		<?php require_once('header' . cfg('template', 'template_extension')); ?>
		
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                
			    <?php require_once('sidebar' . cfg('template', 'template_extension')); ?>	
				
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Tools and social accounts</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active"><i class="fa fa-dashboard"></i> Home</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                   
				   <!-- Small boxes (Stat box) -->
                    <div class="row">
					    <div class="col-md-12">
			
						   <!-- Social accounts -->
						   <div class="box">
								<div class="box-header">
									<h3 class="box-title">Tools Accounts</h3>
								</div>
							<div class="box-body">
                        
								<div class="col-lg-3 col-xs-6">
									<!-- small box -->
									<div class="small-box bg-aqua">
										<div class="inner">
											<p>
												Gmail Account
											</p>
										</div>
										<div class="icon">
											<i class="fa fa-envelope-o"></i>
										</div>
										<a href="https://mail.google.com/mail/" target="_blank" class="small-box-footer">
											Go <i class="fa fa-arrow-circle-right"></i>
										</a>
									</div>
								</div><!-- ./col -->
								<div class="col-lg-3 col-xs-6">
									<!-- small box -->
									<div class="small-box bg-green">
									   <div class="inner">
											<p>
												Disqus Account
											</p>
										</div>
										<div class="icon">
											<i class="fa fa-comments-o"></i>
										</div>
										<a href="http://<?php echo cfg('social', 'disqus_shortname'); ?>.disqus.com/admin/moderate/" target="_blank" class="small-box-footer">
											Go <i class="fa fa-arrow-circle-right"></i>
										</a>
									</div>
								</div><!-- ./col -->
								<div class="col-lg-3 col-xs-6">
									<!-- small box -->
									<div class="small-box bg-aqua">
										<div class="inner">
											<p>
												Analytics
											</p>
										</div>
										<div class="icon">
											<i class="fa fa-bar-chart-o"></i>
										</div>
										<a href="https://www.google.com/analytics/web/" target="_blank" class="small-box-footer">
											Go <i class="fa fa-arrow-circle-right"></i>
										</a>
									</div>
								</div><!-- ./col -->
								<div class="col-lg-3 col-xs-6">
									<!-- small box -->
									<div class="small-box bg-red">
										<div class="inner">
											<p>
												Adwords
											</p>
										</div>
										<div class="icon">
											<i class="fa fa-tags"></i>
										</div>
										<a href="https://adwords.google.com/" target="_blank" class="small-box-footer">
											Go <i class="fa fa-arrow-circle-right"></i>
										</a>
									</div>
								</div><!-- ./col -->
								<div class="col-lg-3 col-xs-6">
									<!-- small box -->
									<div class="small-box bg-green">
										<div class="inner">
											<p>
											  Google WebmasterTools
											</p>
										</div>
										<div class="icon">
											<i class="fa fa-sitemap"></i>
										</div>
										<a href="https://www.google.com/webmasters/tools/" target="_blank" class="small-box-footer">
											Go <i class="fa fa-arrow-circle-right"></i>
										</a>
									</div>
								</div><!-- ./col -->
								<div class="col-lg-3 col-xs-6">
									<!-- small box -->
									<div class="small-box bg-yellow">
										<div class="inner">
											<p>
											   Bing WebmasterTools
											</p>
										</div>
										<div class="icon">
											<i class="fa fa-sitemap"></i>
										</div>
										<a href="https://ssl.bing.com/webmaster/home/" target="_blank" class="small-box-footer">
											Go <i class="fa fa-arrow-circle-right"></i>
										</a>
									</div>
								</div><!-- ./col -->
								<div class="col-lg-3 col-xs-6">
									<!-- small box -->
									<div class="small-box bg-yellow">
										<div class="inner">
											<p>
												Mailchimp Account
											</p>
										</div>
										<div class="icon">
											<i class="fa  fa-paperclip"></i>
										</div>
										<a href="https://us3.admin.mailchimp.com/" target="_blank" class="small-box-footer">
											Go <i class="fa fa-arrow-circle-right"></i>
										</a>
									</div>
								</div><!-- ./col -->
								<div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <p>
                                      Adsense Account
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-money"></i>
                                </div>
                                <a href="https://www.google.com/adsense" target="_blank" class="small-box-footer">
                                    Go <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
						
						 </div><!-- /.box-body -->
                        <div class="clearfix"></div>
						</div><!-- /.box -->

                        </div><!-- ./col -->
						
					</div><!-- /.row -->
					<div class="row">
					<div class="col-md-12">
					
                            <!-- Social accounts -->
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Social Accounts</h3>
                                </div>
                                <div class="box-body">
                                   
                                    <a href="<?php echo cfg('social', 'facebook_page'); ?>" target="_blank" class="btn btn-app">
                                        <i class="fa fa-facebook"></i> Facebook
                                    </a>
                                    <a href="<?php echo cfg('social', 'twitter_page'); ?>" target="_blank" class="btn btn-app">
                                        <i class="fa fa-twitter"></i> Twitter
                                    </a>
                                    <a href="<?php echo cfg('social', 'googleplus_page'); ?>" target="_blank" class="btn btn-app">
                                        <i class="fa fa-google-plus"></i> Google +
                                    </a>
                                    <a href="<?php echo cfg('social', 'youtube_channel'); ?>" target="_blank" class="btn btn-app">
                                        <i class="fa fa-youtube"></i> Youtube
                                    </a>
                                    <a href="<?php echo cfg('social', 'pinterest_page'); ?>" target="_blank" class="btn btn-app">
                                        <i class="fa fa-pinterest"></i> Pinterest
                                    </a>
                                    <a href="<?php echo cfg('social', 'tumblr_page'); ?>" target="_blank" class="btn btn-app">
                                        <i class="fa fa-tumblr"></i> Tumblr
                                    </a>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div>
						
					    </div><!-- /.row -->
				
				</section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        
    <?php require_once('footer' . cfg('template', 'template_extension')); ?>
		
    </body>
</html>
