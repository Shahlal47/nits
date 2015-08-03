<div class="span12">
	<div class="box">
		<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5>
		<?php echo __('Add Client Alert Setting'); ?>
		</h5>
		<div class="toolbar">
			<ul class="nav">
				<li><a href="javascript:;"
					onclick="APP_HELPER.ajaxLoad('clientAlertSettings/index/<?php echo $client_info_id?>','<?php echo $ajaxPlaceholder?>');"> <i
						class="icon-list-alt"></i> List </a>
				</li>
			</ul>
		</div>

		</header>

		<div class="in body" id="div-1">

		<?php
		echo $this->Session->flash();
		$data = $this->Js->get('#ClientAlertSettingAddForm')->serializeForm(array('isForm' => true, 'inline' => true));
		$this->Js->get('#ClientAlertSettingAddForm')->event(
					'submit',
		$this->Js->request(
		array('action' => 'add',$client_info_id),
		array(
						'data' => $data,
						'async' => true,    
						'dataExpression'=>true,
						'method' => 'POST',
						'before' => 'APP_HELPER.ajax_start();',
						'success' => "APP_HELPER.ajax_stop();APP_HELPER.loadContentHolder(data,'$ajaxPlaceholder');",
						'error' => 'APP_HELPER.ajax_error(errorThrown);'
						)
						)
						);
						echo $this->Form->create('ClientAlertSetting', array('inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal'));
						?>
			<fieldset>
				<?php echo $this->Form->hidden('client_info_id',array('value'=>$client_info_id));?>

				<div class="control-group">
					<label class="control-label" for="name">Client Contact </label>
					<div class="controls">
					<?php echo $this->Form->input('client_contact_id', array('class'=>'input-large','empty'=>'-- Select a Contact --'));
					echo $this->Form->error('client_contact_id'); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Client Device </label>
					<div class="controls">
					<?php echo $this->Form->input('client_device_id', array('class'=>'input-large'));
					echo $this->Form->error('client_device_id'); ?>
					</div>
				</div>


				<div class="control-group">
					<label class="control-label" for="name">Alert Type </label>
					<div class="controls">
					<?php echo $this->Form->input('alert_type_id', array('class'=>'input-large'));
					echo $this->Form->error('alert_type_id'); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">SMS </label>
					<div class="controls">
					<?php echo $this->Form->input('is_sms', array('class'=>'input-large'));
					echo $this->Form->error('is_sms'); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Email </label>
					<div class="controls">
					<?php echo $this->Form->input('is_email', array('class'=>'input-large'));
					echo $this->Form->error('is_email'); ?>
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

		APP_COMMON.initPage('Alert Settings');
		

		$('#ajax-page-title').html('<i class="icon-user"></i> Client Alert Setting : Add');	   
		<?php if($client_type_id==2){?>
		$('#ClientAlertSettingClientContactId').bind('change',function(){
			var id = $(this).val();
			var url = 'clientContactDevices/get_device_names/'+id;
			var data = '';
			$('#ClientAlertSettingClientDeviceId').html('');			
			APP_HELPER.ajaxSubmitDataCallback(url,data,function(data){
				var dt = JSON.parse(data);
				var t = '';					
				$.each(dt,function(k,v){
					t+= '<option value="'+v.ClientContactDevice.id+'">'+v.ClientDevice.name+'</option>';						
				});
				$('#ClientAlertSettingClientDeviceId').html(t);
			});
		});
		<?php }?>
	});
</script>
