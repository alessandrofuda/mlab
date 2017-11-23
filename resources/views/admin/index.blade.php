@extends('adminlte::page') 

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Gestione utenti</h1>
@stop

@section('content')

{{-- dd($users) --}}


<div class="box">
	<div class="box-header">
		<h3 class="box-title">Lista utenti iscritti alla piattaforma</h3>
	</div><!-- /.box-header -->

	<div class="box-body">
		<div class="text-right">	
	  		<div class="btn btn-primary"><b>Crea nuovo utente /FARE</b></div>
	  	</div>
	</div>

	<div class="box-body">
	  <table id="userstable1" class="table table-bordered table-striped">
	    <thead>
		    <tr>
				<th>Id</th>
				<th>Nome</th>
				<th>Email</th>
				<th>Ruolo</th>
				<th>Data creazione</th>
				<th>Azione</th>
		    </tr>
	    </thead>
	    <tbody>
	    	@foreach($users as $user)
			    <tr>
					<td>{{ $user->id }}</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ $user->is_admin ? 'Admin' : 'User' }}</td>
					<td>{{ $user->created_at }}</td>
					<td>
						<button class="col-md-4 btn btn-block btn-warning btn-xs" data-toggle="modal" data-target="#edit-{{ $user->id }}" title="Edit user"><i class="fa fa-fw fa-edit"></i> Edit</button>
                        <a href="{{ asset('admin/user/'. $user->id . '/destroy') }}" class="col-md-4 btn btn-block btn-danger btn-xs" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-fw fa-remove"></i> Delete</a>
					</td>
			    </tr>
		    @endforeach
	    </tbody>
	    <tfoot>
			<tr>
			  	<th>Id</th>
			  	<th>Nome</th>
			  	<th>Email</th>
			  	<th>Ruolo</th>
			  	<th>Data creazione</th>
			  	<th>Azione</th>
			</tr>
	    </tfoot>
	  </table>


	  	@foreach($users as $user)
		<!-- modal-->
		<div id="edit-{{ $user->id }}" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
				    	<button type="button" class="close" data-dismiss="modal">&times;</button>
				    	<h3 class="modal-title">Modifica utente</h3>
				    </div>
				    <div class="modal-body">
						<form role="form" id="form-{{ $user->id }}" method="post" action="{{ asset('admin/user/'. $user->id . '/update') }}">
							{!! csrf_field() !!}
							<div class="box-body">
								<div class="col-md-6 form-group">
									<label for="name">Nome</label>
									<input type="text" name="name" class="form-control" value="{{ $user->name }}" placeholder="Insert name">
								</div>
								<div class="col-md-6 form-group">
									<label for="email">Email</label>
									<input type="email" name="email" class="form-control" value="{{ $user->email }}" disabled>
								</div>
								<div class="clearfix"></div>
								<div class="col-md-6 form-group">
									<button id="reset-psw-{{$user->id}}" class="btn btn-block btn-danger">Reset Password / FARE</button>
								</div>
								<div class="col-md-6 form-group">
									<span class=""><b><i>Amministratore ?</i></b></span>
									<span class=""><input type="checkbox" name="admin" value="true" {{ $user->is_admin ? 'checked' : '' }}></span>
								</div>
								<div class="clearfix"></div>
								<div class="col-md-6 form-group">	
									<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</div>
						</form>
					</div><!--.modal-body-->
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
				</div><!--.modal-content-->
			</div>
		</div>
		@endforeach


	</div>
	<!-- /.box-body -->
</div>
<!-- /.box -->

@stop



