<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php echo Configure::read('Application.name') ?> - <?php echo !empty($title_for_layout) ? $title_for_layout : ''; ?>
</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width">

<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
<style>
body {
	padding-top: 0px;
	padding-bottom: 40px;
}

.error-message {
	float: left;
	margin-left: 180px;
	color: #B94A48;
}

@
-webkit-keyframes ajax-loader-rotate { 0% {
	-webkit-transform: rotate(0deg);
}

100%
{
-webkit-transform






:



 



rotate






(360
deg




);
}
}
@
-moz-keyframes ajax-loader-rotate { 0% {
	transform: rotate(0deg);
}

100%
{
transform






:



 



rotate






(360
deg




);
}
}
@
keyframes ajax-loader-rotate { 0% {
	transform: rotate(0deg);
}

100%
{
transform






:



 



rotate






(360
deg




);
}
}
.ajax-loader {
	opacity: .8;
	display: block;
	border-radius: 50%;
	font-size: 29px;
	width: .25em;
	height: .25em;
	box-shadow: 0 -.4em 0 0 rgba(0, 0, 0, 1), -.28em -.28em 0 0
		rgba(0, 0, 0, .75), -.4em 0 0 0 rgba(0, 0, 0, .50), -.28em .28em 0 0
		rgba(0, 0, 0, .25);
	-webkit-animation: .85s ajax-loader-rotate steps(8) infinite;
	-moz-animation: .85s ajax-loader-rotate steps(8) infinite;
	animation: .85s ajax-loader-rotate steps(8) infinite;
}

#ajax-loader {
	background-color: #666;
	height: 8px;
	opacity: 0.7;
	padding: 20px;
	position: absolute;
	right: 0;
	top: 70px;
	width: 50px;
	z-index: 100;
	display: none;
}
</style>
<!-- google font -->
<link href="http://fonts.googleapis.com/css?family=Aclonica:regular"
	rel="stylesheet" type="text/css" />

<!-- styles -->
<?php echo $this->Html->css('normalize.css') ?>
<?php echo $this->Html->css('bootstrap-default.min.css') ?>
<?php echo $this->Html->css('bootstrap-responsive.min.css') ?>
<?php echo $this->Html->css('stilearn.css') ?>
<?php echo $this->Html->css('stilearn-responsive.css') ?>
<?php echo $this->Html->css('stilearn-helper.css') ?>
<?php echo $this->Html->css('stilearn-icon.css') ?>
<?php echo $this->Html->css('elusive-webfont.css') ?>
<?php echo $this->Html->css('font-awesome.css') ?>

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

<?php
if (is_file(WWW_ROOT . 'css' . DS . $this->params->controller . '.css')) {
	echo $this->Html->css($this->params->controller);
}
if (is_file(WWW_ROOT . 'css' . DS . $this->params->controller . DS . $this->params->action . '.css')) {
	echo $this->Html->css($this->params->controller . '/' . $this->params->action);
}
?>

<script type="text/javascript"
	src="http://maps.googleapis.com/maps/api/js?v=3&sensor=false&libraries=geometry&key=AIzaSyAkov9R7ORYZvjOVDZEbmzsZn51ePNPWp4"></script>
<script src="<?php echo $this->params->webroot ?>js/lib/jquery.js"></script>
<?php //echo $this->Html->script('lib/modernizr') ?>



<script type="text/javascript">
	var VTS_URL_ROOT = "<?php echo $this->webroot;?>";
	var VTS_XHR=null;
</script>
</head>
<body>
	<div class="row-fluid">
		<div id="ajax-contents" class="span12">
		<?php echo $this->fetch('content'); ?>
		</div>
	</div>

	<!-- javascript
        ================================================== -->

	<?php echo $this->Html->script(
	array(
                      'lib/jquery-ui.min',
                      'lib/bootstrap.min',
						'lib/BdccArrowedPolyline',
						'lib/gmap3.min',
                      'lib/jquery.timer.js',
						'lib/markerwithlabel',
						'lib/infobubble',
						'lib/jquery.jodometer.min',
                      'src/mapHelper',
						//'lib/knob/jquery.knob.js',
                      'src/scripts',
						'src/common',
                      ));
                      ?>



                      <?php
                      if (is_file(WWW_ROOT . 'js' . DS . $this->params->controller . '.js')) {
                      	echo $this->Html->script($this->params->controller);
                      }
                      if (is_file(WWW_ROOT . 'js' . DS . $this->params->controller . DS . $this->params->action . '.js')) {
                      	echo $this->Html->script($this->params->controller . '/' . $this->params->action);
                      }
                      ?>


	<style>
.content > .content-header{
			padding-top: 5px; 
			height: 30px;
		}
		.box{
			margin-bottom: 10px;
		}
		.box > .box-body{
			padding:0;
		}
		.row{
			margin:0 10px;
		}
		
		.span12{
			margin-left:0!important;
		}
		#tracker-list li{
			z-index:9999;
			background: linear-gradient(to bottom, #FFFFFF 0%, #F1F1F1 100%) repeat scroll 0 0 transparent;
			padding: 2px 5px;
			border: 1px solid #ddd;
			height: 45px;
			margin: 0 2px;
		}
		.row-fluid [class*="span"]{
			margin: 0 10px 0 0;
			min-height:0;
		}

</style>
<script type="text/javascript">
	$(function() {
		APP_COMMON.bindResizeDiv('#monitor-tracker-list',120); 
		APP_COMMON.bindResizeDiv('#maps-container',120);
	});
</script>
	

</body>
</html>
