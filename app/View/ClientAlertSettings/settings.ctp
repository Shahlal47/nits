<!-- .span12 -->
<div class="span12">
	<div class="box">
		<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5>Client Device And Alert Settings</h5>
		<div class="toolbar">
			<ul class="nav">
				<li><a href="#" id="btnNew"> <i class="icon-plus"></i> New </a>
				</li>
				<li><a href="#actionTable" data-toggle="collapse"
					class="accordion-toggle minimize-box"> <i class="icon-chevron-up"></i>
				</a>
				</li>
			</ul>

		</div>
		</header>
		<div id="actionTable" class="body collapse in">
			<table class="table table-bordered responsive">
				<thead>
					<tr>
						<th>Client Contact</th>
						<th>Tracker Device</th>
						<th>Alert Type</th>
						<th>Alert By</th>
						<th class="td-actions"><?php echo __('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($alert_settings as &$setting) {
					?>
					<tr>
						<td><?php echo $setting['ClientContact']['name']?></td>
						<td><?php echo $setting['ClientDevice']['name']?></td>
						<td><?php echo $setting['AlertType']['name']?></td>
						<td><?php echo $setting['ClientAlertSetting']['alert_by']?></td>
						<td>
							<button class="btn edit"
								onclick="editAlertSettings(<?php echo $setting['ClientAlertSetting']['id'].','.$setting['ClientAlertSetting']['alert_type_id'].','.$setting['ClientAlertSetting']['client_contact_id'].",'".$setting['ClientAlertSetting']['client_device_id']."','".$setting['ClientAlertSetting']['alert_by']."'"?>)">
								<i class="icon-edit"></i>
							</button>
							<button class="btn btn-danger remove"
								onclick="deleteAlertSettings(<?php echo $setting['ClientAlertSetting']['id']?>)">
								<i class="icon-remove"></i>
							</button>
						</td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- /.span12 -->




<div aria-hidden="false" aria-labelledby="loginModalLabel" role="dialog"
	tabindex="-1" class="modal hide fade" id="alertSettingsModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" id="btnClose"
			aria-hidden="true">X</button>
		<h3 id="loginModalLabel">
			<i class="icon-external-link"></i> Add/Update Alert Settings
		</h3>
	</div>
	<form accept-charset="utf-8" id="frmAlertSettings">
		<div class="modal-body">
			<div id="login-loader">
				<img src="<?php echo $this->webroot;?>assets/img/loader.gif" />
			</div>
			<div id="login-error">Fail to save Alert Settings</div>
			<input type="hidden" id="id" value="" name="data[id]" /> <input
				type="hidden" id="client_info_id" value="<?php echo $id?>"
				name="data[client_info_id]" />


				<?php echo $this->Form->input('client_contact_id', array('options' => $contacts));?>
				<?php echo $this->Form->input('client_device_id', array('options' => $devices));?>
				<?php echo $this->Form->input('alert_type_id', array('options' => $alert_types));?>
				<?php //echo $this->Form->input('alert_by', array('options' => $alertBy));?>
			<div class="controls">
				<label>Alert By</label> <label> <input type="checkbox" id="chkEmail" name="alert_by"
					value="email"> Email </label> <label> <input id="chkSms" name="alert_by"
					type="checkbox" value="sms"> Sms </label>
			</div>
		</div>
		<div class="modal-footer">
			<button id="btnSave" class="btn btn-primary" type="submit">Save</button>
			<button id="btnCancel" class="btn" type="submit">Cancel</button>
		</div>
	</form>
</div>

<style>
#login-loader {
	margin: 10px;
	text-align: center;
	display: none;
}

#login-error {
	color: RED;
	display: none;
}

.chzn-container-multi {
	width: 300px !important;
}

.modal-body {
	max-height: 600px;
}
</style>

<script>
	$(function() {
		$("#alert_by").chosen();
		$("#btnSave").bind("click", function (event) {
			var data = $("#frmAlertSettings").serialize();
			var id = $('#id').val();
			var url = 'clientAlertSettings/edit';
			if(id==""){
				url = 'clientAlertSettings/add';
			}
			$('#login-error').hide();
			APP_HELPER.ajaxSubmitDataCallback(url,data,function(data){
				if(data=="ERROR"){
					$('#login-error').show();
				}else{
					setAlertSettings();
					$('#alertSettingsModal').modal('hide');
					$('#ajaxClientInfo').html(data);
				}
			});
			return false;
		});
		$("#btnCancel").bind("click", function (event) {
			setAlertSettings();
			$('#alertSettingsModal').modal('hide');
			return false;
		});
		$("#btnClose").bind("click", function (event) {
			setAlertSettings();
			$('#alertSettingsModal').modal('hide');
			return false;
		});
		$("#btnNew").bind("click", function (event) {
			setAlertSettings();
			$('#alertSettingsModal').modal('show');
			return false;
		});
	});
	function deleteAlertSettings(id){
		if(confirm('Are you sure you want delete the record?')){
			var cid = $('#client_info_id').val();
			var url = 'clientAlertSettings/delete/'+id;
			data = 'cid='+cid;
			$('#login-error').hide();
			APP_HELPER.ajaxSubmitDataCallback(url,data,function(data){
				if(data=="ERROR"){
					$('#login-error').show();
				}else{
					setAlertSettings();
					$('#alertSettingsModal').modal('hide');
					$('#ajaxClientInfo').html(data);
				}
			});
		}
	}
	function editAlertSettings(id, aid, ccid, cdid, atp){
		$('#id').val(id);
		$('#alert_type_id').val(aid);		
		$('#client_contact_id').val(ccid);
		$('#client_device_id').val(cdid);
		
		var vv=atp.split(',');
		var t = '';
	  	$('#chkSms').prop('checked', false);
		$('#chkEmail').prop('checked', false);
	    $.each(vv,function(v){
	          //console.debug(vv[v]);
	          //$('#alert_by option[value="'+vv[v]+'"]').attr('selected');
	          if(vv[v]=='sms'){
	        	  $('#chkSms').prop('checked', true);
			  }          
	          if(vv[v]=='email'){
	        	  $('#chkEmail').prop('checked', true);
			  }          
	    });		
		$('#alertSettingsModal').modal('show');
	}
	function setAlertSettings(){
		$('#id').val('');
		$('#alert_type_id').val('');
		$('#client_contact_id').val('');
		$('#client_device_id').val('');
		$('#alert_by').val('');		
	}
	function getAlertSettingsData(){
		var $id = $('#id').val('');
		var $id = $('#alert_type_id').val('');
		var $id = $('#client_contact_id').val('');
		var $id = $('#client_device_id').val('');
		var $atb = '';
		if($('#chkSms').prop('checked') && $('#chkEmail').prop('checked')){
			$atb = 'sms,email'; 
		}else if(true){
			$atb = 'sms';
		}else if(true){
			$atb = 'email';
		}
		;
		var $atb = $('#alert_by').val('');		
		var $id = $('#alert_by').val('');
	}
	
</script>
