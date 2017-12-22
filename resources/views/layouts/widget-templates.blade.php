

<div id="template_1" style="display: none;">
	
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

      	chart.draw(data, {width: width, height: height, title: 'Dummy Data', legend: {position: "top"}, curveType: 'function', });  // change to dynamic according to container dimensions
    }

	</script>

</div>



<div id="template_2" style="display: none;">
	
	<div id="widget_2"> </div>

	<script type="text/javascript">
		// Set a callback to run when the Google Visualization API is loaded.
    	google.charts.setOnLoadCallback(drawChart);
      
    	function drawChart() {
      		var jsonData = $.ajax({
          	url: "{{ url('ajax/data-widget-2') }}",
          	dataType: "json",
          	async: false
          	}).responseText;
          
      	// Create our data table out of JSON data loaded from server.
      	var data = new google.visualization.DataTable(jsonData);

      	// Instantiate and draw our chart, passing in some options.
      	var chart = new google.visualization.ColumnChart(document.getElementById('widget_2'));

      	// responsive layout
      	var width = $('#widget_2 .grid-stack-item-content .content').width();
      	var height = $('#widget_2 .grid-stack-item-content .content').height();

      	chart.draw(data, {width: width, height: height, title: 'Ciabatta ufficio, quartoraria - dati "reali" agganciati a Database', legend:{ position:'bottom' }, });  // change to dynamic according to container dimensions
    }

	</script>

</div>



<div id="template_3" style="display: none;">
  <h4>Energy consuption per Departement<br/>Years comparaison</h4>
  <div id="widget_3"> </div>

  <script type="text/javascript">
    // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);
      
      function drawChart() {
          var jsonData = $.ajax({
            url: "{{ url('ajax/data-widget-3') }}",
            dataType: "json",
            async: false
            }).responseText;
          
        // Create our data table out of JSON data loaded from server.
        var data = new google.visualization.DataTable(jsonData);

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.BarChart(document.getElementById('widget_3'));

        // responsive layout
        var width = $('#widget_3 .grid-stack-item-content .content').width();
        var height = $('#widget_3 .grid-stack-item-content .content').height();

        chart.draw(data, {width: width, height: height, title: 'Titolo', legend: {position: "bottom"}, });  // change to dynamic according to container dimensions
    }

  </script>	
</div>



<div id="template_4" style="display: none;">
	
<h4>Energy consumption in 2017 per Departement</h4>
  <div id="widget_4"> </div>

  <script type="text/javascript">
    // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);
      
      function drawChart() {
          var jsonData = $.ajax({
            url: "{{ url('ajax/data-widget-4') }}",
            dataType: "json",
            async: false
            }).responseText;
          
        // Create our data table out of JSON data loaded from server.
        var data = new google.visualization.DataTable(jsonData);

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.AreaChart(document.getElementById('widget_4'));

        // responsive layout
        var width = $('#widget_4 .grid-stack-item-content .content').width();
        var height = $('#widget_4 .grid-stack-item-content .content').height();

        chart.draw(data, {width: width, height: height, title: 'Sub-title', legend: {position: "bottom"}, });  // change to dynamic according to container dimensions
    }

  </script>

</div>



<div id="template_5" style="display: none;">
	
  <h4>Energy consumption - 2017</h4>
  <div id="widget_5"> </div>

  <script type="text/javascript">
    // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);
      
      function drawChart() {
          var jsonData = $.ajax({
            url: "{{ url('ajax/data-widget-5') }}",
            dataType: "json",
            async: false
            }).responseText;
          
        // Create our data table out of JSON data loaded from server.
        var data = new google.visualization.DataTable(jsonData);

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('widget_5'));

        // responsive layout
        var width = $('#widget_5 .grid-stack-item-content .content').width();
        var height = $('#widget_5 .grid-stack-item-content .content').height();

        chart.draw(data, {width: width, height: height, title: 'Consumption per Departement - %', pieHole: 0.4, legend: {position: "right", alignment: "center"}, });  // change to dynamic according to container dimensions
    }

  </script>


</div>






{{-- ALL TEMPLATES LIST --}}
<script>
	// var template_1 = $('#template_1').html();		
	// var template_2 = $('#template_2').html();
	// var template_3 = $('#template_3').html();
	// var template_4 = $('#template_4').html();
	// var template_5 = $('#template_5').html();

  @if(isset($widgets)) 

  	@foreach ($widgets as $widget)		
  		var template_{{ $widget->widget_id }} = $('#template_{{ $widget->widget_id }}').html();
  	@endforeach

  {{-- @else --}}

  @endif

</script>