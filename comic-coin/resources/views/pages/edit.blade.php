<form method="POST" action="{{ route('pages.update', $page) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label for="page_number">Page Number</label>
        <input type="number" name="page_number" value="{{ $page->page_number }}" required>
    </div>

    <div>
        <label for="image">Replace Image (optional)</label>
        <input type="file" name="image" accept="image/*">
    </div>

    <button type="submit">Update</button>
</form>
