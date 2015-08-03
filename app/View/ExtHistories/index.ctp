
<div class="box">
	<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5>Extension Histories of selected device</h5>
	</header>

	<div class="body collapse in">
		<table id="ExtHistoryListTable"
			class="table table-bordered table-striped table-highlight table-hover responsive">
			<thead>
				<tr>
					<th>Id</th>
					<th>Memo Number</th>
					<th>Ref Number</th>
					<th>From Date</th>
					<th>To Date</th>
					<th>Update Date</th>
					<th class="td-actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	</div>
</div>


<script type="text/javascript">
	var FN_ExtHistory = {
		tableName : '#ExtHistoryListTable',
		ExtHistoryListUrl : APP_HELPER.getFullPath("extHistories/jsondata/<?php echo $cdsid;?>"),
		addDatatableActions : function(oObj) {  
			var id = oObj.aData[0]; 
			var ondelete = "APP_HELPER.ajaxDeleteRecordAction('extHistories/delete/"+id+"')";
			var onedit = "APP_HELPER.ajaxRequestModelAction('extHistories/edit/"+id+"');";
			return '<a class="btn btn-small btn-warning" href="javascript:;" onclick="'+onedit+'"><i class="btn-icon-only icon-edit"></i></a><a class="btn btn-small" href="javascript:;" onclick="'+ondelete+'"><i class="btn-icon-only icon-remove"></i></a>';
		},
		initTable : function(){
			$(FN_ExtHistory.tableName).dataTable({
	        	"bFilter": false,"bInfo": false,
	        	"bProcessing": true,
	    		"bServerSide": true,
	    		"sAjaxSource": FN_ExtHistory.ExtHistoryListUrl,
    		"aoColumns": [     
							{ 'sName': 'id',  'sWidth': 30, 'sClass': 'center', 'bVisible':false},
							{ 'sName': 'memo_number',  'sWidth': 30, 'sClass': 'center', },
							{ 'sName': 'ref_number',  'sWidth': 30, 'sClass': 'center', },
							{ 'sName': 'from_date',  'sWidth': 30, 'sClass': 'center', },
							{ 'sName': 'to_date',  'sWidth': 30, 'sClass': 'center', },
							{ 'sName': 'created',  'sWidth': 30, 'sClass': 'center', },
							{ "sName": "id",  "sWidth": 52, fnRender: FN_ExtHistory.addDatatableActions, "bSortable": false, "bSearchable": false , "sClass":"td-actions" , 'bVisible':false},    // <---- getting ID column again, but will re-write it as delete icon
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
	                                "sTitle":"ExtHistory Report",
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
		document.title = 'NITS::ExtHistory';
		$('#ajax-page-title').html('<i class="icon-user"></i> Ext History : Index');	   
		FN_ExtHistory.initTable();
    });
</script>

<!-- 'id','memo_number','ref_number','from_date','to_date','client_device_subscriptions_id',  -->
