<?php $this->load->view('frontend/beranda/include/head'); ?>
<div class="wrap-header"></div><!--/ .wrap-header-->

	<div class="wrap">
	
	<?php echo $header; ?>
	
	<!-- - - - - - - - - - - - - - - Container - - - - - - - - - - - - - - - - -->	
	<?php $tag = $value; ?>
	<?php if (count($value) == 0) { ?>
		<section class="container clearfix">
		
			<!-- - - - - - - - - - - - - - - Content - - - - - - - - - - - - - - - - -->		
			
			<p>Tidak ada artikel dengan tag: <em><?php echo $tag[0]['tag']?></em></p>
			
			<!-- - - - - - - - - - - - - - end Content - - - - - - - - - - - - - - - - -->	
			
		</section><!--/.container -->
	<?php } else { ?>
		<section class="container clearfix">
		
			<!-- - - - - - - - - - - - - - - Content - - - - - - - - - - - - - - - - -->		
			<p>Artikel-artikel dengan tag: <em><?php echo $tag[0]['tag'] ?></em></p>
			<?php foreach ($value as $urut => $list) {
				if (($urut+1)%3 != 0) { ?>
					<div class="one-third">
					
						<h4><a href="<?php echo site_url('beranda/artikel/'.$list['id_artikel']) ?>"><?php echo $list['judul_artikel'] ?></a></h4>
						<section class="post-meta clearfix">
							
							<div class="post-date"><?php echo $list['tanggal_artikel'] ?></div><!--/ .post-date-->
							<div class="post-tags"><?php echo $list['kategori_artikel'] ?></div><!--/ .post-tags-->
							<div class="post-comments"><?php echo $list['jumlah_komentar'] ?> Komentar</div><!--/ .post-comments-->
							
						</section><!--/ .post-meta-->
						<a class="single-image" href="<?php echo base_url() ?>uploads/images/artikel/original/<?php echo $list['gambar_artikel'] ?>">
							<img class="custom-frame" alt="" src="<?php echo base_url() ?>uploads/images/artikel/list/<?php echo $list['gambar_artikel'] ?>">
						</a>
						<span class="dropcap"><?php echo $urut+1 ?></span>
						<p>
							<?php echo word_limiter($list['isi_artikel'], 15) ?> 
						</p>
						<a href="<?php echo base_url('beranda/artikel/'.$list['id_artikel']) ?>" class="button gray">Read More &rarr;</a>
						
					</div><!--/ .one-third-->
				<?php } else { ?>
					<div class="one-third last">
					
						<h4><a href="<?php echo site_url('beranda/artikel/'.$list['id_artikel']) ?>"><?php echo $list['judul_artikel'] ?></a></h4>
						<section class="post-meta clearfix">
							
							<div class="post-date"><?php echo $list['tanggal_artikel'] ?></div><!--/ .post-date-->
							<div class="post-tags"><?php echo $list['kategori_artikel'] ?></div><!--/ .post-tags-->
							<div class="post-comments"><?php echo $list['jumlah_komentar'] ?> Komentar</div><!--/ .post-comments-->
							
						</section><!--/ .post-meta-->
						<a class="single-image" href="<?php echo base_url() ?>uploads/images/artikel/original/<?php echo $list['gambar_artikel'] ?>">
							<img class="custom-frame" alt="" src="<?php echo base_url() ?>uploads/images/artikel/list/<?php echo $list['gambar_artikel'] ?>">
						</a>
						<span class="dropcap"><?php echo $urut+1 ?></span>
						<p>
							<?php echo word_limiter($list['isi_artikel'], 15) ?> 
						</p>
						<a href="<?php echo base_url('beranda/artikel/'.$list['id_artikel']) ?>" class="button gray">Read More &rarr;</a>
						
					</div><!--/ .one-third-->
				<?php }
			} ?>

			<?php echo $links; ?>
			
			<!-- - - - - - - - - - - - - - end Content - - - - - - - - - - - - - - - - -->	
			
		</section><!--/.container -->
	<?php } ?>
		
	<!-- - - - - - - - - - - - - end Container - - - - - - - - - - - - - - - - -->	
	
	<?php echo $footer; ?>
	
</div><!--/ .wrap-->

</body>
</html>
