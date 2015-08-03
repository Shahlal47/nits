<div class="span12">
	<?php echo $this->Session->flash();?>
	<div class="box">
		<header>
			<div class="icons">
				<i class="icon-edit"></i>
			</div>
			<h5>List Client Devices</h5>
		</header>

		<div class="body collapse in">
			<table id="ClientDeviceListTable"
				class="table table-bordered table-striped table-highlight table-hover responsive">
				<thead>
					<tr style="color: white; background-color: #555555">
						<th>Id</th>
						<th>Vehicle Reg/Person Name</th>
						<th>Tracker ID</th>
						<th>Unit SIM</th>
						<th>Device Id</th>
						<th>Expiry Date</th>
						<th>Device Type</th>
						<th>Device Model</th>
						<th>Client</th>
						<th>Active</th>
						<th>CID</th>
						<th class="td-actions"><?php echo __('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>

		</div>

	</div>
</div>

<style>
<!--
#ClientDeviceListTable tr {
	font-size: 0.8em;
}
-->
</style>

<script type="text/javascript">
	var FN_ClientDevice = {
		tableName : '#ClientDeviceListTable',
		ClientDeviceListUrl : APP_HELPER.getFullPath("clientDevices/jsondata?client_info_id=<?php echo $id?>"),
		addDatatableActions : function(oObj) {  
			var id = oObj.aData[0]; 
			var cid = oObj.aData[9]; 
			//var ondelete = "APP_HELPER.ajaxDeleteRecord('clientDevices/delete/"+id+"?clientid=<?php echo $id?>','<?php echo $ajaxPlaceholder?>')";
			var onedit = "APP_HELPER.ajaxSubmitData('clientDevices/edit/"+id+"?clientid="+cid+"','ajax-content');";
			
			return '<a class="btn btn-small btn-warning" href="javascript:;" onclick="'+onedit+'"><i class="btn-icon-only icon-edit"></i></a>';//<a class="btn btn-small" href="javascript:;" onclick="'+ondelete+'"><i class="btn-icon-only icon-remove"></i></a>';
		},
		addDatatableCheckBox : function(oObj) {  
			var flg = oObj.aData[6];
			if(flg){
				return '<i class="icon-check icon-1x"></i>';
			}else{
				return '<i class="icon-check-empty icon-1x"></i>';
			}
		},
		
		initTable : function(){
			$(FN_ClientDevice.tableName).dataTable({
	        	"bFilter": true,"bInfo": true,
	        	"bSearch":true,
	        	"bProcessing": true,
	    		"bServerSide": true,
	    		"bStateSave": true,
	    		"sAjaxSource": FN_ClientDevice.ClientDeviceListUrl,
	    		"aoColumns": [     
							{ 'sName': 'id',  'sWidth': 30, 'sClass': 'center', 'bVisible':false},
							{ 'sName': 'name',  'sWidth': 30, 'sClass': 'center',},
							{ 'sName': 'tracker_id',  'sWidth': 30, 'sClass': 'center',},
							{ 'sName': 'mob_no',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},
							{ 'sName': 'deviceid',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},
							{ 'sName': 'expiry_date',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},
							{ 'sName': 'device_type_id',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},							
							{ 'sName': 'device_info_id',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},
							{ 'sName': 'name',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},
							{ 'sName': 'active',  'sWidth': 30, 'sClass': 'center',fnRender: FN_ClientDevice.addDatatableCheckBox, "bSearchable": false},
							{ 'sName': 'id',  'sWidth': 30, 'sClass': 'center', 'bVisible':false, "bSearchable": false},							
							{ "sName": "id",  "sWidth": 52, fnRender: FN_ClientDevice.addDatatableActions, "bSortable": false, "bSearchable": false , "sClass":"td-actions",'bVisible':false},    // <---- getting ID column again, but will re-write it as delete icon
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
    });
</script>

