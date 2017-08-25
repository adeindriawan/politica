<!-- - - - - - - - - - - - - - - Footer - - - - - - - - - - - - - - - - -->	
	
	<footer id="footer" class="container clearfix">
		<div id="pesan-newsletter"></div>
		
		<div class="one-fourth">
			
			<div class="widget-container widget_text">
				
				<h3 class="widget-title">Info</h3>
				
				<div class="textwidget">
					
					<h3><?php echo $nama; ?></h3>
					<p><?php echo $alamat; ?></p>	
					<p><?php echo $kota; ?></p>	
					<p><?php echo $kodepos; ?></p><br>
					<p><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>	
					<p><?php echo $telepon; ?></p>	
					
				</div><!--/ .textwidget-->
				
			</div><!--/ .widget-container-->
			
		</div><!--/ .one-fourth-->
		
		<div class="one-fourth">
			
			<div class="widget-container widget_nav_menu">
				
				<h3 class="widget-title">Campaign</h3>

				<div class="menu-custom_menu-container">
					
					<ul class="menu" id="menu-custom_menu">

						<li><a href="<?php echo site_url('tentang-kami') ?>">Tentang Kami</a></li>
						<li><a href="<?php echo site_url('faq') ?>">Frequently Asked Questions (FAQ)</a></li>
						<li><a href="<?php echo site_url('kegiatan-kami') ?>">Kegiatan Kami</a></li>
						<li><a href="<?php echo site_url('kontak') ?>">Kontak Kami</a></li>

					</ul><!--/ .menu-->		
				
				</div><!--/ .menu-custom_menu-container-->
				
			</div><!--/ .widget-container-->
			
		</div><!--/ .one-fourth-->
		
		<div class="one-half last">

			<h3 class="widget-title">Newsletter</h3>
			
			<div class="widget-container widget_search">
					
				<input type="text" id="email-newsletter" name="teks_cari" placeholder="Jadilah pelanggan newsletter kami">
				<button type="submit" name="tombol_cari" id="submit-newsletter"></button>
			
			</div><!--/ .widget-container-->
			
		</div><!--/ .one-fourth-->
		
		<div class="clear"></div>
		
		<ul class="copyright">
			
			<li>Copyright @ <?php echo date('Y'); ?></li>
			<li><a href="http://www.sophistica.id/" target="_blank">Sophistica</a></li>
			<li>All rights reserved</li>
			
		</ul><!--/ .copyright-->
	
	</footer><!--/ #footer-->
	
	<!-- - - - - - - - - - - - - - - end Footer - - - - - - - - - - - - - - - - -->
<script type="text/javascript">
  $(document).ready(function() {
    var link = '<?php echo base_url() ?>';
    $("#submit-newsletter").click(function(event) {
      /* Act on the event */
      var al_email = $("#email-newsletter").val();
      $.post(link + 'beranda/newsletter', {email: al_email, ajax: 1}, function(data) {
        /*optional stuff to do after success */
        if (data == 'false') {
          $('#email-newsletter').val('');
          $('#pesan-newsletter').html('<p class="error">Gagal mengirim permintaan langganan <em>newsletter</em>! Coba beberapa saat lagi.</p>');
        } else{
          $('#email-newsletter').val('');
          $('#pesan-newsletter').html('<p class="success">Sukses mengirim permintaan langganan <em>newsletter</em></p>');
        };
      });
    });
  });
</script>
</body>
</html>