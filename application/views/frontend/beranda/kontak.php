<?php $this->load->view('frontend/beranda/include/head'); ?>
	
<div class="wrap-header"></div><!--/ .wrap-header-->

<div class="wrap">
	
	<!-- - - - - - - - - - - - - - Header - - - - - - - - - - - - - - - - -->	
	
	<?php echo $header; ?>
	
	<!-- - - - - - - - - - - - - - end Header - - - - - - - - - - - - - - - - -->	
	
	
	<!-- - - - - - - - - - - - - - - Container - - - - - - - - - - - - - - - - -->	
	
	<section class="container clearfix">
		
		<!-- - - - - - - - - - Page Header - - - - - - - - - - -->	
		
		<div class="page-header">
			
			<h1 class="page-title">Kirim pesan untuk kami</h1>
			
		</div><!--/ .page-header-->
		
		<!-- - - - - - - - - end Page Header - - - - - - - - - -->	
		
		<div class="one-third">
			
			<h3>Main Office</h3>
			
			<address>
				Alamat: <?php echo $alamat; ?> <br />
				Telepon: <?php echo $telepon; ?> <br />
				Email:  <?php echo $email; ?>
			</address>
			
		</div><!--/ .one-third-->
		
		<div class="two-third last">
			
			<div id="contact">
			
				<h3>Kirim email</h3>

					<p class="input-block">
						<label for="name">Nama Anda: <span class="required">*</span><i>(wajib diisi)</i></label>
						<input type="text" name="name" id="name" />
					</p>

					<p class="input-block">
						<label for="email">E-mail: <span class="required">*</span><i>(wajib diisi)</i></label>
						<input type="text" name="email" id="email" />
					</p>

					<p class="textarea-block">
						<label for="message">Pesan:</label>
						<textarea name="comments" id="message"></textarea>	
					</p>						
					
					<p class="row">
						<button type="submit" class="button gray" id="submit-kirim">Kirim</button>
					</p><!--/ #contactform-->
					<div id="pesan-kontak"></div>
				
			</div><!--/ contact-->
			
		</div><!--/ .two-third .last-->
	
	</section><!--/.container -->
		
<!-- - - - - - - - - - - - - end Container - - - - - - - - - - - - - - - - -->	
	
	<!-- - - - - - - - - - - - - - - Footer - - - - - - - - - - - - - - - - -->	
	
	<?php echo $footer; ?>
	
	<!-- - - - - - - - - - - - - - - end Footer - - - - - - - - - - - - - - - - -->		
	
</div><!--/ .wrap-->
<script type="text/javascript">
	$(document).ready(function() {
		$("#submit-kirim").click(function() {
			/* Act on the event */
			var link = '<?php echo base_url() ?>';
			var nam = $("#name").val();
			var ema = $("#email").val();
			var msg = $("#contact").find('textarea[name="comments"]').val();
			$.post(link + 'beranda/pesan', {ajax: 1, nama: nam, email: ema, pesan: msg}, function(data) {
				/*optional stuff to do after success */
				if (data == 'true') {
					$("#name").val('');
					$("#email").val('');
					$("#contact").find('textarea[name="comments"]').val('');
					$('#pesan-kontak').html('<p class="success">Sukses mengirim pesan!</p>');
				} else {
					$("#name").val('');
					$("#email").val('');
					$("#contact").find('textarea[name="comments"]').val('');
					$('#pesan-kontak').html('<p class="error">Gagal mengirim pesan! Pastikan semua isian terisi dengan benar.</p>');
				};
			});
		});
	});
</script>
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="<?php echo base_url() ?>frontend/js/jquery.gmap.min.js"></script>
</body>
</html>

