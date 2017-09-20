@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/task.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div id="app"></div>
@endsection

@section('scripts')
    <script src="{{ asset('js/task.js') }}"></script>
@endsection
