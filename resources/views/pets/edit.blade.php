@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Edytuj zwierzę</h1>
    <form action="{{ route('pets.update', $pet['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">ID</label>
            <input type="text" class="form-control" id="name" name="id" value="{{ $pet['id'] }}">
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Nazwa</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $pet['name'] }}">
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="available" {{ $pet['status'] == 'available' ? 'selected' : '' }}>Available</option>
                <option value="pending" {{ $pet['status'] == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="sold" {{ $pet['status'] == 'sold' ? 'selected' : '' }}>Sold</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">ID kategorii</label>
            <input type="number" class="form-control" id="category_id" name="category_id" value="{{ $pet['category']['id'] ?? '' }}">
        </div>
        <div class="mb-3">
            <label for="category_name" class="form-label">Nazwa kategorii</label>
            <input type="text" class="form-control" id="category_name" name="category_name" value="{{ $pet['category']['name'] ?? '' }}">
        </div>
        <div class="mb-3">
            <label for="photo_url" class="form-label">URL zdjęcia</label>
            <input type="text" class="form-control" id="photo_url" name="photo_url" value="{{ $pet['photoUrls'][0] ?? '' }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Tagi</label>
            <div id="tags-container">
                @if(!empty($pet['tags']))
                    @foreach($pet['tags'] as $index => $tag)
                        <div class="tag-item mb-2">
                            <input type="hidden" name="tags[{{ $index }}][id]" value="{{ $tag['id'] }}">
                            <input type="text" class="form-control d-inline-block w-75" name="tags[{{ $index }}][name]" value="{{ $tag['name'] }}" placeholder="Nazwa tagu">
                            <button type="button" class="btn btn-danger btn-sm d-inline-block remove-tag">Usuń</button>
                        </div>
                    @endforeach
                @endif
            </div>
            <button type="button" id="add-tag" class="btn btn-secondary btn-sm mt-2">Dodaj tag</button>
        </div>
        <a href="{{ route('pets.index') }}" class="btn btn-secondary">Wróć do listy</a>
        <button type="submit" class="btn btn-success">Zaktualizuj zwierzę</button>
    </form>
    <template id="tag-template">
        <div class="tag-item mb-2">
            <input type="hidden" name="tags[__INDEX__][id]" value="0">
            <input type="text" class="form-control d-inline-block w-75" name="tags[__INDEX__][name]" placeholder="Nazwa tagu">
            <button type="button" class="btn btn-danger btn-sm d-inline-block remove-tag">Usuń</button>
        </div>
    </template>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        let tagIndex = {{ count($pet['tags'] ?? []) }};

        $('#add-tag').on('click', function () {
            const template = $('#tag-template').html();
            const newTag = template.replace(/__INDEX__/g, tagIndex);
            $('#tags-container').append(newTag);
            tagIndex++;
        });

        $('#tags-container').on('click', '.remove-tag', function () {
            $(this).closest('.tag-item').remove();
        });
    });
</script>
@endpush
