<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anime — Anime Collection</title>
    <link rel="stylesheet" href="{{ asset('css/anime.css') }}">
</head>
<body>

<nav class="navbar">
    <a href="{{ route('anime.index') }}" class="navbar-brand">
        <span class="icon">⛩️</span> Anime Collection
    </a>
    <ul class="navbar-nav">
        <li><a href="{{ route('anime.index') }}">Koleksi</a></li>
        <li><a href="{{ route('anime.create') }}" class="active">+ Tambah</a></li>
    </ul>
</nav>

<div class="main-container">

    <div class="page-header">
        <h1>＋ Tambah Anime</h1>
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
        <form action="{{ route('anime.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Gambar Upload --}}
            <div class="form-group">
                <label class="form-label">🖼️ Gambar Anime</label>
                <div class="image-upload-area" onclick="document.getElementById('gambarInput').click()">
                    <span class="upload-icon">📁</span>
                    <p>Klik untuk upload gambar anime</p>
                    <p style="font-size:0.75rem; margin-top:4px; color:var(--text-light);">JPG, PNG, WEBP — Maks 2MB</p>
                    <img id="previewImg" class="image-preview" alt="Preview">
                </div>
                <input type="file" id="gambarInput" name="gambar" accept="image/*"
                       style="display:none;" onchange="previewImage(this)">
            </div>

            {{-- Judul --}}
            <div class="form-group">
                <label class="form-label">🎌 Judul Anime</label>
                <input type="text" name="judul"
                       class="form-control {{ $errors->has('judul') ? 'is-invalid' : '' }}"
                       placeholder="contoh: Attack on Titan" value="{{ old('judul') }}" required>
                @error('judul') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            {{-- Genre + Studio — DIUBAH jadi dropdown relasi --}}
            <div class="form-row">

                {{-- Dropdown Genre --}}
                <div class="form-group">
                    <label class="form-label">🎭 Genre</label>
                    <select name="genre_id"
                            class="form-control {{ $errors->has('genre_id') ? 'is-invalid' : '' }}"
                            id="genreSelect"
                            onchange="toggleBaru(this, 'genre')" required>
                        <option value="">-- Pilih Genre --</option>
                        @foreach($genres as $g)
                            <option value="{{ $g->id }}" {{ old('genre_id') == $g->id ? 'selected' : '' }}>
                                {{ $g->nama }}
                            </option>
                        @endforeach
                        <option value="baru">+ Tambah Genre Baru</option>
                    </select>
                    <input type="text" name="genre_baru" id="genre_baru"
                           class="form-control"
                           placeholder="Nama genre baru..."
                           style="display:none; margin-top:8px;">
                    @error('genre_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                {{-- Dropdown Studio --}}
                <div class="form-group">
                    <label class="form-label">🎬 Studio</label>
                    <select name="studio_id"
                            class="form-control {{ $errors->has('studio_id') ? 'is-invalid' : '' }}"
                            id="studioSelect"
                            onchange="toggleBaru(this, 'studio')" required>
                        <option value="">-- Pilih Studio --</option>
                        @foreach($studios as $s)
                            <option value="{{ $s->id }}" {{ old('studio_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->nama }}
                            </option>
                        @endforeach
                        <option value="baru">+ Tambah Studio Baru</option>
                    </select>
                    <input type="text" name="studio_baru" id="studio_baru"
                           class="form-control"
                           placeholder="Nama studio baru..."
                           style="display:none; margin-top:8px;">
                    @error('studio_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

            </div>

            {{-- Episode + Rating --}}
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">📺 Jumlah Episode</label>
                    <input type="number" name="episode"
                           class="form-control {{ $errors->has('episode') ? 'is-invalid' : '' }}"
                           placeholder="contoh: 24" value="{{ old('episode') }}" min="1" required>
                    @error('episode') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">⭐ Rating (0–10)</label>
                    <input type="number" name="rating"
                           class="form-control {{ $errors->has('rating') ? 'is-invalid' : '' }}"
                           placeholder="contoh: 9.5" value="{{ old('rating') }}" step="0.1" min="0" max="10" required>
                    @error('rating') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Tahun Rilis --}}
            <div class="form-group">
                <label class="form-label">📅 Tahun Rilis</label>
                <input type="number" name="tahun_rilis" class="form-control"
                       placeholder="contoh: 2021" value="{{ old('tahun_rilis') }}" min="1900" max="2099">
            </div>

            {{-- Sinopsis --}}
            <div class="form-group">
                <label class="form-label">📝 Sinopsis</label>
                <textarea name="sinopsis" class="form-control"
                          placeholder="Tulis sinopsis singkat anime ini...">{{ old('sinopsis') }}</textarea>
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <button type="submit" class="btn btn-save">💾 Simpan Anime</button>
                <a href="{{ route('anime.index') }}" class="btn btn-cancel">✕ Batal</a>
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

function toggleBaru(select, type) {
    const input = document.getElementById(type + '_baru');
    input.style.display = select.value === 'baru' ? 'block' : 'none';
}
</script>

</body>
</html>