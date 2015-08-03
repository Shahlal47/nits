<div class="span12">
<?php echo $this->Session->flash();?>
	<div class="box">
		<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5>List Of All Devices</h5>
		</header>

		<div class="body collapse in">
			<table id="AllDeviceListTable"
				class="table table-bordered table-striped table-highlight table-hover responsive">
				<thead>
					<tr>
						<th>Id</th>
						<th>Vehicle Reg/Person Name</th>
						<th>Tracker ID</th>
						<th>Unit SIM</th>
						<th>Device ID</th>
						<th>Expiry Date</th>
						<th>Device Type</th>
						<th>Device Model</th>
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

<script type="text/javascript">
	var FN_AllDevices = {
		tableName : '#AllDeviceListTable',
		openTrackerNewTab : function (id) {
			var win = window.open('trackerTracks/tracker_live_view/' + id, '_blank');
			win.focus();
			return false;
		},
		AllDeviceListUrl : APP_HELPER.getFullPath("clientDevices/jsondata_all_devices"),
		addDatatableActions : function(oObj) {  
			var id = oObj.aData[0]; 
			//var ondelete = "APP_HELPER.ajaxDeleteRecord('clientDevices/delete/"+id+"?clientid=<?php echo $id?>','<?php echo $ajaxPlaceholder?>')";
			var onedit = "APP_HELPER.ajaxLoad('clientDevices/edit/"+id+"?clientid=<?php echo $id?>','<?php echo $ajaxPlaceholder?>');";
			var deviceid = oObj.aData[4]; 
			return '<a class="btn btn-small btn-warning" href="javascript:;" onclick="'+onedit+'"><i class="btn-icon-only icon-edit"></i></a><a href="#" class="tracker-btn btn btn-small" id="'+deviceid+'" onclick="FN_AllDevices.openTrackerNewTab('+deviceid+')"><i class="icon-external-link"></i></a>';//<a class="btn btn-small" href="javascript:;" onclick="'+ondelete+'"><i class="btn-icon-only icon-remove"></i></a>';
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
			var isTransfer = '<?php echo $transfer; ?>';
			$(FN_AllDevices.tableName).dataTable({
				"language": {
            				"lengthMenu": "Display _MENU_ records per page",
            				"zeroRecords": "Nothing found - sorry",
            				"info": "Showing page _PAGE_ of _PAGES_",
            				"infoEmpty": "No records available",
            				"infoFiltered": "(filtered from _MAX_ total records)"
        					},
        	    "sAjaxSource": FN_AllDevices.AllDeviceListUrl,
	    		"aoColumns": [     
							{ 'sName': 'id',  'sWidth': 30, 'sClass': 'center', 'bVisible':false},
							{ 'sName': 'name',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},
							{ 'sName': 'tracker_id',  'sWidth': 30, 'sClass': 'center', },
							{ 'sName': 'mob_no',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},
							{ 'sName': 'deviceid',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},
							{ 'sName': 'expiry_date',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},
							{ 'sName': 'device_type_id',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},							
							{ 'sName': 'device_info_id',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},
							{ 'sName': 'active',  'sWidth': 30, 'sClass': 'center',fnRender: FN_AllDevices.addDatatableCheckBox },							
							{ "sName": "id",  "sWidth": 52, fnRender: FN_AllDevices.addDatatableActions, "bSortable": false, "bSearchable": false , "sClass":"td-actions", "bVisible":isTransfer.length == 0 ? true :false },    // <---- getting ID column again, but will re-write it as delete icon
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

			var url = 'trackerTracks/get_all_devices_profile_json/<?php echo $id;?>';
			APP_HELPER.ajaxSubmitDataCallback(url, '', function(data) {
				JStorageLib.setUserDeviceInfos(data);
			});

		}
	};
	$(function(){
		APP_COMMON.initPage('All Devices');
		$('#ajax-page-title').html('<i class="icon-user"></i> All Devices : Index');	   
		FN_AllDevices.initTable();
		$('.tracker-btn').bind('click',function(e){
			var deviceid = $(this).attr('id');
			var win = window.open('trackerTracks/tracker_live_view/' + deviceid, '_blank');
			win.focus();
			return false;
		});
    });
</script>

