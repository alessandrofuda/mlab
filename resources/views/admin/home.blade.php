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
    <p>Per personalizzare le dashboards cliccare su 'Widgets' in alto a dx</p>
	


    @include('layouts.gridstack-layout')

	

@stop
