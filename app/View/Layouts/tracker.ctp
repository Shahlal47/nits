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
<!-- google font -->

<link type="text/css" rel="stylesheet"
	href="<?php echo $this->webroot;?>assets/css/bootstrap.min.css">
<link type="text/css" rel="stylesheet"
	href="<?php echo $this->webroot;?>assets/css/bootstrap-responsive.min.css">
<link type="text/css" rel="stylesheet"
	href="<?php echo $this->webroot;?>assets/Font-awesome/css/font-awesome.min.css">


<link type="text/css" rel="stylesheet"
	href="<?php echo $this->webroot;?>assets/css/DT_bootstrap.css" />
<link rel="stylesheet"
	href="<?php echo $this->webroot;?>assets/css/responsive-tables.css">

<link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/datepicker.css" />
<link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/timepicker.css" />

<link type="text/css" rel="stylesheet"
	href="<?php echo $this->webroot;?>assets/select2/select2.css" />
<!-- styles -->
<?php echo $this->Html->css('stilearn.css') ?>
<?php echo $this->Html->css('stilearn-responsive.css') ?>

<?php echo $this->Html->css('stilearn-helper.css') ?>
<?php echo $this->Html->css('stilearn-icon.css') ?>


<?php echo $this->Html->css('style.css') ?>

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<!--[if IE 7]>
        <link type="text/css" rel="stylesheet" href="<?php echo $this->webroot;?>assets/Font-awesome/css/font-awesome-ie7.min.css"/>
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

<link rel="stylesheet" href="/vts/css/jgauge.css" type="text/css" />
<!-- CSS for jGauge styling. -->
<!--[if IE]><script type="text/javascript" language="javascript" src="/vts/js/lib/jgauge/excanvas.min.js"></script><![endif]-->
<!-- Extends canvas support to IE. (Possibly buggy, need to look into this.) -->
<script language="javascript" type="text/javascript"
	src="/vts/js/lib/jgauge/jQueryRotate.min.js"></script>
<!-- jQueryRotate plugin used for needle movement. -->
<script language="javascript" type="text/javascript"
	src="/vts/js/lib/jgauge/jgauge-0.3.0.a3.min.js"></script>
<!-- jGauge JavaScript. -->

<script type="text/javascript">
	var VTS_URL_ROOT = "<?php echo $this->webroot;?>";
	var VTS_XHR=null;
	<?php	$deviceInfo = $this->requestAction('trackerTracks/get_all_devices_profile');?>
	var VTS_GROUP_device_status = <?php echo json_encode($deviceInfo['DeviceStatus']);?>;
	var VTS_GROUP_device_profiles = <?php echo json_encode($deviceInfo['DeviceProfiles']);?>;
</script>
</head>
<body>
	<div class="row-fluid">
		<div id="ajax-contents" class="span12">
		<?php echo $this->fetch('content'); ?>
		</div>
	</div>

	<?php echo $this->Html->script(
	array(
                      'lib/jquery-ui.min',
                      'lib/bootstrap.min',
	//'lib/uniform/jquery.uniform',
                      'lib/datepicker/bootstrap-datepicker',
                    	'lib/select2/select2',
						'lib/clockface',
						'lib/bootstrap-timepicker',
	//'lib/datatables/jquery.dataTables.min',
	//'lib/datatables/extras/ZeroClipboard',
	//'lib/datatables/extras/TableTools.min',
	//'lib/datatables/DT_bootstrap.js',
	//'lib/responsive-tables/responsive-tables',
                      'lib/BdccArrowedPolyline',
	//'lib/markerwithlabel',
                      'lib/gmap3.min',
	//'lib/jquery.timer.js'
                      'lib/knob/jquery.knob.js',
                      'lib/jquery.timer.js',
					  'lib/markerwithlabel',
					  'lib/infobubble',
						'lib/jquery.jodometer.min',
                      
                      'src/scripts',
						'src/common',
                      ));
                      ?>
<script type="text/javascript"  src="<?php echo $this->webroot;?>js/src/mapHelper.js"></script>
                      <?php
                      if (is_file(WWW_ROOT . 'js' . DS . $this->params->controller . '.js')) {
                      	echo $this->Html->script($this->params->controller);
                      }
                      if (is_file(WWW_ROOT . 'js' . DS . $this->params->controller . DS . $this->params->action . '.js')) {
                      	echo $this->Html->script($this->params->controller . '/' . $this->params->action);
                      }
                      ?>
<script type="text/javascript">
	$(function() {
		APP_COMMON.bindResizeDiv('#single-tracker-map',0);
		APP_COMMON.bindResizeDiv('#history_map',0);
		APP_COMMON.bindResizeDiv('#group_cluster_map',0);
	});
</script>
</body>
</html>
