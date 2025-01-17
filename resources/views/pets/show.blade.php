@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Pet Details</h1>
    <ul class="list-group">
        <li class="list-group-item"><strong>ID:</strong> {{ $pet['id'] }}</li>
        <li class="list-group-item"><strong>Name:</strong> {{ $pet['name'] }}</li>
        <li class="list-group-item"><strong>Status:</strong> {{ $pet['status'] }}</li>
    </ul>
    <a href="{{ route('pets.index') }}" class="btn btn-secondary mt-3">Back to List</a>
@endsection
