@extends('adminlte::page')   

@section('title', config('adminlte.title', 'AdminLTE'))


@section('content_header')
    <h1>My Tree</h1>
@stop

@section('content')
    <p></p>
    <p>My subtree tree chart</p>


	{{-- var_dump($subTree) --}} 
    <style>table.google-visualization-orgchart-table {border-collapse: separate!important;}</style>
    <div id="my_tree_chart" style="overflow-x: auto; overflow-y: auto;"> </div>

    <script type="text/javascript">
	// Set packages (in theory must be in header)
	google.charts.load('current', {packages:["orgchart"]});
	// Set a callback to run when the Google Visualization API is loaded.
	google.charts.setOnLoadCallback(drawChart);
  
	function drawChart() {
  		var jsonData = $.ajax({
      		url: "{{ url('ajax/data-myTreechart') }}",
      		dataType: "json",
      		async: false
      	}).responseText;
      	
      	console.log(jsonData);

  		// Create our data table out of JSON data loaded from server.
  		var data = new google.visualization.DataTable(jsonData);


	  	// Instantiate and draw our chart, passing in some options.
	  	var chart = new google.visualization.OrgChart(document.getElementById('my_tree_chart'));

	  	// responsive layout
	  	var width = $('#my_tree_chart').width();  // .grid-stack-item-content .content
  	  	var height = $('#my_tree_chart').height();   //   .grid-stack-item-content .content

	  	chart.draw(data, {allowHtml:true, width:width, height:height, title: 'subTree Nodes', });  // change to dynamic according to container dimensions
    }

</script>


@stop
