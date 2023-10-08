@extends('layouts.app')
@section('content')
<h1>Register for Queue</h1>
    <form method="POST" action="{{ route('queue.create') }}">
        @csrf
        <button type="submit">Register</button>
    </form>
@endsection
