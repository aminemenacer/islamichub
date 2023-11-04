@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Payments</h1>
@stop

@section('content')
    <payment-component></payment-component>
    <p>Welcome to user panel.</p>
@stop

@section('css')
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
@stop

@section('js')
    <script src="{{ asset('js/app.js') }}"> </script>
@stop