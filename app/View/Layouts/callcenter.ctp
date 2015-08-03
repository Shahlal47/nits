<!DOCTYPE html>
<!--[if lt IE 7]>       <html class="no-js lt-ie9 lt-ie8 lt-ie7">   <![endif]-->
<!--[if IE 7]>          <html class="no-js lt-ie9 lt-ie8">          <![endif]-->
<!--[if IE 8]>          <html class="no-js lt-ie9">                 <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Dashboard</title>
<meta name="description"
	content="Metis: Bootstrap Responsive Admin Theme">
<meta name="viewport" content="width=device-width">
<link type="text/css" rel="stylesheet"
	href="<?php echo $this->webroot;?>assets/css/bootstrap.min.css">
<link type="text/css" rel="stylesheet"
	href="<?php echo $this->webroot;?>assets/css/bootstrap-responsive.min.css">
<link type="text/css" rel="stylesheet"
	href="<?php echo $this->webroot;?>assets/Font-awesome/css/font-awesome.min.css">
<link type="text/css" rel="stylesheet"
	href="<?php echo $this->webroot;?>assets/css/style.css">

<link type="text/css" rel="stylesheet"
	href="<?php echo $this->webroot;?>assets/css/DT_bootstrap.css" />
<link rel="stylesheet"
	href="<?php echo $this->webroot;?>assets/css/responsive-tables.css">

<link type="text/css" rel="stylesheet"
	href="<?php echo $this->webroot;?>assets/css/jquery.tagsinput.css" />
<link type="text/css" rel="stylesheet"
	href="<?php echo $this->webroot;?>assets/chosen/chosen/chosen.css" />



<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<!--[if IE 7]>
        <link type="text/css" rel="stylesheet" href="<?php echo $this->webroot;?>assets/Font-awesome/css/font-awesome-ie7.min.css"/>
        <![endif]-->

<script
	src="<?php echo $this->webroot;?>assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<script type="text/javascript">
			var APP_URL_ROOT = "<?php echo $this->webroot;?>";
			var APP_XHR=null;
		</script>


<script
	src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo $this->webroot;?>assets/js/vendor/jquery-1.10.1.min.js"><\/script>')</script>

<script
	src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>window.jQuery.ui || document.write('<script src="<?php echo $this->webroot;?>assets/js/vendor/jquery-ui-1.10.0.custom.min.js"><\/script>')</script>


<script
	src="<?php echo $this->webroot;?>assets/js/vendor/bootstrap.min.js"></script>

	<script type="text/javascript"
	src="<?php echo $this->webroot;?>assets/js/lib/jquery.dataTables.min.js"></script>
<script type="text/javascript"
	src="<?php echo $this->webroot;?>assets/js/lib/DT_bootstrap.js"></script>
<script
	src="<?php echo $this->webroot;?>assets/js/lib/responsive-tables.js"></script>
	
<script src="<?php echo $this->webroot;?>assets/js/bootstrap-typeahead.js"></script>	
<script src="<?php echo $this->webroot;?>assets/js/main.js"></script>

<script src="<?php echo $this->webroot;?>assets/js/scripts.js"></script>



</head>
<body>
	<div id="ajax-loader">
		<div class="ajax-loader"></div>
	</div>
	<!-- BEGIN WRAP -->
	<div id="wrap">


		<!-- BEGIN TOP BAR -->
		<div id="top">
			<!-- .navbar -->
			<div class="navbar navbar-static-top">
				<div class="navbar-inner">
					<div class="container-fluid">
					<?php echo $this->element('Commons/Page/header') ?>
					<?php echo $this->element('Roles/Callcenter/topnav') ?>
					</div>
				</div>
			</div>
			<!-- /.navbar -->
		</div>
		<!-- END TOP BAR -->


		<!-- BEGIN HEADER.head -->
		<header class="head" style="height: 0;">

		</header>
		<!-- END HEADER.head -->

		<!-- BEGIN LEFT  -->
		<div id="left" style="width:300px;">


			<!-- BEGIN MAIN NAVIGATION -->
		<?php echo $this->element('Roles/Callcenter/leftnav') ?>
			<!-- END MAIN NAVIGATION -->

		</div>
		<!-- END LEFT -->

		<!-- BEGIN MAIN CONTENT -->
		<div id="content" style="margin-left:300px;">
			<!-- .outer -->
			<div class="container-fluid outer">
				<div class="row-fluid" id="ajax-content">
				<?php echo $this->fetch('content'); ?>
				</div>
				<!-- /.row-fluid -->
			</div>
			<!-- /.outer -->
		</div>
		<!-- END CONTENT -->


	</div>
	<!-- END WRAP -->



	<?php echo $this->element('Commons/Page/ajaxlogin') ?>


	<script type="text/javascript">
            $(function() {
                dashboard();   
                $(window).resize(function() {
        			//var h = $(window).height();
        			//$('.iframe').css('height',h);	                   
        		});                
            });
        </script>
	<style>
.ajax-loader {
	opacity: .8;
	display: block;
	border-radius: 50%;
	font-size: 29px;
	width: .25em;
	height: .25em;
}

#ajax-loader {
	background: url("/nits/assets/img/loader.gif") no-repeat scroll 0 0
		transparent;
	height: 32px;
	opacity: 0.7;
	position: absolute;
	right: 0;
	top: 53px;
	right: 10px;
	width: 32px;
	z-index: 100;
	display: none;
}

</style>
</body>
</html>
