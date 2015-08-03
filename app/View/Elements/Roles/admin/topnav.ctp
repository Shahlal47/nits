
<div class="btn-toolbar topnav">
	<div class="btn-group">
		<a data-placement="bottom" data-original-title="Show / Hide Sidebar"
			rel="tooltip" class="btn btn-success" id="changeSidebarPos"><i
			class="icon-resize-horizontal"></i> </a>
	</div>
	<div class="btn-group">
		<a class="btn btn-inverse" href="<?php echo $this->webroot;?>logout"><i
			class="icon-off"></i> <?php echo $user['username']?> </a> <a
			class="btn btn-inverse dropdown-toggle" data-toggle="dropdown"
			href="#"> <span class="caret"></span>
		</a>
		<ul class="dropdown-menu pull-right">
			<li class="menu-ajax"><a href="#/users/change_password"> <i
					class="icon-key"></i> Change Password
			</a>
			</li>
			<li><a href="<?php echo $this->webroot;?>logout"> <i class="icon-off"></i>
					Logout
			</a>
			</li>
		</ul>
	</div>
</div>
<div class="nav-collapse collapse">
	<!-- .nav -->
	<ul class="nav" id="admin-top-menu">
		<!-- 
		<li class="menu-ajax"><a href="#/dashboard/dashboard"><i class="icon-dashboard topnav-icon"></i> Dashboard</a>
		</li>
		 -->
		<li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle"
			href="javascript:;"><i class="icon-cogs topnav-icon"></i> Settings <b
				class="caret"></b> </a>
			<ul class="dropdown-menu">
				<li class="menu-ajax"><a href="#/companyTypes"><i class="icon-cog"></i>
						Company Type</a>
				</li>
<!-- 				<li class="menu-ajax"><a href="#/clientTypes"><i class="icon-cog"></i> -->
<!-- 						Client Type</a> -->
<!-- 				</li> -->
<!-- 				<li class="divider"></li> -->
				<li class="menu-ajax"><a href="#/accountTypes"><i class="icon-cog"></i>
						Acount Subscription Type</a>
				</li>
<!-- 				<li class="menu-ajax"><a href="#/userTypes"><i class="icon-cog"></i> -->
<!-- 						User Type</a> -->
<!-- 				</li> -->
<!-- 				<li class="divider"></li> -->

<!-- 				<li class="menu-ajax"><a href="#/deviceTypes"><i class="icon-cog"></i> -->
<!-- 						Device Type</a> -->
<!-- 				</li> -->
				<li class="menu-ajax"><a href="#/expenseTypes"><i class="icon-cog"></i>
						Expense Type</a>
				</li>
				<li class="menu-ajax"><a href="#/vehicleModels"><i class="icon-cog"></i>
						Vehicle Model</a>
				</li>
<!-- 				<li class="menu-ajax"><a href="#/alertTypes"><i class="icon-cog"></i> -->
<!-- 						Alert Type</a> -->
<!-- 				</li> -->
				<!-- 
				<li class="menu-ajax"><a href="#/sensorTypes"><i class="icon-cog"></i> Sensor Type</a>
				</li> -->
<!-- 				<li class="divider"></li> -->
<!-- 				<li class="menu-ajax"><a href="#/geofenceTypes"><i class="icon-cog"></i> -->
<!-- 						Geo-Fence Type</a> -->
<!-- 				</li> -->
<!-- 				<li class="menu-ajax"><a href="#/expenseTypes"><i class="icon-cog"></i> -->
<!-- 						Expense Type</a> -->
<!-- 				</li> -->
				<!-- <li class="menu-ajax"><a href="#/poiTypes"><i class="icon-cog"></i> POI Type</a>
				</li> -->
<!-- 				<li class="divider"></li> -->
<!-- 				<li class="menu-ajax"><a href="#/reportSettings"><i class="icon-cog"></i> -->
<!-- 						Reports</a> -->
<!-- 				</li> -->
			</ul></li>
		<li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle"
			href="#"><i class="icon-group topnav-icon"></i> Users <b
				class="caret"></b> </a>
			<ul class="dropdown-menu">
				<li class="menu-ajax"><a href="#/users/add"><i class="icon-user"></i>
						Add User</a>
				</li>
				<li class="divider"></li>
<!-- 				<li class="menu-ajax"><a href="#/users/index/admin"><i -->
<!-- 						class="icon-group"></i> Admin Users</a> -->
<!-- 				</li> -->
				<li class="menu-ajax"><a href="#/users/index/callcenter"><i
						class="icon-group"></i> Call-Center Users</a>
				</li>
				<li class="menu-ajax"><a href="#/users/index/accounts"><i
						class="icon-group"></i> Accounts Users</a>
				</li>
				<li class="menu-ajax"><a href="#/users/index/super"><i
						class="icon-group"></i> Group Users</a>
				</li>
				<!-- 				<li class="menu-ajax"><a href="#/users/index/group"><i class="icon-group"></i> Group Users</a> -->
				<!-- 				</li> -->
				<li class="menu-ajax"><a href="#/users/index/single"><i
						class="icon-group"></i> Single Users</a>
				</li>
<!-- 				<li class="menu-ajax"><a href="#/users/index/"><i class="icon-group"></i> -->
<!-- 						All Users</a> -->
<!-- 				</li> -->
				<li class="divider"></li>
				<li class="menu-ajax"><a href="#/users/blocked_users"><i
						class="icon-group"></i> Blocked Users</a>
				</li>
			</ul>
		</li>

		<li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle"
			href="#"><i class="icon-list-alt topnav-icon"></i> Transfer <b
				class="caret"></b> </a>
			<ul class="dropdown-menu">
				<li class="menu-ajax"><a href="#/clientInfos/transfer"><i
						class="icon-user"></i> Client Update (Single User to Group User)</a>
				</li>
<!-- 				<li class="menu-ajax"><a href="#/clientInfos/transfergroup"><i -->
<!-- 						class="icon-group"></i> Client Transfer</a> -->
<!-- 				</li> -->
				<li class="menu-ajax"><a href="#/clientDevices/transfer/"><i
						class="icon-table"></i> Device transfer</a>
				</li>

			</ul>
		</li>

		<li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle"
			href="#"><i class="icon-list-alt topnav-icon"></i> Reports <b
				class="caret"></b> </a>
			<ul class="dropdown-menu">
				<li class="menu-ajax"><a
					href="#/userLogs/index/<?php echo $user['id']?>"><i
						class="icon-table"></i> User Login History</a>
				</li>
				<li class="menu-ajax"><a href="#/clientDevices/unitSimDevice"><i
						class="icon-group"></i> Unit Sim Report</a>
				</li>

			</ul>
		</li>
	</ul>
</div>
<script type="text/javascript">
$('.dropdown-menu').mouseleave(		
function(){
	$(this).parent().removeClass('open');	
});

</script>
