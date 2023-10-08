@extends('layouts.app')
@section('content')
<h1>Register for Queue</h1>
    <form method="POST" action="{{ route('getQueue') }}">
        @csrf
        <button type="submit">Get Queue</button>
    </form>
@endsection
