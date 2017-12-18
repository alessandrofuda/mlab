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
		<div class="col-md-4 form-group">
			<label for="user">Select User</label>
			<select name="user" class="form-control">
				<option value="">--- Select User ---</option>
				@foreach ($users as $user)
					<option value="{{ $user->id }}">{{ $user->name }}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-4 form-group">
			<label for="dashboard">Select Dashboard:</label>
			<select name="dashboard" class="form-control">	
			</select>
		</div>
	</div>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		$('select[name="user"]').on('change', function() {
			var userID = $(this).val();
			// console.log(userID);
			if(userID) {
				$.ajax({
					url: "{{url('ajax/dashboard-customization/user-') }}"+userID,
					type: "GET",
					dataType: "json",
					success:function(data) {
						// console.log(data);
						$('select[name="dashboard"]').empty();
						$.each(data, function(key, value) {
							//console.log(value.dashboard.name);
							$('select[name="dashboard"]').append('<option value="'+ value.dashboard_id +'">'+ value.dashboard.name +'</option>');
						});
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
	});
</script>


    


@stop