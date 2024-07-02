@extends('layouts.app')
@section('content')
 <div id="app" >
  <surah-list :filteredSurah="filteredSurah" @select-surah="handleSelectSurah"></surah-list>
  <div>
{{-- @include('layouts.footer') --}}
@endsection

