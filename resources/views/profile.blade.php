@extends('layouts.master')
@section('content')
<div id="app">
    <profile-component :user="{{ Auth::user() }}"></profile-component>
<div>
@endsection
