<div class="btn-toolbar topnav">
	<div class="btn-group">
		<a data-placement="bottom" data-original-title="Show / Hide Sidebar"
			rel="tooltip" class="btn btn-success" id="changeSidebarPos"> <i
			class="icon-resize-horizontal"></i> </a>
	</div>
	<!-- 
	<div class="btn-group  menu-ajax">
		<a class="btn btn-danger" rel="tooltip" data-original-title="Add Expenses"
			href="#/clientExpenses/add"
			data-placement="bottom"> <i class="icon-money"></i></a>
	</div>
	
	<div class="btn-group">
		<a class="btn btn-inverse" rel="tooltip" data-original-title="Alerts"
			data-placement="bottom"> <i class="icon-bell-alt"></i> <span
			class="label label-warning">5</span> </a>
	</div>
	 -->
	<div class="btn-group">
		<a class="btn btn-inverse"
			href="<?php echo $this->webroot;?>logout"><i class="icon-off"></i> 
			<?php echo $user['username']?>
		</a>
		<a class="btn btn-inverse dropdown-toggle" data-toggle="dropdown" href="#">		
			<span class="caret"></span>
		</a>
		<ul class="dropdown-menu pull-right">
		<!--  
			<li>
				<a href="#/clientInfos/edit"> 
					<i class="icon-phone-sign"></i> Change Contact 
				</a>
			</li>
			 -->
						<li class="menu-ajax">
			<a href="#/users/change_password"> 
				<i class="icon-key"></i> Change Password </a>
			</li>

			<li>
			<a href="<?php echo $this->webroot;?>logout"> 
				<i class="icon-off"></i> Logout </a>
			</li>
		</ul>	
	</div>
</div>
<div class="nav-collapse collapse">
	<!-- .nav -->
	<ul class="nav" id="admin-top-menu">
		<li class=""><a href="<?php echo $this->webroot;?>"><i class="icon-dashboard topnav-icon"></i> Dashboard</a>
		</li>
		<li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle"
			href="#"><i class="icon-user topnav-icon"></i> Contacts <b class="caret"></b> </a>
			<ul class="dropdown-menu">
			<li class="menu-ajax"><a
				href="#/clientContacts/index/<?php echo $user['client_info_id']?>"><i
					class="icon-list"></i> List</a></li>

			</ul>
		</li>
		<!-- <li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle"
			href="#"><i class="icon-cogs topnav-icon"></i> Settings <b class="caret"></b> </a>
			<ul class="dropdown-menu">
			<li class="menu-ajax"><a
				href="#/clientAlertSettings/index/<?php echo $user['client_info_id']?>"><i
					class="icon-cog"></i> Tracker-Alert Settings</a></li>

			</ul>
		</li>
		 
		<li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle"
			href="#"><i class="icon-list-alt topnav-icon"></i> User <b class="caret"></b> </a>
			<ul class="dropdown-menu">
				<li class="menu-ajax"><a href="#/userLogs/index/<?php echo $user['id']?>"><i
						class="icon-table"></i> User Login History</a>
				</li>

			</ul>
		</li>
		-->
		<li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle"
			href="#"><i class="icon-money topnav-icon"></i> Expense <b
				class="caret"></b> </a>
			<ul class="dropdown-menu">
				<li class="menu-ajax"><a href="#/clientExpenses/index"><i
						class="icon-money"></i> Expense List</a></li>
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
