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
			
			<h1 class="page-title">Berita</h1>
			
		</div><!--/ .page-header-->
		
		<!-- - - - - - - - - end Page Header - - - - - - - - - -->	
		
		
		<!-- - - - - - - - - - - - - - - Columns - - - - - - - - - - - - - - - - -->
		<?php foreach ($data1 as $urut => $artikel) {
			$slug_title = str_replace(' ', '-', strtolower($artikel['judul_artikel']));
			$slug_date = date('d', strtotime($artikel['tanggal_artikel'])) . '-' . date('m', strtotime($artikel['tanggal_artikel'])) . '-' . date('Y', strtotime($artikel['tanggal_artikel']));
			$slug_url = $slug_date . '-' . $slug_title;
			if (($urut+1)%3 != 0) { ?>
				<div class="one-third">
				
					<h4><a href="<?php echo base_url('berita/artikel/'.$artikel['id_artikel'].'/'.$slug_url) ?>"><?php echo $artikel['judul_artikel'] ?></a></h4>
					<section class="post-meta clearfix">
						
						<div class="post-date"><a href="#"><?php echo $artikel['tanggal_artikel'] ?></a></div><!--/ .post-date-->
						<div class="post-tags"><?php echo $artikel['kategori'] ?></div><!--/ .post-tags-->
						<div class="post-comments"><?php echo ($artikel['jumlah_komentar'] == NULL) ? 0 : $artikel['jumlah_komentar'] ?> Komentar</div><!--/ .post-comments-->
						
					</section><!--/ .post-meta-->
					<a class="single-image" href="<?php echo base_url() ?>uploads/images/artikel/original/<?php echo $artikel['gambar_artikel'] ?>">
						<img class="custom-frame" alt="" src="<?php echo base_url() ?>uploads/images/artikel/list/<?php echo $artikel['gambar_artikel'] ?>">
					</a>
					<span class="dropcap"><?php echo $urut+1 ?></span>
					<p>
						<?php echo word_limiter($artikel['isi_artikel'], 15) ?> 
					</p>
					<a href="<?php echo base_url('berita/artikel/'.$artikel['id_artikel'].'/'.$slug_url) ?>" class="button gray">Read More &rarr;</a>
					
				</div><!--/ .one-third-->
			<?php } else { ?>
				<div class="one-third last">
				
					<h4><a href="<?php echo base_url('berita/artikel/'.$artikel['id_artikel'].'/'.$slug_url) ?>"><?php echo $artikel['judul_artikel'] ?></a></h4>
					<section class="post-meta clearfix">
						
						<div class="post-date"><a href="#"><?php echo $artikel['tanggal_artikel'] ?></a></div><!--/ .post-date-->
						<div class="post-tags"><?php echo $artikel['kategori'] ?></div><!--/ .post-tags-->
						<div class="post-comments"><?php echo ($artikel['jumlah_komentar'] == NULL) ? 0 : $artikel['jumlah_komentar'] ?> Komentar</div><!--/ .post-comments-->
						
					</section><!--/ .post-meta-->
					<a class="single-image" href="<?php echo base_url() ?>uploads/images/artikel/original/<?php echo $artikel['gambar_artikel'] ?>">
						<img class="custom-frame" alt="" src="<?php echo base_url() ?>uploads/images/artikel/list/<?php echo $artikel['gambar_artikel'] ?>">
					</a>
					<span class="dropcap"><?php echo $urut+1 ?></span>
					<p>
						<?php echo word_limiter($artikel['isi_artikel'], 15) ?> 
					</p>
					<a href="<?php echo base_url('berita/artikel/'.$artikel['id_artikel'].'/'.$slug_url) ?>" class="button gray">Read More &rarr;</a>
					
				</div><!--/ .one-third-->
			<?php }
		} ?>

		<?php echo $data2; ?>
			
		<!-- - - - - - - - - - - - - - end Columns - - - - - - - - - - - - - - - -->
		
	</section><!--/.container -->
		
	<!-- - - - - - - - - - - - - end Container - - - - - - - - - - - - - - - - -->	
	
	
	<!-- - - - - - - - - - - - - - - Footer - - - - - - - - - - - - - - - - -->	
	
	<?php echo $footer ?>
	
	<!-- - - - - - - - - - - - - - - end Footer - - - - - - - - - - - - - - - - -->		
	
</div><!--/ .wrap-->

</body>
</html>