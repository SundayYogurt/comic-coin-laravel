<form method="POST" action="{{ route('chapters.store') }}" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="chapter_id">Chapter ID</label>
        <input type="number" name="chapter_id" required>
    </div>

    <div>
        <label for="images">Upload Pages</label>
        <input type="file" name="images[]" accept="image/*" multiple required>
        <!-- multiple = เลือกได้หลายไฟล์ -->
    </div>

    <button type="submit">Upload Pages</button>
</form>
