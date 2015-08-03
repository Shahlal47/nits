<div class="span12">
<?php echo $this->Session->flash();?>
	<div class="box">
		<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5>User login time <?php echo $username?></h5>
		</header>

		<div class="body collapse in">
			<table id="UserLogListTable"
				class="table table-bordered table-striped table-highlight table-hover responsive">
				<thead>
					<tr>
						<th>Id</th>
						<th>Username</th>
						<th>Role</th>
						<th>Login Date-Time</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>

		</div>

	</div>
</div>

<script type="text/javascript">
	var FN_UserLog = {
		tableName : '#UserLogListTable',
		UserLogListUrl : APP_HELPER.getFullPath("userLogs/jsondata?user_id=<?php echo $userid?>"),
		initTable : function(){
			$(FN_UserLog.tableName).dataTable({
	        	"bFilter": false,"bInfo": false,
	        	"bProcessing": true,
	    		"bServerSide": true,
	    		"sAjaxSource": FN_UserLog.UserLogListUrl,
	    		"aoColumns": [     
							{ 'sName': 'id',  'sWidth': 30, 'sClass': 'center', 'bVisible':false},
							{ 'sName': 'username',  'sWidth': 30, 'sClass': 'center', <?php if($userid){?> 'bVisible':false<?php } ?>},
							{ 'sName': 'role',  'sWidth': 30, 'sClass': 'center', <?php if($userid){?> 'bVisible':false<?php } ?>},
							{ 'sName': 'created',  'sWidth': 30, 'sClass': 'center'},
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
	                                "sTitle":"UserLog Report",
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
		document.title = 'NITS::UserLog';
		$('#ajax-page-title').html('<i class="icon-user"></i> User Log : Index');	   
		FN_UserLog.initTable();
    });
</script>

<!-- 'id','user_id',  -->
