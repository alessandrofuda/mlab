@extends('adminlte::page')   {{-- from: .. /resources/views/vendor/adminlte/page.blade.php    --}}

@section('title', config('adminlte.title', 'AdminLTE'))


@section('widgets_button')
	<li id="widgets-list">
		<a href="#" data-toggle="control-sidebar">
			<i class="fa fa-chevron-left"></i> <span class="hidden-xs" style="margin:0 6px;">Widgets</span> <i class="fa fa-bar-chart" style="font-size:130%;"></i>
		</a>
	</li>
@stop


@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')
    <p>You are logged in!</p>
    <p>My admin dashboard</p>
	<!--style>
		.grid{ min-height: 100px; border:1px solid red; box-sizing: border-box; }
		.box{ margin:10px; padding:10px; border:1px dashed #CCC; box-sizing: border-box; min-height: 200px; width: auto;} 
	</style>    
    <div id="drop-target" class="container" style="width: 100%; border:1px solid #CCC; min-height: 400px;">
    	<div class="row">
    		<div class="col-md-6 grid">
    			<div id="box-1" class="drop-target box"></div>
    		</div>
    		<div class="col-md-6 grid">
    			<div id="box-2" class="drop-target box"></div>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-md-4 grid">
    			<div id="box-3" class="drop-target box"></div>
    		</div>
    		<div class="col-md-4 grid">
    			<div id="box-4" class="drop-target box"></div>
    		</div>
    		<div class="col-md-4 grid">
    			<div id="box-5" class="drop-target box"></div>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-md-4 grid">
    			<div id="box-6" class="drop-target box"></div>
    		</div>
    		<div class="col-md-4 grid">
    			<div id="box-7" class="drop-target box"></div>
    		</div>
    		<div class="col-md-4 grid">
    			<div id="box-8" class="drop-target box"></div>
    		</div>
    	</div>
    	drop target
    </div-->



<!--div class="draggable_test">Drag me</div>
 
<script>
$( ".draggable_test" ).draggable({scroll: true });
</script-->



gridstack.js
<style>
	.grid-stack > .grid-stack-item { border:1px solid #888; }
</style>


<div id="grid2" class="grid-stack grid-stack-4"> </div>


<script type="text/javascript">
    $(function () {
    	var options1 = {
        	cellHeight: 60,
        	verticalMargin:10,
        	alwaysShowResizeHandle:false,
        	width:1, // column number
        	float:false,  // ???
        	acceptWidgets: '#grid2 > .grid-stack-item',
        };
        var options2 = {
        	cellHeight: 'auto', // 80,
        	verticalMargin: 10,
        	alwaysShowResizeHandle: /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),  // if touch not work cfr 444 issue
            width: 4,
            // float: false,
            acceptWidgets: '#grid1 > .grid-stack-item',
        };
        
        $('#grid1').gridstack(options1);  // control-sidebar dx
        $('#grid2').gridstack(_.defaults({
            float: true,
        }, options2));


        // $('.grid-stack').each(function () {  // ! loop for each '.grid-stack'.  First: grid2 , second:grid1

        var items = [
         	{x: 0, y: 0, width: 1, height: 2},
	        {x: 0, y: 2, width: 1, height: 2},
	        {x: 0, y: 4, width: 1, height: 2},
	        {x: 0, y: 6, width: 1, height: 2},
	        {x: 0, y: 8, width: 1, height: 2},
        ];

        // var items_sx = [
        //	{x: 0, y: 0, width: 1, height: 2},
        // ];
        // console.log(items);  // array di 5 oggetti

        // try to convert to: $('#grid1 > .grid-stack') ...
        $('.grid-stack').each(function () {  // ! loop for each '.grid-stack'.  First: grid2 , second:grid1
            var grid = $(this).data('gridstack');
            console.log(grid);
        	console.log(items);
            _.each(items, function (node, i) {
                grid.addWidget($('<div style="background-color: green; border:1px solid #FFF;"><div class="grid-stack-item-content">Testing.. index:' + i + '</div></div>'),
                    node.x, node.y, node.width, node.height);
            }, this);
        });

        // $('.sidebar .grid-stack-item').draggable({
        //    revert: 'invalid',
        //    handle: '.grid-stack-item-content',
        //    scroll: false,
        //    appendTo: 'body'
        // });
    });
</script>


@stop
