@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Feedback</h1>
@stop

@section('content')
    <div id="app">
        <feedback-component></feedback-component>
    </div>
@stop

@section('css')
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
@stop

@section('js')
    <script src="{{ asset('js/app.js') }}"> </script>
@stop