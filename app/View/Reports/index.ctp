<div class="span12">
	<div id="report-view"></div>
</div>



<script>
var REPORT_SCRIPT = {
		client_report : {}, 
}
$(document).ready(function(){

	APP_HELPER.ajaxSubmitDataCallback('reports/left/<?php echo $id;?>','',function(data){
		$('#left').html(data);
	});
	 $('#left').css('width','220px');
	 $('#content').css('margin-left','220px');
});

function active_list(node){
	$(node).addClass('color-green');
	$(node).parent().addClass('active');	
}
function remove_active_list(){
	$('#report-list li').removeClass('active');
	$('#report-list li a').removeClass('color-green');
	$('#report-list li a').addClass('color-red');
}
</script>

