@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Dodaj nowe zwierzę</h1>
    <form action="{{ route('pets.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="id" class="form-label">ID</label>
            <input type="number" class="form-control" id="id" name="id" >
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Nazwa</label>
            <input type="text" class="form-control" id="name" name="name" >
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status" >
                <option value="available">Available</option>
                <option value="pending">Pending</option>
                <option value="sold">Sold</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">ID kategorii</label>
            <input type="number" class="form-control" id="category_id" name="category_id" >
        </div>
        <div class="mb-3">
            <label for="category_name" class="form-label">Nazwa kategorii</label>
            <input type="text" class="form-control" id="category_name" name="category_name" >
        </div>
        <div class="mb-3">
            <label for="photo_url" class="form-label">URL zdjęcia</label>
            <input type="url" class="form-control" id="photo_url" name="photo_url" >
        </div>


        <div class="mb-3">
            <label class="form-label">Tagi</label>
            <div id="tags-container">

            </div>
            <button type="button" id="add-tag" class="btn btn-secondary btn-sm mt-2">Dodaj tag</button>
        </div>
        <button type="submit" class="btn btn-primary">Dodaj zwierzę</button>
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
    let tagIndex = 0;


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
