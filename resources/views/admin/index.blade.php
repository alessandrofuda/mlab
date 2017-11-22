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
	</div>
	<!-- /.box-header -->
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
						<a href="{{ asset('admin/user/'. $user->id . '/edit') }}" class="label label-warning">Edit</a>
                        <a href="{{ asset('admin/user/'. $user->id . '/destroy') }}" class="label label-danger" onclick="return confirm('Are you sure to delete?')">Delete</a>
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
	</div>
	<!-- /.box-body -->
</div>
<!-- /.box -->






pagination


@stop



