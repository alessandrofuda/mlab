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
			{id: 9, name: 'Widget 9', x: 0, y: 0, width: 2, height: 1, active: false},
			{id: 10, name: 'Widget 10', x: 1, y: 0, width: 2, height: 1, active: false},
			{id: 11, name: 'Widget 11', x: 1, y: 1, width: 2, height: 1, active: false},	
		];

	</script>



	<div id="dashboard">
	    <div class="active-widgets">
	        <div class="grid-stack grid-stack-active">              
	        </div>
	    </div>
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
