<!-- - - - - - - - - - - - - - Header - - - - - - - - - - - - - - - - -->	
	
	<header id="header" class="clearfix">
		
		<div id="logo">
			<h1><a href="<?php echo site_url('beranda') ?>"><?php echo $nama; ?></a></h1><br>
			<p><?php echo $tagline; ?></p>
		</div>
		<ul class="social-links clearfix">
			<li class="twitter"><a href="http://www.twitter.com/<?php echo $twitter ?>">Twitter<span></span></a></li>
			<li class="facebook"><a href="http://www.facebook.com/<?php echo $facebook ?>">Facebook<span></span></a></li>
			<li class="youtube"><a href="http://www.youtube.com/<?php echo $youtube ?>">YouTube<span></span></a></li>
		</ul><!--/ .social-links-->
			
		<nav id="navigation" class="navigation">
			
			<ul>
				<?php echo ($this->uri->segment(1) == '' || $this->uri->segment(1) == 'beranda') ? '<li class="current"><a href="' . base_url() .'">Beranda</a></li>' : '<li><a href="' . base_url() .'">Beranda</a></li>'; ?>
				<li><a href="<?php echo site_url('beranda/search_tag') ?>">Tentang Kami</a></li>
				<li><a href="<?php echo site_url('beranda/kegiatan') ?>">Kegiatan</a></li>
				<?php echo ($this->uri->segment(1) == 'berita') ? '<li class="current"><a href="' . site_url("berita") . '">Berita</a></li>' : '<li><a href="' . site_url("berita") .'">Berita</a></li>'; ?>
				<?php echo ($this->uri->segment(1) == 'blog') ? '<li class="current"><a href="' . site_url("blog") . '">Blog</a></li>' : '<li><a href="' . site_url("blog") .'">Blog</a></li>'; ?>
				<?php echo ($this->uri->segment(1) == 'galeri') ? '<li class="current"><a href="' . site_url("galeri") . '">Galeri</a></li>' : '<li><a href="' . site_url("galeri") .'">Galeri</a></li>'; ?>
				<?php echo ($this->uri->segment(1) == 'kontak') ? '<li class="current"><a href="' . site_url("kontak") . '">Kontak</a></li>' : '<li><a href="' . site_url("kontak") .'">Kontak</a></li>'; ?>
			</ul>
			
			<?php 
			if ($this->session->userdata('id')) { ?>
				<a href="<?php echo site_url('dashboard') ?>" class="donate">Dashboard</a>
			<?php } else { ?>
				<a href="<?php echo site_url('beranda/login') ?>" class="donate">Login</a>
			<?php } ?>
			
		</nav><!--/ #navigation-->
		
	</header><!--/ #header-->

<!-- - - - - - - - - - - - - - end Header - - - - - - - - - - - - - - - - -->	