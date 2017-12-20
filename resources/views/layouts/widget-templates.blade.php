

<div id="template_1" style="display: none;">
	<p>import template: template-1_AAAA</p>
	<div id="widget_1"> </div>

	<script type="text/javascript">
		// Set a callback to run when the Google Visualization API is loaded.
    	google.charts.setOnLoadCallback(drawChart);
      
    	function drawChart() {
      		var jsonData = $.ajax({
          	url: "{{ url('ajax/data-widget-1') }}",
          	dataType: "json",
          	async: false
          	}).responseText;
          
      	// Create our data table out of JSON data loaded from server.
      	var data = new google.visualization.DataTable(jsonData);

      	// Instantiate and draw our chart, passing in some options.
      	var chart = new google.visualization.LineChart(document.getElementById('widget_1'));

      	// responsive layout
      	var width = $('#widget_1 .grid-stack-item-content .content').width();
      	var height = $('#widget_1 .grid-stack-item-content .content').height();

      	chart.draw(data, {width: width, height: height});  // change to dynamic according to container dimensions
    }

	</script>

</div>



<div id="template_2" style="display: none;">
	<p>import template: template-2_BBBB</p>
</div>



<div id="template_3" style="display: none;">
	<p>SDKHFSDKHSDFJ import template: template-3_CCCC</p>
</div>



<div id="template_4" style="display: none;">
	<p>import template: template-4_DDDDD</p>
</div>



<div id="template_5" style="display: none;">
	<p>import template: template-5_EEEEE</p>
</div>




{{-- ALL TEMPLATES LIST --}}
<script>
	// var template_1 = $('#template_1').html();		
	// var template_2 = $('#template_2').html();
	// var template_3 = $('#template_3').html();
	// var template_4 = $('#template_4').html();
	// var template_5 = $('#template_5').html();

	@foreach ($widgets as $widget)		
		var template_{{ $widget->widget_id }} = $('#template_{{ $widget->widget_id }}').html();
	@endforeach
</script>