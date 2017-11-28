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
	  		<button class="btn btn-primary" data-toggle="modal" data-target="#user-create" title="Create user">
	  			<i class="fa fa-fw fa-plus"></i> Crea nuovo utente <i class="fa fa-fw fa-user"></i>
	  		</button>
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
				<th>Actuator</th>
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
					<td>{{ $user->is_actuator ? 'Yes' : 'No'}}</td>
					<td>{{ $user->created_at }}</td>
					<td>
						<button class="col-md-4 btn btn-block btn-warning btn-xs" data-toggle="modal" data-target="#edit-{{ $user->id }}" title="Edit user"><i class="fa fa-fw fa-edit"></i> Edit</button>
                        <a class="col-md-4 btn btn-block btn-danger btn-xs" href="{{ asset('admin/user/'. $user->id . '/destroy') }}" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-fw fa-remove"></i> Delete</a>
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
		<!-- modal - edit -->
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
									<input type="text" name="name" class="form-control" value="{{ $user->name }}" placeholder="Insert name" required>
								</div>
								<div class="col-md-6 form-group">
									<label for="email">Email</label>
									<input type="email" name="email" class="form-control" value="{{ $user->email }}" disabled>
								</div>
								<div class="clearfix"></div>
								<div class="col-md-6 form-group">
									<button id="reset-psw-{{$user->id}}" class="btn btn-block btn-danger">Reset Password / FARE</button>
									{{-- sistemare --}}
									<input type="text" name="password" placeholder="Nuova password">
									<input type="text" name="password_confirmation" placeholder="Reimmetti password">
								</div>
								<div class="col-md-6 form-group">
									<span class=""><b><i>Amministratore ?</i></b></span>
									<span class=""><input type="checkbox" name="admin" value="true" {{ $user->is_admin ? 'checked' : '' }}></span>
								</div>
								<div class="col-md-6 form-group">
									<span class=""><b><i>Abilitato all'uso degli attuatori?</i></b></span>
									<span class=""><input type="checkbox" name="actuator" value="true" {{ $user->is_actuator ? 'checked' : '' }}></span>
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
		</div><!--/modal-->
		@endforeach

		<!-- modal- create -->
		<div id="user-create" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
				    	<button type="button" class="close" data-dismiss="modal">&times;</button>
				    	<h3 class="modal-title">Crea nuovo utente</h3>
				    </div>
				    <div class="modal-body">
						<div class="register-box">
					        <div class="register-box-body">
					            <form action="{{ url('admin/user/create') }}" method="post">
					                {!! csrf_field() !!}

					                <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
					                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
					                           placeholder="{{ trans('adminlte::adminlte.full_name') }} required">
					                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
					                    @if ($errors->has('name'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('name') }}</strong>
					                        </span>
					                    @endif
					                </div>
					                <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
					                    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
					                           placeholder="{{ trans('adminlte::adminlte.email') }}">
					                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					                    @if ($errors->has('email'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('email') }}</strong>
					                        </span>
					                    @endif
					                </div>
					                <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
					                    <input type="password" name="password" class="form-control"
					                           placeholder="{{ trans('adminlte::adminlte.password') }}">
					                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
					                    @if ($errors->has('password'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('password') }}</strong>
					                        </span>
					                    @endif
					                </div>
					                <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
					                    <input type="password" name="password_confirmation" class="form-control"
					                           placeholder="{{ trans('adminlte::adminlte.retype_password') }}">
					                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
					                    @if ($errors->has('password_confirmation'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('password_confirmation') }}</strong>
					                        </span>
					                    @endif
					                </div>
					                <div class="form-group">
					                	<span>Iscrivi come <b><i>Amministratore</i></b></span>
					                	<input type="checkbox" name="admin" value="true">
					                </div>
					                <div class="form-group">
					                	<span>Abilita all'uso degli attuatori</span>
					                	<input type="checkbox" name="actuator" value="true">
					                </div>
					                <button type="submit" class="btn btn-primary btn-block btn-flat">
					                	{{ trans('adminlte::adminlte.register') }}
					                </button>
					            </form>					            
					        </div>
					        <!-- /.form-box -->
					    </div><!-- /.register-box -->






					</div><!--.modal-body-->
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
				</div><!--.modal-content-->
			</div>
		</div>


	</div><!-- /.box-body -->
</div>
<!-- /.box -->

@stop


