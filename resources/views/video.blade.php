
{{-- @if(Auth::user())
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

@elseif(!Auth::user()) --}}

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



