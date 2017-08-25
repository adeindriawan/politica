<!-- Last edited: 2017-07-02 00:59 -->
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
						<h2><i class="halflings-icon user"></i><span class="break"></span>Data Pelanggan Newsletter (Ada <?php echo $data3 ?> pelanggan)</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<script type="text/javascript">
                        $(document).ready(function() {
                            $('#data-pelanggan').DataTable( {
                                "bPaginate":   false,
                                "bFilter": false,
                                "bInfo": false,
                                "bDestroy": true,
                            } );
                        } );
                    </script>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable" id="data-pelanggan">
						  <thead>
							  <tr>
								  <th>Email</th>
								  <th>Waktu Berlangganan</th>
								  <th>Tindakan</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php if ($data1->num_rows() == 0) { ?>
						  		<tr>
						  			<td>Belum ada pelanggan newsletter</td>
						  			<td></td>
						  			<td></td>
						  		</tr>
						  	<?php } else { ?>
						  		<?php foreach ($data1->result_array() as $element) { ?>
							  		<tr id="tr<?php echo $element['id_pelanggan'] ?>">
										<td><?php echo $element['email_pelanggan'] ?></td>
										<td class="center"><?php echo $element['waktu_berlangganan'] ?></td>
										<td class="center">
											<?php if (!is_null($this->session->userdata('bisa_hapus_pelanggan'))) { ?>
												<a class="btn btn-danger" href="#" id="tmblHapus<?php echo $element['id_pelanggan'] ?>" value="<?php echo $element['id_pelanggan'] ?>" judul="<?php echo $element['email_pelanggan'] ?>" title="Hapus pelanggan" data-rel="tooltip">
													<i class="halflings-icon white trash"></i> 
												</a>
											<?php } ?>
										</td>
									</tr>
									<script type="text/javascript">
							        	$(document).ready(function() {
							        		var idArt = $("#tmblHapus<?php echo $element['id_pelanggan'] ?>").attr('value');
							        		var jdArt = $("#tmblHapus<?php echo $element['id_pelanggan'] ?>").attr('judul');
							        		var link = "<?php echo base_url() ?>"
							        		$("#tmblHapus<?php echo $element['id_pelanggan'] ?>").click(function(event) {
							        			/* Act on the event */
							        			$("#actHapusArtikel").attr('value', idArt);
							        			$("#nam_ins").text(jdArt);
							        			$("#cnfHapusArtikel").modal('show');
							        		});
							        	});
							        </script>
							  	<?php } ?>
						  	<?php } ?>
						  </tbody>
					  	</table>
					  	<?php echo $data2; ?>           
					</div>
				</div><!--/span-->
			</div><!--/row-->
		</div><!--/.fluid-container-->
	<!-- end: Content -->
	</div><!--/#content.span10-->
</div><!--/fluid-row-->

<div class="modal hide fade" id="cnfHapusArtikel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="H3">Konfirmasi penghapusan pelanggan</h4>
            </div>
            <div class="modal-body">
               Yakin ingin menghapus <span id="nam_ins"></span> dari daftar pelanggan newsletter?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" id="actHapusArtikel" value="" class="btn btn-danger">Hapus</button>
            </div>
        </div>
    </div>
</div>	
<script type="text/javascript">
	$(document).ready(function() {
		$('#actHapusArtikel').click(function(event) {
			/* Act on the event */
			var idArt = $('#actHapusArtikel').attr('value');
			var link = "<?php echo base_url() ?>";
			$.post(link + 'dashboard/hapus_pelanggan/' + idArt, {id_pelanggan: idArt, ajax: 1}, function(data) {
				/*optional stuff to do after success */
				if (data == "true") {
					$('#cnfHapusArtikel').modal('hide');
					$("#tr" + idArt).fadeTo('slow', 0, function() {
						$("#tr" + idArt).slideUp('slow');
					});
				} else {
					$('#cnfHapusArtikel').modal('hide');
					alert("Penghapusan gagal!");
				};
			});
		});
	});
</script>
<div class="modal hide fade" id="myModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h3>Settings</h3>
	</div>
	<div class="modal-body">
		<p>Here settings can be configured...</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Close</a>
		<a href="#" class="btn btn-primary">Save changes</a>
	</div>
</div>
	
<div class="clearfix"></div>
<?php $this->load->view('backend/dashboard/include/footer'); ?>