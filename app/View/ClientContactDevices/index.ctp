<div class="span12">
	<div class="box">
		<header>
			<div class="icons">
				<i class="icon-edit"></i>
			</div>
			<h5>
				<?php echo __('Add Client Contact Device'); ?>
			</h5>
		</header>
		<div class="in body" id="div-1">
			<?php  echo $this->Session->flash();?>
			<form accept-charset="utf-8" method="post" id="frmContactDeviceIndex"
				class="form-horizontal">
				<fieldset>
					<input name="data[client_info_id]" type="hidden"
						id="client_info_id" value="<?php echo $clientid?>" />
					<?php echo $this->Form->input('client_contact_id', array('options' => $contacts,'empty'=>'-- Select Contacts --'));?>
					<hr>
					<?php echo $this->Form->input('client_device_id', array('class'=>'chzn-select', 'multiple'=>'multiple', 'options' => $devices));?>


					<div class="form-actions">
						<button class="btn btn-danger btn" id="btnSubmit">Submit</button>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>

<script>
	$(function() {
		APP_COMMON.initPage('Device Contacts');
		$('#ajax-page-title').html('<i class="icon-user"></i> Client Contact Device : Add');	
		$('#client_device_id').select2({width:'400px'});
		$('#btnSubmit').bind('click',function(){
			var data = $("#frmContactDeviceIndex").serialize();
			console.debug(data);
			var url = 'clientContactDevices/save';
			APP_HELPER.ajaxSubmitDataCallback(url,data,function(data){
				if(data=="ERROR"){
					alert('Error Occurred in saving data.');
				}else{
					$('#client_contact_id').val('');
					$('#client_device_id').select2("val", []);
					APP_HELPER.ajaxRequestModelAction('clientContactDevices/index/<?php echo $clientid;?>');
				}
			});
			return false;
		});
		$('#client_contact_id').bind('change',function(){
			$('#client_device_id option').removeAttr('selected');
			var id = $(this).val();			
			if(id){
				var url = 'clientContactDevices/get_devices/'+id;
				var data = '';
				APP_HELPER.ajaxSubmitDataCallback(url,data,function(data){
					var dt = JSON.parse(data);
					var t = new Array();					
					$.each(dt,function(k,v){
						t.push(v);						
					});
					$('#client_device_id').select2("val", t);
				});
			}
		});
		   
	});
</script>
<style>
#client_deviced_id option[selected=selected] {
	background-color: green;
}
</style>
