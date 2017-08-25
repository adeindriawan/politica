<!-- Last edited: 2017-07-02 12:19 -->
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
											<a class="btn btn-success" href="<?php echo site_url('beranda/halaman/'.$artikel['id_halaman']) ?>" title="Lihat halaman" data-rel="tooltip">
												<i class="halflings-icon white zoom-in"></i>  
											</a>
											<a class="btn btn-info" href="<?php echo site_url('dashboard/detail-halaman/'.$artikel['id_halaman']) ?>" title="Edit halaman" data-rel="tooltip">
												<i class="halflings-icon white edit"></i>  
											</a>
										</td>
									</tr>
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
	
<div class="clearfix"></div>
<?php $this->load->view('backend/dashboard/include/footer'); ?>