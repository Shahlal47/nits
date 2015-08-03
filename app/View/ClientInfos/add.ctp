<div class="span12">
	<div class="box">
		<header>
			<div class="icons">
				<i class="icon-edit"></i>
			</div>
			<h5>
				<?php echo __('Add Client Information'); ?>
			</h5>
			<div class="toolbar">
				<ul class="nav">
					<li>
						<a href="javascript:;" onclick="APP_HELPER.ajaxRequestModelAction('clientInfos/index');">
							<i class="icon-list-alt"></i> List
						</a>
					</li>
				</ul>
			</div>
		</header>
		<div class="in body" id="div-1">
			<?php
			echo $this->Session->flash();
			$data = $this->Js->get('#ClientInfoAddForm')->serializeForm(array('isForm' => true, 'inline' => true));
			$this->Js->get('#ClientInfoAddForm')->event(
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
			echo $this->Form->create('ClientInfo', array('inputDefaults' => array('label' => false,'div' => false, 'error' => false, 'novalidate'=>'novalidate'), 'class'=>'form-horizontal'));
			?>
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="name">Client Type</label>
					<div class="controls">
						<?php echo $this->Form->input('ClientInfo.client_type_id', array('class'=>'input-large'));
						echo $this->Form->error('ClientInfo.client_type_id'); ?>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>Login Information</legend>
				<div>
					<div class="control-group">
						<label class="control-label" for="name">Login Name<span
							class="">*</span>
						</label>
						<div class="controls">
							<?php echo $this->Form->input('User.username', array('class'=>'input-large','value'=>$username, 'maxlength'=>30));
						echo $this->Form->error('User.username'); ?>
							<div id="username_ajax_result"></div>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="name">Password<span
							class="">*</span>
						</label>
						<div class="controls">
							<?php echo $this->Form->input('User.password', array('class'=>'input-large','value'=>$password));
						echo $this->Form->error('User.password'); ?>
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>Client Information</legend>
				<div>
					<div class="control-group">
						<label class="control-label" for="name" id="lblName">Name<span
							class="mandatory">*</span>
						</label>
						<div class="controls">
							<?php echo $this->Form->input('ClientInfo.name', array('class'=>'input-large', 'maxlength'=>128));
						echo $this->Form->error('ClientInfo.name'); ?>
						</div>
					</div>


					<div class="control-group" id="divCompanyType">
						<label class="control-label" for="name">Company Type</label>
						<div class="controls">
							<?php echo $this->Form->input('ClientInfo.company_type_id', array('class'=>'input-large'));
						echo $this->Form->error('ClientInfo.company_type_id'); ?>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="name" id="lblName">Buyer No </label>
						<div class="controls">
							<?php echo $this->Form->input('ClientInfo.buyerno', array('class'=>'input-large'));
						echo $this->Form->error('ClientInfo.buyerno'); ?>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="name">Address </label>
						<div class="controls">
							<?php echo $this->Form->input('ClientInfo.address', array('class'=>'input-large'));
						echo $this->Form->error('ClientInfo.address'); ?>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="website" id="lblName">Website</label>
						<div class="controls">
							<?php echo $this->Form->input('ClientInfo.website', array('class'=>'input-large'));
						echo $this->Form->error('ClientInfo.website'); ?>
						</div>
					</div>
				</div>
				</fieldset>
				<fieldset>
					<legend>Client Contact Detail</legend>
					<div>
					<div class="control-group" id="divContactName">
						<label class="control-label" for="name">Contact Person Name<span
							class="mandatory">*</span>
						</label>
						<div class="controls">
							<?php echo $this->Form->input('ClientContact.name', array('class'=>'input-large', 'maxlength'=>64));
						echo $this->Form->error('ClientContact.name'); ?>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="name" id="lblName">National ID </label>
						<div class="controls">
							<?php echo $this->Form->input('ClientContact.nationalid', array('class'=>'input-large', 'maxlength'=>17));
						echo $this->Form->error('ClientContact.nationalid'); ?>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="name">Phone </label>
						<div class="controls">
							<?php echo $this->Form->input('ClientContact.phone', array('class'=>'input-large'));
						echo $this->Form->error('ClientContact.phone'); ?>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="name">Mobile<span
							class="mandatory">*</span>
						</label>
						<div class="controls">
							<?php echo $this->Form->input('ClientContact.mobile', array('class'=>'input-large','maxlength'=>20));
						echo $this->Form->error('ClientContact.mobile'); ?>
						</div>
					</div>

					<div class="control-group">
						<!--<label class="control-label" for="name">Mobile<span
							class="mandatory">*</span>
						</label>-->
						<label class="control-label" for="name">Mobile (Home) </label>
                        <div class="controls">
							<?php echo $this->Form->input('ClientContact.mobile_home');
						//echo $this->Form->error('ClientContact.mobile_home'); 
						?>
						</div>
					</div>

					<div class="control-group">
						<!--<label class="control-label" for="name">Mobile<span
							class="mandatory">*</span>
						</label>-->
						<label class="control-label" for="name">Mobile (Office)</label>
                        <div class="controls">
							<?php echo $this->Form->input('ClientContact.mobile_office');
						//echo $this->Form->error('ClientContact.mobile_office'); 
						?>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="name">Email</label>
						<div class="controls">
							<?php echo $this->Form->input('ClientContact.email', array('class'=>'input-large', 'maxlength'=>64));
						echo $this->Form->error('ClientContact.email'); ?>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="name">Fax </label>
						<div class="controls">
							<?php echo $this->Form->input('ClientContact.fax', array('class'=>'input-large','maxlength'=>30));
						echo $this->Form->error('ClientContact.fax'); ?>
						</div>
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
		APP_COMMON.initPage('Add Client Information');
		$('#ajax-page-title').html('<i class="icon-user"></i> Client Info : Add');
		$(this).closest('form').find("input[type=text], textarea, input[type=select],input[type=password]").val("");
		$("#username_ajax_result").text('');
		if($('#ClientInfoClientTypeId').val()==1){
			$('#divCompanyType').hide();
			$('#divContactName').hide();
			$('#lblName').html('Name<span class="mandatory">*</span>');
		}else{
			$('#lblName').html('Business Name<span class="mandatory">*</span>');
		}
		$('#ClientInfoClientTypeId').bind('change',function(){
			$(this).closest('form').find("input[type=text], textarea, input[type=select],input[type=password]").val("");
			$("#username_ajax_result").text('');
			var val = $(this).val();
			if(val==1){
				$('#divCompanyType').hide();
				$('#divContactName').hide();
				$('#lblName').html('Name<span class="mandatory">*</span>');
			}else{
				$('#divCompanyType').show();
				$('#divContactName').show();
				$('#lblName').html('Business Name<span class="mandatory">*</span>');
			}
		});	
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
