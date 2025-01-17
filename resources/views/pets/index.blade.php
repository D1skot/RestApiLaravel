@extends('layouts.app')

@push('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
    <h1 class="mb-4">Dostępne zwierzęta</h1>
    <a href="{{ route('pets.create') }}" class="btn btn-primary mb-3">Dodaj nowe zwierzę</a>
    <table id="petsTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Zdjęcie</th>
                <th>Kategoria</th>
                <th>Nazwa</th>
                <th>Status</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pets as $pet)
                <tr>
                    <td>
                        <img class="img-fluid" src="{{ $pet['photoUrls'][0] ?? 'https://via.placeholder.com/150' }}" alt="No image" width="150">
                    </td>
                    <td>{{ $pet['category']['name'] ?? 'Brak kategorii' }}</td>
                    <td>{{ $pet['name'] ?? 'Brak nazwy' }}</td>
                    <td>{{ $pet['status'] ?? 'Brak statusu' }}</td>
                    <td>
                        <a href="{{ route('pets.show', $pet['id']) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('pets.update', $pet['id']) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('pets.destroy', $pet['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No pets available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

@push('scripts')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- DataTables Initialization -->
    <script>
        $(document).ready(function() {
            $('#petsTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pl.json'
                }
            });
        });
    </script>
@endpush
