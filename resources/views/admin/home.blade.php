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
	<style>
		.grid{ min-height: 100px; border:1px solid red; box-sizing: border-box; }
		.box{ margin:10px; padding:10px; border:1px dashed #CCC; box-sizing: border-box; min-height: 200px; width: auto;} 
	</style>    
    <div id="drop-target" class="container" style="max-width: 100%; border:1px solid #CCC; min-height: 400px;">
    	<div class="row">
    		<div class="col-md-6 grid">
    			<div id="box-1" class="drop-target box"></div>
    		</div>
    		<div class="col-md-6 grid">
    			<div id="box-2" class="drop-target box"></div>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-md-4 grid">
    			<div id="box-3" class="drop-target box"></div>
    		</div>
    		<div class="col-md-4 grid">
    			<div id="box-4" class="drop-target box"></div>
    		</div>
    		<div class="col-md-4 grid">
    			<div id="box-5" class="drop-target box"></div>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-md-4 grid">
    			<div id="box-6" class="drop-target box"></div>
    		</div>
    		<div class="col-md-4 grid">
    			<div id="box-7" class="drop-target box"></div>
    		</div>
    		<div class="col-md-4 grid">
    			<div id="box-8" class="drop-target box"></div>
    		</div>
    	</div>
    	drop target
    </div>



<!--div class="draggable_test">Drag me</div>
 
<script>
$( ".draggable_test" ).draggable({scroll: true });
</script-->
    


@stop
