<!-- section header -->
        <header class="header">
            <!--nav bar helper-->
            <div class="navbar-helper">
                <div class="row-fluid">
                    <!--panel site-name-->
                    <div class="span2">
                        <div class="panel-sitename">						
                            <h2><a href="/"><span class="color-teal">VTS</span>App</a></h2>
                        </div>
                    </div>
                    <!--/panel name-->

                    <div class="span4 pull-right">
                        <!--panel button ext-->
                        <div class="panel-ext" style="float:right; margin-right:20px;">
                            
                            <div class="pull-left" style="margin-right:10px;">                            
                                
									<span class="label label-info"><?php echo $user_info['User']['username'].' ['.$user_info['ClientContact']['email'].']';?></span>

                            </div>
                            <div class="btn-group user-group">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                	<?php echo $this->Html->image('user-thumb.jpg', array('alt' => 'User-Pic', 'class'=>"corner-all"));?>
                                    <button class="btn btn-small btn-inverse">John Doe</button> <!--this for display on tablet and phone device-->
                                </a>
                                <ul class="dropdown-menu dropdown-user" role="menu" aria-labelledby="dLabel">
                                    <li>
                                        <div class="media">
                                            <a class="pull-left" href="#">
			                                	<?php echo $this->Html->image('user.jpg', array('alt' => 'User-profile', 'class'=>"img-circle"));?>
                                            </a>
                                            <div class="media-body description">
                                                <p><strong>Username:</strong> <?php echo $user_info['username'];?></p>
                                                <p><strong>Buyer No:</strong> <?php echo $user_info['name'];?></p>
                                                <p><strong>Contact :</strong> <?php echo $user_info['name'];?></p>
                                                <p><strong>Email   :</strong> <?php echo $user_info['email'];?></p>
                                                                                              
                                                <!-- <a href="userprofile.html" class="btn btn-primary btn-small btn-block">View Profile</a> -->
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-footer">
                                        <div class="">
                                            <a class="btn btn-small" href="users/logout"><i class="icofont-signout"></i> Logout</a>                                            
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div><!--panel button ext-->
                    </div>
                </div>
            </div><!--/nav bar helper-->
        </header>