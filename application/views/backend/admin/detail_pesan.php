<!-- Last edited: 2017-07-02 12:16 -->
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
				<div class="box span12">
					<div class="box-header">
						<h2><i class="halflings-icon th"></i><span class="break"></span>Tabs</h2>
					</div>
					<div class="box-content">
						<ul class="nav tab-menu nav-tabs" id="myTab">
							<li class="active"><a href="#isi">Isi</a></li>
							<li><a href="#detail">Detail</a></li>
						</ul>
						 
						<div id="myTabContent" class="tab-content">
							<div class="tab-pane active" id="isi">
								<p>
									<?php echo $data1[0]['isi_pesan'] ?>
								</p>

							</div>
							<div class="tab-pane" id="detail">
								<p>Dikirim oleh	: <?php echo $data1[0]['nama_pemberi_pesan'] ?></p>
								<p>Email		: <?php echo $data1[0]['email_pemberi_pesan'] ?></p>
								<p>Tanggal		: <?php echo $data1[0]['tanggal_pesan'] ?></p>
								<p>Status		: <?php echo $data1[0]['status_pesan'] ?></p>
							</div>
						</div>
					</div>
				</div><!--/span-->
				<button type="button" class="btn btn-primary" data-target="#balas" data-toggle="modal">Balas Pesan</button>
			</div><!--/row-->
		</div><!--/.fluid-container-->
	<!-- end: Content -->
	</div><!--/#content.span10-->
</div><!--/fluid-row-->
<div class="modal hide fade" id="balas">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Balas Pesan</h4>
			</div>
			<div class="modal-body">
				<div class="control-group">
				  	<label class="control-label" for="email">ID Pesan</label>
				  	<div class="controls">
						<input type="text" class="span6 uneditable-input" id="id-pesan" name="id-pesan" value="<?php echo $data1[0]['id_pesan'] ?>">
				  	</div>
				</div>
				<div class="control-group">
				  	<label class="control-label" for="email">Tujuan</label>
				  	<div class="controls">
						<input type="text" class="span6 uneditable-input" id="email-tujuan" name="email" value="<?php echo $data1[0]['email_pemberi_pesan'] ?>">
				  	</div>
				</div>
				<div class="control-group hidden-phone">
				  	<label class="control-label" for="textarea2">Isi Balasan</label>
				  	<div class="controls">
						<textarea class="cleditor" id="textarea2" rows="3" name="isi"></textarea>
				  	</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<button type="submit" name="submit" id="balas-pesan" class="btn btn-primary">Balas</button>
			</div>
		</div>
	</div>
</div>
<div class="modal hide fade" id="sksBalas">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Balas Pesan</h4>
			</div>
			<div class="modal-body">
				<p>Sukses mengirim balasan!</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<button type="submit" name="submit" id="balas-pesan" class="btn btn-primary">Balas</button>
			</div>
		</div>
	</div>
</div>
<div class="modal hide fade" id="gglBalas">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Balas Pesan</h4>
			</div>
			<div class="modal-body">
				<p>Gagal mengirim balasan! Silakan coba beberapa saat lagi.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<button type="submit" name="submit" id="balas-pesan" class="btn btn-primary">Balas</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$("#balas-pesan").click(function(event) {
			/* Act on the event */
			var link = '<?php echo base_url() ?>';
			var ses = "<?php $this->session->userdata('type') ?>";
			var isi = $("#textarea2").val();
			var ema = $("#email-tujuan").val();
			var idp = $("#id-pesan").val();

			$.post(link + 'admin/balas_pesan', {ajax: 1, isi: isi, email: ema, id_pesan: idp}, function(data) {
				/*optional stuff to do after success */
				if (data == 'false') {
					$("#balas").modal('hide');
					$("#gglBalas").modal('show');
				} else{
					$("#balas").modal('hide');
					$("#sksBalas").modal('show');
					window.location = link + 'admin/detail-pesan/' + idp;
				};
			});
		});
	});
</script>
	
<div class="clearfix"></div>
<?php $this->load->view('backend/admin/include/footer'); ?>