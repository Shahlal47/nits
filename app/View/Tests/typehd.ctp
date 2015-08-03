
<div class="example example-twitter-oss">

	<div class="demo">
		<input class="typeahead" type="text"
			placeholder="open source projects by Twitter">
	</div>


</div>



<script>
	$(document).ready(function() {

		  $('.example-twitter-oss .typeahead').typeahead({
			name: 'test',
			
			remote: 'http://localhost:8080/nits/tests/search/%QUERY',
			limit: 10,
			template: [
			  '<p class="repo-language">{{odj}} - {{fld}}</p>',
			  '<p class="repo-name">{{search}}</p>'
			].join(''),
			engine: Hogan
		  });
	});
	</script>
