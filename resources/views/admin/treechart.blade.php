@extends('adminlte::page') 

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Tree Chart</h1>
@stop

@section('content')
<p>Example with: node_id=3</p>
{{ var_dump($subTree) }}

@stop