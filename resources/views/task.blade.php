@extends('layouts.app')

@section('content')
    <div id="task"></div>
@endsection

@section('scripts')
    <script src="{{ mix('/js/task.js') }}"></script>
@endsection
