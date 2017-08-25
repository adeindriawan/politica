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
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Tambah Blog</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<?php echo form_open_multipart('kontributor/pasang_blog', array('class' => 'form-horizontal')); ?>
						  <fieldset>
							<div class="control-group">
							  	<label class="control-label" for="judul">Judul Artikel</label>
							  	<div class="controls">
									<input type="text" class="span6" id="judul-artikel" placeholder="Isi Judul Artikel" name="judul">
							  	</div>
							</div>
							<div class="control-group">
								<label class="control-label col-lg-4">Foto Artikel</label>
                                <div>
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>
                                        <div class="span2">
                                            <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" name="gambar" class="filestyle"/></span><br>
                                            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
                                    		<p><small><em>*) foto harus landscape dengan ukuran lebar minimal: 960px dan tinggi minimal: 480px</em></small></p>
                                        </div>
                                    </div>
                                </div>
							</div>  
							<div class="control-group hidden-phone">
							  	<label class="control-label" for="textarea2">Isi Artikel</label>
							  	<div class="controls">
									<textarea class="cleditor" id="textarea2" rows="3" name="isi"></textarea>
							  	</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="kategori">Kategori Artikel</label>
								<div class="controls">
								  <select id="kategori" name="kategori" data-rel="chosen">
									<?php foreach ($data2 as $value) { ?>
										<option value="<?php echo $value['id_kategori'] ?>"><?php echo $value['kategori'] ?></option>
									<?php } ?>
								  </select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="tags-artikel">Tags Artikel</label>
								<div class="controls">
								  <select id="tags-artikel" multiple name="tags[]" data-rel="chosen" data-placeholder="Pilih Tags Artikel">
									<?php foreach ($data1 as $value) { ?>
										<option value="<?php echo $value['id_tag'] ?>"><?php echo $value['tag'] ?></option>
									<?php } ?>
								  </select><br>
								<button type="button" class="btn btn-default btn-mini" style="margin-top:5px;" id="tambah-tag" data-target="#tagModal" data-toggle="modal">Tambah Tag</button>
								</div>
							</div>
							<div class="form-actions">
							  	<button type="submit" class="btn btn-primary">Tampilkan Blog</button>
							  	<a href="<?php echo site_url("kontributor/data-blog") ?>" name="kembali" class="btn btn-danger">Kembali</a>
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
		
<div class="modal hide fade" id="tagModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h3>Tambah Tag</h3>
	</div>
	<div class="modal-body tambah-tag">
		<fieldset class="form_cart">
            <input type="text" name="tags" class="form-control" id="nama-tag">
            <br><button class="btn btn-md btn-primary" id="actTambahTag">Tambah Tag</button>
        </fieldset>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Tutup</a>
	</div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
    var link = "<?php echo base_url() ?>";

        $("#actTambahTag").click(function() {
            /* Get the product ID and the quantity */
            var tag = $("#nama-tag").val();

            $.post(link + 'kontributor/tambah_tag', {tag: tag, ajax: 1}, function(data) {
                /*optional stuff to do after success*/
                if (data == 'false') {
                    alert("Penambahan tag artikel gagal!");
                } else{
                    $.get(link + 'kontributor/tambah_berita', function(cart) {
                        /*optional stuff to do after success*/
                        var newOption = $('<option value=' + data + '>' + tag + '</option>');
                        $('#tags-artikel').append(newOption);
                        $('#tags-artikel').trigger('liszt:updated');
                        $('#tagModal').modal('hide');
                    });
                };
            });
            return false;
        });
    });
</script>
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
<?php $this->load->view('backend/kontributor/include/footer'); ?>