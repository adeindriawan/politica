<!-- Last edited: 2017-07-02 12:19 -->
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
						<h2><i class="halflings-icon user"></i><span class="break"></span>Data Halaman (Ada <?php echo $data3 ?> halaman)</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<script type="text/javascript">
                        $(document).ready(function() {
                            $('#data-halaman').DataTable( {
                                "bPaginate":   false,
                                "bFilter": false,
                                "bInfo": false,
                                "bDestroy": true,
                            } );
                        } );
                    </script>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable" id="data-halaman">
						  <thead>
							  <tr>
								  <th>Judul Halaman</th>
								  <th>Alamat Halaman</th>
								  <th>Tanggal Halaman</th>
								  <th>Keterangan Halaman</th>
								  <th>Tindakan</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php if ($data1->num_rows() == 0) { ?>
						  		<tr>
						  			<td>Belum ada artikel</td>
						  			<td></td>
						  			<td></td>
						  			<td></td>
						  			<td></td>
						  		</tr>
						  	<?php } else { ?>
						  		<?php foreach ($data1->result_array() as $artikel) { ?>
							  		<tr id="tr<?php echo $artikel['id_halaman'] ?>">
										<td><?php echo $artikel['nama_halaman'] ?></td>
										<td><?php echo $artikel['alamat_halaman'] ?></td>
										<td class="center"><?php if ($artikel['tanggal_halaman'] == NUll) { ?>
											(tanggal tidak terdeteksi)
										<?php } else { ?>
											<?php echo $artikel['tanggal_halaman'] ?>
										<?php } ?>
										</td>
										<td class="center"><?php if ($artikel['keterangan_halaman'] == NUll) { ?>
											(tidak ada keterangan)
										<?php } else { ?>
											<?php echo $artikel['keterangan_halaman'] ?>
										<?php } ?>
										</td>
										<td class="center">
											<a class="btn btn-success" href="<?php echo site_url('admin/detail-halaman/'.$artikel['id_halaman']) ?>" title="Lihat halaman" data-rel="tooltip">
												<i class="halflings-icon white zoom-in"></i>  
											</a>
											<a class="btn btn-info" href="<?php echo site_url('admin/edit-halaman/'.$artikel['id_halaman']) ?>" title="Edit halaman" data-rel="tooltip">
												<i class="halflings-icon white edit"></i>  
											</a>
											<a class="btn btn-danger" href="#" id="tmblHapus<?php echo $artikel['id_halaman'] ?>" value="<?php echo $artikel['id_halaman'] ?>" judul="<?php echo $artikel['nama_halaman'] ?>" title="Hapus halaman" data-rel="tooltip">
												<i class="halflings-icon white trash"></i> 
											</a>
										</td>
									</tr>
									<script type="text/javascript">
							        	$(document).ready(function() {
							        		var idArt = $("#tmblHapus<?php echo $artikel['id_halaman'] ?>").attr('value');
							        		var jdArt = $("#tmblHapus<?php echo $artikel['id_halaman'] ?>").attr('judul');
							        		var link = "<?php echo base_url() ?>"
							        		$("#tmblHapus<?php echo $artikel['id_halaman'] ?>").click(function(event) {
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
                <h4 class="modal-title" id="H3">Konfirmasi penghapusan halaman</h4>
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
			$.post(link + 'admin/hapus_halaman/' + idArt, {id_artikel: idArt, ajax: 1}, function(data) {
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