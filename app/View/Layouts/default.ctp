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
<title><?php echo Configure::read('Application.name') ?></title>
<meta name="description"
	content="">
<meta name="viewport" content="width=device-width">
<!-- <link rel="shortcut icon" href="<?php echo $this->webroot;?>favicon.ico" /> -->
<link type="text/css" rel="stylesheet"	href="<?php echo $this->webroot;?>assets/css/bootstrap.min.css">
<link type="text/css" rel="stylesheet"	href="<?php echo $this->webroot;?>assets/css/bootstrap-responsive.min.css">
<link type="text/css" rel="stylesheet"	href="<?php echo $this->webroot;?>assets/Font-awesome/css/font-awesome.min.css">

<link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/datetimepicker.css" />
<link type="text/css" rel="stylesheet"	href="<?php echo $this->webroot;?>assets/select2/select2.css" />
<link type="text/css" rel="stylesheet"	href="<?php echo $this->webroot;?>assets/css/DT_bootstrap.css" />
<link rel="stylesheet"	href="<?php echo $this->webroot;?>assets/css/responsive-tables.css">

<link type="text/css" rel="stylesheet"	href="<?php echo $this->webroot;?>assets/css/jquery.simplecolorpicker.css">
<link rel="stylesheet" href="<?php echo $this->webroot;?>css/jgauge.css" type="text/css" /> <!-- CSS for jGauge styling. -->
<link type="text/css" rel="stylesheet"	href="<?php echo $this->webroot;?>assets/menu/gmap3-menu.css">
<link type="text/css" rel="stylesheet"	href="<?php echo $this->webroot;?>assets/css/style.css">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<!--[if IE 7]>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->webroot;?>assets/Font-awesome/css/font-awesome-ie7.min.css"/>
<![endif]-->

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
	var APP_URL_ROOT = "<?php echo $this->webroot;?>";
	var APP_XHR=null;
	google.load('visualization', '1.0', {'packages':['corechart','timeline']});
</script>
<script	src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo $this->webroot;?>js/lib/jquery.js"><\/script>')</script>

<script	src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>window.jQuery.ui || document.write('<script src="<?php echo $this->webroot;?>assets/js/vendor/jquery-ui-1.10.0.custom.min.js"><\/script>')</script>


</head>
<body>
	<!--  <div id="ajax-loader">
		<div class="ajax-loader"></div>
	</div>-->

	<div id="wrap">
		<div id="top">
			<div class="navbar navbar-static-top">
				<div class="navbar-inner">
					<div class="container-fluid">
					<?php echo $this->element('Commons/Page/header') ?>
					<?php echo $this->element("Roles/".$role."/topnav") ?>
					</div>
				</div>
			</div>
		</div>
		<header class="head" style="height: 0;"></header>

		<div id="left">
			<?php //echo $this->element('Roles/'.$role.'/leftnav') ?>
		</div>
		<div id="content">
		 	<div class="container-fluid outer"> 
				<div class="row-fluid" id="ajax-content">
					<?php echo $this->fetch('content'); ?>
				</div>
			</div>
		</div>
	
	<div id="freeow" class="freeow freeow-bottom-right"></div>
	<?php echo $this->element('Commons/Page/ajaxlogin') ?>
</div>
<div class="modal_loader"></div>

</body>



<script	src="<?php echo $this->webroot;?>assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

<script	src="<?php echo $this->webroot;?>assets/js/vendor/bootstrap.min.js"></script>

<script type="text/javascript"	src="<?php echo $this->webroot;?>assets/js/lib/jquery.dataTables.min.js"></script>
<script type="text/javascript"	src="<?php echo $this->webroot;?>assets/js/lib/DT_bootstrap.js"></script>
<script	type="text/javascript"  src="<?php echo $this->webroot;?>assets/js/lib/responsive-tables.js"></script>
	
<script type="text/javascript"  src="<?php echo $this->webroot;?>assets/js/lib/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript"	src="<?php echo $this->webroot;?>assets/select2/select2.js"></script>
<script type="text/javascript"	src="<?php echo $this->webroot;?>assets/select2/select2.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/bootstrap-typeahead.js"></script>	
<script src="<?php echo $this->webroot;?>assets/js/jquery.simplecolorpicker.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/jquery.fastLiveFilter.js"></script>
<script src="<?php echo $this->webroot;?>js/lib/jquery.timer.js"></script>
<script type="text/javascript" src="assets/js/lib/jquery.dualListBox-1.3.min.js"></script>

<!--[if IE]><script type="text/javascript" language="javascript" src="<?php echo $this->webroot;?>js/lib/jgauge/excanvas.min.js"></script><![endif]--> <!-- Extends canvas support to IE. (Possibly buggy, need to look into this.) -->
<script language="javascript" type="text/javascript" src="<?php echo $this->webroot;?>js/lib/jgauge/jQueryRotate.min.js"></script> <!-- jQueryRotate plugin used for needle movement. -->
<script language="javascript" type="text/javascript" src="<?php echo $this->webroot;?>js/lib/jgauge/jgauge-0.3.0.a3.min.js"></script> <!-- jGauge JavaScript. -->

<script src="<?php echo $this->webroot;?>js/lib/jquery.jodometer.min.js"></script>
<script type="text/javascript"	src="http://maps.googleapis.com/maps/api/js?v=3&sensor=false&libraries=geometry,drawing"></script>

<script type="text/javascript"	src="<?php echo $this->webroot;?>js/lib/BdccArrowedPolyline.js"></script>	
<script type="text/javascript"	src="<?php echo $this->webroot;?>js/lib/gmap3.min.js"></script>
<script type="text/javascript"	src="<?php echo $this->webroot;?>assets/js/infobubble.js"></script>
<script type="text/javascript"	src="<?php echo $this->webroot;?>assets/js/markerwithlabel.js"></script>
<script type="text/javascript"  src="<?php echo $this->webroot;?>assets/js/mapHelper.js"></script>

<script type="text/javascript"  src="<?php echo $this->webroot;?>assets/js/jstorage.js"></script>
<script type="text/javascript"  src="<?php echo $this->webroot;?>assets/js/jstoragelib.js"></script>
	
<script type="text/javascript"  src="<?php echo $this->webroot;?>assets/js/main.js"></script>
<script type="text/javascript"  src="<?php echo $this->webroot;?>assets/js/scripts.js"></script>
<script type="text/javascript"  src="<?php echo $this->webroot;?>js/src/common.js"></script>

<script type="text/javascript">

	$(function() {		
		APP_HELPER.ajaxSubmitDataCallback('dashboard/left','',function(data){
			
			$('#left').html(data);
			
			APP_COMMON.initLayout("<?php echo $user['username']?>");
			APP_COMMON.clearDeviceProfiles();
			<?php if(($role=="admin")||($role=="callcenter")){?>
					
			<?php }?>	
			<?php if($role=="admin"){?>	
					//APP_COMMON.loadDashboard();
			<?php }
			else {?>
					APP_COMMON.loadUserDeviceInfo(APP_COMMON.loadDashboard);		
			<?php }?>
			
		});			
	});
	$body = $("body");

	$(document).on({
	    ajaxStart: function() { $body.addClass("loading");    },
	     ajaxStop: function() { $body.removeClass("loading"); }    
	});
</script>



</body>
</html>
