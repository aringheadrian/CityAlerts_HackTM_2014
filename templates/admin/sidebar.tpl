<!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li <?php echo $current_dashboard; ?>>
                            <a href="index.php">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li <?php echo $current_settings; ?>>
                            <a href="settings.php">
                                <i class="fa fa-cog"></i> <span>Settings</span>
                            </a>
                        </li>
						<li <?php echo $current_languages; ?>>
                            <a href="languages.php">
                                <i class="fa fa-flag"></i> <span>Languages</span>
                            </a>
                        </li>
						<li <?php echo $current_ads; ?>>
                            <a href="ads.php">
                                <i class="fa fa-qrcode"></i> <span>Ads</span>
                            </a>
                        </li>
						<li <?php echo $current_slides; ?>>
                            <a href="slides.php">
                                <i class="fa fa-picture-o"></i> <span>Slides</span>
                            </a>
                        </li>
						<li class="treeview <?php echo $current_music; ?>">
                            <a href="#">
                                <i class="fa fa-music"></i>
                                <span>Dj Mixes</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li <?php echo $current_mcategories; ?>><a href="mixes_categories.php"><i class="fa fa-angle-double-right"></i> Categories</a></li>
								<li <?php echo $current_mixes; ?>><a href="mixes.php"><i class="fa fa-angle-double-right"></i> Mixes</a></li>
                            </ul>
                        </li>
						<li <?php echo $current_events; ?>>
                            <a href="events.php">
                                <i class="fa fa-thumb-tack"></i> <span>Events</span>
                            </a>
                        </li>
						<li <?php echo $current_users; ?>>
                            <a href="users.php">
                                <i class="fa fa-group"></i> <span>Users</span>
                            </a>
                        </li>
						<li <?php echo $current_partners; ?>>
                            <a href="partners.php">
                                <i class="fa fa-briefcase"></i> <span>Partners</span>
                            </a>
                        </li>
                        <li class="treeview <?php echo $current_blog; ?>">
                            <a href="#">
                                <i class="fa fa-book"></i>
                                <span>Blog</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li <?php echo $current_categories; ?>><a href="articles_categories.php"><i class="fa fa-angle-double-right"></i> Categories</a></li>
								<li <?php echo $current_articles; ?>><a href="articles.php"><i class="fa fa-angle-double-right"></i> Articles</a></li>
                            </ul>
                        </li>
						<li class="treeview <?php echo $current_gallery; ?>">
                            <a href="#">
                                <i class="fa fa-camera"></i>
                                <span>Gallery</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li <?php echo $current_albums; ?>><a href="albums.php"><i class="fa fa-angle-double-right"></i> Albums</a></li>
								<li <?php echo $current_images; ?>><a href="album_images.php"><i class="fa fa-angle-double-right"></i> Album Images</a></li>
								<li <?php echo $current_videos; ?>><a href="album_videos.php"><i class="fa fa-angle-double-right"></i> Album Videos</a></li>
                            </ul>
                        </li>
						<li class="treeview <?php echo $current_pages; ?>">
                            <a href="#">
                                <i class="fa fa-sitemap"></i>
                                <span>Pages</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li <?php if($_GET['page_id']==1) echo 'class="active"'; ?>><a href="pages.php?page_id=1"><i class="fa fa-angle-double-right"></i> Home</a></li>
								<li <?php if($_GET['page_id']==2) echo 'class="active"'; ?>><a href="pages.php?page_id=2"><i class="fa fa-angle-double-right"></i> DJ Mixes</a></li>
								<li <?php if($_GET['page_id']==3) echo 'class="active"'; ?>><a href="pages.php?page_id=3"><i class="fa fa-angle-double-right"></i> Blog</a></li>
								<li <?php if($_GET['page_id']==4) echo 'class="active"'; ?>><a href="pages.php?page_id=4"><i class="fa fa-angle-double-right"></i> Partners</a></li>
								<li <?php if($_GET['page_id']==5) echo 'class="active"'; ?>><a href="pages.php?page_id=5"><i class="fa fa-angle-double-right"></i> Events</a></li>
								<li <?php if($_GET['page_id']==6) echo 'class="active"'; ?>><a href="pages.php?page_id=6"><i class="fa fa-angle-double-right"></i> Contact</a></li>
								<li <?php if($_GET['page_id']==7) echo 'class="active"'; ?>><a href="pages.php?page_id=7"><i class="fa fa-angle-double-right"></i> Add Mix</a></li>
								<li <?php if($_GET['page_id']==8) echo 'class="active"'; ?>><a href="pages.php?page_id=8"><i class="fa fa-angle-double-right"></i> 404</a></li>
                            </ul>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->