<?php $this->load->view('frontend/beranda/include/head'); ?>
<div class="wrap-header"></div><!--/ .wrap-header-->

	<div class="wrap">
	
	<?php echo $header; ?>
	
	<!-- - - - - - - - - - - - - - - Container - - - - - - - - - - - - - - - - -->	
	
	<section class="container sbr clearfix">
		<?php if ($this->session->flashdata('sesi_habis')) { ?>
			<p class="error">Sesi Anda sudah habis, silakan login kembali</p>
		<?php } ?>
	
		<!-- - - - - - - - - - - Slider - - - - - - - - - - - - - -->	

		<div id="slider" class="flexslider clearfix">

			<ul class="slides">
				<?php foreach ($data1 as $key => $value) { 
					$slug_title = str_replace(' ', '-', strtolower($value['nama_halaman']));
					$slug_url = $slug_title; ?>
					<li>
						<img src="<?php echo base_url() ?>uploads/images/halaman/slider/<?php echo $value['gambar_halaman'] ?>" alt="" />
						<div class="caption">
							<div class="caption-entry">
								<div class="caption-title"><h2><a href="<?php echo site_url('beranda/halaman/'.$value['id_halaman'].'/'.$slug_url) ?>"><?php echo $value['nama_halaman'] ?></a></h2></div>
								<p>
									<?php echo $value['isi_halaman'] ?>
								</p>
							</div><!--/ .caption-entry-->
						</div><!--/ .caption-->
					</li>
				<?php } ?>
			</ul><!--/ .slides-->

		</div><!--/ #slider-->

		<!-- - - - - - - - - - - end Slider - - - - - - - - - - - - - -->
		
		<ul class="block-with-icons clearfix">
			<li class="b1">
				<a href="#">
					<h5>Campaign</h5>
					<span>Adipiscing tincidunt malesuada.</span>
				</a>
			</li>
			<li class="b2">
				<a href="#">
					<h5>accessibility</h5>
					<span>Adipiscing tincidunt malesuada.</span>
				</a>
			</li>
			<li class="b3">
				<a href="#">
					<h5>calendar</h5>
					<span>Adipiscing tincidunt malesuada.</span>
				</a>
			</li>
		</ul><!--/ .block-with-icons-->
		
		<!-- - - - - - - - - - - - - - - Content - - - - - - - - - - - - - - - - -->		
		
		<section id="content">
			<?php if (count($data2) > 0) { ?>
				<?php foreach ($data2 as $nomor => $artikel) {
					$slug_title = str_replace(' ', '-', strtolower($artikel['judul_artikel']));
					$slug_date = date('d', strtotime($artikel['tanggal_artikel'])) . '-' . date('m', strtotime($artikel['tanggal_artikel'])) . '-' . date('Y', strtotime($artikel['tanggal_artikel']));
					$slug_url = $slug_date . '-' . $slug_title;
					if ($nomor == 0) { ?>
						<article class="post-item clearfix">
					
							<a href="<?php echo base_url() ?>berita/artikel/<?php echo $artikel['id_artikel'].'/'.$slug_url ?>">
								<h3 class="title">
									<?php echo $artikel['judul_artikel'] ?>
								</h3><!--/ .title -->
							</a>
							
							<section class="post-meta clearfix">
								
								<div class="post-date"><a href="#"><?php echo $artikel['tanggal_artikel'] ?></a></div><!--/ .post-date-->
								<div class="post-tags">
									<a href="#"><?php echo $artikel['kategori'] ?></a>
								</div><!--/ .post-tags-->
								<div class="post-comments"><a href="#"><?php echo $artikel['jumlah_komentar'] ?> Komentar</a></div><!--/ .post-comments-->
								
							</section><!--/ .post-meta-->
							
							<a class="single-image" href="<?php echo base_url() ?>uploads/images/artikel/original/<?php echo $artikel['gambar_artikel'] ?>">
								<img class="custom-frame" alt="" src="<?php echo base_url() ?>uploads/images/artikel/page/<?php echo $artikel['gambar_artikel'] ?>">
							</a>
							
							<p>
								<?php echo word_limiter($artikel['isi_artikel'], 10) ?>
							</p>
							
							<a href="<?php echo base_url() ?>berita/artikel/<?php echo $artikel['id_artikel'].'/'.$slug_url ?>" class="button gray">Read More &rarr;</a>
							
						</article><!--/ .post-item-->
					<?php } else { ?>
						<article class="post-item clearfix">
					
							<a href="<?php echo base_url() ?>berita/artikel/<?php echo $artikel['id_artikel'].'/'.$slug_url ?>">
								<h3 class="title">
									<?php echo $artikel['judul_artikel'] ?>
								</h3><!--/ .title -->
							</a>
							
							<section class="post-meta clearfix">
								
								<div class="post-date"><a href="#"><?php echo $artikel['tanggal_artikel'] ?></a></div><!--/ .post-date-->
								<div class="post-tags">
									<a href="#"><?php echo $artikel['kategori'] ?></a>
								</div><!--/ .post-tags-->
								<div class="post-comments"><a href="#"><?php echo $artikel['jumlah_komentar'] ?> Komentar</a></div><!--/ .post-comments-->
								
							</section><!--/ .post-meta-->
							
							<a class="single-image" href="<?php echo base_url() ?>uploads/images/artikel/original/<?php echo $artikel['gambar_artikel'] ?>">
								<img class="custom-frame" alt="" src="<?php echo base_url() ?>uploads/images/artikel/thumbnail/<?php echo $artikel['gambar_artikel'] ?>">
							</a>
							
							<p>
								<?php echo word_limiter($artikel['isi_artikel'], 10) ?>
							</p>
							
							<a href="<?php echo base_url() ?>berita/artikel/<?php echo $artikel['id_artikel'].'/'.$slug_url ?>" class="button gray">Read More &rarr;</a>
							
						</article><!--/ .post-item-->
					<?php }				
				} ?>
			<?php } else { ?>
				<p>Belum ada artikel berita.</p>
			<?php } ?>
		
		<div class="sep"></div>
		<?php if (count($data2) > 0) { ?>
			<p style="text-decoration: underline"><em><a href="<?php echo site_url('berita') ?>">Klik di sini untuk lihat lebih banyak artikel &raquo;</a></em></p>
		<?php } ?>

		</section><!--/ #content-->
		
		<!-- - - - - - - - - - - - - - end Content - - - - - - - - - - - - - - - - -->	
		
		
		<!-- - - - - - - - - - - - - - - Sidebar - - - - - - - - - - - - - - - - -->	
		
		<aside id="sidebar">

			<div class="widget-container widget_search">

				<?php echo form_open('beranda/cari'); ?>
					
					<fieldset>
						<input type="text" id="s" name="teks_cari" placeholder="Apa yang Anda cari?">
						<button type="submit" name="tombol_cari" id="searchsubmit"></button>
					</fieldset>
					
				<?php echo form_close(); ?><!--/ #searchform-->
			
			</div><!--/ .widget-container-->
			
			<?php echo $kategori_artikel; ?>
			
			<?php echo $populer_dibaca; ?>

			<?php echo $populer_dikomentari; ?>
			
			<div class="widget-container widget_video">
				
				<h3 class="widget-title">Video</h3>
				
				<div class="video-widget">
					<iframe class="custom-frame" width="290" height="200" src="http://www.youtube.com/embed/jilRF0mocRQ?wmode=transparent" frameborder="0" <allowfullscreen></allowfullscreen>></iframe>
				</div><!--/ .video-widget-->
				
				<div class="video-entry">
					<a href="#" class="video-title">
						<h5>Potenti Nullam Consectetur Urna Ipsum Fringilla</h5>
					</a>
				</div><!--/ .video-entry-->
				
			</div><!--/ .widget-container-->

			<div class="widget-container widget_facebook">
				
				<h3 class="widget-title">Become a Facebook Fan</h3>
				
				<div class="fb-like-box" data-href="http://www.facebook.com/pages/ThemeMakers/273813622709585" data-width="300" data-show-faces="true" data-stream="true" data-header="true"></div>
				
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>
				
				
			</div><!--/ .widget-container-->
			
		</aside><!--/ #sidebar-->
		
		<!-- - - - - - - - - - - - - end Sidebar - - - - - - - - - - - - - - - - -->
		
	</section><!--/.container -->
		
	<!-- - - - - - - - - - - - - end Container - - - - - - - - - - - - - - - - -->	
	
	<?php echo $footer; ?>
	
</div><!--/ .wrap-->

</body>
</html>
