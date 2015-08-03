<div class="span12">
<?php echo $this->Session->flash();?>
	<div class="box">
		<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5>Contact & Alert Settings</h5>
		<div class="toolbar">
			<ul class="nav">
				<li><a href="javascript:;"
					onclick="APP_HELPER.ajaxLoad('clientAlertSettings/add/<?php echo $id?>','<?php echo $ajaxPlaceholder?>');">
						<i class="icon-plus"></i> New </a></li>
			</ul>
		</div>
		</header>

		<div class="body collapse in">
			<table id="ClientAlertSettingListTable"
				class="table table-bordered table-striped table-highlight table-hover responsive">
				<thead>
					<tr>
						<th>Id</th>
						<th>Tracker Device</th>
						<th>Contact</th>
						<th>Alert Type</th>
						<th>Sms</th>
						<th>Email</th>
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
	var FN_ClientAlertSetting = {
		tableName : '#ClientAlertSettingListTable',
		ClientAlertSettingListUrl : APP_HELPER.getFullPath("clientAlertSettings/jsondata?client_info_id=<?php echo $id?>"),
		addDatatableActions : function(oObj) {  
			var id = oObj.aData[0]; 
			var ondelete = "APP_HELPER.ajaxDeleteRecordAction('clientAlertSettings/delete/"+id+"?clientid=<?php echo $id?>','<?php echo $ajaxPlaceholder?>')";
			var onedit = "APP_HELPER.ajaxLoad('clientAlertSettings/edit/"+id+"?clientid=<?php echo $id?>','<?php echo $ajaxPlaceholder?>');";
			
			return '<a class="btn btn-small btn-warning" href="javascript:;" onclick="'+onedit+'"><i class="btn-icon-only icon-edit"></i></a><a class="btn btn-small" href="javascript:;" onclick="'+ondelete+'"><i class="btn-icon-only icon-remove"></i></a>';
		},
		addDatatableCheckBox4 : function(oObj) {  
			if(oObj.aData[4]){
				return '<i class="icon-check icon-1x"></i>';
			}else{
				return '<i class="icon-check-empty icon-1x"></i>';
			}
		},
		addDatatableCheckBox5 : function(oObj) {  
			if(oObj.aData[5]){
				return '<i class="icon-check icon-1x"></i>';
			}else{
				return '<i class="icon-check-empty icon-1x"></i>';
			}
		},
		
		initTable : function(){
			$(FN_ClientAlertSetting.tableName).dataTable({
	        	"bFilter": false,"bInfo": false,
	        	"bProcessing": true,
	    		"bServerSide": true,
	    		"sAjaxSource": FN_ClientAlertSetting.ClientAlertSettingListUrl,
	    		"aoColumns": [     
								{ 'sName': 'id',  'sWidth': 30, 'sClass': 'center', "bVisible": false},
								{ 'sName': 'device',  'sWidth': 30, 'sClass': 'center', },
								{ 'sName': 'contact',  'sWidth': 30, 'sClass': 'center', },
								{ 'sName': 'alert_type',  'sWidth': 30, 'sClass': 'center', },
								{ 'sName': 'is_sms',  'sWidth': 30, 'sClass': 'center', fnRender: FN_ClientAlertSetting.addDatatableCheckBox4},
								{ 'sName': 'is_email',  'sWidth': 30, 'sClass': 'center', fnRender: FN_ClientAlertSetting.addDatatableCheckBox5},
								{ "sName": "id",  "sWidth": 52, fnRender: FN_ClientAlertSetting.addDatatableActions, "bSortable": false, "bSearchable": false , "sClass":"td-actions" },    // <---- getting ID column again, but will re-write it as delete icon
	    		        ],			    		        			    		        
	        	"fnServerData": function ( sSource, aoData, fnCallback ) {
	                $.getJSON( sSource, aoData, function (json) { 
	                    fnCallback(json);
	                } );
	            },
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
	                                "sTitle":"ClientAlertSetting Report",
	                                "sPdfOrientation": "landscape",
	                                "sPdfMessage": "Genral Report"
	                            }
	                        ]
	                    }
	                ],
	                "sSwfPath": "<?php echo $this->webroot;?>js/lib/datatables/swf/copy_csv_xls_pdf.swf"
	            }
	        });

		}
	};
	$(function(){
		APP_COMMON.initPage('Alert Settings');

		$('#ajax-page-title').html('<i class="icon-user"></i> Client Alert Setting : Index');	   
		FN_ClientAlertSetting.initTable();
    });
</script>

<!-- 'id','client_info_id','alert_type_id','client_contact_id','client_device_id','is_sms','is_email',  -->
