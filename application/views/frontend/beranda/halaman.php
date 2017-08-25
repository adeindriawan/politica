<?php $this->load->view('frontend/beranda/include/head'); ?>
	
<div class="wrap-header"></div><!--/ .wrap-header-->

<div class="wrap">
	
	<!-- - - - - - - - - - - - - - Header - - - - - - - - - - - - - - - - -->	
	
	<?php echo $header; ?>
	
	<!-- - - - - - - - - - - - - - end Header - - - - - - - - - - - - - - - - -->	
	
	
	<!-- - - - - - - - - - - - - - - Container - - - - - - - - - - - - - - - - -->	
	
	<section class="container sbr clearfix">

		<!-- - - - - - - - - - - - - - - Content - - - - - - - - - - - - - - - - -->		
		
		<section id="content">
			
			<article class="post clearfix">
				
				<h3 class="title">
					<?php echo $data1[0]['nama_halaman']; ?>
				</h3><!--/ .title -->
				
				<section class="post-meta clearfix">
					
					<div class="post-date"><?php echo $data1[0]['tanggal_halaman'] ?></div><!--/ .post-date-->
					
				</section><!--/ .post-meta-->
				
				<a class="single-image" href="<?php echo base_url() ?>uploads/images/halaman/original/<?php echo $data1[0]['gambar_halaman'] ?>">
					<img class="custom-frame" alt="" src="<?php echo base_url() ?>uploads/images/halaman/page/<?php echo $data1[0]['gambar_halaman'] ?>">
				</a>
				
				<p>
					<?php echo $data1[0]['isi_halaman'] ?>
				</p>
				
			</article><!--/ .post-->
			
		</section><!--/ #content-->
		
		<!-- - - - - - - - - - - - - - end Content - - - - - - - - - - - - - - - - -->	
		
		
		<!-- - - - - - - - - - - - - - - Sidebar - - - - - - - - - - - - - - - - -->	
		
		<aside id="sidebar">
			
			<div class="widget-container widget_search">

				<form action="#" id="searchform" method="get" role="search">
					
					<fieldset>
						<input type="text" id="s" placeholder="Search">
						<button type="submit" id="searchsubmit"></button>
					</fieldset>
					
				</form><!--/ #searchform-->
			
			</div><!--/ .widget-container-->

			<?php echo $populer_dibaca; ?>

			<?php echo $populer_dikomentari; ?>

			<div class="widget-container eventsListWidget">

				<h3 class="widget-title">Upcoming Events</h3>

				<ul>
					
					<li>
						<a href="#"><h6>Suspendisse Potenti Consectetur</h6></a>
						<span class="widget-date">June 15, 2012</span>
					
					</li>
					<li>
						<a href="#"><h6>Mauris Vitae Adipiscing et Urna</h6></a>
						<span class="widget-date">June 14, 2012</span>
					</li>
					<li>
						<a href="#"><h6>Donec Blandit Luctus Diam</h6></a>
						<span class="widget-date">June 13, 2012</span>
					</li>
					
				</ul>
				
			</div><!--/ .widget-container-->
			
			<div class="widget-container widget_video">
				
				<h3 class="widget-title">Video Title</h3>
				
				<div class="video-widget">
					<iframe class="custom-frame" width="290" height="200" src="http://www.youtube.com/embed/jilRF0mocRQ?wmode=transparent" frameborder="0" allowfullscreen></iframe>					
				</div><!--/ .video-widget-->
				<div class="video-entry">
					<a href="#" class="video-title">
						<h5>Potenti Nullam Consectetur Urna Ipsum Fringilla</h5>
					</a>
				</div><!--/ .video-entry-->
				
			</div><!--/ .widget-container-->
			
			<div class="widget-container widget_testimonials">
				
				<h3 class="widget-title">Testimonial Widget</h3>
				
				<div class="testimonials">
					
					<div class="substrate-rotate-left"></div>
					<div class="substrate-rotate-right"></div>
					
					<div class="quoteBox">
						
						<ul class="quotes">
							<li>
								<div class="quote-text">
									Suspendisse potenti. Praesent sit amet rhoncus nisi. Etiam tristique velit 
									ut felis ultrices pulvinar. condimentum.
								</div><!--/ .quote-text-->
								<div class="quote-author">
									Jessica Spenser
									<span>Manager</span>
								</div><!--/ .quote-author-->							
							</li>
							<li>
								<div class="quote-text">
									Proin nonummy, lacus eget pulvinar lacinia, pede felis dignissim leo, vitae tristique. 
									Nullam ornare. Praesent odio ligula, dapibus sed.
								</div><!--/ .quote-text-->
								<div class="quote-author">
									James Brown
									<span>Director</span>
								</div><!--/ .quote-author-->							
							</li>							
						</ul><!--/ .quotes-->
						
					</div><!--/ .quoteBox-->
					
				</div><!--/ .testimonials-->
				
			</div><!--/ .widget-container-->
			
		</aside><!--/ #sidebar-->
		
		<!-- - - - - - - - - - - - - end Sidebar - - - - - - - - - - - - - - - - -->
		
	</section><!--/.container -->
		
	<!-- - - - - - - - - - - - - end Container - - - - - - - - - - - - - - - - -->	
	
	
	<!-- - - - - - - - - - - - - - - Footer - - - - - - - - - - - - - - - - -->	
	
	<?php echo $footer; ?>
	
	<!-- - - - - - - - - - - - - - - end Footer - - - - - - - - - - - - - - - - -->		
	
</div><!--/ .wrap-->