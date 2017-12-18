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
		<form id="redesign-dashboard" class="">
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
			<!--div class="col-md-3 form-group">
				<label for="submit" style="visibility: hidden;">.</label>
				<input class="form-control btn btn-info" type="submit" value="Re-design user dashboard" />
			</div-->
		</form>
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
		$('select[name="dashboard"]').on('change', function() {
			var userID = $('select[name="user"]').val();
			var dashboardID = $(this).val();
			console.log('userID:'+userID+' dashboardID:'+dashboardID);
			if(userID && dashboardID) {
				console.log('ok');
				$.ajax({
					url: "{{ url('ajax/dashboard-redesign/user-') }}"+userID+"/dashboard-"+dashboardID,
					type: "GET",
					dataType: "json",
					success:function(data) {
						console.log(data);
						/*if (data.length > 0 ) {
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
						}*/
					},
					error: function(req, err){
						console.log('errore');
						console.log (req);
						console.log(err);
					}
				});
			}
		});



		// form submit
		/*$('#redesign-dashboard').submit( function(event) {
			

			console.log('submit ok!');


			event.preventDefault();
		});*/

	});
</script>


    


@stop