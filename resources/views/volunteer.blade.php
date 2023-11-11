@extends('adminlte::page')


@section('content')
    <div id="app">
        <volunteer-component></volunteer-component>
    </div>
@stop

@section('css')
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
@stop

@section('js')
    <script src="{{ asset('js/app.js') }}"> </script>
@stop