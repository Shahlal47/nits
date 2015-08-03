<div class="span12">
<?php echo $this->Session->flash();?>
	<div class="box">
		<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5>List Client Device Subscriptions</h5>
		
		</header>

		<div class="body collapse in">
			<table id="ClientDeviceSubscriptionListTable"
				class="table table-bordered table-striped table-highlight table-hover responsive">
				<thead>
					<tr>
						<th>Id</th>
						<th>Subscription Type</th>
						<th>Subscription Date</th>
						<th>Expire Date</th>
						<!-- <th class="td-actions"><?php echo __('Actions'); ?></th>  -->
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>

		</div>

	</div>
</div>

<script type="text/javascript">
	var FN_ClientDeviceSubscription = {
		tableName : '#ClientDeviceSubscriptionListTable',
		ClientDeviceSubscriptionListUrl : APP_HELPER.getFullPath("clientDeviceSubscriptions/jsondata?did=<?php echo $did?>"),
		addDatatableActions : function(oObj) {  
			var id = oObj.aData[0]; 
			var ondelete = "APP_HELPER.ajaxDeleteRecordAction('clientDeviceSubscriptions/delete/"+id+"')";
			var onedit = "APP_HELPER.ajaxRequestModelAction('clientDeviceSubscriptions/edit/"+id+"');";
			return '<a class="btn btn-small btn-warning" href="javascript:;" onclick="'+onedit+'"><i class="btn-icon-only icon-edit"></i></a><a class="btn btn-small" href="javascript:;" onclick="'+ondelete+'"><i class="btn-icon-only icon-remove"></i></a>';
		},
		initTable : function(){
			$(FN_ClientDeviceSubscription.tableName).dataTable({
	        	"bFilter": false,"bInfo": false,
	        	"bProcessing": true,
	    		"bServerSide": true,
	    		"sAjaxSource": FN_ClientDeviceSubscription.ClientDeviceSubscriptionListUrl,
	    		"aoColumns": [     
								{ 'sName': 'id',  'sWidth': 30, 'sClass': 'center', 'bVisible':false},
								{ 'sName': 'subscription_type',  'sWidth': 30, 'sClass': 'center', },
								{ 'sName': 'subscription_date',  'sWidth': 30, 'sClass': 'center', },
								{ 'sName': 'expire_date',  'sWidth': 30, 'sClass': 'center', },
								//{ "sName": "id",  "sWidth": 52, fnRender: FN_ClientDeviceSubscription.addDatatableActions, "bSortable": false, "bSearchable": false , "sClass":"td-actions" },    // <---- getting ID column again, but will re-write it as delete icon
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
	                                "sTitle":"ClientDeviceSubscription Report",
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
		APP_COMMON.initPage('Subscription History');   
		FN_ClientDeviceSubscription.initTable();
    });
</script>

<!-- 'id','client_info_id','client_device_id','subscription_date','expire_date','active',  -->
