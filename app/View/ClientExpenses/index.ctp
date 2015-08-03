<div class="span12">
	<?php echo $this->Session->flash();?>
	<div class="box">
		<header>
			<div class="icons">
				<i class="icon-edit"></i>
			</div>
			<h5>List Client Expenses</h5>
			<div class="toolbar">
				<ul class="nav">

					<li><a href="javascript:;"
						onclick="APP_HELPER.ajaxRequestModelAction('clientExpenses/add')">
							<i class="icon-plus"></i> New
					</a></li>
				</ul>
			</div>
		</header>

		<div class="body collapse in">
			<div>
				<div class="control-group">
					<label class="control-label" for="name">Vehicle Registration Number
					</label>
					<div class="controls">
						<select id="client_device_id" data-form="select2"
							style="width: 200px" data-placeholder="Please Select A Tracker"
							name="data[ClientExpense][client_device_id]"
							onchange="FN_ClientExpense.loadData();">
							<option value=""></option>
							<optgroup label="Personal Tracker">
							</optgroup>
							<optgroup label="Vahicle Tracker">
							</optgroup>
						</select>
						<?php 
					echo $this->Form->error('client_device_id'); ?>
					</div>
				</div>
			</div>
			<table id="ClientExpenseListTable"
				class="table table-bordered table-striped table-highlight table-hover responsive">
				<thead>
					<tr>
						<th>Id</th>
						<th>Client Information</th>
						<th>Client Device</th>
						<th>Expense Type</th>
						<th>Ondate</th>
						<th>Amount</th>
						<th>Comments</th>
						<th class="td-actions"><?php echo __('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>

		</div>

	</div>
</div>

<script type="text/javascript">
	var FN_ClientExpense = {
		tableName : '#ClientExpenseListTable',
		ClientExpenseListUrl : APP_HELPER.getFullPath("clientExpenses/jsondata"),
		deviceId:'',
		loadData:function(){
			FN_ClientExpense.deviceId = $("#client_device_id").select2('val');;
			APP_HELPER.refreshDataTable('#ClientExpenseListTable', APP_HELPER.getFullPath("clientExpenses/jsondata?cdeviceid="+FN_ClientExpense.deviceId));
			},
		addDatatableActions : function(oObj) {  
			var id = oObj.aData[0]; 
			var ondelete = "APP_HELPER.ajaxDeleteRecordAction('clientExpenses/delete/"+id+"')";
			var onedit = "APP_HELPER.ajaxRequestModelAction('clientExpenses/edit/"+id+"');";
			return '<a class="btn btn-small btn-warning" href="javascript:;" onclick="'+onedit+'"><i class="btn-icon-only icon-edit"></i></a><a class="btn btn-small" href="javascript:;" onclick="'+ondelete+'"><i class="btn-icon-only icon-remove"></i></a>';
		},
		initTable : function(){
			$(FN_ClientExpense.tableName).dataTable({
	        	"bFilter": false,"bInfo": false,
	        	"bProcessing": true,
	    		"bServerSide": false,
	    		//"sAjaxSource": FN_ClientExpense.ClientExpenseListUrl,
	    		"sAjaxSource": null,
	    		"aoColumns": [     
							{ 'sName': 'id',  'sWidth': 30, 'sClass': 'center', 'bVisible':false},
							{ 'sName': 'client_info_id',  'sWidth': 30, 'sClass': 'center','bVisible':false },
							{ 'sName': 'name',  'sWidth': 30, 'sClass': 'center', 'bVisible':false},
							{ 'sName': 'expense_type_id',  'sWidth': 30, 'sClass': 'center', },
							{ 'sName': 'ondate',  'sWidth': 30, 'sClass': 'center', },
							{ 'sName': 'amount',  'sWidth': 30, 'sClass': 'center', },
							{ 'sName': 'comments',  'sWidth': 30, 'sClass': 'center', },
							{ "sName": "id",  "sWidth": 52, fnRender: FN_ClientExpense.addDatatableActions, "bSortable": false, "bSearchable": false , "sClass":"td-actions" },    // <---- getting ID column again, but will re-write it as delete icon
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
	                                "sTitle":"ClientExpense Report",
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
		APP_COMMON.initPage('Client Expenses');
		$('#ajax-page-title').html('<i class="icon-user"></i> Client Expense : Index');	   
		FN_ClientExpense.initTable();
		APP_COMMON.loadTrackersInList('#client_device_id');
		var deviceid = '<?php echo $deviceid;?>'; 
		$("#client_device_id").select2('val',deviceid);
		console.debug(deviceid);
		
		if(deviceid != ''){ 
			FN_ClientExpense.loadData();
		}
    });
</script>

<!-- 'id','client_info_id','expense_type_id','client_device_id','ondate','amount','comments',  -->
