<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Login</title>
<link rel="stylesheet"
	href="<?php echo $this->webroot;?>assets/css/bootstrap.min.css">
<link rel="stylesheet"
	href="<?php echo $this->webroot;?>assets/css/login.css">
</head>
<body>
	<div class="container" style="width: auto !important">
		<div class="text-center">
			<img src="<?php echo $this->webroot;?>assets/img/logo.png"
				alt="Metis Logo">
		</div>
		<div class="tab-content">

			<div id="login" class="tab-pane active">
				<div style="width: 50%;margin-left: 25%;margin-right: 25%;margin-top: 1%;">
					<?php echo $this->Session->flash();?>
					<?php echo $this->element('form_login') ?>
				</div>
			</div>
			<div id="forgot" class="tab-pane">
				<form action="index.html" class="form-signin">
					<p class="muted text-center">Enter your valid e-mail</p>
					<input type="email" placeholder="mail@domain.com"
						required="required" class="input-block-level"> <br> <br>
					<button class="btn btn-large btn-danger btn-block" type="submit">Recover
						Password</button>
				</form>
			</div>
		</div>


	</div>
	<!-- /container -->

	<script
		src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?php echo $this->webroot;?>assets/js/vendor/jquery-1.10.1.min.js"><\/script>')</script>
	<script type="text/javascript"
		src="<?php echo $this->webroot;?>assets/js/vendor/bootstrap.min.js"></script>

	<script>
            $('.inline li > a').click(function() {
                var activeForm = $(this).attr('href') + ' > form';
                //console.log(activeForm);
                $(activeForm).addClass('magictime swap');
                //set timer to 1 seconds, after that, unload the magic animation
                setTimeout(function() {
                    $(activeForm).removeClass('magictime swap');
                }, 1000);
            });

        </script>
</body>
</html>
