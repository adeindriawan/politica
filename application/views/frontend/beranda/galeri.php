<?php $this->load->view('frontend/beranda/include/head'); ?>
<div class="wrap-header"></div><!--/ .wrap-header-->

<div class="wrap">
	
	<!-- - - - - - - - - - - - - - Header - - - - - - - - - - - - - - - - -->	
	
	<?php echo $header; ?>
	
	<!-- - - - - - - - - - - - - - end Header - - - - - - - - - - - - - - - - -->	
	
	
	<!-- - - - - - - - - - - - - - - Container - - - - - - - - - - - - - - - - -->	
	
	<section class="container clearfix">

		<?php if (count($data1) == 0) { ?>
			<p>Belum ada album.</p>
		<?php } else { ?>
			<?php foreach ($data1 as $key => $value) { 
				$slug_title = str_replace(' ', '-', strtolower($value[0]['judul_album']));
				$slug_date = date('d', strtotime($value[0]['tanggal_album'])) . '-' . date('m', strtotime($value[0]['tanggal_album'])) . '-' . date('Y', strtotime($value[0]['tanggal_album']));
				$slug_url = $slug_date . '-' . $slug_title; ?>
				<!-- - - - - - - - - - Page Header - - - - - - - - - - -->	
		
				<div class="page-header">
					
					<h1 class="page-title"><a href="<?php echo site_url('galeri/album/'.$value[0]['id_album'].'/'.$slug_url) ?>"><?php echo $value[0]['judul_album'] ?></a></h1>
					
				</div><!--/ .page-header-->
				
				<!-- - - - - - - - - end Page Header - - - - - - - - - -->	
				<!-- - - - - - - - - - - - - - - Columns - - - - - - - - - - - - - - - - -->
				<?php foreach ($value as $urut => $album) {
					if (($urut+1)%4 != 0) { ?>
						<div class="one-fourth">
							<a class="nlb" data-lightbox-gallery="gallery1" href="<?php echo base_url() ?>uploads/images/album/view/<?php echo $album["path_view"] ?>" title="<?php echo $album["caption"] ?>"><img class="custom-frame" src="<?php echo base_url() ?>uploads/images/album/thumbnail/<?php echo $album["path_view"] ?>" alt=""></a>
							
						</div><!--/ .one-fourth-->
					<?php } else { ?>
						<div class="one-fourth last">
							<a class="nlb" data-lightbox-gallery="gallery1" href="<?php echo base_url() ?>uploads/images/album/view/<?php echo $album["path_view"] ?>" title="<?php echo $album["caption"] ?>"><img class="custom-frame" src="<?php echo base_url() ?>uploads/images/album/thumbnail/<?php echo $album["path_view"] ?>" alt=""></a>
							
						</div><!--/ .one-fourth-->
					<?php }
				} ?>
				<!-- - - - - - - - - - - - - - end Columns - - - - - - - - - - - - - - - -->
			<div class="clear"></div>
				<?php if ($value[0]['deskripsi_album']) { ?>
					<p><?php echo $value[0]['deskripsi_album'] ?></p>
				<?php } ?>
			<?php } ?>
		<?php } ?>
		<?php echo $data2; ?>
	</section><!--/.container -->
		
	<!-- - - - - - - - - - - - - end Container - - - - - - - - - - - - - - - - -->	
	
	
	<!-- - - - - - - - - - - - - - - Footer - - - - - - - - - - - - - - - - -->	
	
	<?php echo $footer; ?>
	
	<!-- - - - - - - - - - - - - - - end Footer - - - - - - - - - - - - - - - - -->		
	
</div><!--/ .wrap-->

</body>
</html>