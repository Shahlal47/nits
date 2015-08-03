
<div class="span12 inner">

	<div class="box">
		<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5>List Client Info: <?php echo $clientInfo['ClientInfo']['name']?></h5>
		
		</header>
		
		<div class="btn-toolbar" style="margin-left: 10px;">
			<div class="btn-group">
				<button data-toggle="dropdown" class="btn dropdown-toggle">
					Client Info <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a href="javascript:;" onclick="APP_HELPER.ajaxLoad('clientInfos/edit/<?php echo $clientInfo['ClientInfo']['id']?>','#ajaxClientInfo');">
					Edit</a></li>
					<li><a href="javascript:;" onclick="APP_HELPER.loadIframe('clientInfos/logo/<?php echo $clientInfo['ClientInfo']['id']?>','#ajaxClientInfo');">
					Logo</a></li>
					<!-- <li><a href="#">Alerts</a></li>  -->
					<li class="divider"></li>
					<li><a href="javascript:;" onclick="APP_HELPER.ajaxLoad('users/client_users/<?php echo $clientInfo['ClientInfo']['id']?>','#ajaxClientInfo');"
					>Login User List</a></li>
				</ul>
			</div>
			<div class="btn-group">
				<button data-toggle="dropdown"
					class="btn dropdown-toggle">
					Devices <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<?php if(!isset($devicecountflag)){?>
					<li><a href="javascript:;" onclick="APP_HELPER.ajaxLoad('clientDevices/add/<?php echo $clientInfo['ClientInfo']['id']?>','#ajaxClientInfo');"
					>Add</a></li>
					<?php }?>
					<li><a href="javascript:;" onclick="APP_HELPER.ajaxLoad('clientDevices/index/<?php echo $clientInfo['ClientInfo']['id']?>','#ajaxClientInfo');"
					>List</a></li>
				</ul>
			</div>
			<!-- 
			<div class="btn-group">
				<button data-toggle="dropdown"
					class="btn dropdown-toggle">
					Person Management <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a href="javascript:;" onclick="APP_HELPER.ajaxLoad('clientPersons/add/<?php echo $clientInfo['ClientInfo']['id']?>','#ajaxClientInfo');"
					>Add</a></li>
					<li><a href="javascript:;" onclick="APP_HELPER.ajaxLoad('clientPersons/index/<?php echo $clientInfo['ClientInfo']['id']?>','#ajaxClientInfo');"
					>List</a></li>
				</ul>
			</div>
			<div class="btn-group">
				<button data-toggle="dropdown"
					class="btn dropdown-toggle">
					Vehicle Management <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a href="javascript:;" onclick="APP_HELPER.ajaxLoad('clientVehicles/add/<?php echo $clientInfo['ClientInfo']['id']?>','#ajaxClientInfo');"
					>Add</a></li>
					<li><a href="javascript:;" onclick="APP_HELPER.ajaxLoad('clientVehicles/index/<?php echo $clientInfo['ClientInfo']['id']?>','#ajaxClientInfo');"
					>List</a></li>
				</ul>
			</div>
			 -->
			 <!-- 
			<div class="btn-group">
				<button data-toggle="dropdown"
					class="btn dropdown-toggle">
					Contacts <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a href="javascript:;" onclick="APP_HELPER.ajaxLoad('clientContacts/add/<?php echo $clientInfo['ClientInfo']['id']?>','#ajaxClientInfo');"
					>Add</a></li>
					<li><a href="javascript:;" onclick="APP_HELPER.ajaxLoad('clientContacts/index/<?php echo $clientInfo['ClientInfo']['id']?>','#ajaxClientInfo');"
					>List</a></li>
				</ul>
			</div>
			 -->
			
			<div class="btn-group">
				<button data-toggle="dropdown"
					class="btn dropdown-toggle">
					Settings <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a href="javascript:;" onclick="APP_HELPER.ajaxLoad('clientReports/settings/<?php echo $clientInfo['ClientInfo']['id']?>','#ajaxClientInfo');"
					>Report Settings</a></li>
					<!-- <li><a href="javascript:;" onclick="APP_HELPER.ajaxLoad('clientAlertSettings/index/<?php echo $clientInfo['ClientInfo']['id']?>','#ajaxClientInfo');"
					>Alert Settings</a></li>  -->
				</ul>
			</div>
			<!-- 
			<div class="btn-group">
				<button data-toggle="dropdown"
					class="btn dropdown-toggle">
					User Accounts <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a href="javascript:;" onclick="APP_HELPER.ajaxLoad('users/client_users/<?php echo $clientInfo['ClientInfo']['id']?>','#ajaxClientInfo');"
					>List</a></li>
				</ul>
			</div>
 			-->
		</div>
	</div>
		
	<hr>
	<div id="ajaxClientInfo"></div>
</div>

<script>
	$(function() {
		APP_COMMON.initPage('Manage Client Information');
		$('#ajax-page-title').html('<i class="icon-user"></i> Client Info : View');
		//APP_HELPER.ajaxLoad('clientInfos/edit/<?php echo $clientInfo['ClientInfo']['id']?>','#ajaxClientInfo');
		APP_HELPER.ajaxLoad('clientDevices/index/<?php echo $clientInfo['ClientInfo']['id']?>','#ajaxClientInfo');	   
	});
</script>
