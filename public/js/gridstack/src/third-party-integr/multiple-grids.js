var dashboardFn = {

		initiate: function () {
            // Grid area to hold active widgets
            var active_grid_options = {
            		width: 4,
            		height: 100,  // max height of the grid
	            	cellHeight:100,
					      alwaysShowResizeHandle: /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),
                resizable: {
                    handles: 'e, se, s, sw, w'
                },
            		// grid_class: 'grid-stack-active',
            		draggable: {
            			cursor: 'move',
            			cancel: '.na-icon',
                		}
            };
            $('.active-widgets .grid-stack').gridstack(active_grid_options);

            // Grid area to hold in-active widgets
            var inactive_grid_options = {
            		width: 1,
            		height: 100,
            		cellHeight:100,
            		animate: false,
            		// grid_class: 'grid-stack-inactive',
           			draggable: {
               			cursor: 'move',
                   		cancel: '.na-icon'
                   		}          		
            };
            $('.inactive-widgets .grid-stack').gridstack(inactive_grid_options);

            dashboardFn.active_grid = $('.active-widgets .grid-stack').data('gridstack');
            dashboardFn.inactive_grid = $('.inactive-widgets .grid-stack').data('gridstack');
			
            dashboardFn.load_grid();
		},



    activate_widget: function (widget, position) {
			// Get the position of the cell under a pixel on screen
			var cell = dashboardFn.inactive_grid.getCellFromPixel(widget.position);
			if(typeof(position) !== 'undefined' && position != null){
				cell = dashboardFn.inactive_grid.getCellFromPixel(position);
			}
			// Check if widget will fit anywhere on Active grid, auto position set to true
			if (dashboardFn.active_grid.willItFit(cell.x, cell.y, 1, 1, true)) {    
				// Remove Widget from In-Active grid, remove from DOM set to false
				dashboardFn.inactive_grid.removeWidget(widget, false);
				// Add Widget to Active Grid, auto position set to true
				dashboardFn.active_grid.addWidget(widget, cell.x, cell.y, 1, 1, true);
				// Enable re-sizing of Widget while In-Active
				dashboardFn.active_grid.resizable('.grid-stack-active .grid-stack-item', true);
				dashboardFn.update_button(widget);				
			}
			else {
				alert('Not enough free space to add the widget');
			}
    },


    deactivate_widget: function (widget, position) {
			// Get the position of the cell under a pixel on screen
			var	cell = dashboardFn.active_grid.getCellFromPixel(widget.position);
			if(typeof(position) !== 'undefined' && position != null){
				cell = dashboardFn.active_grid.getCellFromPixel(position);
			}
			// Check if widget will fit anywhere on In-Active grid, auto position set to true
			if (dashboardFn.inactive_grid.willItFit(cell.x, cell.y, 1, 1, true)) {             
				// Remove Widget from Active grid, remove from DOM set to false
				dashboardFn.active_grid.removeWidget(widget, false);
				// Add Widget to In-Active Grid, auto position set to true
				dashboardFn.inactive_grid.addWidget(widget, cell.x, cell.y, 1, 1, true);        
				// Disable re-sizing of Widget while In-Active
				dashboardFn.inactive_grid.resizable('.grid-stack-inactive .grid-stack-item', false);
				dashboardFn.update_button(widget);
			}
			else {
				alert('Not enough free space to remove the widget');
			}
    },


    update_button: function (widget, button) {
       		var	button = widget.find('.portlet-header .portlet-close,.portlet-header .widget-add');
        	if(button.hasClass('portlet-close')){
        		button.after('<span class="na-icon na-icon-triangle-1-s widget-add" title="Add"></span>');
        	}
        	else{
        		button.after('<span class="na-icon na-icon-close portlet-close" title="Close"></span>');
        	}
        	button.remove();
    },


    load_grid : function () {
    	 dashboardFn.active_grid.removeAll();
    	 dashboardFn.inactive_grid.removeAll();
       var items = GridStackUI.Utils.sort(serialized_data);
       var widget;
       _.each(items, function (node) {

		      // Quick and dirty example using clone of a template widget div
		      widget = $("#template .widget").clone();
		      // Set Widget Id
		      widget.attr('data-widget-id', node.id);
		      // Set widget name
		      widget.find('.header').html(node.name);
          
          // Set widget content 
          if(node.id == 1) {
            var template = template_1; 
          } else if(node.id == 2) {
            var template = template_2;
          } else if(node.id == 3) {
            var template = template_3;
          } else if(node.id == 4) {
            var template = template_4;
          } else if(node.id == 5) {
            var template = template_5;
          } else {
            var template = null;
          }

          widget.find('.content').html(template); 
          
          if(node.active == true){
  					// Add 'close' widget button
      			widget.find('.portlet-header .header').after('<span class="na-icon na-icon-close portlet-close" title="Close"></span>');
      			// If item is active place in it's position on the active widget grid
            dashboardFn.active_grid.addWidget(widget, node.x, node.y, node.width, node.height);  
          }
  				else{           		
  					// Add 'Add' widget button
      				widget.find('.portlet-header .header').after('<span class="na-icon na-icon-triangle-1-s widget-add" title="Add"></span>');
      				// If item not active place in it's position on available widgets area
  	                dashboardFn.inactive_grid.addWidget(widget, node.x, node.y, 1, 1, true);
  					// Disable re-sizing of Widget while In-Active
  					dashboardFn.inactive_grid.resizable('.grid-stack-inactive .grid-stack-item', false);				
  				}
       }, this);
                
       //Click Widget Close Button
       $('#dashboard').on('click', '.portlet-header .portlet-close', function(){
		      // !!! IMPORTANTE: prima la chiamata ajax e POI la funzione deactivate !!!!
          // ajax call to: 'active' = 0
          var id = $(this).parents(".grid-stack-item:first").attr("data-widget-id");
          var active = 0;
          $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
              }
          });
          $.ajax({
              type: 'POST',
              url: host + '/ajax/deactivate-widget',
              data: { id:id, dashboard_id:current_dashboard }, 
              success: function( msg ) {
                //console.log('chiamata ajax OK: ' + msg);
              },
              error: function(req, err) {
                //console.log('chamata ajax errore: ');
                //console.log(req);
                //console.log(err);
              }
          });

          // deactivate func !!
          dashboardFn.deactivate_widget($(this).parents(".grid-stack-item:first"));

       });


       //Click Widget Add Button
       $('.inactive-widgets').on('click', '.portlet-header .widget-add', function(){ 
		      dashboardFn.activate_widget($(this).parents(".grid-stack-item:first"));          
       });

	
       // Force Active grid to accept only Widgets from In-Active Grid, otherwise allow grid-stack to do it's thing
       dashboardFn.active_grid.container.droppable({
          accept: ".grid-stack-inactive .grid-stack-item",
          tolerance: 'pointer',
          drop: function( event, ui ) {
		        dashboardFn.activate_widget(ui.draggable, ui.position);
          }
       });

       // Force In-Active grid to accept only Widgets from Active Grid, otherwise allow grid-stack to do it's thing
       dashboardFn.inactive_grid.container.droppable({
          accept: ".grid-stack-active .grid-stack-item",
          tolerance: 'pointer',
          drop: function( event, ui ) {
		        dashboardFn.deactivate_widget(ui.draggable, ui.position);
           }
       });

    }  // fine load_grid()


	};
