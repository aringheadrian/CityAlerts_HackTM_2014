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
                        Settings
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Settings</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        
                        <div class="col-md-12">
                            
							<?php if ($error->hasErrors()): ?>
							 <div class="alert alert-danger alert-dismissable">
								<i class="fa fa-ban"></i>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<span>
								<strong>An error occurred while processing request</strong>
								</span>
								<?php foreach ($error->displayErrors() as $value): ?>		
								<p><?php echo $value; ?></p>
								<?php endforeach; ?>
							 </div>
							 <?php $error->clearErrors(); endif; ?>
							<?php if ($session->get('success') && isset($_POST['submit'])): ?>
							 <div class="alert alert-success alert-dismissable">
								<i class="fa fa-check"></i>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								Settings edited successfully! 
							 </div>
							 <?php endif; ?>
							 
							 <div class="alert alert-info alert-dismissable">
								<i class="fa fa-info"></i>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								To prevent unwanted data alteration only preview is available in demo version! 
							 </div>
							
							<!-- form start -->
                            <form role="form" action="" method="post" enctype="multipart/form-data">

							<!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_general" data-toggle="tab">General</a></li>
                                    <li><a href="#tab_contact" data-toggle="tab">Contact</a></li>
									<li><a href="#tab_upload" data-toggle="tab">Upload</a></li>
									<li><a href="#tab_seo" data-toggle="tab">Seo Related</a></li>
									<li><a href="#tab_social" data-toggle="tab">Social Networks</a></li>
									<li><a href="#tab_integration" data-toggle="tab">Social Integration</a></li>
								</ul>
								<div class="tab-content">
                                    <div class="tab-pane active" id="tab_general">
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Site title</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="site_title" value="<?php echo cfg('base', 'site_title'); ?>">
												</div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Site url</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="site_url" value="<?php echo cfg('base', 'site_url'); ?>">
												</div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Default language</label>
												<div class="col-md-4 no-padding">
													<select class="form-control" name="site_language">
														<?php foreach ($languages as $row): ?>
														<?php if ($row['language_code'] == cfg('language','site_language')): ?>
														<option value="<?php echo $row['language_code']; ?>" selected="selected"><?php echo $row['language_name']; ?></option>
														<?php else: ?>	
														<option value="<?php echo $row['language_code']; ?>"><?php echo $row['language_name']; ?></option>
														<?php endif; ?>
														<?php endforeach; ?>
												    </select>
												</div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Admin email</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="admin_email" value="<?php echo cfg('authentication', 'admin_email'); ?>">
												    <span class="help-block">The owner email address that will be used to send email.</span>
											    </div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">User registration</label>
												<div class="col-md-4 no-padding">
													<select class="form-control" name="type_registration">
														<option value="0">Immediate registration</option>
														<option value="1" <?php if (cfg('authentication', 'email_activation') == 1) echo 'selected="selected"'; ?>>Activation by email</option>
														<option value="2" <?php if (cfg('authentication', 'approve_user_registration') == 1) echo 'selected="selected"'; ?>>Approval by the administrator</option>
													</select>
												</div>	
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Items per page (Front)</label>
												<div class="col-md-2 no-padding">
												    <input type="text" class="form-control" name="per_page_catalog" value="<?php echo cfg('base', 'per_page_catalog'); ?>">
											    </div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Items per page (Admin)</label>
												<div class="col-md-2 no-padding">
												    <input type="text" class="form-control" name="per_page_admin" value="<?php echo cfg('base', 'per_page_admin'); ?>">
											    </div>
											</div>
										</div><!-- /.tab-pane -->
										<div class="tab-pane" id="tab_contact">
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Contact Address</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="contact_address" value="<?php echo cfg('contact', 'contact_address'); ?>">
												</div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Contact Zip Code</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="contact_zip_code" value="<?php echo cfg('contact', 'contact_zip_code'); ?>">
												</div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Contact City</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="contact_city" value="<?php echo cfg('contact', 'contact_city'); ?>">
												</div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Contact County</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="contact_county" value="<?php echo cfg('contact', 'contact_county'); ?>">
												</div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Contact Country</label>
												<div class="col-md-10 no-padding">
													 <input type="text" class="form-control" name="contact_country" value="<?php echo cfg('contact', 'contact_country'); ?>">
												</div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Contact Phone</label>
												<div class="col-md-10 no-padding">
													 <input type="text" class="form-control" name="contact_phone" value="<?php echo cfg('contact', 'contact_phone'); ?>">
								                     <span class="help-block">All phones numbers separated by commas.</span>
												</div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Contact Fax</label>
												<div class="col-md-10 no-padding">
													 <input type="text" class="form-control" name="contact_fax" value="<?php echo cfg('contact', 'contact_fax'); ?>">
												</div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Contact Email</label>
												<div class="col-md-10 no-padding">
													<input type="text" class="form-control" name="contact_email" value="<?php echo cfg('contact', 'contact_email'); ?>">
                                                    <span class="help-block">Used as main contact email for website.</span>
												</div>
											</div>
											<div class="form-group col-md-12 no-padding">
											    <label class="control-label col-md-2">Map Position</label>
											    <div class="col-md-10 no-padding">
													<div class="col-md-6 no-padding">
														<div id="map_canvas" style="width:100%;height:300px;"></div>
													</div>
													<div class="col-md-2">
														<label class="control-label col-md-2">Latitude</label>
														<input type="text" class="form-control" id="latitude" name="map_latitude" value="<?php echo cfg('contact', 'map_latitude'); ?>">
													</div>
													<div class="col-md-2">
														<label class="control-label col-md-2">Longitude</label>
														<input type="text" class="form-control" id="longitude"  name="map_longitude" value="<?php echo cfg('contact', 'map_longitude'); ?>">
													 </div>
											  </div>
											</div>
										</div><!-- /.tab-pane -->
										<div class="tab-pane" id="tab_upload">
										    <div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">The maximum size (bytes)</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="max_filesize" value="<?php echo cfg('upload', 'max_filesize'); ?>">
												</div>
											</div>
											<div class="form-group col-md-12 no-padding">
											    <label class="control-label col-md-2">Image thumbnail size</label>
											    <div class="col-md-10 no-padding">
													<div class="col-md-2">
														<label class="control-label col-md-2">MAX width</label>
														<input type="text" class="form-control" name="max_width_thumbnail" value="<?php echo cfg('upload', 'max_width_thumbnail'); ?>">
													</div>
													<div class="col-md-2">
														<label class="control-label col-md-2">MAX height</label>
														<input type="text" class="form-control" name="max_height_thumbnail" value="<?php echo cfg('upload', 'max_height_thumbnail'); ?>">
													 </div>
											  </div>
											    <label class="control-label col-md-2"></label>
												<div class="col-md-10">
													<div class="checkbox">
														<label>
														<input type="checkbox" class="icheckbox_minimal" id="crop_thumbnail" name="crop_thumbnail" value="1" <?php if (cfg('upload', 'crop_thumbnail') == 1) echo 'checked="checked"'; ?>>
														Crop thumbnail to exact dimensions.</label>
												    </div>
												 </div>
											</div>
											<div class="form-group col-md-12 no-padding">
											    <label class="control-label col-md-2">Image size</label>
											    <div class="col-md-10 no-padding">
													<div class="col-md-2">
														<label class="control-label col-md-2">MAX width</label>
														<input type="text" class="form-control" name="max_width" value="<?php echo cfg('upload', 'max_width'); ?>">
													</div>
													<div class="col-md-2">
														<label class="control-label col-md-2">MAX height</label>
														<input type="text" class="form-control" name="max_height" value="<?php echo cfg('upload', 'max_height'); ?>">
													 </div>
											    </div>
											</div>
										</div><!-- /.tab-pane -->
										<div class="tab-pane" id="tab_seo">
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Google Site Verification Code</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="google_verification" value="<?php echo cfg('base', 'google_verification'); ?>">
									                <span class="help-block">Used in <a href="http://www.google.com/webmasters/tools/" target="_blank">google webmaster tools</a>.</span>
											    </div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Bing Site Verification Code</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="bing_verification" value="<?php echo cfg('base', 'bing_verification'); ?>">
									                <span class="help-block">Used in <a href="http://www.bing.com/toolbox/webmaster" target="_blank">bing webmaster tools</a>.</span>
											    </div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Analytics Code</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="google_analytics" value="<?php echo cfg('base', 'google_analytics'); ?>">
									                <span class="help-block">Add user code used in <a href="http://www.google.com/analytics/" target="_blank">gooogle analytics</a>. Ex: <span class="label label-info"> UA-46086560-1 </span>.</span>
											    </div>
											</div>
										</div><!-- /.tab-pane -->	
										<div class="tab-pane" id="tab_social">
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Facebook Application Id</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="facebook_appid" value="<?php echo cfg('social', 'facebook_appid'); ?>">
												</div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Facebook Page URL</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="facebook_page" value="<?php echo cfg('social', 'facebook_page'); ?>">
												</div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Twitter Page URL</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="twitter_page" value="<?php echo cfg('social', 'twitter_page'); ?>">
												</div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Google Plus Page URL</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="googleplus_page" value="<?php echo cfg('social', 'googleplus_page'); ?>">
												</div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Youtube Channel URL</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="youtube_channel" value="<?php echo cfg('social', 'youtube_channel'); ?>">
												</div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Pinterest Page URL</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="pinterest_page" value="<?php echo cfg('social', 'pinterest_page'); ?>">
												</div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Pinterest Domain Verification Code</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="pinterest_verification" value="<?php echo cfg('social', 'pinterest_verification'); ?>">
											    </div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Tumblr Page URL</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="tumblr_page" value="<?php echo cfg('social', 'tumblr_page'); ?>">
											    </div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Delicious Page URL</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="delicious_page" value="<?php echo cfg('social', 'delicious_page'); ?>">
											    </div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Stumbleupon Page URL</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="stumbleupon_page" value="<?php echo cfg('social', 'stumbleupon_page'); ?>">
											    </div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Disqus Shortname</label>
												<div class="col-md-10 no-padding">
												    <input type="text" class="form-control" name="disqus_shortname" value="<?php echo cfg('social', 'disqus_shortname'); ?>">
									                <span class="help-block">Ex. var disqus_shortname = ' <span class="label label-info">value to replace</span> '; // required: replace example with your forum shortname</span>
											    </div>
											</div>
											<div class="form-group col-md-12 no-padding">
												<label class="control-label col-md-2">Comment System</label>
												<div class="col-md-10 no-padding">
												    <select class="form-control" name="comment_system">
														<option value="0">None</option>
														<option value="1" <?php if (cfg('social', 'comment_system') == 1) echo 'selected="selected"'; ?>>Facebook (requires Facebook Application Id)</option>
														<option value="2" <?php if (cfg('social', 'comment_system') == 2) echo 'selected="selected"'; ?>>Disqus (requires Disqus Shortname)</option>
													</select>
									                <span class="help-block">In order to use one of the comment system available fill required field in parentheses and select the desired one from dropdown.</span>
											    </div>
											</div>
										</div><!-- /.tab-pane -->	
										<div class="tab-pane" id="tab_integration" id="accordion">
                                        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                                        <div class="panel box box-primary">
                                            <div class="box-header">
                                                <h4 class="box-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#facebook">
                                                        Facebook
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="facebook" class="panel-collapse collapse">
                                                <div class="box-body">
                                                    <div class="form-group">
													    <label class="control-label col-md-2">Facebook Adapter Satus</label>
													    <div class="col-md-10">
															 <div class="checkbox no-top">
																<label>
																<input type="checkbox" class="icheckbox_minimal" name="facebook_enabled" value="1" <?php if (cfg('integration', 'facebook_enabled') == true) echo 'checked="checked"'; ?>>
																Enabled</label>
															 </div>
														</div>
												    </div>
												    <div class="form-group col-md-12 no-padding">
														<label class="control-label col-md-2">Application ID</label>
														<div class="col-md-10 no-padding">
															<input type="text" class="form-control" name="facebook_id" value="<?php echo cfg('integration', 'facebook_id'); ?>">
														</div>
												    </div>
													<div class="form-group col-md-12 no-padding">
														<label class="control-label col-md-2">Application Secret</label>
														<div class="col-md-10 no-padding">
															<input type="text" class="form-control" name="facebook_secret" value="<?php echo cfg('integration', 'facebook_secret'); ?>">
														</div>
												    </div>
													<div class="form-group col-md-12 no-padding">
														<label class="control-label col-md-2"></label>
														<div class="col-md-10 no-padding">
															<span class="help-block">
																 <p><b>1</b>. Go to <a href="https://www.facebook.com/developers/" target="_blank">https://www.facebook.com/developers/</a> and <b>create a new application</b>.</p>
																 <p><b>2</b>. Fill out any required fields such as the application name and description.</p>
																 <p><b>3</b>. Put your website domain in the <b>Site Url</b> field. It should match with the current hostname <em style="color:#CB4B16;"><?php echo $_SERVER['HTTP_HOST']; ?></em>.</p>
																 <p><b>4</b>. Once you have registered, copy and past the created application credentials into this setup page.</p>
															</span>
														</div>
													</div>
											   </div>
                                            </div>
											<div class="clearfix"></div>
                                        </div>
                                        <div class="panel box box-primary">
                                            <div class="box-header">
                                                <h4 class="box-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#google">
                                                        Google
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="google" class="panel-collapse collapse">
                                                <div class="box-body">
                                                    <div class="form-group">
													    <label class="control-label col-md-2">Google Adapter Satus</label>
													    <div class="col-md-10">
															 <div class="checkbox no-top">
																<label>
																<input type="checkbox" class="icheckbox_minimal" name="google_enabled" value="1" <?php if (cfg('integration', 'google_enabled') == true) echo 'checked="checked"'; ?>>
																Enabled</label>
															 </div>
														</div>
												    </div>
												    <div class="form-group col-md-12 no-padding">
														<label class="control-label col-md-2">Application ID</label>
														<div class="col-md-10 no-padding">
															<input type="text" class="form-control" name="google_id" value="<?php echo cfg('integration', 'google_id'); ?>">
														</div>
												    </div>
													<div class="form-group col-md-12 no-padding">
														<label class="control-label col-md-2">Application Secret</label>
														<div class="col-md-10 no-padding">
															<input type="text" class="form-control" name="google_secret" value="<?php echo cfg('integration', 'google_secret'); ?>">
														</div>
												    </div>
													<div class="form-group col-md-12 no-padding">
														<label class="control-label col-md-2"></label>
														<div class="col-md-10 no-padding">
															<span class="help-block">
																<p><b>1</b>. Go to <a href="https://code.google.com/apis/console/" target="_blank">https://code.google.com/apis/console/</a> and <b>create a new application</b>.</p>
																<p><b>2</b>. Fill out any required fields such as the application name and description.</p>
																<p><b>3</b>. On the <b>"Create Client ID"</b> popup switch to advanced settings by clicking on <b>(more options)</b>.</p>
																<p><b>4</b>. Provide this URL as the Callback URL for your application: 
																<span style="color:green"><?php echo cfg('base', 'site_url'); ?>hybridauth/?hauth.done=Google</span>	</p>
																<p><b>5</b>. Once you have registered, copy and past the created application credentials into this setup page.</p>
															</span>
														</div>
													</div>
											   </div>
                                            </div>
											<div class="clearfix"></div>
                                        </div>
										<div class="panel box box-primary">
                                            <div class="box-header">
                                                <h4 class="box-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#twitter">
                                                        Twitter
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="twitter" class="panel-collapse collapse">
                                                <div class="box-body">
                                                    <div class="form-group">
													    <label class="control-label col-md-2">Twitter Adapter Satus</label>
													    <div class="col-md-10">
															 <div class="checkbox no-top">
																<label>
																<input type="checkbox" class="icheckbox_minimal" name="twitter_enabled" value="1" <?php if (cfg('integration', 'twitter_enabled') == true) echo 'checked="checked"'; ?>>
																Enabled</label>
															 </div>
														</div>
												    </div>
												    <div class="form-group col-md-12 no-padding">
														<label class="control-label col-md-2">Application Key</label>
														<div class="col-md-10 no-padding">
															<input type="text" class="form-control" name="twitter_key" value="<?php echo cfg('integration', 'twitter_key'); ?>">
														</div>
												    </div>
													<div class="form-group col-md-12 no-padding">
														<label class="control-label col-md-2">Application Secret</label>
														<div class="col-md-10 no-padding">
															<input type="text" class="form-control" name="twitter_secret" value="<?php echo cfg('integration', 'twitter_secret'); ?>">
														</div>
												    </div>
													<div class="form-group col-md-12 no-padding">
														<label class="control-label col-md-2"></label>
														<div class="col-md-10 no-padding">
															<span class="help-block">
																<p><b>1</b>. Go to <a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a> and <b>create a new application</b>.</p>
																<p><b>2</b>. Fill out any required fields such as the application name and description.</p>
																<p><b>3</b>. Put your website domain in the <b>Application Website</b> and <b>Application Callback URL</b> fields. It should match with the current hostname <em style="color:#CB4B16;"><?php echo $_SERVER['HTTP_HOST']; ?></em>.</p>
																<p><b>4</b>. Set the <b>Default Access Type</b> to <em style="color:#CB4B16;">Read, Write, &amp; Direct Messages</em>.</p>
																<p><b>5</b>. Once you have registered, copy and past the created application credentials into this setup page.</p>
															</span>
														</div>
													</div>
											   </div>
                                            </div>
											<div class="clearfix"></div>
                                         </div>
                                         <div class="panel box box-primary">
                                            <div class="box-header">
                                                <h4 class="box-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#yahoo">
                                                        Yahoo
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="yahoo" class="panel-collapse collapse">
                                                <div class="box-body">
                                                    <div class="form-group">
													    <label class="control-label col-md-2">Yahoo Adapter Satus</label>
													    <div class="col-md-10">
															 <div class="checkbox no-top">
																<label>
																<input type="checkbox" class="icheckbox_minimal" name="yahoo_enabled" value="1" <?php if (cfg('integration', 'yahoo_enabled') == true) echo 'checked="checked"'; ?>>
																Enabled</label>
															 </div>
														</div>
												    </div>
												    <div class="form-group col-md-12 no-padding">
														<label class="control-label col-md-2">Application Key</label>
														<div class="col-md-10 no-padding">
															<input type="text" class="form-control" name="yahoo_key" value="<?php echo cfg('integration', 'yahoo_key'); ?>">
														</div>
												    </div>
													<div class="form-group col-md-12 no-padding">
														<label class="control-label col-md-2">Application Secret</label>
														<div class="col-md-10 no-padding">
															<input type="text" class="form-control" name="yahoo_secret" value="<?php echo cfg('integration', 'yahoo_secret'); ?>">
														</div>
												    </div>
													<div class="form-group col-md-12 no-padding">
														<label class="control-label col-md-2"></label>
														<div class="col-md-10 no-padding">
															<span class="help-block">
																<p><b>1</b>. Go to <a href="https://developer.apps.yahoo.com/dashboard/createKey.html" target="_blank">https://developer.apps.yahoo.com/dashboard/createKey.html</a> and <b>create a new application</b>.</p>
																<p><b>2</b>. Fill out any required fields such as the application name and description.</p>
																<p><b>3</b>. Put your website domain in the <b>Application URL</b> and <b>Application Domain</b> fields. It should match with the current hostname <em style="color:#CB4B16;"><?php echo $_SERVER['HTTP_HOST']; ?></em>.</p>
																<p><b>4</b>. Set the <b>Kind of Application</b> to <em style="color:#CB4B16;">Web-based</em>.</p>
																<p><b>5</b>. Make sure to select <em style="color:#CB4B16;">"This app requires access to private user data."</em> under <b>Access Scopes</b>.</p>
																<p><b>6</b>. Set permission for <b>Contacts & Social Directory</b> to <em style="color:#CB4B16;">read-only</em>.</p>
																<p><b>7</b>. Once you have registered, copy and past the created application credentials into this setup page.</p>
															</span>
														</div>
													</div>
											   </div>
                                            </div>
											<div class="clearfix"></div>
                                         </div>
										 <div class="panel box box-primary">
                                            <div class="box-header">
                                                <h4 class="box-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#linkedin">
                                                        LinkedIn
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="linkedin" class="panel-collapse collapse">
                                                <div class="box-body">
                                                    <div class="form-group">
													    <label class="control-label col-md-2">LinkedIn Adapter Satus</label>
													    <div class="col-md-10">
															 <div class="checkbox no-top">
																<label>
																<input type="checkbox" class="icheckbox_minimal" name="linkedin_enabled" value="1" <?php if (cfg('integration', 'linkedin_enabled') == true) echo 'checked="checked"'; ?>>
																Enabled</label>
															 </div>
														</div>
												    </div>
												    <div class="form-group col-md-12 no-padding">
														<label class="control-label col-md-2">Application Key</label>
														<div class="col-md-10 no-padding">
															<input type="text" class="form-control" name="linkedin_key" value="<?php echo cfg('integration', 'linkedin_key'); ?>">
														</div>
												    </div>
													<div class="form-group col-md-12 no-padding">
														<label class="control-label col-md-2">Application Secret</label>
														<div class="col-md-10 no-padding">
															<input type="text" class="form-control" name="linkedin_secret" value="<?php echo cfg('integration', 'linkedin_secret'); ?>">
														</div>
												    </div>
													<div class="form-group col-md-12 no-padding">
														<label class="control-label col-md-2"></label>
														<div class="col-md-10 no-padding">
															<span class="help-block">
																<p><b>1</b>. Go to <a href="https://www.linkedin.com/secure/developer" target="_blanck">https://www.linkedin.com/secure/developer</a> and <b>create a new application</b>.</p>
																<p><b>2</b>. Fill out any required fields such as the application name and description.</p>
																<p><b>3</b>. Put your website domain in the <b>Integration URL</b> field. It should match with the current hostname <em style="color:#CB4B16;"><?php echo $_SERVER['HTTP_HOST']; ?></em>.</p>
																<p><b>4</b>. Set the <b>Application Type</b> to <em style="color:#CB4B16;">Web Application</em>.</p>
																<p><b>5</b>. Once you have registered, copy and past the created application credentials into this setup page.</p>
															</span>
														</div>
													</div>
											   </div>
                                            </div>
											<div class="clearfix"></div>
                                         </div>
									</div><!-- /.tab-pane -->
									</div><!-- /.tab-content -->
									<div class="form-group col-md-12 no-padding">
										<label class="control-label col-md-2"></label>
										<div class="col-md-10 no-padding">
											<button type="submit" name="submit" class="btn btn-primary">Submit</button>
										</div>
								    </div>
								<div class="clearfix"></div>
								</div><!-- nav-tabs-custom -->
                            </form><!-- /.form -->
							
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        
    <?php require_once('footer' . cfg('template', 'template_extension')); ?>
	
    <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript">
		
		var myZoom = 12;
		var myMarkerIsDraggable = true;
		var myCoordsLenght = 6;
		var defaultLat=<?php echo cfg('contact', 'map_latitude'); ?>;
		var defaultLng=<?php echo cfg('contact', 'map_longitude'); ?>;
		var map;

		function initialize() {
		  
					

					// creates the map
					// zooms
					// centers the map
					// sets the map�s type
					map = new google.maps.Map(document.getElementById('map_canvas'), {
						zoom: myZoom,
						center: new google.maps.LatLng(defaultLat, defaultLng),
						mapTypeId: google.maps.MapTypeId.ROADMAP
					});

					// creates a draggable marker to the given coords
					myMarker = new google.maps.Marker({
						position: new google.maps.LatLng(defaultLat, defaultLng),
						draggable: myMarkerIsDraggable
					});

					// adds a listener to the marker
					// gets the coords when drag event ends
					// then updates the input with the new coords
					google.maps.event.addListener(myMarker, 'dragend', function(evt){
						document.getElementById('latitude').value = evt.latLng.lat().toFixed(myCoordsLenght);
						document.getElementById('longitude').value = evt.latLng.lng().toFixed(myCoordsLenght);
					});
					
		}

		$('a[data-toggle="tab"]').on('shown.bs.tab', function() {

			/* Trigger map resize event */
			google.maps.event.trigger(map, 'resize');
		  
		  
			// centers the map on markers coords
		   map.setCenter(myMarker.position);
		  
		   // adds the marker on the map
		   myMarker.setMap(map);
		  
		});

		initialize();
	</script>
	
    </body>
</html>
