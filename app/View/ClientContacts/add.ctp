<div class="span12">
	<div class="box dark">
		<header>
			<div class="icons">
				<i class="icon-edit"></i>
			</div>
			<h5>
				<?php echo __('Add Client Contact'); ?>
			</h5>

		</header>
		<div class="in body" id="div-1">

			<?php
			echo $this->Session->flash();
			$data = $this->Js->get('#ClientContactAddForm')->serializeForm(array('isForm' => true, 'inline' => true));
			$this->Js->get('#ClientContactAddForm')->event(
					'submit',
					$this->Js->request(
							array('action' => 'add',$client_info_id),
							array(
									'data' => $data,
									'async' => true,
									'dataExpression'=>true,
									'method' => 'POST',
									'before' => 'APP_HELPER.ajax_start();',
									'success' => "APP_HELPER.ajax_stop();APP_HELPER.loadContentHolder(data, '$ajaxPlaceholder');",
									'error' => 'APP_HELPER.ajax_error(errorThrown);'
							)
					)
			);
			echo $this->Form->create('ClientContact', array('inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal'));
			?>


			<?php if($role!="single"){?>
			<fieldset id="divUserInformation">
				<legend>User Account</legend>
				<div style="display: none">
					<div class="control-group">
						<label class="control-label" for="name">Create User </label>
						<div class="controls">
							<input type="checkbox" id="chkCreateUser"
								name="data[chkCreateUser]" checked="checked">
						</div>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Username </label>
					<div class="controls">
						<?php echo $this->Form->input('User.username', array('class'=>'input-large', 'maxlength'=>20));
						echo $this->Form->error('User.username'); ?>
						<div id="username_ajax_result"></div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">Password </label>
					<div class="controls">
						<?php echo $this->Form->input('User.password', array('class'=>'input-large'));
						echo $this->Form->error('User.password'); ?>
					</div>
				</div>
			</fieldset>
			<?php }?>
			<fieldset>
				<legend>Contact Information</legend>
				<?php if($client_info_id==null){?>
				<div class="control-group">
					<label class="control-label" for="name">Client Info </label>
					<div class="controls">
						<?php echo $this->Form->input('ClientContact.client_info_id', array('class'=>'input-large'));
						echo $this->Form->error('ClientContact.client_info_id'); ?>
					</div>
				</div>

				<?php }else{ echo $this->Form->hidden('ClientContact.client_info_id',array('value'=>$client_info_id)); 
}?>

				<div class="control-group">
					<label class="control-label" for="name">Name<span class="mandatory">*</span>
					</label>
					<div class="controls">
						<?php echo $this->Form->input('ClientContact.name', array('class'=>'input-large', 'maxlength'=>128));
						echo $this->Form->error('ClientContact.name'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">National ID </label>
					<div class="controls">
						<?php echo $this->Form->input('ClientContact.nationalid', array('class'=>'input-large', 'maxlength'=>17));
						echo $this->Form->error('ClientContact.nationalid'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">Email </label>
					<div class="controls">
						<?php echo $this->Form->input('ClientContact.email', array('class'=>'input-large', 'maxlength'=>64));
						echo $this->Form->error('ClientContact.email'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">Phone </label>
					<div class="controls">
						<?php echo $this->Form->input('ClientContact.phone', array('class'=>'input-large', 'maxlength'=>30));
						echo $this->Form->error('ClientContact.phone'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">Mobile<span
						class="mandatory">*</span>
					</label>
					<div class="controls">
						<?php echo $this->Form->input('ClientContact.mobile', array('class'=>'input-large', 'maxlength'=>20));
						echo $this->Form->error('ClientContact.mobile'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">Mobile</label>
					<div class="controls">
						<?php echo $this->Form->input('ClientContact.mobile_home', array('class'=>'input-large', 'maxlength'=>20));
						echo $this->Form->error('ClientContact.mobile_home'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">Mobile</label>
					<div class="controls">
						<?php echo $this->Form->input('ClientContact.mobile_office', array('class'=>'input-large', 'maxlength'=>20));
						echo $this->Form->error('ClientContact.mobile_office'); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Fax </label>
					<div class="controls">
						<?php echo $this->Form->input('ClientContact.fax', array('class'=>'input-large', 'maxlength'=>64));
						echo $this->Form->error('ClientContact.fax'); ?>
					</div>
				</div>

			</fieldset>

			<div class="form-actions">
				<button type="submit" class="btn btn-danger btn"
					id="contactSubmitId">Submit</button>
				&nbsp;&nbsp;
				<button type="reset" class="btn">Reset</button>
			</div>
			<?php
			echo $this->Form->end();
			echo $this->Js->writeBuffer();
			?>
		</div>
	</div>
</div>

<script>
	$(function() {
		APP_COMMON.initPage('Add Client Contacts');
		$(this).closest('form').find("input[type=text], textarea, input[type=select],input[type=password]").val("");
		$("#username_ajax_result").text('');
		$('#ajax-page-title').html('<i class="icon-user"></i> Client Contact : Add');	 
		
		$('#chkCreateUser').prop('checked',<?php echo $chk?>);
		/*
		if(<?php echo $chk?>){
			$('#divUserInformation').show(); 
		}else{
			$('#divUserInformation').hide();
		}*/
		$('#divUserInformation').show();
		$('#chkCreateUser').click(function(){
		    if (this.checked) {
		      	$('#divUserInformation').show();  
		    }else{
		      	$('#divUserInformation').hide();  
			}
		}) ;
		$("#username_ajax_result").text('');
		$("#UserUsername").focusout(function() {
			$("#username_ajax_result").css('display','none');
			var username = $("#UserUsername").val();
			if(username==''){
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
