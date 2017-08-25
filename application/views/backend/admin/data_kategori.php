<!-- Last edited: 2017-07-01 01:42 -->
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
			
			<p><button class="btn btn-primary" data-target="#tmbhKategori" data-toggle="modal"><i class="halflings-icon plus white"></i> Tambah Kategori</button></p>
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Data Kategori (Ada <?php echo $data3 ?> kategori)</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<script type="text/javascript">
                        $(document).ready(function() {
                            $('#data-kategori').DataTable( {
                                "bPaginate":   false,
                                "bFilter": false,
                                "bInfo": false,
                                "bDestroy": true,
                            } );
                        } );
                    </script>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable" id="data-kategori">
						  <thead>
							  <tr>
								  <th>Kategori</th>
								  <th>Jumlah Artikel</th>
								  <th>Tindakan</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php if (count($data1) == 0) { ?>
						  		<tr>
						  			<td>Belum ada kategori</td>
						  			<td></td>
						  			<td></td>
						  		</tr>
						  	<?php } else { ?>
						  		<?php foreach ($data1 as $artikel) { ?>
							  		<tr id="tr<?php echo $artikel['id_kategori'] ?>">
										<td><?php echo $artikel['kategori'] ?></td>
										<td class="center"><?php echo $artikel['jumlah_artikel'] ?> Artikel</td>
										<td class="center">
											<a class="btn btn-success" href="<?php echo site_url('beranda/search-category/'.$artikel['id_kategori']) ?>" title="Lihat artikel" data-rel="tooltip">
												<i class="halflings-icon white zoom-in"></i>  
											</a>
											<a class="btn btn-info" href="#" id="tmblEdit<?php echo $artikel['id_kategori'] ?>" value="<?php echo $artikel['id_kategori'] ?>" judul="<?php echo $artikel['kategori'] ?>" title="Edit kategori" data-rel="tooltip">
												<i class="halflings-icon white edit"></i>  
											</a>
											<a class="btn btn-danger" href="#" id="tmblHapus<?php echo $artikel['id_kategori'] ?>" value="<?php echo $artikel['id_kategori'] ?>" judul="<?php echo $artikel['kategori'] ?>" title="Hapus kategori" data-rel="tooltip">
												<i class="halflings-icon white trash"></i> 
											</a>
										</td>
									</tr>
									<script type="text/javascript">
							        	$(document).ready(function() {
							        		var link = "<?php echo base_url() ?>";
							        		var idKat = $("#tmblEdit<?php echo $artikel['id_kategori'] ?>").attr('value');
							        		var jdKat = $("#tmblEdit<?php echo $artikel['id_kategori'] ?>").attr('judul');
							        		$("#tmblEdit<?php echo $artikel['id_kategori'] ?>").click(function(event) {
							        			/* Act on the event */
							        			$("#kolom-edit").attr('value', jdKat);
							        			$("#actEditKategori").attr('value', idKat);
							        			$("#cnfEditKategori").modal('show');
							        		});

							        		var idArt = $("#tmblHapus<?php echo $artikel['id_kategori'] ?>").attr('value');
							        		var jdArt = $("#tmblHapus<?php echo $artikel['id_kategori'] ?>").attr('judul');
							        		$("#tmblHapus<?php echo $artikel['id_kategori'] ?>").click(function(event) {
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

<div class="modal hide fade" id="cnfEditKategori" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="H3">Edit kategori</h4>
            </div>
            <div class="modal-body">
               <input type="text" id="kolom-edit" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" id="actEditKategori" value="" class="btn btn-danger">Edit</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#actEditKategori').click(function(event) {
			/* Act on the event */
			var idKategori = $('#actEditKategori').attr('value');
			var jdKategori = $('#kolom-edit').val();
			var link = "<?php echo base_url() ?>";
			$.post(link + 'admin/edit_kategori/' + idKategori, {id_kategori: idKategori, kategori: jdKategori, ajax: 1}, function(data) {
				/*optional stuff to do after success */
				if (data == "true") {
					$('#cnfEditKategori').modal('hide');
					location.reload();
				} else {
					$('#cnfHapusArtikel').modal('hide');
					alert("Penghapusan gagal!");
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
                <h4 class="modal-title" id="H3">Konfirmasi penghapusan kategori</h4>
            </div>
            <div class="modal-body">
               Yakin ingin menghapus kategori <span id="nam_ins"></span>? Semua artikel dalam kategori tersebut akan terhapus.
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
			$.post(link + 'admin/hapus_kategori/' + idArt, {id_kategori: idArt, ajax: 1}, function(data) {
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
<div class="modal hide fade" id="tmbhKategori">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h3>Tambah Kategori</h3>
	</div>
	<div class="modal-body tambah-kategori">
		<?php echo form_open('admin/tambah_kategori'); ?>
            <fieldset class="form_cart">
                <?php echo form_input(array('name' => 'kategori', 'type' => 'text', 'class' => 'form-control')); ?>
                <br><?php echo form_submit('tambah', 'Tambah', "class='btn btn-primary btn-md tambah'"); ?>
            </fieldset>
        <?php echo form_close(); ?>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Batal</a>
	</div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
	    var link = "<?php echo base_url() ?>";

	    $(".tambah-kategori form").submit(function() {
	        /* Get the product ID and the quantity */
	        var kat = $(this).find('input[name=kategori]').val();

	        $.post(link + 'admin/tambah_kategori', {kategori: kat, ajax: 1}, function(data) {
	            /*optional stuff to do after success*/
	            if (data == 'false') {
	                alert("Penambahan kategori gagal!");
	            } else{
	            	var newRow = "<tr id='tr'" + data +"><td>" + kat +"</td><td>0 Artikel</td><td></td>"
	                $('#tmbhKategori').modal('hide');
					$('#data-kategori').append(newRow);
	            };
	        });
	        return false;
	    });
	});
</script> 
	
<div class="clearfix"></div>
<?php $this->load->view('backend/admin/include/footer'); ?>