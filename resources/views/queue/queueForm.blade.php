@extends('layouts.app')
@section('content')
<h1>Register for Queue</h1>
    <form method="POST" action="{{ route('getQueue') }}" id="get-queue-form">
        @csrf
        <button type="submit" id="get-queue-button" class="btn btn-sm btn-primary">Get Queue</button>
        <div id="loading-indicator" style="display: none;">Loading...</div>
    </form>
@endsection
