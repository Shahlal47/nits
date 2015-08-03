<div class="span12">
	<div class="row-fluid">
		<!-- .span12 -->
		<div class="span12">
			<div class="box">
				<header>
					<div class="toolbar">
						<a href="javascript;" id="btnExport"> <i class="icon-list"></i>
							Excel report
						</a>
					</div>
				</header>
				<header>
					<h5>
						<i class="icon-edit"></i> Halt Report
					</h5>
					<div class="toolbar">
						<a class="accordion-toggle minimize-box" data-toggle="collapse"
							href="#reportResult"> <i class="icon-chevron-up"></i>
						</a>
					</div>
				</header>
				<div class="body collapse in" id="reportResult">
					<table class="table table-bordered responsive" id="nitsreport">
						<thead>
							<tr>
								<th width="20%">Registration Number</th>
								<th width="15%">Date</th>
								<th width="10%">Duration (Min)</th>
								<th width="20%">Location</th>
								<th width="10%">Latitude</th>
								<th width="10%">Logitude</th>
								<th width="15%">Relavant Information</th>
							</tr>
						</thead>
						<tbody id="reportBody">
							<tr>
								<td colspan="7">No result found.</td>
							</tr>
						</tbody>
					</table>
					<div id='graphdiv'>
					</div>
				</div>
			</div>
		</div>
		<!-- /.span12 -->
	</div>
</div>
<style>
<!--
#reportResult table tr {
	font-size: 0.85em;
}

#reportResult table thead tr {
	background-color: #555555;
	font-size: 0.85em;
	font-style: bold;
	color: white;
}
-->
</style>
<script type="text/javascript">
$(document).ready(function () {

    function exportTableToCSV($table, filename) {

        //var $rows = $table.find('tr:has(td)'),
        var $rows = $table.find('tr'),

            // Temporary delimiter characters unlikely to be typed by keyboard
            // This is to avoid accidentally splitting the actual contents
            tmpColDelim = String.fromCharCode(11), // vertical tab character
            tmpRowDelim = String.fromCharCode(0), // null character

            // actual delimiter characters for CSV format
            colDelim = '","',
            rowDelim = '"\r\n"',

            // Grab text from table into CSV formatted string
            csv = '"' + $rows.map(function (i, row) {
                var $row;
                if(i == 0)
                    {
                	$row = $(row),
                    	$cols = $row.find('th');
                    }
                else{
                	$row = $(row),
                    	$cols = $row.find('td');
                    }
                

                return $cols.map(function (j, col) {
                    var $col = $(col),
                        text = $col.text();

                    return text.replace('"', '""'); // escape double quotes

                }).get().join(tmpColDelim);

            }).get().join(tmpRowDelim)
                .split(tmpRowDelim).join(rowDelim)
                .split(tmpColDelim).join(colDelim) + '"',

            // Data URI
            csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

        $(this)
            .attr({
            'download': filename,
                'href': csvData,
                'target': '_blank'
        });
    }

    $("#btnExport").on('click', function (event) {
        exportTableToCSV.apply(this, [$('#reportResult>table'), 'export.csv']);
    });
});

</script>

