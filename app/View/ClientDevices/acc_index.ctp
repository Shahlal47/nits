<div class="span12">
	<div class="box">
		<?php echo $this->Session->flash();?>
		<header>

			<h5>
				<i class="icon-edit"></i>
				<?php echo __('Expired Devices'); ?>
			</h5>

		</header>
		<div class="in body" id="div-1">
			<!-- <form id="expireddeviceform" style="text-align: center;">
				From <input type="text" id="fromDate" name="data[FromDate]"
					class="form-date" /> To <input type="text" class="form-date"
					id="toDate" name="data[toDate]" />

				<button id="btnSearch" title="earch" class="btn btn-info"
					type="button" style="margin-top: -1%; margin-left: 1%;"
					onclick="FN_ClientDevice.getStudentInformation();">
					<i class="icon-search"></i>
				</button>
			</form>
			 -->
			<?php 
			echo $this->Form->create('ClientExpense', array('id'=>'expireddeviceform','inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal'));
			?>
			<div class="control-group">
				<label class="control-label" for="name">From Date </label>
				<div class="controls">
					<input type="text" id="fromDate" name="data[FromDate]"
						class="form-date" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="name">To Date </label>
				<div class="controls">
					<input type="text" class="form-date" id="toDate"
						name="data[toDate]" />
				</div>
			</div>

			<div class="form-actions">
				<button id="btnSearch" title="search" class="btn btn-danger"
					type="button" onclick="FN_ClientDevice.getStudentInformation();">
					<i class="icon-search"></i> Search
				</button>
			</div>
			<?php
			echo $this->Form->end();
			?>
			<div class="body collapse in">
				<table id="ClientDeviceListTable"
					class="table table-bordered table-striped table-highlight table-hover responsive">
					<thead>
						<tr>
							<th>Id</th>
							<th>Vehicle Reg/Person Name</th>
							<th>Unit SIM</th>
							<th>Device ID</th>
							<th>Tracker ID</th>
							<th>Expiry Date</th>
							<th>Active</th>
							<th class="td-actions"><?php echo __('Actions'); ?>
							</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>

			</div>
		</div>
	</div>
</div>

<style>
#ClientDeviceListTable {
	font-size: 0.9em;
}
</style>

<script type="text/javascript">
	var FN_ClientDevice = {
		tableName : '#ClientDeviceListTable',
		getStudentInformation:function(){
			APP_HELPER.refreshDataTable('#ClientDeviceListTable', APP_HELPER.getFullPath("clientDevices/jsondata_acc?client_info_id=<?php echo $index;?>&&fromdate="+$("#fromDate").val()+"&&todate="+$("#toDate").val()));
			},
		ClientDeviceListUrl : APP_HELPER.getFullPath("clientDevices/jsondata_acc?client_info_id=<?php echo $index?>"),
		addDatatableActions : function(oObj) {  
			var id = oObj.aData[0]; 
			var onedit = "APP_HELPER.ajaxLoad('clientDevices/edit/"+id+"?clientid=<?php echo $index?>','<?php echo $ajaxPlaceholder?>');";
			var returnData = '';
			<?php if ($role == 'accounts') {?>
				returnData = '<button class="btn btn-small btn-warning" onclick="FN_ClientDevice.loadModal('+oObj.aData[3]+');"><i class="btn-icon-only icon-edit"></i></button>';//<a class="btn btn-small" href="javascript:;" onclick="'+ondelete+'"><i class="btn-icon-only icon-remove"></i></a>';
			<?php } ?>
			return returnData;
			
		},	
		addDatatableCheckBox : function(oObj) {  
			var flg = oObj.aData[5];
			if(flg){
				return '<i class="icon-check icon-1x"></i>';
			}else{
				return '<i class="icon-check-empty icon-1x"></i>';
			}
		},
		
		initTable : function(){
			$(FN_ClientDevice.tableName).dataTable({
	        	"bFilter": false,"bInfo": false,
	        	"bProcessing": false,
	    		"bServerSide": false,
	    		"sAjaxSource": null,
	    		"aoColumns": [     
							{ 'sName': 'id',  'sWidth': 30, 'sClass': 'center', 'bVisible':false},
							{ 'sName': 'name',  'sWidth': 30, 'sClass': 'center', },
							{ 'sName': 'mob_no',  'sWidth': 30, 'sClass': 'center', },
							{ 'sName': 'deviceid',  'sWidth': 30, 'sClass': 'center', },
							{ 'sName': 'tracker_id',  'sWidth': 30, 'sClass': 'center', },
							{ 'sName': 'expiry_date',  'sWidth': 30, 'sClass': 'center', },
							{ 'sName': 'active',  'sWidth': 30, 'sClass': 'center',fnRender: FN_ClientDevice.addDatatableCheckBox },							
							{ "sName": "id",  "sWidth": 52, fnRender: FN_ClientDevice.addDatatableActions, "bSortable": false, "bSearchable": false , "sClass":"td-actions" ,'bVisible':false},    // <---- getting ID column again, but will re-write it as delete icon
	    		        ],			    		        			    		        
	        	"fnServerData": function ( sSource, aoData, fnCallback ) {
	                $.getJSON( sSource, aoData, function (json) { 
	                    fnCallback(json);
	                } );
	            }

            ,
	            "sDom": "<'row-fluid'<'span6'T><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
	            "oTableTools": {
	                "aButtons": [
	                    "copy",
	                    "print",
	                    {
	                        "sExtends":    "collection",
	                        "sButtonText": 'Save <span class="caret" />',
	                        "aButtons":    [ 
	                            "xls", 
	                            "csv",
	                            {
	                                "sExtends": "pdf",
	                                "sTitle":"ClientDevice Report",
	                                "sPdfOrientation": "landscape",
	                                "sPdfMessage": "Genral Report"
	                            }
	                        ]
	                    }
	                ],
	                "sSwfPath": APP_URL_ROOT+"js/lib/datatables/swf/copy_csv_xls_pdf.swf"
	            }
	        });

		}
	};
	$(function(){
		APP_COMMON.initPage('Client Devices');
		$('#ajax-page-title').html('<i class="icon-user"></i> Client Device : Index');	   
		FN_ClientDevice.initTable();
		$("#fromDate").datetimepicker({format: 'yyyy-mm-dd',autoclose:true,minView:2}).val(getTodaysDate(0));
		$("#toDate").datetimepicker({format: 'yyyy-mm-dd',autoclose:true,minView:2}).val(getTodaysDate(0));
		
    });
</script>

