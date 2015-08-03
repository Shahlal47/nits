<div class="span12">
	<div class="box">
		<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5>Change Password</h5>
		</header>
		<div class="in body" id="div-1">
		
				<?php
		echo $this->Session->flash();
		$data = $this->Js->get('#UserChangePasswordForm')->serializeForm(array('isForm' => true, 'inline' => true));
		$this->Js->get('#UserChangePasswordForm')->event(
					'submit',
		$this->Js->request(
		array('controller' => 'users', 'action'	 => 'change_password'),
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
				<?php
					if( !empty($hash))
					{
						echo $this->Form->input('hash',array('value' => $hash,'type' => 'hidden'));
					}
				?>
				<div class="control-group">
					<label class="control-label" for="name">New password </label>
					<div class="controls">
					<?php echo $this->Form->input('password', array('class'=>'input-large'));
					echo $this->Form->error('password'); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Confirm new password</label>
					<div class="controls">
					<?php echo $this->Form->input('re_password', array('type'=>'password', 'class'=>'input-large'));
					echo $this->Form->error('re_password'); ?>
					</div>
				</div>

				<div class="form-actions">
					<button type="submit" class="btn btn-danger btn">Submit</button>
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
		APP_COMMON.initPage('Change Password');
	});
</script>
