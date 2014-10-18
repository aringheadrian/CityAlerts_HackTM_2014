<!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo cfg('base', 'site_url'); ?>" class="logo" target="_blank">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <?php echo cfg('base', 'site_title'); ?>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $user['last_name'].' '.$user['first_name']; ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <?php if($user['avatar']): ?>
									    <img src="<?php echo cfg('base', 'site_url'); ?>uploads/images/<?php echo $user['avatar']; ?>" class="img-circle" alt="<?php echo $user['last_name'].' '.$user['first_name']; ?>" />
									<?php else: ?>
									    <img src="<?php echo cfg('base', 'site_url'); ?>templates/admin/assets/img/user.jpg" class="img-circle" alt="User Image" />
									<?php endif; ?>
									<p>
                                        <?php echo $user['last_name'].' '.$user['first_name']; ?> 
                                        <small><?php echo $user['user_email']; ?></small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="account.php" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="index.php?logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>