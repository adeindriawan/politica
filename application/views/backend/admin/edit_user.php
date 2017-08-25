<?php $this->load->view('backend/admin/include/header'); ?>
<?php echo $nav; ?>
<div class="container-fluid-full">
	<div class="row-fluid">
				
		<?php $this->load->view('backend/admin/include/menu'); ?>
			
		<noscript>
			<div class="alert alert-block span10">
				<h4 class="alert-heading">Warning!</h4>
				<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
			</div>
		</noscript>
			
		<!-- start: Content -->
		<div id="content" class="span10">
			<?php $this->load->view('backend/admin/include/breadcrumb'); ?>
			<div class="row-fluid sortable">
				<div class="box span8">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Edit User</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<?php echo form_open_multipart('admin/ubah_user/'.$data1[0]['id_admin'], array('class' => 'form-horizontal')); ?>
						  <fieldset>
							<div class="control-group">
							  <label class="control-label" for="nama">Nama User</label>
							  <div class="controls">
								<input type="text" class="span6" id="nama-user" placeholder="Isi Nama User" name="nama" value="<?php echo $data1[0]['nama_admin'] ?>">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="username">Username*</label>
							  <div class="controls">
								<input type="text" class="span6" id="username" placeholder="Isi Username" name="username" value="<?php echo $data1[0]['username_admin'] ?>">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="password">Password*</label>
							  <div class="controls">
								<input type="text" class="span6" id="password" placeholder="Isi Password" name="password" value="<?php echo $data1[0]['password_admin'] ?>">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="email">Email*</label>
							  <div class="controls">
								<input type="email" class="span6" id="email" placeholder="Isi Email" name="email" value="<?php echo $data1[0]['email_admin'] ?>">
							  </div>
							</div>
							<div class="control-group">
								<label class="control-label" for="kategori">Kategori Admin*</label>
								<div class="controls">
								  <select id="kategori" name="kategori" data-rel="chosen">
								  	<?php if ($data1[0]['kategori_admin'] == 'Staf') { ?>
								  		<option value="staf" selected="selected">Staf</option>
								  	<?php } else { ?>
								  		<option value="kontributor" selected="selected">Kontributor</option>
								  	<?php } ?>
								  </select>
								</div>
							</div>
							<div class="control-group">
							  	<label class="control-label" for="fileInput">Foto User</label>
							  	<div class="controls">
									<input class="input-file uniform_on" id="fileInput" type="file" name="foto">
							  	</div>
							</div>
							<p><em><small>*) Harus diisi</small></em></p>
							<div class="form-actions">
							  <button type="submit" name="daftar" class="btn btn-primary">Edit User</button>
							  <button type="reset" class="btn">Batal</button>
							</div>
						  </fieldset>
						<?php echo form_close(); ?>
					</div>
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

<?php if ($this->session->flashdata('insert_success_no_upload')) { ?>
	<div class="modal hide fade" id="successNoUploadModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Dialog</h3>
		</div>
		<div class="modal-body tambah-tag">
			<?php echo $this->session->flashdata('insert_success_no_upload'); ?>
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
<?php if ($this->session->flashdata('success_insert_with_upload')) { ?>
	<div class="modal hide fade" id="successWithUploadModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Dialog</h3>
		</div>
		<div class="modal-body tambah-tag">
			<?php echo $this->session->flashdata('success_insert_with_upload'); ?>
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
<?php if ($this->session->flashdata('error_form_validation')) { ?>
	<div class="modal hide fade" id="errorFormModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Dialog</h3>
		</div>
		<div class="modal-body tambah-tag">
			<?php echo $this->session->flashdata('error_form_validation'); ?>
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
<?php $this->load->view('backend/admin/include/footer'); ?>