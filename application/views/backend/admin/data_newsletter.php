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
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Data Newsletter (Ada <?php echo $data3 ?> newsletters)</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<script type="text/javascript">
                        $(document).ready(function() {
                            $('#data-berita').DataTable( {
                                "bPaginate":   false,
                                "bFilter": false,
                                "bInfo": false,
                                "bDestroy": true,
                            } );
                        } );
                    </script>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable" id="data-berita">
						  <thead>
							  <tr>
								  <th>Judul Newsletter</th>
								  <th>Penulis</th>
								  <th>Tanggal</th>
								  <th>Status Newsletter</th>
								  <th>Tindakan</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php if ($data1->num_rows() == 0) { ?>
						  		<tr>
						  			<td>Belum ada newsletter</td>
						  			<td></td>
						  			<td></td>
						  			<td></td>
						  			<td></td>
						  		</tr>
						  	<?php } else { ?>
						  		<?php foreach ($data1->result_array() as $artikel) { ?>
							  		<tr id="tr<?php echo $artikel['id_newsletter'] ?>">
										<td><?php echo $artikel['judul_newsletter'] ?></td>
										<td class="center"><?php echo $artikel['username_admin'] ?></td>
										<td class="center"><?php echo $artikel['tanggal_newsletter'] ?></td>
										<td class="center">
											<?php if ($artikel['status_newsletter'] == 'Created') { ?>
												<span class="label label-success"><?php echo $artikel['status_newsletter'] ?></span>
											<?php } elseif ($artikel['status_newsletter'] == 'Published') { ?>
												<span class="label label-warning"><?php echo $artikel['status_newsletter'] ?></span>
											<?php } ?>
										</td>
										<td class="center">
											<a class="btn btn-success" href="<?php echo site_url('admin/detail-newsletter/'.$artikel['id_newsletter']) ?>" title="Lihat newsletter" data-rel="tooltip">
												<i class="halflings-icon white zoom-in"></i>  
											</a>
											<?php if ($artikel['status_newsletter'] == 'Created') { ?>
												<a class="btn btn-primary" id="tmblKirim<?php echo $artikel['id_newsletter'] ?>" value="<?php echo $artikel['id_newsletter'] ?>" judul="<?php echo $artikel['judul_newsletter'] ?>" title="Kirim newsletter" data-rel="tooltip">
													<i class="halflings-icon white envelope"></i>  
												</a>
												<a class="btn btn-info" href="<?php echo site_url('admin/edit-newsletter/'.$artikel['id_newsletter']) ?>" title="Edit newsletter" data-rel="tooltip">
													<i class="halflings-icon white edit"></i>  
												</a>
												<a class="btn btn-danger" href="#" id="tmblHapus<?php echo $artikel['id_newsletter'] ?>" value="<?php echo $artikel['id_newsletter'] ?>" judul="<?php echo $artikel['judul_newsletter'] ?>" title="Hapus newsletter" data-rel="tooltip">
													<i class="halflings-icon white trash"></i> 
												</a>
											<?php } ?>
										</td>
									</tr>
									<script type="text/javascript">
							        	$(document).ready(function() {
							        		var link = "<?php echo base_url() ?>"
							        		var idArt = $("#tmblHapus<?php echo $artikel['id_newsletter'] ?>").attr('value');
							        		var jdArt = $("#tmblHapus<?php echo $artikel['id_newsletter'] ?>").attr('judul');
							        		$("#tmblHapus<?php echo $artikel['id_newsletter'] ?>").click(function(event) {
							        			/* Act on the event */
							        			$("#actHapusArtikel").attr('value', idArt);
							        			$("#nam_ins").text(jdArt);
							        			$("#cnfHapusArtikel").modal('show');
							        		});

							        		var idNwl = $("#tmblKirim<?php echo $artikel['id_newsletter'] ?>").attr('value');
							        		var jdNwl = $("#tmblKirim<?php echo $artikel['id_newsletter'] ?>").attr('judul');
							        		$("#tmblKirim<?php echo $artikel['id_newsletter'] ?>").click(function(event) {
							        			/* Act on the event */
							        			$("#actKirimNewsletter").attr('value', idArt);
							        			$("#nam_ins").text(jdArt);
							        			$("#cnfKirimNewsletter").modal('show');
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

<div class="modal hide fade" id="cnfKirimNewsletter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="H3">Konfirmasi pengiriman newsletter</h4>
            </div>
            <div class="modal-body">
               Yakin ingin mengirim <span id="nam_ins"></span> ke semua pelanggan newsletter?<br>
            	<small><em>Proses pengiriman email bisa berlangsung beberapa saat, harap menunggu...</em></small>
            </div>
            <div class="modal-footer">
            	<img src="<?php echo base_url() ?>img/loading.gif" class="loadingImage" style="display:none;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" id="actKirimNewsletter" value="" class="btn btn-danger">Kirim</button>
            </div>
        </div>
    </div>
</div>
<div class="modal hide fade" id="sksKirimNewsletter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="H3">Dialog pengiriman newsletter</h4>
            </div>
            <div class="modal-body">
               Sukses mengirim newsletter!
            </div>
        </div>
    </div>
</div>	
<script type="text/javascript">
	$(document).ready(function() {
		$('#actKirimNewsletter').click(function(event) {
			/* Act on the event */
			var idArt = $('#actKirimNewsletter').attr('value');
			var link = "<?php echo base_url() ?>";
			$('.loadingImage').show();
			$.post(link + 'admin/kirim_newsletter/' + idArt, {id_newsletter: idArt, ajax: 1}, function(data) {
				/*optional stuff to do after success */
				if (data != "false") {
					$('#cnfKirimNewsletter').modal('hide');
					$('#sksKirimNewsletter').modal('show');
					location.reload();
				} else {
					$('#cnfKirimNewsletter').modal('hide');
					alert("Pengiriman gagal!");
				};
			});
		});
	});
</script>

<div class="modal hide fade" id="cnfHapusArtikel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="H3">Konfirmasi penghapusan artikel berita</h4>
            </div>
            <div class="modal-body">
               Yakin ingin menghapus <span id="nam_ins"></span>?
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
			$.post(link + 'admin/hapus_newsletter/' + idArt, {id_newsletter: idArt, ajax: 1}, function(data) {
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
	
<div class="clearfix"></div>
<?php $this->load->view('backend/admin/include/footer'); ?>