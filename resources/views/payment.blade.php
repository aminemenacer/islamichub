@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
<div id="app">
    <payment-component></payment-component>
</div>
@stop

@section('css')
<link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
@stop

@section('js')
<script src="{{ asset('js/app.js') }}"> </script>
@stop