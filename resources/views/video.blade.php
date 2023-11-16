@if(Auth::user())
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
<div id="app">
    <video-component></video-component>
</div>
@stop

@section('css')
<link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
@stop

@section('js')
<script src="{{ asset('js/app.js') }}"> </script>
@stop

@elseif(!Auth::user())
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
<div id="app" class="pt-5">
    <div class="container alert alert-danger text-center" role="alert">
        Login into your account to access Short Videos content
      </div>
</div>
@stop

@section('css')
<link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
@stop

@section('js')
<script src="{{ asset('js/app.js') }}"> </script>
@stop
@endif


{{-- @extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
    <div id="app">
        <video-component></video-component>
    </div>
@stop

@section('css')
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
@stop

@section('js')
<script src="{{ asset('js/app.js') }}"> </script>
@stop --}}