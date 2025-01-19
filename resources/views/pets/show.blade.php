@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Szczegóły zwierzęcia</h1>
    <ul class="list-group">
        <li class="list-group-item"><strong>ID:</strong> {{ $pet['id'] }}</li>
        <li class="list-group-item"><strong>Nazwa:</strong> {{ $pet['name'] }}</li>
        <li class="list-group-item"><strong>Status:</strong> {{ $pet['status'] }}</li>
        <li class="list-group-item"><strong>Kategoria:</strong>
            {{ $pet['category']['name'] ?? 'Brak kategorii' }} (ID: {{ $pet['category']['id'] ?? 'N/A' }})
        </li>
        <li class="list-group-item"><strong>Zdjęcia:</strong>
            @if (!empty($pet['photoUrls']))
                <ul>
                    <img class="img-fluid" src="{{ $pet['photoUrls'][0] ?? 'https://v.wpimg.pl/ZGYyNjNldSY4GzhZYRd4M3tDbAMnTnZlLFt0SGFdaH9pAWEMJwA_NTwJIUQpHi83OA4-RD4AdSYpEGEcf0M-LioJIgs3Qz8qOxwqRX9dO3U9SnkMY1xpc2FUel1-Cnd-YEl4R39dYyM_S3hZKwg5f3sE' }}" alt="No image" width="150">
                </ul>
            @else
                Brak zdjęć
            @endif
        </li>
        <li class="list-group-item"><strong>Tagi:</strong>
            @if (!empty($pet['tags']))
                <ul>
                    @foreach ($pet['tags'] as $tag)
                        <li>{{ $tag['name'] ?? 'Brak nazwy' }} (ID: {{ $tag['id'] ?? 'N/A' }})</li>
                    @endforeach
                </ul>
            @else
                Brak tagów
            @endif
        </li>
    </ul>
    <div class="mt-4">
        <a href="{{ route('pets.index') }}" class="btn btn-secondary">Wróć do listy</a>
        <a href="{{ route('pets.edit', $pet['id']) }}" class="btn btn-primary">Edytuj</a>
    </div>
@endsection
