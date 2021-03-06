

<div id="template_1" style="display: none;">


	<form id="sensors_selector_widget_1" class="" style="float: left;">
      @if (isset($mysensors))  
        <?php $i = 1; ?>
        @foreach ($mysensors as $mysensor)
          <input type="checkbox" name="sensors[]" value="{{ $i }}" checked="true">{{ $mysensor->sensorsDescriptor->shortDescr  }}
          <?php $i++; ?>
        @endforeach
      <!--input class="btn btn-default btn-sm" type="submit" name="Filter sensors" value="Filter sensors"-->

      @else

        <p>No sensors filter found for this user (check user or admin controller controller)</p>

      @endif
  </form>

  <div id="date_selector_widget_1" class="" style="text-align: right;">
      <input type="text" name="daterange" value="Select Date" />
      <script type="text/javascript">

      // default dates range
      var startDate = moment().subtract(6, 'days');  // 1 week ago
      var endDate = moment();

      $(function() {
          $('input[name="daterange"]').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            startDate: startDate, 
            endDate: endDate,      
            ranges: {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days': [moment().subtract(6, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            } 
          },
          function(start, end, label) {
            alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
          }
          );
      });
      </script>
  </div>

	<div id="widget_1">  </div>




	<script type="text/javascript">
      // Set a callback to run when the Google Visualization API is loaded.
    	google.charts.setOnLoadCallback(drawChart1);
      
    	function drawChart1() {
        
        var jsonData = $.ajax({
          url: "{{ url('ajax/data-widget-1') }}",  // add parameters from front-end controls
          dataType: "json",
          async: false,
          success: function(data){
            // console.log(data);
          },
          error: function(err){
            console.log(err);
          }
        }).responseText;


        // Create our data table out of JSON data loaded from server.
        var data = new google.visualization.DataTable(jsonData);
        //var columnnumber = data.getNumberOfColumns(); 
        //console.log(columnnumber);

        // Create a view that shows/hide columns.
        var view = new google.visualization.DataView(data);

        var indexes = $("#sensors_selector_widget_1 input:checkbox:not(:checked)").map(function(){
                          return eval($(this).val());
                      }).get();
        view.hideColumns(indexes); 

        





        // create view that select/filter dates range
        var minValue = startDate.format('YYYY-MM-DD').split('-');
        var maxValue = endDate.format('YYYY-MM-DD').split('-');
        var min_yyyy = minValue[0], min_mm = minValue[1]-1, min_dd = minValue[2];  // zero based months !
        var max_yyyy = maxValue[0], max_mm = maxValue[1]-1, max_dd = maxValue[2];

        //console.log(min_mm - 1);

        var filters = [{
            column: 0, 
            minValue: new Date(min_yyyy, min_mm, min_dd),  // months zero based 
            maxValue: new Date(max_yyyy, max_mm, max_dd),
        }]; 
        view.setRows(view.getFilteredRows(filters));









        var options = {
            'width': '100%',
            'height': '100%',
            'legend': 'top',
            'title': 'Energy consumption',
            // curveType: 'function',
            'hAxis': {
              'title': 'Time',
            },
            'vAxis': {
              'title': 'kWh',
            },
          };


        var chart = new google.visualization.LineChart(document.getElementById('widget_1'));
        chart.draw(view, options);  





        // checkbox column filter: on change --> set columns
        $('#sensors_selector_widget_1').on('change',function(e) { 
          e.preventDefault();
          var indexes = [];
          var indexes = $("#sensors_selector_widget_1 input:checkbox:not(:checked)").map(function(){
                          return eval($(this).val());
                      }).get();
          // console.log(indexes);

          var view = new google.visualization.DataView(data);
          //view.setColumns(array); 
          view.hideColumns(indexes); 
          
          // chart.draw(view, options);
          chart.draw(view, options);

        });




        // date range rows filter: on change --> set rows
        /* $('#date_selector_widget_1').on('change',function(e) {
          e.preventDefault();

          var view = new google.visualization.DataView(data);

          chart.draw(view, options);          
        }); */




    }

    // resize on runtime (timeout to avoid data overflows)
    var resizeId1;
    $(window).resize(function() {
      clearTimeout(resizeId1);
      resizeId1 = setTimeout(drawChart1, 200);
    });



	</script>

</div>



<div id="template_2" style="display: none;">
	
	<div id="widget_2"> </div>

	<script type="text/javascript">
		// Set a callback to run when the Google Visualization API is loaded.
    	google.charts.setOnLoadCallback(drawChart2);
      
    	function drawChart2() {
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
      	var width = '100%';  
        var height = '100%'; 

      	chart.draw(data, {width: width, height: height, title: 'Ciabatta ufficio, quartoraria - dati "reali" agganciati a Database', legend:{ position:'bottom' }, });  // change to dynamic according to container dimensions
    }

    // resize on runtime (timeout to avoid data overflows)
    var resizeId2;
    $(window).resize(function() {
      clearTimeout(resizeId2);
      resizeId2 = setTimeout(drawChart2, 200);
    });

	</script>

</div>



<div id="template_3" style="display: none;">
  <h4>Energy consuption per Departement<br/>Years comparaison</h4>
  <div id="widget_3"> </div>

  <script type="text/javascript">
    // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart3);
      
      function drawChart3() {
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
        var width = '100%';  
        var height = '100%'; 

        chart.draw(data, {width: width, height: height, title: 'Titolo', legend: {position: "bottom"}, });  // change to dynamic according to container dimensions
    }

    // resize on runtime (timeout to avoid data overflows)
    var resizeId3;
    $(window).resize(function() {
      clearTimeout(resizeId3);
      resizeId3 = setTimeout(drawChart3, 200);
    });

  </script>	
</div>



<div id="template_4" style="display: none;">
	
<h4>Energy consumption in 2017 per Departement</h4>
  <div id="widget_4"> </div>

  <script type="text/javascript">
    // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart4);
      
      function drawChart4() {
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
        var width = '100%';  
        var height = '100%'; 

        chart.draw(data, {width: width, height: height, title: 'Sub-title', legend: {position: "bottom"}, });  // change to dynamic according to container dimensions
    }

    // resize on runtime (timeout to avoid data overflows)
    var resizeId4;
    $(window).resize(function() {
      clearTimeout(resizeId4);
      resizeId4 = setTimeout(drawChart4, 200);
    });

  </script>

</div>



<div id="template_5" style="display: none;">
	
  <h4>Energy consumption - 2017</h4>
  <div id="widget_5"> </div>

  <script type="text/javascript">
    // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart5);
      
      function drawChart5() {
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
        var width = '100%';  
        var height = '100%'; 

        chart.draw(data, {width: width, height: height, title: 'Consumption per Departement - %', pieHole: 0.4, legend: {position: "right", alignment: "center"}, });  // change to dynamic according to container dimensions
    }

    // resize on runtime (timeout to avoid data overflows)
    var resizeId5;
    $(window).resize(function() {
      clearTimeout(resizeId5);
      resizeId5 = setTimeout(drawChart5, 200);
    });

  </script>


</div>




<div id="template_6" style="display: none;">
  
  <h4>Energy consumption per department - Pie</h4>
  <div id="widget_6"> </div>

  <script type="text/javascript">
    // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart6);
      
      function drawChart6() {
          var jsonData = $.ajax({
            url: "{{ url('ajax/data-widget-6') }}",
            dataType: "json",
            async: false
            }).responseText;
          
        // Create our data table out of JSON data loaded from server.
        var data = new google.visualization.DataTable(jsonData);

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('widget_6'));

        // responsive layout
        var width = '100%';  
        var height = '100%'; 

        chart.draw(data, {width: width, height: height, title: 'Title - %', legend: {position: "right", alignment: "center"}, });  // change to dynamic according to container dimensions
    }

    // resize on runtime (timeout to avoid data overflows)
    var resizeId6;
    $(window).resize(function() {
      clearTimeout(resizeId6);
      resizeId6 = setTimeout(drawChart6, 200);
    });

  </script>


</div>



<div id="template_7" style="display: none;">
  
  <h4>Instant Power - kW</h4>
  <style>
    .plain-text { text-align: center; font-size: 80px; display: block; line-height: normal; margin: auto; }
  </style>
  <div id="widget_7"> </div>

  <script type="text/javascript">
      
    var jsonData = $.ajax({
        url: "{{ url('ajax/data-widget-7') }}",
        dataType: "json",
        async: false
        }).responseText;

    $('#widget_7').html('<div class="plain-text">'+jsonData+'</div>');

    // resize on runtime (timeout to avoid data overflows)
    //var resizeId7;
    //$(window).resize(function() {
    //  clearTimeout(resizeId7);
    //  resizeId7 = setTimeout(drawChart7, 200);
    //});

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