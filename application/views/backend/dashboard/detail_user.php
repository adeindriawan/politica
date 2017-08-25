<?php $this->load->view('backend/dashboard/include/header'); ?>
<?php echo $nav; ?>
<div class="container-fluid-full">
	<div class="row-fluid">
				
		<?php echo $menu; ?>
			
		<noscript>
			<div class="alert alert-block span10">
				<h4 class="alert-heading">Warning!</h4>
				<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
			</div>
		</noscript>
			
		<!-- start: Content -->
		<div id="content" class="span10">
			<?php $this->load->view('backend/dashboard/include/breadcrumb'); ?>
			<div class="row-fluid sortable">
				<div class="box span8">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Profil</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<?php echo form_open_multipart('dashboard/ubah_user/'.$data1[0]['id_admin'], array('class' => 'form-horizontal')); ?>
					<div class="box-content">
						<fieldset>
							<div class="control-group">
							  <label class="control-label" for="username">Username</label>
							  <div class="controls">
								<input type="text" class="span6" id="username" value="<?php echo $data1[0]['username_admin'] ?>" placeholder="Username Admin" name="username">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="password">Password</label>
							  <div class="controls">
								<input type="text" class="span6" id="password" value="<?php echo $data1[0]['password_admin'] ?>" placeholder="Password Admin" name="password">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="nama">Nama Lengkap</label>
							  <div class="controls">
								<input type="text" class="span6" id="nama" value="<?php echo $data1[0]['nama_admin'] ?>" placeholder="Nama Lengkap Admin" name="nama">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="email">Email</label>
							  <div class="controls">
								<input type="text" class="span6" id="email" value="<?php echo $data1[0]['email_admin'] ?>" placeholder="Email Admin" name="email">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="lahir">Tanggal Lahir</label>
							  <div class="controls">
								<input type="text" class="span6" id="lahir" value="<?php echo $data1[0]['tanggal_lahir_admin'] ?>" placeholder="Tanggal Lahir Admin" name="lahir">
							  </div>
							</div>
							<div class="control-group">
								<label class="control-label" for="kategori">Kategori Admin*</label>
								<div class="controls">
								  <select id="kategori" name="kategori" data-rel="chosen">
								  	<?php if ($data1[0]['kategori_admin'] == 'staf') { ?>
								  		<option value="staf" selected="selected">Staf</option>
								  		<option value="kontributor">Kontributor</option>
								  	<?php } else { ?>
								  		<option value="staf">Staf</option>
								  		<option value="kontributor" selected="selected">Kontributor</option>
								  	<?php } ?>
								  </select>
								</div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="fileInput">Foto Profil</label>
							  <div class="controls">
								<input class="input-file uniform_on" id="fileInput" type="file" name="foto">
							  </div>
							</div>          
							<div class="control-group hidden-phone">
							  <label class="control-label" for="textarea2">Deskripsi Diri</label>
							  <div class="controls">
								<textarea class="cleditor" id="textarea2" class="span6" rows="3" name="deskripsi"><?php echo $data1[0]['deskripsi_admin'] ?></textarea>
							  </div>
							</div>
							<div class="control-group">
								<label class="control-label">Akses Berita</label>
								<div class="controls">
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox1" name="bisa-buat-berita" <?php echo (!is_null($data1[0]['bisa_buat_berita'])) ? 'checked' : ''; ?> value="1"> Bisa buat berita
								  </label>
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox2" name="bisa-lihat-berita" <?php echo (!is_null($data1[0]['bisa_lihat_berita'])) ? 'checked' : ''; ?> value="1"> Bisa lihat data berita
								  </label>
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox3" name="bisa-ubah-berita" <?php echo (!is_null($data1[0]['bisa_ubah_berita'])) ? 'checked' : ''; ?> value="1"> Bisa ubah berita
								  </label>
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox4" name="bisa-hapus-berita" <?php echo (!is_null($data1[0]['bisa_hapus_berita'])) ? 'checked' : ''; ?> value="1"> Bisa hapus berita
								  </label>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Akses Blog</label>
								<div class="controls">
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox5" name="bisa-buat-blog" <?php echo (!is_null($data1[0]['bisa_buat_blog'])) ? 'checked' : ''; ?> value="1"> Bisa buat blog
								  </label>
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox6" name="bisa-lihat-blog" <?php echo (!is_null($data1[0]['bisa_lihat_blog'])) ? 'checked' : ''; ?> value="1"> Bisa lihat data blog
								  </label>
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox7" name="bisa-ubah-blog" <?php echo (!is_null($data1[0]['bisa_ubah_blog'])) ? 'checked' : ''; ?> value="1"> Bisa ubah blog
								  </label>
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox8" name="bisa-hapus-blog" <?php echo (!is_null($data1[0]['bisa_hapus_blog'])) ? 'checked' : ''; ?> value="1"> Bisa hapus blog
								  </label>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Akses Galeri</label>
								<div class="controls">
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox9" name="bisa-buat-galeri" <?php echo (!is_null($data1[0]['bisa_buat_galeri'])) ? 'checked' : ''; ?> value="1"> Bisa buat galeri
								  </label>
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox10" name="bisa-lihat-galeri" <?php echo (!is_null($data1[0]['bisa_lihat_galeri'])) ? 'checked' : ''; ?> value="1"> Bisa lihat data galeri
								  </label>
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox11" name="bisa-ubah-galeri" <?php echo (!is_null($data1[0]['bisa_ubah_galeri'])) ? 'checked' : ''; ?> value="1"> Bisa ubah galeri
								  </label>
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox12" name="bisa-hapus-galeri" <?php echo (!is_null($data1[0]['bisa_hapus_galeri'])) ? 'checked' : ''; ?> value="1"> Bisa hapus galeri
								  </label>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Akses Newsletter</label>
								<div class="controls">
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox13" name="bisa-buat-newsletter" <?php echo (!is_null($data1[0]['bisa_buat_newsletter'])) ? 'checked' : ''; ?> value="1"> Bisa buat newsletter
								  </label>
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox14" name="bisa-lihat-newsletter" <?php echo (!is_null($data1[0]['bisa_lihat_newsletter'])) ? 'checked' : ''; ?> value="1"> Bisa lihat data newsletter
								  </label>
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox15" name="bisa-ubah-newsletter" <?php echo (!is_null($data1[0]['bisa_ubah_newsletter'])) ? 'checked' : ''; ?> value="1"> Bisa ubah newsletter
								  </label>
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox16" name="bisa-hapus-newsletter" <?php echo (!is_null($data1[0]['bisa_hapus_newsletter'])) ? 'checked' : ''; ?> value="1"> Bisa hapus newsletter
								  </label>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Akses User</label>
								<div class="controls">
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox17" name="bisa-buat-user" <?php echo (!is_null($data1[0]['bisa_buat_user'])) ? 'checked' : ''; ?> value="1"> Bisa buat user
								  </label>
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox18" name="bisa-lihat-user" <?php echo (!is_null($data1[0]['bisa_lihat_user'])) ? 'checked' : ''; ?> value="1"> Bisa lihat data user
								  </label>
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox19" name="bisa-ubah-user" <?php echo (!is_null($data1[0]['bisa_ubah_user'])) ? 'checked' : ''; ?> value="1"> Bisa ubah user
								  </label>
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox20" name="bisa-hapus-user" <?php echo (!is_null($data1[0]['bisa_hapus_user'])) ? 'checked' : ''; ?> value="1"> Bisa hapus user
								  </label>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Akses Pesan</label>
								<div class="controls">
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox21" name="bisa-lihat-pesan" <?php echo (!is_null($data1[0]['bisa_lihat_pesan'])) ? 'checked' : ''; ?> value="1"> Bisa lihat pesan
								  </label>
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox22" name="bisa-balas-pesan" <?php echo (!is_null($data1[0]['bisa_balas_pesan'])) ? 'checked' : ''; ?> value="1"> Bisa balas pesan
								  </label>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Akses Info Situs</label>
								<div class="controls">
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox23" name="bisa-lihat-info" <?php echo (!is_null($data1[0]['bisa_lihat_info'])) ? 'checked' : ''; ?> value="1"> Bisa lihat info situs
								  </label>
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox24" name="bisa-ubah-info" <?php echo (!is_null($data1[0]['bisa_ubah_info'])) ? 'checked' : ''; ?> value="1"> Bisa ubah info situs
								  </label>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Akses Halaman Statis</label>
								<div class="controls">
								  <label class="checkbox inline">
									<input type="checkbox" id="inlineCheckbox23" name="bisa-ubah-halaman" <?php echo (!is_null($data1[0]['bisa_ubah_halaman'])) ? 'checked' : ''; ?> value="1"> Bisa ubah halaman statis
								  </label>
								</div>
							</div>
							<div class="form-actions">
								<?php if (!is_null($this->session->userdata('bisa_ubah_user'))) { ?>
									<?php echo form_submit("simpan", "Edit User", array("class" => "btn btn-primary", "id" => "tombol-submit")); ?>
							  		<button type="reset" class="btn">Batal</button>
								<?php } ?>
							</div>
						</fieldset>
					</div>
					<?php echo form_close(); ?>
				</div><!--/span-->
				<div class="box span3">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Foto Profil</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<?php if ($data1[0]['foto_admin'] == NULL) { ?>
							<p>(Belum ada foto profil)</p>
						<?php } else { ?>
							<img src="<?php echo base_url() ?>uploads/images/profil/page/<?php echo $data1[0]['foto_admin'] ?>">
						<?php } ?>
					</div>
				</div><!--/span-->
			</div><!--/row-->
		</div><!--/.fluid-container-->
	
			<!-- end: Content -->
	</div><!--/#content.span10-->
</div><!--/fluid-row-->

<script type="text/javascript">
	$(document).ready(function() {
		$('#lahir').datetimepicker({
			format: 'Y-m-d',
		})
	});
</script>

<?php if ($this->session->flashdata('update_no_upload')) { ?>
	<div class="modal hide fade" id="successNoUploadModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Dialog</h3>
		</div>
		<div class="modal-body tambah-tag">
			<?php echo $this->session->flashdata('update_no_upload'); ?>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Tutup</a>
		</div>
	</div>
	<script type="text/javascript">
        $(document).ready(function() {
            $('#successNoUploadModal').modal({
                'show':true,
                'keyboard': false
            });
        });
    </script>
<?php } ?>
<?php if ($this->session->flashdata('update_with_upload')) { ?>
	<div class="modal hide fade" id="successWithUploadModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Dialog</h3>
		</div>
		<div class="modal-body tambah-tag">
			<?php echo $this->session->flashdata('update_with_upload'); ?>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Tutup</a>
		</div>
	</div>
	<script type="text/javascript">
        $(document).ready(function() {
            $('#successWithUploadModal').modal({
                'show':true,
                'keyboard': false
            });
        });
    </script>
<?php } ?>
<?php if ($this->session->flashdata('validasi_eror')) { ?>
	<div class="modal hide fade" id="errorFormModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Dialog</h3>
		</div>
		<div class="modal-body tambah-tag">
			<?php echo $this->session->flashdata('validasi_eror'); ?>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Tutup</a>
		</div>
	</div>
	<script type="text/javascript">
        $(document).ready(function() {
            $('#errorFormModal').modal({
                'show':true,
                'keyboard': false
            });
        });
    </script>
<?php } ?>
	
<div class="clearfix"></div>
<?php $this->load->view('backend/dashboard/include/footer'); ?>