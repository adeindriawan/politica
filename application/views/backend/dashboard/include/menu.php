<!-- Last edited: 2017-07-02 11:34 -->
<!-- start: Main Menu -->
<div id="sidebar-left" class="span2">
	<div class="nav-collapse sidebar-nav">
		<ul class="nav nav-tabs nav-stacked main-menu">
			<li><a href="<?php echo site_url('dashboard') ?>"><i class="icon-dashboard"></i><span class="hidden-tablet"> Dashboard</span></a></li>
			<?php if (!is_null($this->session->userdata('bisa_lihat_info')) || !is_null($this->session->userdata('bisa_ubah_info'))) { ?>
				<li><a href="<?php echo site_url('dashboard/data-info') ?>"><i class="icon-credit-card"></i><span class="hidden-tablet"> Info</span></a></li>
			<?php } ?>				
			<li>
				<a class="dropmenu" href="#"><i class="icon-book"></i><span class="hidden-tablet"> Halaman</span></a>
				<ul>
					<li><a class="submenu" href="<?php echo site_url('dashboard/data-halaman') ?>"><i class="icon-file-alt"></i><span class="hidden-tablet"> Data Halaman</span></a></li>
					<li><a class="submenu" href="<?php echo site_url('dashboard/tambah-halaman') ?>"><i class="icon-pencil"></i><span class="hidden-tablet"> Tambah Halaman</span></a></li>
				</ul>
			</li>
			<?php if ($this->session->userdata('bisa_lihat_berita') != NULL || $this->session->userdata('bisa_buat_berita') != NULL) { ?>
				<li>
					<a class="dropmenu" href="#"><i class="icon-paste"></i><span class="hidden-tablet"> Berita</span></a>
					<ul>
						<?php if ($this->session->userdata('bisa_lihat_berita') != NULL) { ?>
							<li><a class="submenu" href="<?php echo site_url('dashboard/data-berita') ?>"><i class="icon-file-alt"></i><span class="hidden-tablet"> Data Berita</span></a></li>
						<?php } ?>
						<?php if ($this->session->userdata('bisa_buat_berita')) { ?>
							<li><a class="submenu" href="<?php echo site_url('dashboard/tambah-berita') ?>"><i class="icon-pencil"></i><span class="hidden-tablet"> Tambah Berita</span></a></li>
						<?php } ?>
					</ul>
				</li>
			<?php } ?>
			<?php if ($this->session->userdata('bisa_lihat_blog') != NULL || $this->session->userdata('bisa_buat_blog') != NULL) { ?>
				<li>
					<a class="dropmenu" href="#"><i class="icon-paste"></i><span class="hidden-tablet"> Blog</span></a>
					<ul>
						<?php if ($this->session->userdata('bisa_lihat_blog') != NULL) { ?>
							<li><a class="submenu" href="<?php echo site_url('dashboard/data-blog') ?>"><i class="icon-list-alt"></i><span class="hidden-tablet"> Data Blog</span></a></li>
						<?php } ?>
						<?php if ($this->session->userdata('bisa_buat_blog') != NULL) { ?>
							<li><a class="submenu" href="<?php echo site_url('dashboard/tambah-blog') ?>"><i class="icon-pencil"></i><span class="hidden-tablet"> Tambah Blog</span></a></li>
						<?php } ?>
					</ul>
				</li>
			<?php } ?>
			<li>
				<a class="dropmenu" href="#"><i class="icon-th"></i><span class="hidden-tablet"> Kategori</span></a>
				<ul>
					<li><a class="submenu" href="<?php echo site_url('dashboard/data-kategori') ?>"><i class="icon-th-list"></i><span class="hidden-tablet"> Data Kategori</span></a></li>
				</ul>	
			</li>
			<?php if ($this->session->userdata('bisa_lihat_galeri') != NULL || $this->session->userdata('bisa_buat_galeri') != NULL) { ?>
				<li>
					<a class="dropmenu" href="#"><i class="icon-picture"></i><span class="hidden-tablet"> Galeri</span></a>
					<ul>
						<?php if ($this->session->userdata('bisa_lihat_galeri') != NULL) { ?>
							<li><a class="submenu" href="<?php echo site_url('dashboard/data-galeri') ?>"><i class="icon-file-alt"></i><span class="hidden-tablet"> Data Galeri</span></a></li>
						<?php } ?>
						<?php if ($this->session->userdata('bisa_buat_galeri') != NULL) { ?>
							<li><a class="submenu" href="#" data-target="#jmlFoto" data-toggle="modal"><i class="icon-pencil"></i><span class="hidden-tablet"> Tambah Galeri</span></a></li>
						<?php } ?>
					</ul>
				</li>
			<?php } ?>
			<li><a href="<?php echo site_url('dashboard/data-notifikasi/'); ?>"><i class="icon-bell"></i><span class="hidden-tablet"> Notifikasi</span></a></li>
			<?php if ($this->session->userdata('bisa_ubah_blog') != NULL) { ?>
				<li><a href="<?php echo site_url('dashboard/data-tugas/'); ?>"><i class="icon-table"></i><span class="hidden-tablet"> Tugas</span></a></li>
			<?php } ?>
			<?php if ($this->session->userdata('bisa_lihat_pesan') != NULL || $this->session->userdata('bisa_balas_pesan') != NULL) { ?>
				<li><a href="<?php echo site_url('dashboard/data-pesan/'); ?>"><i class="icon-envelope"></i><span class="hidden-tablet"> Pesan</span></a></li>
			<?php } ?>
			<?php if (!is_null($this->session->userdata('bisa_buat_newsletter')) || !is_null($this->session->userdata('bisa_lihat_newsletter')) || !is_null($this->session->userdata('bisa_ubah_newsletter')) || !is_null($this->session->userdata('bisa_hapus_newsletter'))) { ?>
				<li>
					<a class="dropmenu" href="#"><i class="icon-group"></i><span class="hidden-tablet"> Subscribers</span></a>
					<ul>
						<?php if (!is_null($this->session->userdata('bisa_buat_newsletter'))) { ?>
							<li><a class="submenu" href="<?php echo site_url('dashboard/tambah-newsletter') ?>"><i class="icon-pencil"></i><span class="hidden-tablet"> Tambah Newsletter</span></a></li>
						<?php } ?>
						<li><a class="submenu" href="<?php echo site_url('dashboard/data-pelanggan') ?>"><i class="icon-group"></i><span class="hidden-tablet"> Data Pelanggan</span></a></li>
						<li><a class="submenu" href="<?php echo site_url('dashboard/data-newsletter') ?>"><i class="icon-list-alt"></i><span class="hidden-tablet"> Data Newsletter</span></a></li>
					</ul>
				</li>
			<?php } ?>
			<li><a href="<?php echo site_url('dashboard/data-pencarian/'); ?>"><i class="icon-zoom-in"></i><span class="hidden-tablet"> Pencarian</span></a></li>
			<?php if (!is_null($this->session->userdata('bisa_buat_user')) || !is_null($this->session->userdata('bisa_lihat_user')) || !is_null($this->session->userdata('bisa_ubah_user')) || !is_null($this->session->userdata('bisa_hapus_user'))) { ?>
				<li>
					<a class="dropmenu" href="#"><i class="icon-group"></i><span class="hidden-tablet"> User</span></a>
					<ul>
						<li><a class="submenu" href="<?php echo site_url('dashboard/data-user') ?>"><i class="icon-file-alt"></i><span class="hidden-tablet"> Data User</span></a></li>
						<?php if (!is_null($this->session->userdata('bisa_buat_user'))) { ?>
							<li><a class="submenu" href="<?php echo site_url('dashboard/tambah-user') ?>"><i class="icon-plus"></i><span class="hidden-tablet"> Tambah User</span></a></li>
						<?php } ?>
					</ul>	
				</li>
			<?php } ?>
			<li><a href="<?php echo site_url('dashboard/profil/'.$this->session->userdata('id')); ?>"><i class="icon-user"></i><span class="hidden-tablet"> Profil</span></a></li>
		</ul>
	</div>
</div>
<div class="modal hide fade" id="jmlFoto">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Dialog</h4>
			</div>
			<div class="modal-body">
				<form action="<?php echo site_url('dashboard/tambah-galeri') ?>" method="POST" role="form">
					<legend>Tentukan Jumlah Foto</legend>
					<div class="form-group">
						<label for="">Jumlah Foto</label>
						<select name="jumlah">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
						</select>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<button type="submit" name="submit" class="btn btn-primary">Buat Album Baru</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- end: Main Menu -->