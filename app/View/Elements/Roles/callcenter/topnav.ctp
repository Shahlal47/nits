<div class="btn-toolbar topnav">
	<div class="btn-group">
		<a data-placement="bottom" data-original-title="Show / Hide Sidebar"
			rel="tooltip" class="btn btn-success" id="ccl_changeSidebarPos"><i
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
			</a></li>
			<li><a href="<?php echo $this->webroot;?>logout"> <i class="icon-off"></i>
					Logout
			</a></li>
		</ul>
	</div>
</div>
<div class="nav-collapse collapse">

	<ul class="nav" id="admin-top-menu">
		<li class=""><a href="<?php echo $this->webroot;?>"><i
				class="icon-dashboard topnav-icon"></i> Dashboard</a>
		
		<li class="menu-ajax"><a href="#/trackerTracks/getExpiredDevices"><i
				class="icon-time topnav-icon"></i> Expired Devices</a>
		</li>
		<li class="menu-ajax"><a
			href="#/trackerTracks/getResponseDataFromDevice"><i
				class="icon-eye-open topnav-icon"></i> Non-Responsive Devices</a>
		</li>
	</ul>

</div>
<script type="text/javascript">
$('.dropdown-menu').mouseleave(		
function(){
	$(this).parent().removeClass('open');	
});
</script>
