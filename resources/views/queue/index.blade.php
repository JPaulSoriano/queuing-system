@extends('layouts.app')
@section('content')
@if ($nowServing)
        <h1>Now Serving: Queue #{{ $nowServing->number }}</h1>
    @else
        <h1>No queue is currently being served.</h1>
    @endif

    <form method="POST" action="{{ route('queue.next') }}">
        @csrf
        <button type="submit">Next</button>
    </form>

    <h2>Queue Lists:</h2>
    <ul>
        @foreach ($queues as $queue)
            <li>Queue #{{ $queue->number }}</li>
        @endforeach
    </ul>

    <form method="POST" action="{{ route('queue.create') }}">
        @csrf
        <button type="submit">Register</button>
    </form>
@endsection
