<!-- Last edited: 2017-07-02 12:16 -->
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
					<div class="box-header">
						<h2><i class="halflings-icon th"></i><span class="break"></span>Tabs</h2>
					</div>
					<div class="box-content">
						<ul class="nav tab-menu nav-tabs" id="myTab">
							<li class="active"><a href="#isi">Isi</a></li>
							<li><a href="#gambar">Gambar</a></li>
							<li><a href="#tanggal">Tanggal</a></li>
						</ul>
						 
						<div id="myTabContent" class="tab-content">
							<div class="tab-pane active" id="isi">
								<p>
									<?php echo $data1[0]['isi_newsletter'] ?>
								</p>

							</div>
							<div class="tab-pane" id="gambar">
								<p>
									<img src="<?php echo base_url() ?>uploads/images/newsletter/email/<?php echo $data1[0]['gambar_newsletter'] ?>">
								</p>
							</div>
							<div class="tab-pane" id="tanggal">
								<p>
									<?php echo $data1[0]['tanggal_newsletter'] ?>
								</p>
							</div>
						</div>
					</div>
				</div><!--/span-->
			</div><!--/row-->
		</div><!--/.fluid-container-->
	<!-- end: Content -->
	</div><!--/#content.span10-->
</div><!--/fluid-row-->
	
<div class="clearfix"></div>
<?php $this->load->view('backend/staf/include/footer'); ?>