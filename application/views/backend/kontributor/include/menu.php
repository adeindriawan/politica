<!-- start: Main Menu -->
<div id="sidebar-left" class="span2">
	<div class="nav-collapse sidebar-nav">
		<ul class="nav nav-tabs nav-stacked main-menu">
			<li><a href="<?php echo site_url('kontributor') ?>"><i class="icon-dashboard"></i><span class="hidden-tablet"> Dashboard</span></a></li>	
			<li>
				<a class="dropmenu" href="#"><i class="icon-paste"></i><span class="hidden-tablet"> Blog</span></a>
				<ul>
					<li><a class="submenu" href="<?php echo site_url('kontributor/data-blog') ?>"><i class="icon-file-alt"></i><span class="hidden-tablet"> Data Blog</span></a></li>
					<li><a class="submenu" href="<?php echo site_url('kontributor/tambah-blog') ?>"><i class="icon-pencil"></i><span class="hidden-tablet"> Tambah Blog</span></a></li>
				</ul>
			</li>
			<li><a href="<?php echo site_url('kontributor/data-notifikasi') ?>"><i class="icon-bell"></i><span class="hidden-tablet"> Notifikasi</span></a></li>
			<li><a href="<?php echo site_url('kontributor/data-pencarian') ?>"><i class="icon-search"></i><span class="hidden-tablet"> Pencarian</span></a></li>
			<li><a href="<?php echo site_url('kontributor/profil/'.$this->session->userdata('id')); ?>"><i class="icon-user"></i><span class="hidden-tablet"> Profil</span></a></li>
		</ul>
	</div>
</div>
<!-- end: Main Menu -->