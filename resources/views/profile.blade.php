@extends('layouts.app')
@section('content')
<div id="app">
    <profile-component :user="{{ Auth::user() }}"></profile-component>
<div>
@endsection
