
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
	                <!--Lorem .. futurum.-->
	            </div>
	        </div>
	    </div>
	</div> 

	<script src="{{ asset('js/gridstack/src/third-party-integr/multiple-grids.js') }}"></script>
	<script>
		var host = '{{ url('/') }}';
		var current_dashboard = '{{ $current_dashboard }}';
		var serialized_data = [
			@foreach ($widgets as $widget)
				{ id:{{ $widget->widget_id }}, name:'{{ $widget->widgets->name }}', x: {{$widget->x}}, y: {{$widget->y}}, width: {{$widget->width}}, height:{{$widget->height}}, active: {{$widget->active?'true':'false'}} },
			@endforeach  
		];
				 
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

	{{-- // !! IMPORTANT !! TEMPLATE DEFINITIONS --}}
	@include('layouts.widget-templates') 


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
