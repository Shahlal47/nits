<div class="span12">
	<div class="row-fluid">
		<!-- .span12 -->
		<div class="span12">
			<div class="box">
				<header>
					<h5>Expense Report</h5>
					<div class="toolbar">
						<a class="accordion-toggle minimize-box" data-toggle="collapse"
							href="#reportResult"> <i class="icon-chevron-up"></i>
						</a>
					</div>
				</header>
				<div class="body collapse in" id="reportResult">
					<table class="table table-bordered responsive">
						<thead>
							<tr>
								<th width="25%">From</th>
								<th width="25%">To</th>
								<th width="10%">Start</th>
								<th width="10%">End</th>
								<th width="10%">Period</th>
								<th width="10%">Mileage</th>
								<th width="10%">Fuel Cost</th>
							</tr>
						</thead>
						<tbody id="reportBody">
							<tr>
								<td colspan="7">No result found.</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /.span12 -->
	</div>
</div>
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

