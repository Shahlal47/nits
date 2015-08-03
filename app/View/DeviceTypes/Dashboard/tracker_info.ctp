<div id="tracker-info-modal"
	style="position: fixed; margin: 50px 0 0 0; z-index: 1; height: 450px; width: 400px;"
	class="modal hide">
	<div class="modal-header" style="padding: 0 15px;">
		<button onclick="closeTrackerInfoBox();" aria-hidden="true"
			data-dismiss="modal" class="close" type="button">x</button>
		<h5>
			<img class="contact-item-object" style="width: 32px; height: 32px;"
				id="tracker-info-icon" src="img/LorryGreen.png"
				id="tracker-info-img"> ::: <span id="tracker-info-deviceid"></span>
		</h5>
	</div>
	<div class="modal-body">
		<ul id="myTab" class="nav nav-tabs">
			<li class="active"><a href="#home" data-toggle="tab">Last Update</a>
			</li>
			<li><a href="#sensors" data-toggle="tab">Sensors</a>
			</li>
			<!--  <li><a href="#messages" data-toggle="tab">Alerts</a></li> -->
			<li><a href="#settings" data-toggle="tab">Profile</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade in active" id="home">
				<table class="table table-striped  table-hover">
					<tbody>
						<tr>
							<td id="tracker-info-lastrecorddate">Date-Time:</td>
							<td></td>
						</tr>
						<tr>
							<td id="tracker-info-latlng">Lat-Lng:</td>
							<td></td>
						</tr>
						<tr>
							<td id="tracker-info-nearaddress">Location:</td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>


			<div class="tab-pane fade" id="sensors">
				<div style="float: left; width: 50%;">
					<h4>Fuel</h4>
					<div id="live-gauge-fuel" class="jgauge"></div>
				</div>
				<div style="float: left; width: 50%;">
					<h4>Speed</h4>
					<div id="live-gauge-speed" class="jgauge"></div>
				</div>
				<div style="float: left; width: 100%;">
					<h4>Odometer</h4>
					<div id="live-odometer" class="counter1"></div>
					Km
				</div>
			</div>
			<div class="tab-pane fade" id="messages">
				<!-- side-task -->
				<div class="side-task" style="overflow-y: scroll; height: 250px;">
					<div class="task fade in">
						<i class="icofont-bullhorn color-green" title="success"></i> <span
							class="task-desc">High Speed Alert</span>
						<button data-dismiss="alert" class="close">&times;</button>
					</div>
					<div class="task fade in">
						<i class="icofont-bullhorn color-green" title="success"></i> <span
							class="task-desc">High Speed Alert</span>
						<button data-dismiss="alert" class="close">&times;</button>
					</div>
					<div class="task fade in">
						<i class="icofont-bullhorn color-red" title="failed"></i> <span
							class="task-desc">GeoFence Alert</span>
						<button data-dismiss="alert" class="close">&times;</button>
					</div>
					<div class="task fade in">
						<i class="icofont-bullhorn color-silver-dark" title="cancel"></i>
						<span class="task-desc">Fule Alert</span>
						<button data-dismiss="alert" class="close">&times;</button>
					</div>
				</div>
				<!-- /side-task -->
			</div>
			<div class="tab-pane fade" id="settings">
				<table class="table table-striped  table-hover">
					<tbody>
						<tr>
							<td id="tracker-info-device_type">Device Type:</td>
							<td></td>
						</tr>
						<tr>
							<td id="tracker-info-device_model">Device Model:</td>
							<td></td>
						</tr>
						<tr>
							<td id="tracker-info-imei">Imei:</td>
							<td></td>
						</tr>
						<tr>
							<td id="tracker-info-devicemobileno">Device Mobile:</td>
							<td></td>
						</tr>
						<tr>
							<td id="tracker-info-person_name">Person Name:</td>
							<td></td>
						</tr>
						<tr>
							<td id="tracker-info-registration_number">Vehicle Registration:</td>
							<td></td>
						</tr>
						<tr>
							<td id="tracker-info-speed_limit">Speed Limit</td>
							<td></td>
						</tr>
						<tr>
							<td id="tracker-info-expiry_date">Expery Date:</td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>


	</div>
</div>
<style>
.table th,.table td {
	line-height: 15px;
}

.table th:first-child,.table td:first-child {
	font-weight: bold;
}

div.jgauge p.label {
	background-color: transparent;
}

.counter1 {
	width: 150px;
	height: 31px;
	border: 1px solid #fff;
	overflow: hidden;
	position: relative;
	background-color: #000;
}

.counter1 img {
	border: 1px solid #eee;
}

.jgauge {
	margin: 0 0 10px 10px !important;
}
</style>
<script type="text/javascript">
function closeTrackerInfoBox() {
	$("#tracker-info-modal").hide();
}</script>
