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
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Edit Newsletter</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<?php echo form_open_multipart('dashboard/ubah_newsletter/'.$data1[0]['id_newsletter'], array('class' => 'form-horizontal')); ?>
						  <fieldset>
							<div class="control-group">
							  	<label class="control-label" for="judul">Judul Newsletter</label>
							  	<div class="controls">
									<input type="text" class="span6" id="judul-artikel" placeholder="Isi Judul Newsletter" name="judul" value="<?php echo $data1[0]['judul_newsletter'] ?>">
							  	</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="gambar-artikel">Gambar Newsletter</label>
			                    <div class="controls">
			                    	<?php if ($data1[0]['gambar_newsletter'] == NULL) { ?>
			                    		[Tidak ada gambar]
			                    	<?php } else { ?>
			                    		<img width="250px" height="103,75px" src="<?php echo base_url() ?>uploads/images/newsletter/email/<?php echo $data1[0]['gambar_newsletter'] ?>">
			                    	<?php } ?>
			                    </div>
			                </div>
							<div class="control-group">
							  	<label class="control-label" for="fileInput">Upload Gambar Baru</label>
							  	<div class="controls">
									<input class="input-file uniform_on" id="fileInput" type="file" name="gambar">
							  	</div>
							</div>          
							<div class="control-group hidden-phone">
							  	<label class="control-label" for="textarea2">Isi Newsletter</label>
							  	<div class="controls">
									<textarea class="cleditor" id="textarea2" rows="3" name="isi"><?php echo $data1[0]['isi_newsletter'] ?></textarea>
							  	</div>
							</div>
							<div class="form-actions">
								<?php if (!is_null($this->session->userdata('bisa_ubah_newsletter'))) { ?>
									<button type="submit" class="btn btn-primary">Ubah Newsletter</button>
							  		<button type="reset" class="btn">Batal</button>
								<?php } ?>
							</div>
						  </fieldset>
						<?php echo form_close(); ?>
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
<?php $this->load->view('backend/dashboard/include/footer'); ?>