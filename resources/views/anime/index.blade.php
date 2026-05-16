<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime Collection</title>
    <link rel="stylesheet" href="{{ asset('css/anime.css') }}">
</head>
<body>

{{-- ===== NAVBAR ===== --}}
<nav class="navbar">
    <a href="{{ route('anime.index') }}" class="navbar-brand">
        <span class="icon">⛩️</span> Anime Collection
    </a>
    <ul class="navbar-nav">
        <li><a href="{{ route('anime.index') }}" class="active">Koleksi</a></li>
        <li><a href="{{ route('anime.create') }}">+ Tambah</a></li>
    </ul>
</nav>

{{-- ===== MAIN ===== --}}
<div class="main-container">

    {{-- Page Header --}}
    <div class="page-header">
        <h1>🎌 Koleksi Anime</h1>
        <div class="header-line"></div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Toolbar: Search + Add --}}
    <div class="toolbar">
        <div class="search-wrapper">
            <span class="search-icon">🔍</span>
            <input
                type="text"
                class="search-input"
                id="searchInput"
                placeholder="Cari judul anime, genre, studio..."
                onkeyup="filterAnime()"
            >
        </div>
        <a href="{{ route('anime.create') }}" class="btn btn-add">
            ＋ Tambah Anime
        </a>
    </div>

    {{-- Anime Grid --}}
    @if($animes->isEmpty())
        <div class="empty-state">
            <span class="empty-icon">⛩️</span>
            <h3>Koleksi Masih Kosong</h3>
            <p>Belum ada anime yang ditambahkan</p>
            <a href="{{ route('anime.create') }}" class="btn btn-add">+ Tambah Anime Pertama</a>
        </div>
    @else
        <div class="anime-grid" id="animeGrid">
            @foreach($animes as $anime)
            <div class="anime-card" data-search="{{ strtolower($anime->judul . ' ' . $anime->genre . ' ' . $anime->studio) }}">

                {{-- Card Image --}}
                <div class="card-image" style="position:relative;">
                    @if($anime->gambar)
                        <img src="{{ asset('storage/' . $anime->gambar) }}" alt="{{ $anime->judul }}">
                    @else
                        <div class="card-image-placeholder">
                            🎌
                            <span>No Image</span>
                        </div>
                    @endif

                    {{-- Rating Badge --}}
                    <div class="rating-badge">
                        ⭐ {{ $anime->rating }}
                    </div>

                    {{-- Genre Badge --}}
                    <div class="genre-badge-img">{{ $anime->genre }}</div>
                </div>

                {{-- Card Body --}}
                <div class="card-body">
                    <h3 class="card-title">{{ $anime->judul }}</h3>

                    <div class="card-meta">
                        <span class="meta-item">
                            <span class="icon">📺</span> {{ $anime->episode }} Eps
                        </span>
                        @if($anime->studio)
                        <span class="meta-item">
                            <span class="icon">🎬</span> {{ $anime->studio }}
                        </span>
                        @endif
                        @if($anime->tahun_rilis)
                        <span class="meta-item">
                            <span class="icon">📅</span> {{ $anime->tahun_rilis }}
                        </span>
                        @endif
                    </div>

                    @if($anime->sinopsis)
                    <p class="card-synopsis">{{ $anime->sinopsis }}</p>
                    @endif

                    {{-- Card Actions --}}
                    <div class="card-actions">
                        <a href="{{ route('anime.show', $anime->id) }}" class="btn btn-detail">
                            🔍 Detail
                        </a>
                        <a href="{{ route('anime.edit', $anime->id) }}" class="btn btn-edit">
                            ✏️ Edit
                        </a>
                        <form action="{{ route('anime.destroy', $anime->id) }}" method="POST"
                              onsubmit="return confirm('Yakin hapus {{ $anime->judul }}?')" style="flex:1;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete" style="width:100%;">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        {{-- No search result --}}
        <div id="noResult" style="display:none;" class="empty-state">
            <span class="empty-icon">🔎</span>
            <h3>Anime Tidak Ditemukan</h3>
            <p>Coba kata kunci yang berbeda</p>
        </div>
    @endif

</div>

<script>
function filterAnime() {
    const query = document.getElementById('searchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.anime-card');
    const noResult = document.getElementById('noResult');
    let visible = 0;

    cards.forEach(card => {
        const text = card.getAttribute('data-search');
        if (text.includes(query)) {
            card.style.display = '';
            visible++;
        } else {
            card.style.display = 'none';
        }
    });

    if (noResult) {
        noResult.style.display = visible === 0 ? 'block' : 'none';
    }
}
</script>

</body>
</html>
