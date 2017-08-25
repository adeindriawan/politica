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
					<?php echo $data1[0]['judul_artikel']; ?>
				</h3><!--/ .title -->
				
				<section class="post-meta clearfix">
					
					<div class="post-date"><?php echo $data1[0]['tanggal_artikel'] ?></div><!--/ .post-date-->
					<div class="post-tags"><a href="<?php echo site_url('beranda/cari-kategori/'.$data5[0]['id_kategori']) ?>"><?php echo $data5[0]['kategori'] ?></a></div><!--/ .post-tags-->
					<div class="post-comments"><?php echo $data4; ?> Komentar</div><!--/ .post-comments-->
					
				</section><!--/ .post-meta-->
				
				<a class="single-image" href="<?php echo base_url() ?>uploads/images/artikel/original/<?php echo $data1[0]['gambar_artikel'] ?>">
					<img class="custom-frame" alt="" src="<?php echo base_url() ?>uploads/images/artikel/page/<?php echo $data1[0]['gambar_artikel'] ?>">
				</a>
				
				<p>
					<?php echo $data1[0]['isi_artikel'] ?>
				</p>

				<em><small>ditulis oleh: <?php echo $data1[0]['username_admin'] ?></small></em>
				
			</article><!--/ .post-->

			<?php if ($data3->num_rows() == 0 ) { ?>
				<section id="comments">

					<h5><span id="belum-ada-komentar">Belum ada komentar untuk artikel ini.</span></h5>

					<ol class="comments-list" id="kolom-komentar">
						
					</ol><!--/ .comments-list-->

				</section>
			<?php } else { ?>
				<section id="comments">

					<h5>Komentar</h5>

					<ol class="comments-list" id="kolom-komentar">

						<?php foreach ($data3->result_array() as $komen) { ?>
							<li class="comment">

								<article>
									
									<img src="<?php echo base_url() ?>frontend/images/gravatar.png" alt="avatar" class="avatar">
									<div class="comment-entry">
										<div class="comment-meta">
											<h6 class="author"><a href="#"><?php echo $komen['nama_komentator'] ?></a></h6>
											<p class="date"><?php echo $komen['tanggal_komentar'] ?></p>
										</div><!--/ .comment-meta -->
										<div class="comment-body">
											<p>
												<?php echo $komen['isi_komentar'] ?> 
											</p>
										</div><!--/ .comment-body -->
									</div><!--/ .comment-entry-->

								</article>

							</li><!--/ .comment-->
						<?php } ?>
						
					</ol><!--/ .comments-list-->

				</section>
			<?php } ?>

			<?php if (!$this->session->userdata('username')) { ?>
				<section id="respond">

					<h5>Leave a Comment</h5>

					<form method="post" id="commentform">

						<fieldset class="input-block">
							<label for="comment-name"><strong>Your Name:</strong> <span>*</span><i>(required)</i></label>
							<input type="text" name="nama" value="" id="comment-name" required>
						</fieldset>

						<fieldset class="input-block">
							<label for="comment-email"><strong>E-mail:</strong> <span>*</span><i>(required)</i></label>
							<input type="email" name="email" value="" id="comment-email" required>
						</fieldset>

						<fieldset class="input-block">
							<label for="comment-url"><strong>Website</strong></label>
							<input type="url" name="website" value="" id="comment-url">
						</fieldset>

						<fieldset class="textarea-block">
							<label for="comment-message"><strong>Message</strong></label>
							<textarea name="komentar" id="comment-message" cols="50" rows="4" required></textarea>
						</fieldset>
						
						<input type="button" class="button gray" id="submitKomentar" value="Submit Comment &rarr;">
						&nbsp;&nbsp;
                		<input type="button" class="button gray" id="batal" value="Batal">
						<div class="clear"></div>
						<div id="pesan-komentar"></div>

					</form>

				</section><!--/ #respond-->
				<script type="text/javascript">
					$(document).ready(function() {
						var link = "<?php echo base_url() ?>";
						$('#submitKomentar').click(function(event) {
							/* Act on the event */
							var jud = "<?php echo $data1[0]['judul_artikel'] ?>";
			                var art = "<?php echo $this->uri->segment(3) ?>";
			                var tgl = "<?php echo date('Y-m-d H:i:s') ?>";
			                var jns = "<?php echo strtolower($data[0]['kategori_artikel']) ?>";
			                var nam = $("#commentform").find('input[name="nama"]').val();
			                var ema = $("#commentform").find('input[name="email"]').val();
			                var web = $("#commentform").find('input[name="website"]').val();
			                var kom = $("#commentform").find('textarea[name="komentar"]').val();

			                $.post(link + 'beranda/tambah_komentar', {artikel: art, nama: nam, email: ema, website: web, komentar: kom, judul: jud, kategori: jns, ajax: 1}, function(data) {
			                    /*optional stuff to do after success */
			                    if (data == 'false') {
			                      $("#pesan-komentar").html('<p class="error">Gagal mengirim komentar. Pastikan semua isian yang dibutuhkan terisi.</p>');
			                    } else{
			                      	$("#kolom-komentar").prepend("<li class='comment'>" + 
			                                                  "<article>" +
			                                                  "<img src='<?php echo base_url() ?>frontend/images/gravatar.png' alt='avatar' class='avatar'>" +
			                                                  "<div class='comment-entry'><div class='comment-meta'><h6 class='author'><a href='#'>" + nam + "</a></h6>" +
			                                                  "<p class='date'>pada " + tgl + "</p>" +
			                                                  "</div>" +
			                                                  "<div class='comment-body'><p>" + kom + "</p></div></div>" +
			                                                  "</article>" +
			                                                  "</li>");
			                      	$("#belum_ada_komentar").text('Komentar');
			                      	$("#commentform").find('input[name="nama"]').val('');
					                $("#commentform").find('input[name="email"]').val('');
					                $("#commentform").find('input[name="website"]').val('');
					                $("#commentform").find('textarea[name="komentar"]').val('');
					                $('#pesan-komentar').html('<p class="success">Sukses mengirim komentar</p>');
			                    };
			                });
						});
						$("#batal").click(function(event) {
			               	$("#commentform").find('input[name="nama"]').val('');
			               	$("#commentform").find('input[name="email"]').val('');
			               	$("#commentform").find('input[name="website"]').val('');
			               	$("#commentform").find('textarea[name="komentar"]').val('');
			            });
					});
				</script>
			<?php } else { ?>
				<section id="respond">

					<h5>Leave a Comment</h5>

					<form method="post" id="commentform">

						<fieldset class="input-block">
							<label for="comment-name"><span id="username"><?php echo $this->session->userdata('username'); ?></span></label>
						</fieldset>

						<fieldset class="input-block">
							<label for="comment-email"><span id="email"><?php echo $this->session->userdata('email'); ?></span></label>
						</fieldset>

						<fieldset class="input-block">
							<label for="comment-url"><strong>Website</strong></label>
							<input type="url" name="website" value="" id="comment-url">
						</fieldset>

						<fieldset class="textarea-block">
							<label for="comment-message"><strong>Message</strong></label>
							<textarea name="komentar" id="comment-message" cols="50" rows="4" required></textarea>
						</fieldset>
						
						<input type="button" class="button gray" id="submitKomentar2" value="Submit Comment &rarr;">
						&nbsp;&nbsp;
                		<input type="button" class="button gray" id="batal2" value="Batal">

						<div class="clear"></div>
						<div id="pesan-komentar"></div>

					</form>

				</section><!--/ #respond-->
				<script type="text/javascript">
					$(document).ready(function() {
						var link = "<?php echo base_url() ?>";
						$('#submitKomentar2').click(function(event) {
							/* Act on the event */
							var jud = "<?php echo $data1[0]['judul_artikel'] ?>";
			                var art = "<?php echo $this->uri->segment(3) ?>";
			                var tgl = "<?php echo date('Y-m-d H:i:s') ?>";
			                var jns = "<?php echo strtolower($data[0]['kategori_artikel']) ?>";
			                var nam = $("#username").text();
			                var ema = $("#email").text();
			                var web = $("#commentform").find('input[name="website"]').val();
			                var kom = $("#commentform").find('textarea[name="komentar"]').val();

			                $.post(link + 'beranda/tambah_komentar', {artikel: art, nama: nam, email: ema, website: web, komentar: kom, judul: jud, kategori: jns, ajax: 1}, function(data) {
			                    /*optional stuff to do after success */
			                    if (data == 'false') {
			                      $("#pesan-komentar").html('<p class="error">Gagal mengirim komentar</p>');
			                    } else{
			                      	$("#kolom-komentar").prepend("<li class='comment'>" + 
			                                                  "<article>" +
			                                                  "<img src='<?php echo base_url() ?>frontend/images/gravatar.png' alt='avatar' class='avatar'>" +
			                                                  "<div class='comment-entry'><div class='comment-meta'><h6 class='author'><a href='#'>" + nam + "</a></h6>" +
			                                                  "<p class='date'>pada " + tgl + "</p>" +
			                                                  "</div>" +
			                                                  "<div class='comment-body'><p>" + kom + "</p></div></div>" +
			                                                  "</article>" +
			                                                  "</li>");
			                      	$("#belum_ada_komentar").text('Komentar');
					                $("#commentform").find('input[name="website"]').val('');
					                $("#commentform").find('textarea[name="komentar"]').val('');
					                $('#pesan-komentar').html('<p class="success">Sukses mengirim komentar</p>');
			                    };
			                });
						});
						$("#batal2").click(function(event) {
			               	$("#commentform").find('input[name="website"]').val('');
			               	$("#commentform").find('textarea[name="komentar"]').val('');
			            });
					});
				</script>
			<?php } ?>
			
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
			
			<div class="widget-container widget_categories">
				
				<h3 class="widget-title">Tag Artikel Ini</h3>
				
				<ul>
					<?php foreach ($data2 as $tag) { ?>
						<li><i class="fa fa-tags"></i>&nbsp;<a href="<?php echo base_url() ?>beranda/cari-tag/<?php echo $tag['id_tag'] ?>"><?php echo $tag['tag'] ?></a></li>
					<?php } ?>
				</ul>
				
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