	<h5 style="float: left">
		<i class="icon-th"></i> Tracker Monitors
	</h5>
<div class="btn-toolbar topnav">

	<div class="btn-group">
		<a data-placement="bottom" data-original-title="Show / Hide Sidebar"
			rel="tooltip" class="btn btn-success" id="ccl_changeSidebarPos"> <i
			class="icon-resize-horizontal"></i> </a>
	</div>
	<div class="btn-group">
		<a class="btn btn-inverse" href="<?php echo $this->webroot;?>logout"><i
			class="icon-off"></i> <?php echo $user['username']?> </a> <a
			class="btn btn-inverse dropdown-toggle" data-toggle="dropdown"
			href="#"> <span class="caret"></span>
		</a>

		<ul class="dropdown-menu pull-right">
			<li><a href="<?php echo $this->webroot;?>logout"> <i class="icon-off"></i>
					Logout
			</a>
			</li>
		</ul>
	</div>
</div>
