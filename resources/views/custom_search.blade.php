@extends('layouts.app')
@section('content')
 <div id="app" >
  <custom-surah-selection :customSurahs="customSurahs" v-model="surah"></custom-surah-selection>
 <div>
{{-- @include('layouts.footer') --}}
@endsection

