<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title>Politica | Login</title>
	<meta name="description" content="Bootstrap Metro Dashboard">
	<meta name="author" content="Dennis Ji">
	<meta name="keyword" content="Metro, Metro UI, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
	<!-- end: Meta -->
	
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	
	<!-- start: CSS -->
	<link id="bootstrap-style" href="<?php echo base_url() ?>backend/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>backend/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link id="base-style" href="<?php echo base_url() ?>backend/css/style.css" rel="stylesheet">
	<link id="base-style-responsive" href="<?php echo base_url() ?>backend/css/style-responsive.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
	<!-- end: CSS -->
	

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<link id="ie-style" href="css/ie.css" rel="stylesheet">
	<![endif]-->
	
	<!--[if IE 9]>
		<link id="ie9style" href="css/ie9.css" rel="stylesheet">
	<![endif]-->
		
	<!-- start: Favicon -->
	<link rel="shortcut icon" href="img/favicon.ico">
	<!-- end: Favicon -->
	
	<style type="text/css">
		body { background: url(<?php echo base_url() ?>backend/img/bg-login.jpg) !important; }
	</style>
		
		
		
</head>

<body>
	<div class="container-fluid-full">
		<div class="row-fluid">					
			<div class="row-fluid">
				<div class="login-box">
					<div class="icons">
						<a href="<?php echo base_url() ?>"><i class="halflings-icon home"></i></a>
						<a href="#"><i class="halflings-icon cog"></i></a>
					</div>
					<h2>Masuk ke akun Anda</h2>
					
						<div class="input-prepend" title="Username">
							<span class="add-on"><i class="halflings-icon user"></i></span>
							<input class="input-large span10" name="username" id="username" type="text" placeholder="type username"/>
						</div>
						
						<div class="clearfix"></div>

						<div class="input-prepend" title="Password">
							<span class="add-on"><i class="halflings-icon lock"></i></span>
							<input class="input-large span10" name="password" id="password" type="password" placeholder="type password"/>
						</div>
						
						<div class="clearfix"></div>
						
						<label class="remember" for="remember"><input type="checkbox" id="remember" />Remember me</label>

						<div class="button-login">	
							<button id="login-button" class="btn btn-primary">Login</button>
						</div>
						<div class="clearfix"></div>
					
					<hr>
					<h3>Forgot Password?</h3>
					<p>
						No problem, <a href="#">click here</a> to get a new password.
					</p>	
				</div><!--/span-->
			</div><!--/row-->	
		</div><!--/.fluid-container-->
	</div><!--/fluid-row-->
	
	<!-- start: JavaScript-->

	<script src="<?php echo base_url() ?>backend/js/jquery-1.9.1.min.js"></script>
	<script src="<?php echo base_url() ?>backend/js/jquery-migrate-1.0.0.min.js"></script>
	<script src="<?php echo base_url() ?>backend/js/jquery-ui-1.10.0.custom.min.js"></script>
	<script src="<?php echo base_url() ?>backend/js/jquery.ui.touch-punch.js"></script>
	<script src="<?php echo base_url() ?>backend/js/modernizr.js"></script>
	<script src="<?php echo base_url() ?>backend/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url() ?>backend/js/jquery.cookie.js"></script>
	<script src='<?php echo base_url() ?>backend/js/fullcalendar.min.js'></script>
	<script src='<?php echo base_url() ?>backend/js/jquery.dataTables.min.js'></script>
	<script src="<?php echo base_url() ?>backend/js/excanvas.js"></script>
	<script src="<?php echo base_url() ?>backend/js/jquery.flot.js"></script>
	<script src="<?php echo base_url() ?>backend/js/jquery.flot.pie.js"></script>
	<script src="<?php echo base_url() ?>backend/js/jquery.flot.stack.js"></script>
	<script src="<?php echo base_url() ?>backend/js/jquery.flot.resize.min.js"></script>
	<script src="<?php echo base_url() ?>backend/js/jquery.chosen.min.js"></script>
	<script src="<?php echo base_url() ?>backend/js/jquery.uniform.min.js"></script>
	<script src="<?php echo base_url() ?>backend/js/jquery.cleditor.min.js"></script>
	<script src="<?php echo base_url() ?>backend/js/jquery.noty.js"></script>
	<script src="<?php echo base_url() ?>backend/js/jquery.elfinder.min.js"></script>
	<script src="<?php echo base_url() ?>backend/js/jquery.raty.min.js"></script>
	<script src="<?php echo base_url() ?>backend/js/jquery.iphone.toggle.js"></script>
	<script src="<?php echo base_url() ?>backend/js/jquery.uploadify-3.1.min.js"></script>
	<script src="<?php echo base_url() ?>backend/js/jquery.gritter.min.js"></script>
	<script src="<?php echo base_url() ?>backend/js/jquery.imagesloaded.js"></script>
	<script src="<?php echo base_url() ?>backend/js/jquery.masonry.min.js"></script>
	<script src="<?php echo base_url() ?>backend/js/jquery.knob.modified.js"></script>
	<script src="<?php echo base_url() ?>backend/js/jquery.sparkline.min.js"></script>
	<script src="<?php echo base_url() ?>backend/js/counter.js"></script>
	<script src="<?php echo base_url() ?>backend/js/retina.js"></script>
	<script src="<?php echo base_url() ?>backend/js/custom.js"></script>
	<!-- end: JavaScript-->
	<script type="text/javascript">
		$(document).ready(function() {
			function logIn() {
				var link = '<?php echo base_url() ?>';
				var usr = $('#username').val();
				var psw = $('#password').val();
				/* Act on the event */
				$.post(link + 'login/masuk', {ajax: 1, username: usr, password: psw}, function(data) {
					/*optional stuff to do after success */
					if (data == 'login gagal') {
						$('#errorLogModal').modal('show');
					} else{
						window.location = link + 'dashboard';
					};
				});
			}
			$('#login-button').click(function() {
				logIn();
			});
			$(document).keypress(function(e) {
				/* Act on the event */
				if (e.which == 13) {
					logIn();
				};
			});
		});
	</script>

	<div class="modal hide fade" id="errorLogModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Dialog</h3>
		</div>
		<div class="modal-body tambah-tag">
			Login gagal, pastikan <em>username</em> dan <em>password</em> benar!
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Tutup</a>
		</div>
	</div>
	
</body>
</html>
