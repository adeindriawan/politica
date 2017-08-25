<!-- Last edited: 2017-07-01 01:34 -->
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
						<h2><i class="halflings-icon user"></i><span class="break"></span>Data Notifikasi (Ada <?php echo $data3 ?> notifikasi)</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<script type="text/javascript">
                        $(document).ready(function() {
                            $('#data-notifikasi').DataTable( {
                                "bPaginate":   false,
                                "bFilter": false,
                                "bInfo": false,
                                "bDestroy": true,
                            } );
                        } );
                    </script>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable" id="data-notifikasi">
						  <thead>
							  <tr>
								  <th>Isi Notifikasi</th>
								  <th>Waktu Notifikasi</th>
								  <th>Status</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php if ($data1->num_rows() == 0) { ?>
						  		<tr>
						  			<td colspan="5">Belum ada notifikasi</td>
						  		</tr>
						  	<?php } else { ?>
						  		<?php foreach ($data1->result_array() as $elemen) { ?>
							  		<tr id="tr<?php echo $elemen['id_notifikasi'] ?>">
										<td><?php echo $elemen['isi_notifikasi'] ?></td>
										<td class="center"><?php echo $elemen['tanggal_notifikasi'] ?></td>
										<td class="center">
											<?php if ($elemen['status_notifikasi'] == 'Sent') { ?>
												<span class="label label-warning">Belum terbaca</span>
											<?php } else { ?>
												<span class="label label-success">Sudah terbaca</span>
											<?php } ?></td>
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
<?php $this->load->view('backend/admin/include/footer'); ?>