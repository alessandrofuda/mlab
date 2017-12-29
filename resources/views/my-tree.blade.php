@extends('adminlte::page')   {{-- from: .. /resources/views/vendor/adminlte/page.blade.php    --}}

@section('title', config('adminlte.title', 'AdminLTE'))


@section('content_header')
    <h1>My Tree</h1>
@stop

@section('content')
    <p></p>
    <p>My subtree tree chart</p>


{{ var_dump($subTree) }}

    


@stop
