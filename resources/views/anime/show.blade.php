<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $anime->judul }} — Anime Collection</title>
    <link rel="stylesheet" href="{{ asset('css/anime.css') }}">
</head>
<body>

<nav class="navbar">
    <a href="{{ route('anime.index') }}" class="navbar-brand">
        <span class="icon">⛩️</span> Anime Collection
    </a>
    <ul class="navbar-nav">
        <li><a href="{{ route('anime.index') }}">Koleksi</a></li>
        <li><a href="{{ route('anime.edit', $anime->id) }}">✏️ Edit</a></li>
    </ul>
</nav>

<div class="main-container">

    <div class="page-header">
        <h1>🎌 Detail Anime</h1>
        <div class="header-line"></div>
    </div>

    <div class="detail-wrapper">

        {{-- ===== LEFT: IMAGE ===== --}}
        <div class="detail-image-col">
            <div class="detail-image">
                @if($anime->gambar)
                    <img src="{{ asset('storage/' . $anime->gambar) }}" alt="{{ $anime->judul }}">
                @else
                    <div class="detail-image-placeholder">
                        🎌
                        <span style="font-size:0.75rem; letter-spacing:3px; color:var(--text-light);">NO IMAGE</span>
                    </div>
                @endif
            </div>

            <div class="detail-actions" style="margin-top: 1rem;">
                <a href="{{ route('anime.edit', $anime->id) }}" class="btn btn-edit" style="flex:1; justify-content:center;">
                    ✏️ Edit
                </a>
                <form action="{{ route('anime.destroy', $anime->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus {{ $anime->judul }}?')" style="flex:1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete" style="width:100%; justify-content:center;">
                        🗑️ Hapus
                    </button>
                </form>
            </div>

            <div style="margin-top: 0.75rem;">
                <a href="{{ route('anime.index') }}" class="btn btn-cancel" style="width:100%; justify-content:center;">
                    ← Kembali ke Koleksi
                </a>
            </div>
        </div>

        {{-- ===== RIGHT: INFO ===== --}}
        <div class="detail-info-col">

            <div class="detail-card">
                <h1 class="detail-title">{{ $anime->judul }}</h1>

                <div style="margin-bottom: 1rem;">
                    @foreach(explode(',', $anime->genre) as $g)
                        <span class="genre-tag">{{ trim($g) }}</span>
                    @endforeach
                </div>

                <div class="stats-grid">
                    <div class="stat-box">
                        <span class="stat-value">⭐ {{ $anime->rating }}</span>
                        <span class="stat-label">Rating</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-value">{{ $anime->episode }}</span>
                        <span class="stat-label">Episode</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-value">{{ $anime->tahun_rilis ?? '—' }}</span>
                        <span class="stat-label">Tahun Rilis</span>
                    </div>
                </div>

                @if($anime->studio)
                <div style="margin-bottom: 1.5rem;">
                    <p class="detail-section-title">Studio Produksi</p>
                    <p style="font-size:0.95rem; font-weight:500; color: var(--text-primary);">
                        🎬 {{ $anime->studio }}
                    </p>
                </div>
                @endif

                <div>
                    <p class="detail-section-title">Sinopsis</p>
                    <p class="detail-synopsis">
                        {{ $anime->sinopsis ?? 'Tidak ada sinopsis tersedia.' }}
                    </p>
                </div>
            </div>

            <div class="detail-card">
                <p class="detail-section-title">Informasi Tambahan</p>
                <div style="display:flex; flex-direction:column; gap:0.75rem;">
                    <div style="display:flex; justify-content:space-between; padding-bottom:0.75rem; border-bottom:1px solid var(--border-card);">
                        <span style="color:var(--text-muted); font-size:0.83rem; letter-spacing:1px;">ID</span>
                        <span style="font-family:'Shippori Mincho',serif; font-size:0.88rem; font-weight:700; color:var(--beni);">#{{ str_pad($anime->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding-bottom:0.75rem; border-bottom:1px solid var(--border-card);">
                        <span style="color:var(--text-muted); font-size:0.83rem; letter-spacing:1px;">Ditambahkan</span>
                        <span style="font-size:0.85rem; color:var(--text-primary);">{{ $anime->created_at->format('d M Y') }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between;">
                        <span style="color:var(--text-muted); font-size:0.83rem; letter-spacing:1px;">Terakhir Update</span>
                        <span style="font-size:0.85rem; color:var(--text-primary);">{{ $anime->updated_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>
