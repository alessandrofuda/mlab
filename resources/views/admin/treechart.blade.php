@extends('adminlte::page') 

@section('title', 'AdminLTE')

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')

<p>Example with: node_id={{ $node_id }}</p>

@foreach ($nodes as $node)
	
	<p>node id: {{ $node->id }}, node type: {{ $node->stType->shortDescr }}</p>

@endforeach

{{ dump($nodes) }}




@stop