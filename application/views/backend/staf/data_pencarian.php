<!-- Last edited: 2017-07-02 11:05 -->
<?php $this->load->view('backend/staf/include/header'); ?>
<?php echo $nav; ?>
<div class="container-fluid-full">
	<div class="row-fluid">
	<?php $this->load->view('backend/staf/include/menu'); ?>
		<noscript>
			<div class="alert alert-block span10">
				<h4 class="alert-heading">Warning!</h4>
				<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
			</div>
		</noscript>
		<!-- start: Content -->
		<div id="content" class="span10">
			<?php $this->load->view('backend/staf/include/breadcrumb'); ?>

			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Data Pencarian (Ada <?php echo $data3 ?> kata pencarian)</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<script type="text/javascript">
                        $(document).ready(function() {
                            $('#data-pencarian').DataTable( {
                                "bPaginate":   false,
                                "bFilter": false,
                                "bInfo": false,
                                "bDestroy": true,
                            } );
                        } );
                    </script>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable" id="data-pencarian">
						  <thead>
							  <tr>
								  <th>Kata Kunci</th>
								  <th>Waktu Pencarian</th>
								  <th>Tindakan</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php if ($data1->num_rows() == 0) { ?>
						  		<tr>
						  			<td>Belum ada kata kunci pencarian</td>
						  			<td></td>
						  			<td></td>
						  		</tr>
						  	<?php } else { ?>
						  		<?php foreach ($data1->result_array() as $element) { ?>
							  		<tr id="tr<?php echo $element['id_pencarian'] ?>">
										<td><?php echo $element['kata_kunci'] ?></td>
										<td class="center"><?php echo $element['waktu_pencarian'] ?></td>
										<td class="center">
											<a class="btn btn-success" href="<?php echo site_url('staf/detail-pencarian/'.$element['kata_kunci']) ?>"  title="Detail pencarian" data-rel="tooltip">
												<i class="halflings-icon white zoom-in"></i> 
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
<?php $this->load->view('backend/staf/include/footer'); ?>