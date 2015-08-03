<div class="span12">
<?php echo $this->Session->flash();?>
	<div class="box dark">
		<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5>List of Client Information</h5>
		</header>

		<div class="body collapse in">
			<table id="ClientInfoListTable"
				class="table table-bordered table-striped table-highlight table-hover responsive">
				<thead>
					<tr>
						<th>Id</th>
						<th>User Name</th>
						<th>Client Type</th>
						<th>Client Name</th>
						<th>Address</th>
						<th>Phone</th>
						<th>Mobile</th>
						<th>Email</th>
						<th>Fax</th>
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
	var FN_ClientInfo = {
		tableName : '#ClientInfoListTable',
		ClientInfoListUrl : APP_HELPER.getFullPath("clientInfos/jsondata"),
		addDatatableActions : function(oObj) {  
			var id = oObj.aData[0]; 
			//var ondelete = "APP_HELPER.ajaxDeleteRecordAction('clientInfos/delete/"+id+"')";
			var onedit = "APP_HELPER.ajaxRequestModelAction('clientInfos/view/"+id+"');";
			return '<a class="btn btn-small btn-warning" href="javascript:;" onclick="'+onedit+'"><i class="btn-icon-only icon-edit"></i></a>';//<a class="btn btn-small" href="javascript:;" onclick="'+ondelete+'"><i class="btn-icon-only icon-remove"></i></a>';
		},
		initTable : function(){
			$(FN_ClientInfo.tableName).dataTable({
	        	"bFilter": true,"bInfo": false,
	        	"bProcessing": true,
	    		"bServerSide": true,
	    		"bStateSave": true,
	    		"sAjaxSource": FN_ClientInfo.ClientInfoListUrl,
	    		"aoColumns": [     
							{ 'sName': 'id',  'sWidth': 30, 'sClass': 'center', 'bVisible':false},
							{ 'sName': 'username',  'sWidth': 30, 'sClass': 'center', },
							{ 'sName': 'client_type_id',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},
							{ 'sName': 'company_type_id',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},
							{ 'sName': 'address',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},
							{ 'sName': 'phone',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},
							{ 'sName': 'mobile',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},
							{ 'sName': 'email',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},
							{ 'sName': 'fax',  'sWidth': 30, 'sClass': 'center', "bSearchable": false},
																																							{ "sName": "id",  "sWidth": 52, fnRender: FN_ClientInfo.addDatatableActions, "bSortable": false, "bSearchable": false , "sClass":"td-actions" },    // <---- getting ID column again, but will re-write it as delete icon
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
	                                "sTitle":"ClientInfo Report",
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
		APP_COMMON.initPage('Client Information');
		$('#ajax-page-title').html('<i class="icon-user"></i> Client Info : Index');	   
		FN_ClientInfo.initTable();
	});
</script>
