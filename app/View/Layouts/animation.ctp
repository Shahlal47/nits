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


.error-message {
	float: left;
	margin-left: 180px;
	color: #B94A48;
}

@-webkit-keyframes ajax-loader-rotate { 0% {
	-webkit-transform: rotate(0deg);
}100%{-webkit-transform:rotate(360 deg);}
}

@-moz-keyframes ajax-loader-rotate { 0% {
	transform: rotate(0deg);
}100%{ transform : rotate(360 deg);}}
@keyframes ajax-loader-rotate { 0% {
	transform: rotate(0deg);
}100%{transform : rotate (360 deg);}}

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
<link type="text/css" rel="stylesheet"	href="<?php echo $this->webroot;?>assets/css/bootstrap.min.css">
<link type="text/css" rel="stylesheet"	href="<?php echo $this->webroot;?>assets/css/bootstrap-responsive.min.css">
<link type="text/css" rel="stylesheet"	href="<?php echo $this->webroot;?>assets/Font-awesome/css/font-awesome.min.css">
<?php echo $this->Html->css('animate.css') ?>
<link type="text/css" rel="stylesheet"	href="<?php echo $this->webroot;?>assets/css/style.css">

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<!--[if IE 7]>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->webroot;?>assets/Font-awesome/css/font-awesome-ie7.min.css"/>
<![endif]-->




<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

<script	src="<?php echo $this->webroot;?>assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>


<script type="text/javascript"
	src="http://maps.googleapis.com/maps/api/js?v=3&sensor=false&libraries=geometry&key=AIzaSyAkov9R7ORYZvjOVDZEbmzsZn51ePNPWp4"></script>

  <script type="text/javascript" src="https://www.google.com/jsapi"></script>

<script	src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo $this->webroot;?>js/jquery.js"><\/script>')</script>
  
 <script type="text/javascript" src="<?php echo $this->params->webroot ?>js/lib/lib/geplugin-helpers.js"></script>
  <script type="text/javascript" src="<?php echo $this->params->webroot ?>js/lib/lib/math3d.js"></script>
  <script type="text/javascript" src="<?php echo $this->params->webroot ?>js/lib/simulator.js"></script>
  <script type="text/javascript" src="<?php echo $this->params->webroot ?>js/lib/index.js"></script>
<script type="text/javascript"  src="<?php echo $this->webroot;?>assets/js/jstorage.js"></script>
<script type="text/javascript"  src="<?php echo $this->webroot;?>assets/js/jstoragelib.js"></script>

  <script type="text/javascript"  src="<?php echo $this->webroot;?>assets/js/scripts.js"></script>
<script type="text/javascript"  src="<?php echo $this->webroot;?>js/src/common.js"></script>
  
 <script type="text/javascript">


var DS_ge;
var DS_geHelpers;
var DS_map;
google.load("earth", "1");

function DS_init() {
  google.earth.createInstance(
    'earth',
    function(ge) {
      DS_ge = ge;
      DS_ge.getWindow().setVisibility(true);
      DS_ge.getLayerRoot().enableLayerById(DS_ge.LAYER_BUILDINGS, true);
      DS_ge.getLayerRoot().enableLayerById(DS_ge.LAYER_BORDERS, true);
      DS_geHelpers = new GEHelpers(DS_ge);
      
      DS_ge.getNavigationControl().setVisibility(ge.VISIBILITY_AUTO);


      var myOptions = {
    	      zoom: 13,
    	      mapTypeId: google.maps.MapTypeId.ROADMAP
    	    };
      DS_map = new google.maps.Map(document.getElementById("map"), myOptions);
      DS_map.setCenter(new google.maps.LatLng(25.760650,
    		  89.222610), 13);
	  
      DS_goDirections();
    },
    function() {
    });

  function onresize() {
    var clientHeight = document.documentElement.clientHeight;

    $('#route-details, #earth, #map').each(function() {
      $(this).css({
        height: (clientHeight - $(this).position().top - 100).toString() + 'px' });      
    });
  }
  
  $(window).resize(onresize);
  onresize();
  
}

google.setOnLoadCallback(DS_init);



	var APP_URL_ROOT = "<?php echo $this->webroot;?>";
	var APP_XHR=null;
</script>


</head>
<body>
	<div id="wrap" style="margin-bottom:0;">
		<div id="top">
			<div class="navbar navbar-static-top">
				<div class="navbar-inner">
					<div class="container-fluid">
					<?php echo $this->element('Commons/Page/header') ?>
					<?php echo $this->element("Roles/animation") ?>
					</div>
				</div>
			</div>
		</div>
		<header class="head" style="height: 0;"></header>

		<div id="content" style="margin-left: 0;">
			<div class="container-fluid outer" style="padding-left: 0;">
				<div class="row-fluid" id="ajax-content">
					<?php echo $this->fetch('content'); ?>
				</div>
			</div>
		</div>
	</div>

	


<style>


#tracker-list li {
	z-index: 9999;
	background: linear-gradient(to bottom, #FFFFFF 0%, #F1F1F1 100%) repeat
		scroll 0 0 transparent;
	padding: 2px 5px;
	border: 1px solid #ddd;
	height: 45px;
	margin: 0 2px;
}

.row-fluid [class *="span"] {
	margin: 0 10px 0 0;
	min-height: 0;
}
</style>

<script type="text/javascript">
	$(function() {
		APP_COMMON.bindResizeDiv('#single-tracker-map',110);	
		APP_COMMON.initLayout("<?php echo $user['username']?>");	
	});
</script>

</body>
</html>
