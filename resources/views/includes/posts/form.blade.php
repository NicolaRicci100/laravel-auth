@if ($post->exists)
    {{-- Se volgio modificare un post --}}
    <form action="{{ route('admin.posts.update', $post) }}" method="POST">
        @method('PUT')
    @else
        {{-- Se volgio aggiungere un post --}}
        <form action="{{ route('admin.posts.store', $post) }}" method="POST">
@endif
@csrf
<div class="row">
    <div class="col-6">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title"
                value="{{ old('title', $post->title) }}" placeholder="Inserisci il titolo" maxlength="50" required>
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" class="form-control" id="slug" maxlength="50"
                value="{{ Str::slug(old('title', $post->title), '-') }}" disabled>
        </div>
    </div>
    <div class="col-12">
        <div class="mb-3">
            <label for="content" class="form-label">Contenuto del post</label>
            <textarea class="form-control" id="content" rows="10" name="content" required>{{ old('content', $post->content) }}</textarea>
        </div>
    </div>
    <div class="col-11">
        <div class="mb-3">
            <label for="image" class="form-label">Copertina</label>
            <input type="url" class="form-control" id="image" name="image"
                value="{{ old('image', $post->image) }}" placeholder="Inserisci un url valido">
        </div>
    </div>
    <div class="col-1">
        <img src="{{ old('image', $post->image ?? 'https://marcolanci.it/utils/placeholder.jpg') }}" alt="preview"
            class="img-fluid" id="image-preview">
    </div>
</div>
<hr>
<div class="d-flex justify-content-end mt-4">
    <button class="btn btn-outline-success">
        <i class="fas fa-floppy-disk me-2"></i> Salva
    </button>
</div>
</form>
