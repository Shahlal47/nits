<div class="span12">
	<div class="box dark">
		<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5>
		<?php echo __('Add User'); ?>
		</h5>
		<!-- <div class="toolbar">
			<ul class="nav">
				<li><a href="javascript:;"
					onclick="APP_HELPER.ajaxRequestModelAction('users/index');"> <i
						class="icon-list-alt"></i> List </a>
				</li>
			</ul>
		</div>
		 -->
		</header>
		<div class="in body" id="div-1">

		<?php
		echo $this->Session->flash();
		$data = $this->Js->get('#UserAddForm')->serializeForm(array('isForm' => true, 'inline' => true));
		$this->Js->get('#UserAddForm')->event(
					'submit',
		$this->Js->request(
		array('action' => 'add'),
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
						echo $this->Form->create('User', array('inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal'));
						?>
			<fieldset>
				
				<div class="control-group">
					<label class="control-label" for="name">Username </label>
					<div class="controls">
					<?php echo $this->Form->input('username', array('class'=>'input-large', 'maxlength'=>30));
					echo $this->Form->error('username'); ?>
					<div id="username_ajax_result"></div>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Password </label>
					<div class="controls">
					<?php echo $this->Form->input('password', array('class'=>'input-large'));
					echo $this->Form->error('password'); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Email </label>
					<div class="controls">
					<?php echo $this->Form->input('email', array('class'=>'input-large', 'maxlength'=>64));
					echo $this->Form->error('email'); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Role </label>
					<div class="controls">
					<?php echo $this->Form->input('role', array('class'=>'input-large', 'options' => $roles));
					echo $this->Form->error('role'); ?>
					</div>
				</div>

				<div class="control-group" style="display: none;">
					<label class="control-label" for="name">Active </label>
					<div class="controls">
					<?php echo $this->Form->input('active', array('class'=>'input-large', 'checked'=>true));
					echo $this->Form->error('active'); ?>
					</div>
				</div>

				<div class="form-actions">
					<button type="submit" class="btn btn-danger btn">Submit</button>
					&nbsp;&nbsp;
					<button type="reset" class="btn">Reset</button>
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
	$(function() {
		APP_COMMON.initPage('Add User');
		$(this).closest('form').find("input[type=text], textarea, input[type=select],input[type=password]").val("");
		$("#username_ajax_result").text('');	
		$("#UserUsername").focusout(function() {
			$("#username_ajax_result").css('display','none');
			var username = $("#UserUsername").val();
			if(username == ""){
				return;
			}
			if(/^[a-zA-Z0-9-]*$/.test(username) == false) {
				$("#username_ajax_result").attr('class', 'ajax_error');
				$("#username_ajax_result").text(' Illegal Characters');
				$("#username_ajax_result").css('display','inline');
				return;
			}
			APP_HELPER.ajaxLoadCallback('users/ajax_check_username/'+username,function(data){
				if (data.inuse) {
					$("#username_ajax_result").attr('class','ajax_success');
					$("#username_ajax_result").text('Username is available');
				} else {
					$("#username_ajax_result").attr('class', 'ajax_error');
					$("#username_ajax_result").text('Username is already in use');
				}
				$("#username_ajax_result").css('display','inline');
			});
	      });

		
	});
</script>
