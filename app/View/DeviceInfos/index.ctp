<div class="span12">
<?php echo $this->Session->flash();?>
	<div class="box">
		<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5><?php echo $device_type['description']?> Information</h5>
		<div class="toolbar">
			<ul class="nav">
				<li><a href="javascript:;"
					onclick="APP_HELPER.ajaxRequestModelAction('deviceInfos/add/<?php echo $device_type['id']?>');"> <i
						class="icon-plus"></i> New </a></li>
			</ul>
		</div>
		</header>

		<div class="body collapse in">
			<table id="DeviceInfoListTable"
				class="table table-bordered table-striped table-highlight table-hover responsive">
				<thead>
					<tr>
						<th>Id</th>
						<th>Model</th>
						<th>Brand</th>
						<th>Description</th>
						<th>Device Type</th>
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
	var FN_DeviceInfo = {
		tableName : '#DeviceInfoListTable',
		DeviceInfoListUrl : APP_HELPER.getFullPath("deviceInfos/jsondata?deviceid=<?php echo $device_type['id']?>"),
		addDatatableActions : function(oObj) {  
			var id = oObj.aData[0]; 
			//var ondelete = "APP_HELPER.ajaxDeleteRecord('deviceInfos/delete/"+id+"')";
			var onedit = "APP_HELPER.ajaxRequestModelAction('deviceInfos/edit/"+id+"');";
			return '<a class="btn btn-small btn-warning" href="javascript:;" onclick="'+onedit+'"><i class="btn-icon-only icon-edit"></i></a>';//<a class="btn btn-small" href="javascript:;" onclick="'+ondelete+'"><i class="btn-icon-only icon-remove"></i></a>';
		},
		initTable : function(){
			$(FN_DeviceInfo.tableName).dataTable({
	        	"bFilter": false,"bInfo": false,
	        	"bProcessing": true,
	    		"bServerSide": true,
	    		"sAjaxSource": FN_DeviceInfo.DeviceInfoListUrl,
	    		"aoColumns": [     
								{ 'sName': 'id',  'sWidth': 30, 'sClass': 'center', 'bVisible':false},
								{ 'sName': 'name',  'sWidth': 30, 'sClass': 'center', },
								{ 'sName': 'brand',  'sWidth': 30, 'sClass': 'center', },
								{ 'sName': 'description',  'sWidth': 30, 'sClass': 'center', },
								{ 'sName': 'device_type',  'sWidth': 30, 'sClass': 'center', },
																																							{ "sName": "id",  "sWidth": 52, fnRender: FN_DeviceInfo.addDatatableActions, "bSortable": false, "bSearchable": false , "sClass":"td-actions" },    // <---- getting ID column again, but will re-write it as delete icon
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
	                                "sTitle":"DeviceInfo Report",
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
		APP_COMMON.initPage('Device Information');
		$('#ajax-page-title').html('<i class="icon-user"></i> Device Info : Index');	   
		FN_DeviceInfo.initTable();
    });
</script>


