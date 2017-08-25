<?php $this->load->view('backend/kontributor/include/header'); ?>
<?php echo $nav; ?>
<div class="container-fluid-full">
	<div class="row-fluid">
				
		<?php $this->load->view('backend/kontributor/include/menu'); ?>
			
		<noscript>
			<div class="alert alert-block span10">
				<h4 class="alert-heading">Warning!</h4>
				<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
			</div>
		</noscript>
			
		<!-- start: Content -->
		<div id="content" class="span10">
			<?php $this->load->view('backend/kontributor/include/breadcrumb'); ?>
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
					<div class="box-content">
						<?php echo form_open_multipart('kontributor/ubah_profil/'.$data1[0]['id_admin'], array('class' => 'form-horizontal')); ?>
						  <fieldset>
							<div class="control-group">
							  <label class="control-label" for="username">Username</label>
							  <div class="controls">
								<input type="text" class="span6" id="username" value="<?php echo $data1[0]['username_admin'] ?>" placeholder="Username kontributor" name="username">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="password">Password</label>
							  <div class="controls">
								<input type="text" class="span6" id="password" value="<?php echo $data1[0]['password_admin'] ?>" placeholder="Password kontributor" name="password">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="nama">Nama Lengkap</label>
							  <div class="controls">
								<input type="text" class="span6" id="nama" value="<?php echo $data1[0]['nama_admin'] ?>" placeholder="Nama Lengkap kontributor" name="nama">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="lahir">Tanggal Lahir</label>
							  <div class="controls">
								<input type="text" class="span6" id="lahir" value="<?php echo $data1[0]['tanggal_lahir_admin'] ?>" placeholder="Tanggal Lahir kontributor" name="lahir">
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
							<div class="form-actions">
							  <?php echo form_submit("simpan", "Edit Profil", array("class" => "btn btn-primary", "id" => "tombol-submit")); ?>
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
<?php $this->load->view('backend/kontributor/include/footer'); ?>