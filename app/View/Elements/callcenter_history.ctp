
<h5 style="float: left">
	<i class="icon-th"></i> Live Tracking
</h5>
<div class="btn-toolbar topnav">

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
