<!-- start: Header -->
<div class="navbar">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="<?php echo base_url() ?>"><span><?php echo $nama ?></span></a>
							
			<!-- start: Header Menu -->
			<div class="nav-no-collapse header-nav">
				<ul class="nav pull-right">
					<li class="dropdown hidden-phone">
						<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="halflings-icon white warning-sign"></i>
						</a>
						<ul class="dropdown-menu notifications">
							<li class="dropdown-menu-title">
									<span><?php echo count($notif) ?> notifikasi terbaru</span>
								<a href="#refresh"><i class="icon-repeat"></i></a>
							</li>
							<?php foreach ($notif as $key => $value) { ?>
								<?php switch ($value['tipe_notifikasi']) {
									case 'komentar': ?>
										<li>
											<?php if ($value['id_artikel']) { ?>
												<a href="<?php echo site_url($value['kategori_artikel'].'/artikel/'.$value['id_artikel']) ?>">
													<span class="icon green"><i class="icon-comment-alt"></i></span>
													<span class="message">1 komentar ditambahkan</span>
			                                    </a>
											<?php } else { ?>
												<a href="<?php echo site_url('galeri/album/'.$value['id_album']) ?>">
													<span class="icon green"><i class="icon-comment-alt"></i></span>
													<span class="message">1 komentar ditambahkan</span>
			                                    </a>
											<?php } ?>
		                                </li>
										<?php break;

									case 'persetujuan': ?>
										<li>
		                                    <a href="<?php echo site_url($value['kategori_artikel'].'/artikel/'.$value['id_artikel']) ?>">
												<span class="icon blue"><i class="icon-check"></i></span>
												<span class="message">1 artikel disetujui</span>
		                                    </a>
		                                </li>
										<?php break;
									
									default:  ?>
										<li class="dropdown-menu-sub-footer">
		                            		<a>Tidak ada notifikasi</a>
										</li>	
										<?php break;
								} ?>
							<?php } ?>
							<li class="dropdown-menu-sub-footer">
                        		<a href="<?php echo site_url('admin/data-notifikasi') ?>">Lihat semua notifikasi</a>
							</li>	
						</ul>
					</li>
					<!-- start: User Dropdown -->
					<li class="dropdown">
						<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="halflings-icon white user"></i> <?php echo $this->session->userdata('username'); ?>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li class="dropdown-menu-title">
									<span>Account Settings</span>
							</li>
							<li><a href="#"><i class="halflings-icon user"></i> Profil</a></li>
							<?php switch ($this->uri->segment(1)) {
								case 'kontributor': ?>
									<li><a href="<?php echo site_url('kontributor/logout') ?>"><i class="halflings-icon off"></i> Logout</a></li>
									<?php break;

								case 'staf': ?>
									<li><a href="<?php echo site_url('staf/logout') ?>"><i class="halflings-icon off"></i> Logout</a></li>
									<?php break;

								default: ?>
									<li><a href="<?php echo site_url('admin/logout') ?>"><i class="halflings-icon off"></i> Logout</a></li>
									<?php break;
							} ?>
						</ul>
					</li>
					<!-- end: User Dropdown -->
				</ul>
			</div>
			<!-- end: Header Menu -->
			
		</div>
	</div>
</div>
<!-- start: Header -->