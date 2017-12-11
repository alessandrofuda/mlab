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



<!--div id="grid2" class="grid-stack sx"> </div-->


<!--script type="text/javascript">

    /* $(function () {
    	var options1 = {
        	cellHeight: 60,
        	verticalMargin:10,
        	alwaysShowResizeHandle:false,
        	width:12, // column number
        	float:false,  // ???
        	acceptWidgets: '#grid2 .grid-stack-item', // '#grid2',
        };
        var options2 = {
        	cellHeight: 'auto', // 80,
        	verticalMargin: 10,
        	alwaysShowResizeHandle: /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),  // if touch not work cfr 444 issue
            width: 12,
            // float: false,
            acceptWidgets: '#grid1 .grid-stack-item', // '#grid1',
        };
        
        $('#grid1').gridstack(options1);  // control-sidebar dx
        $('#grid2').gridstack(_.defaults({
            float: true,
        }, options2));


        // $('.grid-stack').each(function () {  // ! loop for each '.grid-stack'.  First: grid2 , second:grid1

        var items1 = [
         	{x: 0, y: 0, width: 12, height: 2},
	        {x: 0, y: 2, width: 12, height: 2},
	        {x: 0, y: 4, width: 12, height: 2},
	        {x: 0, y: 6, width: 12, height: 2},
	        {x: 0, y: 8, width: 12, height: 2},
        ];

        var items2 = [
        	{x: 0, y: 0, width: 12, height: 4},
        ];


        // var items_sx = [
        //	{x: 0, y: 0, width: 1, height: 2},
        // ];
        // console.log(items);  // array di 5 oggetti

        // try to convert to: $('#grid1 > .grid-stack') ...
        //$('.grid-stack').each(function () {  // ! loop for each '.grid-stack'.  First: grid2 , second:grid1
        //    var grid = $(this).data('gridstack');
        //    console.log(grid);
        //	console.log(items);
        //    _.each(items, function (node, i) {
        //        grid.addWidget($('<div style="background-color: green; border:1px solid #FFF;"><div class="grid-stack-item-content">' + i + '</div></div>'),
        //            node.x, node.y, node.width, node.height);
        //    }, this);
        //}); 

        // TEST
        var grid = $('.grid-stack.dx').data('gridstack');
        console.log(grid);
        console.log(items1);
        _.each(items1, function (node, i) {
            grid.addWidget($('<div style="background-color: green; border:1px solid #FFF;"><div class="grid-stack-item-content">' + i + '</div></div>'),
                node.x, node.y, node.width, node.height);
        }, this);
                

        // $('.sidebar .grid-stack-item').draggable({
        //    revert: 'invalid',
        //    handle: '.grid-stack-item-content',
        //    scroll: false,
        //    appendTo: 'body'
        // });
    }); */



</script-->
<script src="{{ asset('js/gridstack/src/third-party-integr/multiple-grids.js') }}"></script>
<script>
	var serialized_data = [
		{id: 1, name: 'Widget 1', x: 0, y: 0, width: 1, height: 3, active: true},
		{id: 2, name: 'Widget 2', x: 1, y: 0, width: 2, height: 3, active: true},
		{id: 3, name: 'Widget 3', x: 3, y: 0, width: 1, height: 3, active: true},
		{id: 4, name: 'Widget 4', x: 0, y: 3, width: 1, height: 1, active: true},
		{id: 5, name: 'Widget 5', x: 1, y: 4, width: 3, height: 1, active: true},
		{id: 6, name: 'Widget 6', x: 0, y: 4, width: 1, height: 2, active: true},
		{id: 7, name: 'Widget 7', x: 1, y: 4, width: 1, height: 2, active: true},
		{id: 8, name: 'Widget 8', x: 2, y: 5, width: 1, height: 2, active: true},
		{id: 9, name: 'Widget 9', x: 0, y: 0, width: 1, height: 2, active: false},
		{id: 10, name: 'Widget 10', x: 1, y: 0, width: 1, height: 1, active: false},
		{id: 11, name: 'Widget 11', x: 1, y: 1, width: 1, height: 1, active: false},	
	];

</script>



<div id="dashboard">
    <div class="active-widgets">
        <!--div class="header-title">
	        <h1>Active Widgets</h1>
        </div-->
        <div class="grid-stack grid-stack-active">              
        </div>
    </div>
    <!--div class="header-title">
        <h1>Inactive Widgets</h1>
    </div>
    <div class="inactive-widgets">		
        <div class="grid-stack grid-stack-inactive">
        </div>
    </div-->
</div>

<div id="template" style="display: none;">
    <div class="widget">
        <div class="grid-stack-item-content">
            <div class="portlet-header" style="vertical-align: middle;">
                <span class="header"></span>
            </div>
            <div class="content">
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tatio 
                ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla
                facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option 		
                congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt 	
                lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum
                claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.
            </div>
        </div>
    </div>
</div> 

<script type="text/javascript">
	$(function () {
		dashboardFn.initiate();
	});
</script>

@stop
