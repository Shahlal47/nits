<div style="margin: 0;">
	<div class="box dark">
		<header>
			<h5 style="margin-left: 90px;">Accounts Panel</h5>
		</header>
		<div id="div-1" class="body">

			<table id="acc_panel" style="padding: 1%;">
				<tbody>
					<tr class="t_head">
						<td><b>Total Trackers : </b>
						</td>
						<td id="tt" class="text-right" style="padding-right: 5px;"></td>
					</tr>
					<tr>
						<td>Vehicle Trackers :</td>
						<td id="vt" class="text-right" style="padding-right: 5px;"></td>
					</tr>
					<tr>
						<td>Personal Trackers :</td>
						<td id="pt" class="text-right" style="padding-right: 5px;"></td>
					</tr>
					<tr class="t_head">
						<td><b>Total Clients : </b>
						</td>
						<td id="tc" class="text-right" style="padding-right: 5px;"></td>
					</tr>
					<tr>
						<td>Group Clients :</td>
						<td id="gc" class="text-right" style="padding-right: 5px;"></td>
					</tr>
					<tr>
						<td>Single Clients :</td>
						<td id="sc" class="text-right" style="padding-right: 5px;"></td>
					</tr>

				</tbody>
			</table>

		</div>
	</div>
</div>

<style>
.div header {
	margin: 0;
}

#acc_panel tbody tr td {
	border: 1px solid #DDDDDD;
	width: 45%;
	font-size: 1em;
	overflow: hidden;
	white-space: nowrap;
	padding: 1px;
	border-radius: 2px 2px 2px 2px;
	height: 30px;
}

.box header h5 {
	margin: 5px 0 5px 15px;
}

.t_head {
	background-color: #000;
	color: #FFF;
}
</style>

<script type="text/javascript">


$(function(){
	$('#left').css('width','300px');
    $('#content').css('margin-left','300px');    
});

</script>
