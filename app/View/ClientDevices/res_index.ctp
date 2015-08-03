<div class="span12">
	<div class="box">
		<?php echo $this->Session->flash();?>
		<header>

			<h5>
				<i class="icon-edit"></i>
				<?php echo __('Non Responsive Devices'); ?>
			</h5>

		</header>
		<div class="in body" id="div-1">
			<form id="resdeviceform">
				<div style="display: none;">
					<input type="text" id="sDate" name="data[sDate]" class="form-date" />
				</div>
				<span>Days Behind : </span>
				<div class="input-append">
					 <input id="days" type="number" value="0"
						style="text-align: right;" min="0" />
					<button id="btnSearch" title="Search" class="btn btn-info"
						type="button" onclick="FN_ResDevice.getStudentInformation();">
						<i class="icon-search"></i>
					</button>
				</div>
			</form>
			<hr>
			<?php echo $this->Session->flash();?>
			<div class="box">
				<div class="body collapse in">
					<div style="width: 100%;"></div>
					<table id="ResClientListTable"
						class="table table-bordered table-striped table-highlight table-hover responsive">
						<thead>
							<tr>
								<th>Registration Number</th>
								<th>Device ID</th>
								<th>Tracker ID</th>
								<th>Unit Sim</th>
								<th>Last Update Date</th>
								<th>Last Address</th>
								<th>Contact Name</th>
								<th>Mobile</th>
								<!-- <th class="td-actions"><?php //echo __('Actions'); ?></th> -->
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>

				</div>

			</div>
		</div>
	</div>
</div>
<style>
<!--
.dataTables_filter, .dataTables_info, .dataTables_length {display: none;}
#ResClientListTable{
	font-size: 0.9em;
}
-->
</style>
<script type="text/javascript">
	var FN_ResDevice = {
		tableName : '#ResClientListTable',
		getStudentInformation:function(){
			APP_HELPER.refreshDataTable('#ResClientListTable', APP_HELPER.getFullPath("trackerTracks/get_non_responsive_devices?client_info_id=<?php echo $index;?>&&days="+$("#days").val()+"&&sDate="+$("#sDate").val()));
		},
		ClientDeviceListUrl : APP_HELPER.getFullPath("clientDevices/jsondata_acc?client_info_id=<?php echo $index?>"),
		addDatatableActions : function(oObj) {  
			var id = oObj.aData[0]; 
			var onedit = "APP_HELPER.ajaxLoad('clientDevices/edit/"+id+"?clientid=<?php echo $index?>','<?php echo $ajaxPlaceholder?>');";
			return '<a class="btn btn-small btn-warning" href="javascript:;" onclick="'+onedit+'"><i class="btn-icon-only icon-edit"></i></a>';//<a class="btn btn-small" href="javascript:;" onclick="'+ondelete+'"><i class="btn-icon-only icon-remove"></i></a>';
		},
		
		initTable : function(){
			$(FN_ResDevice.tableName).dataTable({
				"bFilter": false,"bInfo": false,
	        	"bProcessing": false,
	    		"bServerSide": false,
	    		"sAjaxSource": null,
	    		"aoColumns": [   
							{ 'sName': 'devicename',  'sWidth': 30, 'sClass': 'center',},
							{ 'sName': 'deviceid',  'sWidth': 30, 'sClass': 'center',},
							{ 'sName': 'tracker_id',  'sWidth': 30, 'sClass': 'center',},
							{ 'sName': 'sim',  'sWidth': 30, 'sClass': 'center', },
							{ 'sName': 'server_date',  'sWidth': 30, 'sClass': 'center',},
							{ 'sName': 'address',  'sWidth': 30, 'sClass': 'center',},
							{ 'sName': 'contactname',  'sWidth': 30, 'sClass': 'center', },
							{ 'sName': 'mobile',  'sWidth': 30, 'sClass': 'center', },
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
		$("#sDate").datetimepicker({format: 'yyyy-mm-dd',autoclose:true,minView:2}).val(getTodaysDate(0));
		
    });
</script>

