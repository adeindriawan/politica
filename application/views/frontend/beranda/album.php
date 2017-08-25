<?php $this->load->view('frontend/beranda/include/head'); ?>
<div class="wrap-header"></div><!--/ .wrap-header-->

<div class="wrap">
	
	<!-- - - - - - - - - - - - - - Header - - - - - - - - - - - - - - - - -->	
	
	<?php $this->load->view('frontend/beranda/include/header'); ?>
	
	<!-- - - - - - - - - - - - - - end Header - - - - - - - - - - - - - - - - -->	
	
	
	<!-- - - - - - - - - - - - - - - Container - - - - - - - - - - - - - - - - -->	
	
	<section class="container clearfix">

		<?php if (count($data1) == 0) { ?>
			<p>Belum ada album.</p>
		<?php } else { ?>
				<!-- - - - - - - - - - Page Header - - - - - - - - - - -->	
		
				<div class="page-header">
					
					<h1 class="page-title"><?php echo $data1[0]['judul_album'] ?></h1>
					
				</div><!--/ .page-header-->
				
				<!-- - - - - - - - - end Page Header - - - - - - - - - -->	
				<!-- - - - - - - - - - - - - - - Columns - - - - - - - - - - - - - - - - -->
				<?php foreach ($data1 as $urut => $album) {
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
		<?php } ?>
		<div class="clear"></div>
		<p><?php echo $data1[0]['deskripsi_album'] ?></p><br>
		<?php if ($data2->num_rows() == 0 ) { ?>
				<section id="comments">

					<h5><span id="belum-ada-komentar">Belum ada komentar untuk album ini.</span></h5>

					<ol class="comments-list" id="kolom-komentar">
						
					</ol><!--/ .comments-list-->

				</section>
			<?php } else { ?>
				<section id="comments">

					<h5>Komentar</h5>

					<ol class="comments-list" id="kolom-komentar">

						<?php foreach ($data2->result_array() as $komen) { ?>
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
							var jud = "<?php echo $data1[0]['judul_album'] ?>";
			                var gal = "<?php echo $this->uri->segment(3) ?>";
			                var tgl = "<?php echo date('Y-m-d H:i:s') ?>";
			                var nam = $("#commentform").find('input[name="nama"]').val();
			                var ema = $("#commentform").find('input[name="email"]').val();
			                var web = $("#commentform").find('input[name="website"]').val();
			                var kom = $("#commentform").find('textarea[name="komentar"]').val();

			                $.post(link + 'beranda/tambah_komentar', {album: gal, nama: nam, email: ema, website: web, komentar: kom, judul: jud, ajax: 1}, function(data) {
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
							var jud = "<?php echo $data1[0]['judul_album'] ?>";
			                var gal = "<?php echo $this->uri->segment(3) ?>";
			                var tgl = "<?php echo date('Y-m-d H:i:s') ?>";
			                var nam = $("#username").text();
			                var ema = $("#email").text();
			                var web = $("#commentform").find('input[name="website"]').val();
			                var kom = $("#commentform").find('textarea[name="komentar"]').val();

			                $.post(link + 'beranda/tambah_komentar', {album: gal, nama: nam, email: ema, website: web, komentar: kom, judul: jud, ajax: 1}, function(data) {
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
	</section><!--/.container -->
		
	<!-- - - - - - - - - - - - - end Container - - - - - - - - - - - - - - - - -->	
	
	
	<!-- - - - - - - - - - - - - - - Footer - - - - - - - - - - - - - - - - -->	
	
	<?php $this->load->view('frontend/beranda/include/footer'); ?>
	
	<!-- - - - - - - - - - - - - - - end Footer - - - - - - - - - - - - - - - - -->		
	
</div><!--/ .wrap-->

</body>
</html>