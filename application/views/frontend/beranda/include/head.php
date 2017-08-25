<!DOCTYPE html>
<!--[if IE 7]>					<html class="ie7 no-js" lang="en">     <![endif]-->
<!--[if lte IE 8]>              <html class="ie8 no-js" lang="en">     <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="not-ie no-js" lang="en">  <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
	<title><?php switch ($this->uri->segment(1)) {
		case 'beranda':
			echo 'Politica | Beranda';
			break;

		case 'berita':
			echo 'Politica | Berita';
			break;

		case 'blog':
			echo 'Politica | Blog';
			break;

		case 'galeri':
			echo 'Politica | Galeri';
			break;
		
		default:
			echo 'Politica';
			break;
	} ?></title>
	
	<meta name="description" content="">
	<meta name="author" content="">	
	
	<link rel="icon" type="image/png" href="<?php echo base_url() ?>frontend/images/favicon.png">
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>frontend/css/style.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>frontend/sliders/flexslider/flexslider.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>frontend/fancybox/jquery.fancybox.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>frontend/css/nivo-lightbox.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>frontend/css/fontawesome-4.2.0.min.css" />

	<!-- HTML5 Shiv -->
	<script type="text/javascript" src="<?php echo base_url() ?>frontend/js/modernizr.custom.js"></script>
</head>

<body class="style-1">

<!-- <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> -->	
<script>window.jQuery || document.write('<script src="<?php echo base_url() ?>frontend/js/jquery-1.7.1.min.js"><\/script>')</script>
<!--[if lt IE 9]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script>
	<script src="js/ie.js"></script>
<![endif]-->
<script src="<?php echo base_url() ?>frontend/js/jquery.cycle.all.min.js"></script>
<script src="<?php echo base_url() ?>frontend/js/respond.min.js"></script>
<script src="<?php echo base_url() ?>frontend/js/jquery.easing.1.3.js"></script>
<script src="<?php echo base_url() ?>frontend/sliders/flexslider/jquery.flexslider-min.js"></script>
<script src="<?php echo base_url() ?>frontend/fancybox/jquery.fancybox.js"></script>
<script src="<?php echo base_url() ?>frontend/js/custom.js"></script>
<script src="<?php echo base_url() ?>frontend/js/nivo-lightbox.min.js"></script>
<script type="text/javascript">
	var link = '<?php echo base_url() ?>';

	$(document).ready(function() {
		// $.post(link + 'beranda/atur_cookie', {ajax: 1}, function(data) {
		// 	optional stuff to do after success 
		// 	console.log(data);
		// });	
		window.setInterval(function() {
			$.post(link + 'beranda/cekKeaktifan', {ajax: 1}, function(data) {
				// optional stuff to do after success 
				if (data != 'true') {
					location.reload();
				} else{
					console.log('durasi visit bertambah 1 detik.');
				};
			});
		}, 1000);
	});
</script>