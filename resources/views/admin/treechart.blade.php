@extends('adminlte::page') 

@section('title', 'AdminLTE')

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')



{{-- @foreach ($nodes as $node)
	
	<p>node id: {{ $node->id }}, node type: {{ $node->stType->shortDescr }}</p>

@endforeach --}}

{{-- dump($nodes) --}}





<div id="tree_chart" style="overflow-x: scroll; overflow-y: auto;"> </div>


<script type="text/javascript">
	// Set packages (in theory must be in header)
	google.charts.load('current', {packages:["orgchart"]});
	// Set a callback to run when the Google Visualization API is loaded.
	google.charts.setOnLoadCallback(drawChart);
  
	function drawChart() {
  		var jsonData = $.ajax({
      		url: "{{ url('ajax/data-treechart') }}",
      		dataType: "json",
      		async: false
      	}).responseText;
      	
      	console.log(jsonData);

  		// Create our data table out of JSON data loaded from server.
  		var data = new google.visualization.DataTable(jsonData);


	  	// Instantiate and draw our chart, passing in some options.
	  	var chart = new google.visualization.OrgChart(document.getElementById('tree_chart'));

	  	// responsive layout
	  	var width = $('#tree_chart').width();  // .grid-stack-item-content .content
  	  	var height = $('#tree_chart').height();   //   .grid-stack-item-content .content

	  	chart.draw(data, {allowHtml:true, width:width, height:height, title: 'Node Tree', });  // change to dynamic according to container dimensions
    }

</script>




@stop