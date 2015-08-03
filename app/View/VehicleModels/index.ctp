<div class="span12">
	<?php echo $this->Session->flash();?>
	<div class="box">
		<header>
			<div class="icons">
				<i class="icon-edit"></i>
			</div>
			<h5>List Vehicle Models</h5>
			<div class="toolbar">
				<ul class="nav">
					<li><a href="javascript:;"
						onclick="APP_HELPER.ajaxRequestModelAction('vehicleModels/add');">
							<i class="icon-plus"></i> New
					</a></li>
				</ul>
			</div>
		</header>

		<div class="body collapse in">
			<table id="VehicleModelListTable"
				class="table table-bordered table-striped table-highlight table-hover responsive">
				<thead>
					<tr>
						<th>Id</th>
						<th>Vehicle Type</th>
						<th>Name</th>
						<th>Description</th>
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
	var FN_VehicleModel = {
		tableName : '#VehicleModelListTable',
		VehicleModelListUrl : APP_HELPER.getFullPath("vehicleModels/jsondata"),
		addDatatableActions : function(oObj) {  
			var id = oObj.aData[0]; 
			var ondelete = "APP_HELPER.ajaxDeleteRecordAction('vehicleModels/delete/"+id+"')";
			var onedit = "APP_HELPER.ajaxRequestModelAction('vehicleModels/edit/"+id+"');";
			return '<a class="btn btn-small btn-warning" href="javascript:;" onclick="'+onedit+'"><i class="btn-icon-only icon-edit"></i></a><a class="btn btn-small" href="javascript:;" onclick="'+ondelete+'"><i class="btn-icon-only icon-remove"></i></a>';
		},
		initTable : function(){
			$(FN_VehicleModel.tableName).dataTable({
	        	"bFilter": false,"bInfo": false,
	        	"bProcessing": true,
	    		"bServerSide": true,
	    		"sAjaxSource": FN_VehicleModel.VehicleModelListUrl,
	    		"aoColumns": [     
							{ 'sName': 'id',  'sWidth': 30, 'sClass': 'center', 'bVisible':false},
							{ 'sName': 'name',  'sWidth': 30, 'sClass': 'center', },
							{ 'sName': 'name',  'sWidth': 30, 'sClass': 'center', },
							{ 'sName': 'desc',  'sWidth': 30, 'sClass': 'center', },
							{ "sName": "id",  "sWidth": 52, fnRender: FN_VehicleModel.addDatatableActions, "bSortable": false, "bSearchable": false , "sClass":"td-actions" },    // <---- getting ID column again, but will re-write it as delete icon
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
	                                "sTitle":"VehicleModel Report",
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
		document.title = 'NITS::VehicleModel';
		$('#ajax-page-title').html('<i class="icon-user"></i> Vehicle Model : Index');	   
		FN_VehicleModel.initTable();
    });
</script>

<!-- 'id','vehicle_type_id','name','desc',  -->
