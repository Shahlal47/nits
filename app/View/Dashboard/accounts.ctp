<div class="span12 inner">
	<div class="box">
		<header>
			<div class="icons">
				<i class="icon-search"></i>
			</div>
			<h5>Update User Accounts</h5>
		</header>
		<div id="div-1" class=" body">
			<?php echo $this->Session->flash();?>
			<fieldset>
				<legend>User</legend>
				<div class="fluid-row">
					<div class="input-append" style="margin-right: 1%;">
						<input placeholder="Search by User Id" style="width: 200px"
							id="searchByUserId" type="text" list="userList">
							<datalist id="userList">
								<?php 
								foreach($userList as $userid=>$username){?>
									<option id="<?php echo $userid?>" value="<?php echo $username?>">
									<?php 
								}
								?>
							</datalist>
							
						<button id="btnUserName" class="btn" type="button" onclick="EXT_HISTORY.reloadTable()">Go</button>
					</div>
				</div>
			</fieldset>
			<hr>
			<div class="body collapse in">
			<header>
				<h5>
					Device List<span id="device_count"> (Total Devices : 0 ) </span>
				</h5>
				<div class="toolbar" >
					<ul class="nav" >
						<li><a id="reportId" style="padding: 4px;" href="javascript:;"> <i
								class="icon-book icon-inverse" title="Reports"></i>
						</a></li>
					</ul>
				</div>
			</header>
			
				<table id="UserDeviceListTable"
					class="table table-bordered table-striped table-highlight table-hover responsive">
					<thead>
						<tr>
							<th>Id</th>
							<th>Tracker ID</th>
							<th>Unit SIM</th>
							<th>Device ID</th>
							<th>Active</th>
							<th class="td-actions"><?php echo __('Actions'); ?>
							</th>
						</tr>
					</thead>
					<tbody>
	
					</tbody>
				</table>
	
			</div>
			
			<hr>
			<?php 
			echo $this->Form->create('ExtHistory', array('inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal'));
			?>
			<fieldset>
				<input id="selectedId" value="" type="hidden"> <input
					id="subscriptionId" value="" type="hidden">

				<div class="control-group">
					<label class="control-label" for="name">Memo Number </label>
					<div class="controls">
						<?php echo $this->Form->input('memo_number', array('class'=>'input-large', 'id'=>'memoId'));
						echo $this->Form->error('memo_number'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">Ref Number </label>
					<div class="controls">
						<?php echo $this->Form->input('ref_number', array('class'=>'input-large' , 'id'=>'refId'));
						echo $this->Form->error('ref_number'); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">To Date </label>
					<div class="controls">
						<?php echo $this->Form->input('to_date', array('id'=> 'nDate','class'=>'input-large form-date', 'type'=>'text'));
						echo $this->Form->error('to_date'); ?>
					</div>
				</div>

				<hr>
				<div class="text-center">
					<button type="button" class="btn btn-danger btn"
						onclick="EXT_HISTORY.saveHistory();">Submit</button>
					&nbsp;&nbsp;
					<button type="reset" class="btn">Reset</button>
				</div>
			</fieldset>
			<?php
			echo $this->Form->end();
			echo $this->Js->writeBuffer();
			?>
			
			<div id="extHistories">
			</div>
			
		</div>
	</div>
	<hr>
	<div id="ajaxSearch"></div>
</div>

<script>
	var EXT_HISTORY = {
			tableName : '#UserDeviceListTable',
			selectedDevices:[],
			UserDeviceListUrl : APP_HELPER.getFullPath("extHistories/get_user_devices_status_list_json"),
			
			saveHistory : function(){
				var memo = $("#memoId").val();
				var ref = $("#refId").val();
				var ndate = $("#nDate").val();
				
				if(ndate == ""){
					alert("Empty Date !!!");
					return;
					}
				
				var data = {'form_data' : $('#ExtHistoryDashboardForm').serialize(), 'trackerIds':EXT_HISTORY.selectedDevices};
				APP_HELPER.ajaxSubmitData('extHistories/batchUpdate', data);
					
				},
			reloadTable : function() {
				$(EXT_HISTORY.tableName).dataTable()._fnAjaxUpdate();
			},
			checkDate : function(){
				var nDate=document.getElementById('nDate').value;
				var d1 = Date.parse(nDate);
				var dt1 = new Date(d1);
				
				var eDate=document.getElementById('e_date').value;
				var d2 = Date.parse(eDate);
				var dt2 = new Date(d2);
				if(dt1 <= dt2){
					return false;
					}
				else{
					return true;
					}
				},
			displayResult:function (item, val, text) 
			{
				var f = val.split("#");
			    $('#selectedId').val(f[1]); 
			    $("#reg_number").val('');
				$("#mob_no").val('');
				$("#device_id").val('');
				$("#device_type").val('');
				$("#s_date").val('');
				$("#e_date").val('');
				$("#subscriptionId").val('');
				$("#nDate").val('');  
				$("#extHistories").hide();
			},

			addDatatableActions : function(oObj) {  
				var deviceid = oObj.aData[1];
				return "<input title='Select Device' class='device_selection' onclick='EXT_HISTORY.prepareTrackerIds();' type=\'checkbox\' value='" + deviceid + "'>";
			},

			prepareTrackerIds : function()
			{
				EXT_HISTORY.selectedDevices = [];
				$('.device_selection:checked').each(function(){
					EXT_HISTORY.selectedDevices.push(this.value);
					})
			},
			
			initTable : function(){
				$(EXT_HISTORY.tableName).dataTable({
		        	"bFilter": true,"bInfo": false,"bPaginate":false,
		        	"bProcessing": true,
		    		"bServerSide": true,
		    		"sAjaxSource": EXT_HISTORY.UserDeviceListUrl,
		    		"aoColumns": [     
									{ 'sName': 'id',  'sWidth': 30, 'sClass': 'center', "bSearchable": false, fnRender: EXT_HISTORY.addDatatableActions},
									{ 'sName': 'deviceid',  'sWidth': 30, 'sClass': 'center'},
									{ 'sName': 'tracker_id',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},
									{ 'sName': 'name',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},
									{ 'sName': 'active',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},
									{ 'sName': 'action',  'sWidth': 30, 'sClass': 'center', "bSearchable": false}							
								],			    		        			    		        
		        	"fnServerData": function ( sSource, aoData, fnCallback ) {
		                $.getJSON( sSource, aoData, function (json) { 
		                    fnCallback(json);
		                } );
		            },
		            "fnServerParams": function ( aoData ) {
			            aoData.push({"name":"username","value":$("#searchByUserId").val()});
			            }
		        });
			}
	}		
	$(function() {
		$(".form-date").datetimepicker({format: 'yyyy-mm-dd',autoclose:true,minView:2}).val(getTodaysDate(0)); 
		EXT_HISTORY.initTable();
		APP_HELPER.ajaxSubmitDataCallback('trackerTracks/getAccountProfile', '', function(rData){
			$("#tt").html(rData.tt);
			$("#pt").html(rData.pt);
			$("#vt").html(rData.vt);
			$("#tc").html(rData.tc);
			$("#sc").html(rData.sc);
			$("#gc").html(rData.gc);
			});
	});
</script>
