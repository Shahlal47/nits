<div class="span12">
	<div class="box">
		<header>
			<div class="icons">
				<i class="icon-edit"></i>
			</div>
			<h5>User Block Status</h5>
			<div class="toolbar">
			<ul class="nav">
				<li><a href="javascript:;"
					onclick="APP_HELPER.ajaxRequestModelAction('users/blocked_users');"> <i
						class="icon-list-alt"></i> List </a>
				</li>
			</ul>
		</div>
		</header>
		<div class="in body" id="div-1">

			<?php
			echo $this->Session->flash();
			$data = $this->Js->get('#UserBlockuserForm')->serializeForm(array('isForm' => true, 'inline' => true));
			$this->Js->get('#UserBlockuserForm')->event(
					'submit',
					$this->Js->request(
							array('controller' => 'users', 'action'	 => 'blockuser/'.$userid),
							array(
									'data' => $data,
									'async' => true,
									'dataExpression'=>true,
									'method' => 'POST',
									'before' => 'APP_HELPER.ajax_start();',
									'success' => 'APP_HELPER.ajax_stop();APP_HELPER.loadContents(data);',
									'error' => 'APP_HELPER.ajax_error(errorThrown);'
							)
					)
			);
			echo $this->Form->create('User', array('inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal', 'autocomplete'=>'off'));
			?>
			<fieldset>
				<?php if(isset($username)){?>
				<div class="control-group">
					<label class="control-label" for="name">User Name </label>
					<div class="controls">
						<?php echo $this->Form->input('uname', array('class'=>'input-large', 'readonly'=>'readonly', 'value'=>$username));
						?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name"> Block Type</label>
					<div class="controls">
						<?php 
						echo $this->Form->input('block_type', array('type' => 'select', 'options' => array(''=>'--Select Block Type--', BLOCK_NO => BLOCK_NO, BLOCK_TEMP => BLOCK_TEMP, BLOCK_PERMANENT => BLOCK_PERMANENT), 'selected'=>$block_type));
					echo $this->Form->error('block_type'); ?>
					</div>
				</div>
				<?php } else{?>
				<div class="control-group">
					<label class="control-label" for="name"> User </label>
					<div class="controls">
						<?php echo $this->Form->input('id', array('class'=>'input-large', 'style'=>'display:none;'));
						echo $this->Form->error('id'); ?>

						<div class="input-append">
							<input style="width: 200px" id="searchText" type="text"
								name="data[User][searchtext]" autocomplete="off">
							<button id="btnSearch" class="btn" type="button"
								onclick="RESET_PASS.loadUserData()">Go</button>
						</div>
					</div>
				</div>
				<hr>
				<div class="control-group">
					<label class="control-label" for="name">User Name </label>
					<div class="controls">
						<?php echo $this->Form->input('uname', array('class'=>'input-large', 'readonly'=>'readonly'));
						?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name"> User Type </label>
					<div class="controls">
						<?php echo $this->Form->input('utype', array('class'=>'input-large', 'readonly'=>'readonly'));
						?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">Email </label>
					<div class="controls">
						<?php echo $this->Form->input('uemail', array('class'=>'input-large', 'readonly'=>'readonly'));
					 ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name"> Block Type</label>
					<div class="controls">
						<?php 
						echo $this->Form->input('block_type', array('type' => 'select', 'options' => array(''=>'--Select Block Type--', BLOCK_TEMP => BLOCK_TEMP, BLOCK_PERMANENT => BLOCK_PERMANENT)));
					echo $this->Form->error('block_type'); ?>
					</div>
				</div>

				<?php }?>
				<div class="form-actions">
					<button type="submit" class="btn btn-danger btn">Save Block Status</button>
				</div>
			</fieldset>
			<?php
			echo $this->Form->end();
			echo $this->Js->writeBuffer();
			?>
		</div>
	</div>
</div>

<script>

var RESET_PASS={
	loadUserData:function(){
		$(".typeahead").hide();
		var str = $("#searchText").val();
		if(str.length > 3){
			APP_HELPER.ajaxLoadCallback('users/loadUserData/'+str, function(data){
				if(data.User){
					$("#UserUtype").val(data.UserType.name);
					$("#UserUname").val(data.User.username);
					$("#UserUemail").val(data.User.email);
					$('#UserId').val(data.User.id);
					$("input[type=password]").val("");
					}
				else{
					$("#UserUtype").val('');
					$("#UserUname").val('');
					$("#UserUemail").val('');
					$('#UserId').val('');
					$("input[type=password]").val("");
					}
				});
			}
		else{
			$("#UserUtype").val('');
			$("#UserUname").val('');
			$("#UserUemail").val('');
			$('#UserId').val('');
			$("input[type=password]").val("");
			alert("Provide at least 4 characters");
			}
		
	},
	displayResult:function (item, val, text) 
	{
	   /* $('#UserId').val(val); 
	    APP_HELPER.ajaxLoadCallback('users/loadUserData/'+str, function(data){
			if(data){
				$("#UserUtype").val(data.UserType.name);
				$("#UserUname").val(data.User.username);
				$("#UserUemail").val(data.User.email);
				$('#UserId').val(data.User.id);
				$("input[type=password]").val("");
				}
			else{
				$("#UserUtype").val('');
				$("#UserUname").val('');
				$("#UserUemail").val('');
				$('#UserId').val('');
				$("input[type=password]").val("");
				}
			}); */ 
	},
	user_search:function () 
	{
		$('#searchText').typeahead({
	        ajax: { url: APP_URL_ROOT+'users/search', triggerLength: 1 },
			display: 'name',
	        val: 'id',        
	        itemSelected: RESET_PASS.displayResult
	    });  
	}	
}
	
$(function() {
	APP_COMMON.initPage('User Block Status');
	RESET_PASS.user_search();
});
	
</script>
