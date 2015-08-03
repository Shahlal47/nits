<div class="span12">
<?php echo $this->Session->flash();?>
	<div class="box dark">
		<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5>Blocked Users</h5>
		<div class="toolbar">
			<ul class="nav">
				<li><a href="javascript:;"
					onclick="APP_HELPER.ajaxRequestModelAction('users/blockuser');"> <i
						class="icon-plus"></i> Add Block User </a></li>
			</ul>
		</div>
		</header>

		<div class="body collapse in">
			<table id="UserListTable"
				class="table table-bordered table-striped table-highlight table-hover responsive">
				<thead>
					<tr>
						<th>Id</th>
						<th>Username</th>
						<th>Role</th>
						<th>Email</th>
						<th>Block Type</th>
						<th>Active</th>
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
	var FN_User = {
		tableName : '#UserListTable',
		UserListUrl : APP_HELPER.getFullPath("users/jsondata?active=0"),
		addDatatableActions : function(oObj) {  
			var id = oObj.aData[0]; 
			var onedit = "APP_HELPER.ajaxRequestModelAction('users/blockuser/"+id+"');";
			return '<a class="btn btn-small btn-warning" href="javascript:;" onclick="'+onedit+'"><i class="btn-icon-only icon-edit"></i></a>';
		},
		addDatatableCheckBox : function(oObj) {  
			var flg = oObj.aData[4];
			if(flg){
				return '<i class="icon-check icon-1x"></i>';
			}else{
				return '<i class="icon-check-empty icon-1x"></i>';
			}
		},
		initTable : function(){
			$(FN_User.tableName).dataTable({
	        	"bFilter": false,"bInfo": false,
	        	"bProcessing": true,
	    		"bServerSide": true,
	    		"sAjaxSource": FN_User.UserListUrl,
	    		"aoColumns": [     
								{ 'sName': 'id',  'sWidth': 30, 'sClass': 'center', "bVisible": false},
								{ 'sName': 'username',  'sWidth': 30, 'sClass': 'center', },
								{ 'sName': 'role',  'sWidth': 30, 'sClass': 'center', },
								{ 'sName': 'email',  'sWidth': 30, 'sClass': 'center', },
								{ 'sName': 'block_type',  'sWidth': 30, 'sClass': 'center', },
								{ 'sName': 'active',  'sWidth': 30, 'sClass': 'center',fnRender: FN_User.addDatatableCheckBox , 'bVisible':false},
								{ "sName": "id",  "sWidth": 52, fnRender: FN_User.addDatatableActions, "bSortable": false, "bSearchable": false , "sClass":"td-actions" },    // <---- getting ID column again, but will re-write it as delete icon
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
	                                "sTitle":"User Report",
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
		document.title = 'NITS::User';
		$('#ajax-page-title').html('<i class="icon-user"></i> User : Index');	   
		FN_User.initTable();
    });
</script>

<!-- 'id','username','password','email','name','hash_change_password','role','active',  -->
