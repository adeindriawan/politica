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
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Info Situs</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<?php echo form_open_multipart('dashboard/ubah_info/', array('class' => 'form-horizontal')); ?>
						  <fieldset>
							<div class="control-group">
							  <label class="control-label" for="name">Nama Situs*</label>
							  <div class="controls">
								<input type="text" class="span6" id="name" value="<?php echo $data1['name'] ?>" placeholder="Nama Situs" name="name">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="tagline">Tagline Situs*</label>
							  <div class="controls">
								<input type="text" class="span6" id="tagline" value="<?php echo $data1['tagline'] ?>" placeholder="Tagline Situs" name="tagline">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="alamat">Alamat Kantor</label>
							  <div class="controls">
								<input type="text" class="span6" id="alamat" value="<?php echo $data1['alamat'] ?>" placeholder="Alamat Kantor" name="alamat">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="kota">Kota</label>
							  <div class="controls">
								<input type="text" class="span6" id="kota" value="<?php echo $data1['kota'] ?>" placeholder="Kota" name="kota">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="kodepos">Kode Pos</label>
							  <div class="controls">
								<input type="text" class="span6" id="kodepos" value="<?php echo $data1['kodepos'] ?>" placeholder="Kodepos" name="kodepos">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="telepon">No Telepon</label>
							  <div class="controls">
								<input type="text" class="span6" id="telepon" value="<?php echo $data1['telepon'] ?>" placeholder="No Telepon" name="telepon">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="email">Email Situs*</label>
							  <div class="controls">
								<input type="text" class="span6" id="email" value="<?php echo $data1['email'] ?>" placeholder="Email Situs" name="email">
							  </div>
							</div>
							<small><em>Email digunakan untuk membalas pesan yang masuk dan mengirim newsletter. Gunakan email dari Gmail dan sangat dianjurkan untuk membuat email khusus untuk situs ini saja dan tidak menggunakan email pribadi</em></small>
							<div class="control-group">
							  <label class="control-label" for="password">Password Email*</label>
							  <div class="controls">
								<input type="text" class="span6" id="password" value="<?php echo $data1['password'] ?>" placeholder="Password Email" name="password">
							  </div>
							</div>
							<small><em>Password email yang telah diinput sebelumnya</em></small>
							<div class="control-group">
							  <label class="control-label" for="facebook">Facebook</label>
							  <div class="controls">
							  	<div class="input-prepend">
									<span class="add-on">http://www.facebook.com/</span><input id="facebook" size="16" type="text" id="facebook" name="facebook" value="<?php echo $data1['facebook'] ?>">
								  </div>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="twitter">Twitter</label>
							  <div class="controls">
							  	<div class="input-prepend">
									<span class="add-on">http://www.twitter.com/</span><input id="twitter" size="16" type="text" id="twitter" name="twitter" value="<?php echo $data1['twitter'] ?>">
								  </div>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="instagram">Instagram</label>
							  <div class="controls">
							  	<div class="input-prepend">
									<span class="add-on">http://www.instagram.com/</span><input id="instagram" size="16" type="text" id="instagram" name="instagram" value="<?php echo $data1['instagram'] ?>">
								  </div>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="youtube">Youtube</label>
							  <div class="controls">
							  	<div class="input-prepend">
									<span class="add-on">http://www.youtube.com/</span><input id="youtube" size="16" type="text" id="youtube" name="youtube" value="<?php echo $data1['youtube'] ?>">
								  </div>
							  </div>
							</div>
							<small><em>*) Wajib diisi</em></small>
							<?php if (!is_null($this->session->userdata('bisa_ubah_info'))) { ?>
								<div class="form-actions">
								  	<?php echo form_submit("simpan", "Edit Info", array("class" => "btn btn-primary", "id" => "tombol-submit")); ?>
								  	<button type="reset" class="btn">Batal</button>
								</div>
							<?php } ?>
						  </fieldset>
						<?php echo form_close(); ?>
					</div>
				</div><!--/span-->
			</div><!--/row-->
		</div><!--/.fluid-container-->
	
			<!-- end: Content -->
	</div><!--/#content.span10-->
</div><!--/fluid-row-->

<?php if ($this->session->flashdata('validasi_eror')) { ?>
	<div class="modal hide fade" id="errorValModal">
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
            $('#errorValModal').modal({
                'show':true,
                'keyboard': false
            });
        });
    </script>
<?php } ?>

<?php if ($this->session->flashdata('sukses_ubah_info')) { ?>
	<div class="modal hide fade" id="successUpdateModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Dialog</h3>
		</div>
		<div class="modal-body tambah-tag">
			<?php echo $this->session->flashdata('sukses_ubah_info'); ?>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Tutup</a>
		</div>
	</div>
	<script type="text/javascript">
        $(document).ready(function() {
            $('#successUpdateModal').modal({
                'show':true,
                'keyboard': false
            });
        });
    </script>
<?php } ?>
	
<div class="clearfix"></div>
<?php $this->load->view('backend/dashboard/include/footer'); ?>