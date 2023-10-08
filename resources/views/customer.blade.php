@extends('layouts.app')

@section('content')
<h1>Now Serving:</h1>
@foreach ($registrars as $registrar)
    @if ($registrar->currentQueue)
        <h1>Queue #{{ $registrar->currentQueue->number }} on Registrar {{ $registrar->id }}</h1>
    @else
        <h1>No queue is currently being served on Registrar {{ $registrar->id }}</h1>
    @endif
@endforeach
<h2>Queues:</h2>
<ul>
    @foreach ($queues as $queue)
        <li>Queue #{{ $queue->number }}</li>
    @endforeach
</ul>
@endsection
