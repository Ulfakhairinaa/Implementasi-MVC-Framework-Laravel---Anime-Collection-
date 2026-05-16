<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anime — Anime Collection</title>
    <link rel="stylesheet" href="{{ asset('css/anime.css') }}">
</head>
<body>

<nav class="navbar">
    <a href="{{ route('anime.index') }}" class="navbar-brand">
        <span class="icon">⛩️</span> Anime Collection
    </a>
    <ul class="navbar-nav">
        <li><a href="{{ route('anime.index') }}">Koleksi</a></li>
        <li><a href="{{ route('anime.show', $anime->id) }}">Detail</a></li>
    </ul>
</nav>

<div class="main-container">

    <div class="page-header">
        <h1>✏️ Edit Anime</h1>
        <p class="subtitle">{{ $anime->judul }}</p>
        <div class="header-line"></div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger" style="max-width:700px; margin:0 auto 1.5rem;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <form action="{{ route('anime.update', $anime->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Gambar Upload --}}
            <div class="form-group">
                <label class="form-label">🖼️ Gambar Anime</label>
                <div class="image-upload-area" onclick="document.getElementById('gambarInput').click()">
                    @if($anime->gambar)
                        <img id="previewImg" class="image-preview"
                             src="{{ asset('storage/' . $anime->gambar) }}"
                             alt="Preview" style="display:block;">
                    @else
                        <span class="upload-icon">📁</span>
                        <p>Klik untuk ganti gambar anime</p>
                        <img id="previewImg" class="image-preview" alt="Preview">
                    @endif
                </div>
                <input type="file" id="gambarInput" name="gambar" accept="image/*"
                       style="display:none;" onchange="previewImage(this)">
            </div>

            {{-- Judul --}}
            <div class="form-group">
                <label class="form-label">🎌 Judul Anime</label>
                <input type="text" name="judul" class="form-control {{ $errors->has('judul') ? 'is-invalid' : '' }}"
                       value="{{ old('judul', $anime->judul) }}" required>
                @error('judul') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            {{-- Genre + Studio --}}
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">🎭 Genre</label>
                    <input type="text" name="genre" class="form-control {{ $errors->has('genre') ? 'is-invalid' : '' }}"
                           value="{{ old('genre', $anime->genre) }}" required>
                    @error('genre') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">🎬 Studio</label>
                    <input type="text" name="studio" class="form-control"
                           value="{{ old('studio', $anime->studio) }}">
                </div>
            </div>

            {{-- Episode + Rating --}}
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">📺 Jumlah Episode</label>
                    <input type="number" name="episode" class="form-control {{ $errors->has('episode') ? 'is-invalid' : '' }}"
                           value="{{ old('episode', $anime->episode) }}" min="1" required>
                    @error('episode') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">⭐ Rating (0–10)</label>
                    <input type="number" name="rating" class="form-control {{ $errors->has('rating') ? 'is-invalid' : '' }}"
                           value="{{ old('rating', $anime->rating) }}" step="0.1" min="0" max="10" required>
                    @error('rating') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Tahun Rilis --}}
            <div class="form-group">
                <label class="form-label">📅 Tahun Rilis</label>
                <input type="number" name="tahun_rilis" class="form-control"
                       value="{{ old('tahun_rilis', $anime->tahun_rilis) }}" min="1900" max="2099">
            </div>

            {{-- Sinopsis --}}
            <div class="form-group">
                <label class="form-label">📝 Sinopsis</label>
                <textarea name="sinopsis" class="form-control">{{ old('sinopsis', $anime->sinopsis) }}</textarea>
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <button type="submit" class="btn btn-save">💾 Update Anime</button>
                <a href="{{ route('anime.show', $anime->id) }}" class="btn btn-cancel">✕ Batal</a>
            </div>

        </form>
    </div>

</div>

<script>
function previewImage(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById('previewImg');
        preview.src = e.target.result;
        preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
}
</script>

</body>
</html>
