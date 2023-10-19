@extends('layouts.app')
@section('content')
@if ($nowServing)
        <h1>Now Serving: Queue #{{ $nowServing->number }}</h1>
@else
        <h1>No queue is currently being served.</h1>
@endif
    <form method="POST" action="{{ route('queue.next') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Next</button>
    </form>
    <div id="queue-list">
        <!-- Queue lists will be displayed here -->
    </div>
@endsection
