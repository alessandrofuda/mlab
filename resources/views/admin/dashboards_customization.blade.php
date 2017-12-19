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
    <p>dashboard customization</p>

<div class="container">
	<div class="row">
		<form id="redesign-dashboard" class="" action="{{ url('admin/dashboards-customization') }}" method="POST">
			{{ csrf_field() }}
			<div class="col-md-3 form-group">
				<label for="user">Select User</label>
				<select name="user" class="form-control">
					<option value="">--- Select User ---</option>
					@foreach ($users as $user)
						<option value="{{ $user->id }}">{{ $user->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-3 form-group">
				<label for="dashboard">Select Dashboard:</label>
				<select name="dashboard" class="form-control">	
				</select>
			</div>
			<div class="col-md-3 form-group">
				<label for="submit" style="visibility: hidden;">.</label>
				<input class="form-control btn btn-info" type="submit" value="Re-design user dashboard" />
			</div>
		</form>
	</div>
	<div class="sub-title">
		{!! isset($sub_title) ? $sub_title : '' !!}
	</div>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		// incremental dropdown
		$('select[name="user"]').on('change', function() {
			var userID = $(this).val();
			if(userID) {
				$.ajax({
					url: "{{url('ajax/dashboard-customization/user-') }}"+userID,
					type: "GET",
					dataType: "json",
					success:function(data) {
						// console.log(data.length);
						if (data.length > 0 ) {
							$('select[name="dashboard"]').empty();
							$('select[name="dashboard"]').removeAttr('disabled');
							$('select[name="dashboard"]').append('<option value="">--- Select Dashboard ---</option>');
							$.each(data, function(key, value) {
								//console.log(value.dashboard.name);
								$('select[name="dashboard"]').append('<option value="'+ value.dashboard_id +'">'+ value.dashboard.name +'</option>');
							});
						} else {
							$('select[name="dashboard"]').empty();
							$('select[name="dashboard"]').attr('disabled', 'disabled');
							$('select[name="dashboard"]').append('<option value="">No dashboards found for this user</option>');
						}
					},
					error: function(req, err){
						console.log('errore');
						console.log (req);
						console.log(err);
					}
				});
			}else{
				$('select[name="dashboard"]').empty();
			}
		});


		// ajax form submit on change (without submit button)
		/*$('select[name="dashboard"]').on('change', function() {
			var userID = $('select[name="user"]').val();
			var dashboardID = $(this).val();
			console.log('userID:'+userID+' dashboardID:'+dashboardID);
			if(userID && dashboardID) {
				console.log('ok');
				$.ajax({
					url: "{{-- url('ajax/dashboard-redesign/user-') --}}"+userID+"/dashboard-"+dashboardID,
					type: "GET",
					dataType: "json",
					success:function(data) {
						console.log(data);


						if (data.length > 0 ) {
							// ricarica pagina con data
							location.reload(data);

						} else {
							// ricarica pagina senza data
							location.reload();
						}

					},
					error: function(req, err){
						console.log('errore');
						console.log (req);
						console.log(err);
					}
				});
			}
		}); */



		// form submit
		/*$('#redesign-dashboard').submit( function(event) {
			

			console.log('submit ok!');


			event.preventDefault();
		});*/

	});
</script>



	<!-- redesign dashboards-->


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

	<script src="{{ asset('js/gridstack/src/third-party-integr/multiple-grids.js') }}"></script>
	<script>
		var host = '{{ url('/') }}';
		var current_dashboard = '{{ isset($current_dashboard) ? $current_dashboard : null }}';
		var current_user = '{{ isset($current_user) ? $current_user : null }}';

		@if(isset($widgets)) 

		var serialized_data = [
			@foreach ($widgets as $widget)
				{ id:{{ $widget->widget_id }}, name:'{{ $widget->widgets->name }}', x: {{$widget->x}}, y: {{$widget->y}}, width: {{$widget->width}}, height:{{$widget->height}}, active: {{$widget->active?'true':'false'}} },
			@endforeach
		];


		@else

		var serialized_data = null;

		@endif

		/*
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
		*/
	</script>

	<script type="text/javascript">
		$(function () {
			dashboardFn.initiate();
		});
	</script>


	<script>
       // Ajax call for re-positioning & resizing grid-stack-item
       	$('.grid-stack').on('change', function() {  
       		
       		var widgets = [];
       		var items = $('.grid-stack-item');
       		// console.log( $(items[0]).attr('data-gs-x') );

       		for (i = 0; i < items.length; i++) {
       			var active = 1;
       			var parent = $(items[i]).parent();
       			if( parent.hasClass('grid-stack-inactive') ){
       				var active = 0;
       			}

		        var widgetsObj = {
		        	'user_id': current_user,
		        	'dashboard_id': current_dashboard,
		            'id': $(items[i]).attr('data-widget-id'),
			        'x':  $(items[i]).attr('data-gs-x'),
			        'y':  $(items[i]).attr('data-gs-y'),
				    'width': $(items[i]).attr('data-gs-width'),
		            'height': $(items[i]).attr('data-gs-height'),
		            'active': active,
		        }

		        widgets.push(widgetsObj);
		    }      		
       		
       		// console.log(widgets);
       		/* console.log('-------START '+ Date($.now()) +'-------');
		    for(i = 0; i < widgets.length; i++) {
	        	console.log('Item:' + i + ' /// ' + ' id:'+ widgets[i].id + '  x:'+ widgets[i].x + '  y:'+ widgets[i].y + '  width:'+ widgets[i].width + '  height:' + widgets[i].height + '  active:' + widgets[i].active);
	        }
	        console.log('-------END------'); */

	        $.ajaxSetup({
	            headers: {
	              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
	            }
	        });
	        $.ajax({
	            type: 'POST',
	            url: host + '/ajax/dashboard',
	            data: {widgets: widgets},   // {id: id, x: x, y: y, active: active},
	            success: function( msg ) {
	              // console.log('chiamata ajax OK: ' + msg);
	            },
	            error: function(req, err) {
	              // console.log('chamata ajax errore: ');
	              console.log(req);
	              console.log(err);
	            }
	        });	        

       	});

	</script>


	






    


@stop