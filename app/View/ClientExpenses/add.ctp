<div class="span12">
	<div class="box">
		<header>
			<div class="icons">
				<i class="icon-edit"></i>
			</div>
			<h5>
				<?php echo __('Add Client Expense'); ?>
			</h5>
			<div class="toolbar">
				<ul class="nav">
					<li><a href="javascript:;"
						onclick="APP_HELPER.ajaxRequestModelAction('clientExpenses/index');">
							<i class="icon-list-alt"></i> List
					</a></li>
				</ul>
			</div>
		</header>
		<div class="in body" id="div-1">

			<?php
			echo $this->Session->flash();
			$data = $this->Js->get('#ClientExpenseAddForm')->serializeForm(array('isForm' => true, 'inline' => true));
			$this->Js->get('#ClientExpenseAddForm')->event(
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
			echo $this->Form->create('ClientExpense', array('inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal'));
			?>
			<fieldset>


				<div class="control-group">
					<label class="control-label" for="name">Vehicle Registration Number </label>
					<div class="controls">
						<select id="client_device_id" data-form="select2"
							style="width: 200px" data-placeholder="Please Select A Tracker"
							name="data[ClientExpense][client_device_id]">
							<option value=""></option>
							<optgroup label="Personal Tracker">
							</optgroup>
							<optgroup label="Vahicle Tracker">
							</optgroup>
						</select>
						<?php //echo $this->Form->input('client_device_id', array('class'=>'input-large'));
					echo $this->Form->error('client_device_id'); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Expense Type </label>
					<div class="controls">
						<?php echo $this->Form->input('expense_type_id', array('class'=>'input-large'));
					echo $this->Form->error('expense_type_id'); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">On date </label>
					<div class="controls">
						<input id="ClientExpenseOndate" type="text"
							name="data[ClientExpense][ondate]" class="input-large  form_date">
						<?php echo $this->Form->error('ondate'); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Amount </label>
					<div class="controls">
						<?php echo $this->Form->input('amount', array('class'=>'input-large number-field2', 'maxlength'=>20));
					echo $this->Form->error('amount'); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Comments </label>
					<div class="controls">
						<?php echo $this->Form->input('comments', array('class'=>'input-large'));
					echo $this->Form->error('comments'); ?>
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
		APP_COMMON.initPage('Add Client Expenses');
		APP_COMMON.loadTrackersInList('#client_device_id');   
		$('#ClientExpenseOndate').datetimepicker('update', new Date());	
		var deviceid = '<?php echo $deviceId;?>';
		if(deviceid.length < 8){
			deviceid = "0"+deviceid;
			}
		if(deviceid != ""){
			$("#client_device_id").select2('val',deviceid); 
			}
	});

	$(".number-field2").keypress(function(e)
		    {
		        var code = e.which || e.keyCode;
		       
		           if((code >= 48 && code <= 57) || code == 8 || code == 46 || code==110 || (code >= 37 && code <= 40)){
		           } 
		           else {
		             return false;
		           }
		    });
</script>
