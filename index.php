<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Blog (CMS)</title>
    <!-- Menggunakan font modern Outfit untuk kesan futuristik & clean -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --sidebar-width: 260px;
            --header-height: 70px;
            --bg-base: #0b0f19; /* Latar belakang gelap kebiruan */
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
            --accent-color: #00f2fe; /* Warna cyan futuristik */
            --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }

        body { 
            background: var(--bg-base); 
            font-family: 'Outfit', sans-serif; 
            color: var(--text-main);
            overflow-x: hidden;
        }

        /* Ambient Glow (Efek cahaya futuristik di latar belakang) */
        body::before {
            content: '';
            position: fixed; top: -20%; left: -10%; width: 50vw; height: 50vw;
            background: radial-gradient(circle, rgba(0, 242, 254, 0.05) 0%, rgba(0,0,0,0) 70%);
            z-index: -1; pointer-events: none;
        }

        /* HEADER */
        #app-header {
            position: fixed; top: 0; left: 0; right: 0; height: var(--header-height);
            background: rgba(11, 15, 25, 0.8);
            backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--glass-border);
            display: flex; align-items: center; padding: 0 2rem; z-index: 1030;
        }
        #app-header h1 { 
            font-size: 1.25rem; font-weight: 700; margin: 0; letter-spacing: 0.5px; 
            background: var(--accent-gradient);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        #app-header i { color: var(--accent-color); }

        /* SIDEBAR */
        #sidebar {
            position: fixed; top: var(--header-height); left: 0; bottom: 0;
            width: var(--sidebar-width); 
            background: rgba(11, 15, 25, 0.95);
            border-right: 1px solid var(--glass-border); 
            overflow-y: auto; z-index: 1020; padding-top: 1.5rem;
        }
        #sidebar .nav-label {
            font-size: 0.75rem; font-weight: 600; color: var(--text-muted);
            text-transform: uppercase; letter-spacing: 1.5px;
            padding: 0 2rem 1rem;
        }
        #sidebar .nav-item a {
            display: flex; align-items: center; gap: 1rem;
            padding: 0.8rem 2rem; color: var(--text-muted); text-decoration: none;
            font-size: 0.95rem; border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }
        #sidebar .nav-item a:hover { 
            background: rgba(255,255,255,0.02); color: var(--text-main); 
        }
        #sidebar .nav-item a.active {
            background: rgba(0, 242, 254, 0.05); color: var(--accent-color);
            border-left-color: var(--accent-color); font-weight: 500;
        }
        #sidebar .nav-item a i { font-size: 1.2rem; }

        /* MAIN CONTENT */
        #main-content {
            margin-left: var(--sidebar-width);
            padding: calc(var(--header-height) + 2rem) 2rem 2rem;
            min-height: 100vh;
        }

        /* GLASS CARDS */
        .content-card {
            background: var(--glass-bg); 
            backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 20px; padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .content-card .card-title {
            font-size: 1.4rem; font-weight: 600; color: var(--text-main); margin-bottom: 0;
        }

        /* BUTTONS */
        .btn-primary {
            background: var(--accent-gradient); border: none; color: #0b0f19;
            font-weight: 600; border-radius: 8px; padding: 0.5rem 1.2rem;
            box-shadow: 0 4px 15px rgba(0, 242, 254, 0.2);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px); color: #0b0f19;
            box-shadow: 0 6px 20px rgba(0, 242, 254, 0.4);
        }
        /* Style untuk tombol aksi di dalam tabel agar lebih clean */
        .btn-warning, .btn-danger { border-radius: 6px; font-weight: 500; }

        /* TABLE */
        .table {
            --bs-table-bg: transparent;
            --bs-table-color: var(--text-main);
            --bs-table-border-color: var(--glass-border);
            --bs-table-hover-bg: rgba(255,255,255,0.02);
            margin-top: 1rem;
        }


        .table th { 
            background: transparent; color: var(--text-muted); 
            font-weight: 500; font-size: 0.85rem; text-transform: uppercase; 
            letter-spacing: 0.5px; border-bottom: 2px solid var(--glass-border);
            padding: 1rem;
        }
        .table td { vertical-align: middle; padding: 1rem; }
        .table img { border-radius: 8px; object-fit: cover; border: 1px solid var(--glass-border); }

        /* MODAL CUSTOMIZATION */
        .modal-content {
            background: #111827; border: 1px solid var(--glass-border);
            border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .modal-header { border-bottom: 1px solid var(--glass-border); padding: 1.5rem; background: transparent !important; }
        .modal-footer { border-top: 1px solid var(--glass-border); padding: 1.5rem; }
        .modal-body { padding: 1.5rem; }
        .modal-title { font-weight: 600; color: var(--text-main); }
        .modal-header.bg-warning .modal-title { color: #fbbf24; }
        .modal-header.bg-danger .modal-title { color: #ef4444; }
        .btn-close-white { filter: invert(1) grayscale(100%) brightness(200%); }

        /* FORMS */
        .form-control, .form-select {
            background-color: rgba(255,255,255,0.03); border: 1px solid var(--glass-border);
            color: var(--text-main); border-radius: 8px; padding: 0.6rem 1rem;
        }
        .form-control:focus, .form-select:focus {
            background-color: rgba(255,255,255,0.05); border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(0, 242, 254, 0.1); color: var(--text-main);
        }
        
        /* PERBAIKAN: Mengatur background dan warna teks untuk elemen <option> */
        .form-select option {
            background-color: #111827; /* Warna gelap menyesuaikan modal */
            color: var(--text-main);
        }

        .form-label { font-size: 0.85rem; font-weight: 500; color: var(--text-muted); margin-bottom: 0.4rem; }

        /* TOAST */
        #toast-container { position: fixed; bottom: 2rem; right: 2rem; z-index: 9999; }
        .toast { background: #1f2937; border: 1px solid var(--glass-border); border-radius: 10px; }

        /* PASSWORD toggle */
        .input-password { position: relative; }
        .input-password .toggle-pw {
            position: absolute; right: 1rem; top: 50%; transform: translateY(-50%);
            cursor: pointer; color: var(--text-muted); transition: color 0.2s;
        }
        .input-password .toggle-pw:hover { color: var(--text-main); }

        /* Image preview */
        .img-preview { max-height: 120px; border-radius: 8px; display: none; margin-top: .8rem; border: 1px solid var(--glass-border); }
    </style>
</head>
<body>

<!-- HEADER -->
<header id="app-header">
    <i class="bi bi-hexagon-half me-3 fs-3"></i>
    <h1>Sistem Manajemen Blog (CMS)</h1>
</header>

<!-- SIDEBAR -->
<nav id="sidebar">
    <div class="nav-label">Menu Utama</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="#" id="nav-penulis" onclick="showSection('penulis')">
                <i class="bi bi-people"></i> Kelola Penulis
            </a>
        </li>
        <li class="nav-item">
            <a href="#" id="nav-artikel" onclick="showSection('artikel')">
                <i class="bi bi-journal-text"></i> Kelola Artikel
            </a>
        </li>
        <li class="nav-item">
            <a href="#" id="nav-kategori" onclick="showSection('kategori')">
                <i class="bi bi-bookmarks"></i> Kelola Kategori Artikel
            </a>
        </li>
    </ul>
</nav>

<!-- MAIN CONTENT -->
<main id="main-content">

    <!-- SECTION: PENULIS -->
    <div id="section-penulis" class="section d-none">
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="card-title"><i class="bi bi-people me-2 text-info"></i>Data Penulis</h2>
                <button class="btn btn-primary" onclick="openModalTambahPenulis()">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Penulis
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-penulis">
                        <tr><td colspan="6" class="text-center text-muted py-5">Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- SECTION: ARTIKEL -->
    <div id="section-artikel" class="section d-none">
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="card-title"><i class="bi bi-journal-text me-2 text-info"></i>Data Artikel</h2>
                <button class="btn btn-primary" onclick="openModalTambahArtikel()">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Artikel
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Penulis</th>
                            <th>Tanggal</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-artikel">
                        <tr><td colspan="7" class="text-center text-muted py-5">Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- SECTION: KATEGORI -->
    <div id="section-kategori" class="section d-none">
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="card-title"><i class="bi bi-bookmarks me-2 text-info"></i>Kategori Artikel</h2>
                <button class="btn btn-primary" onclick="openModalTambahKategori()">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kategori</th>
                            <th>Keterangan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-kategori">
                        <tr><td colspan="4" class="text-center text-muted py-5">Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>

<!-- ===================== MODAL: TAMBAH PENULIS ===================== -->
<div class="modal fade" id="modalTambahPenulis" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-plus me-2 text-info"></i>Tambah Penulis</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Depan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="tp-nama_depan" placeholder="John">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Belakang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="tp-nama_belakang" placeholder="Doe">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="tp-user_name" placeholder="username_unik">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                    <div class="input-password">
                        <input type="password" class="form-control" id="tp-password" placeholder="••••••••">
                        <i class="bi bi-eye toggle-pw" onclick="togglePw('tp-password', this)"></i>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Foto Profil</label>
                    <input type="file" class="form-control" id="tp-foto" accept="image/*" onchange="previewImg(this,'tp-preview')">
                    <img id="tp-preview" class="img-preview">
                    <small class="text-muted d-block mt-2">Maks. 2 MB. JPG/PNG/GIF/WEBP. Kosongkan untuk foto default.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary" onclick="simpanPenulis()"><i class="bi bi-save me-1"></i>Simpan Data</button>
            </div>
        </div>
    </div>
</div>

<!-- ===================== MODAL: EDIT PENULIS ===================== -->
<div class="modal fade" id="modalEditPenulis" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Penulis</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="ep-id">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Depan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="ep-nama_depan">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Belakang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="ep-nama_belakang">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="ep-user_name">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password Baru <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                    <div class="input-password">
                        <input type="password" class="form-control" id="ep-password" placeholder="••••••••">
                        <i class="bi bi-eye toggle-pw" onclick="togglePw('ep-password', this)"></i>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Foto Profil <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                    <input type="file" class="form-control" id="ep-foto" accept="image/*" onchange="previewImg(this,'ep-preview')">
                    <img id="ep-preview" class="img-preview">
                    <small class="text-muted d-block mt-2">Maks. 2 MB. JPG/PNG/GIF/WEBP.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-warning text-dark fw-bold" onclick="updatePenulis()"><i class="bi bi-save me-1"></i>Perbarui Data</button>
            </div>
        </div>
    </div>
</div>

<!-- ===================== MODAL: HAPUS PENULIS ===================== -->
<div class="modal fade" id="modalHapusPenulis" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title"><i class="bi bi-trash me-2"></i>Hapus Penulis</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="bi bi-exclamation-triangle-fill text-danger mb-3" style="font-size: 3rem;"></i>
                <p class="fs-5 mb-1">Hapus <strong><span id="hapus-nama-penulis"></span></strong>?</p>
                <small class="text-muted">Tindakan ini tidak dapat dibatalkan.</small>
                <input type="hidden" id="hapus-id-penulis">
            </div>
            <div class="modal-footer justify-content-center">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-danger" onclick="hapusPenulis()"><i class="bi bi-trash me-1"></i>Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- ===================== MODAL: TAMBAH KATEGORI ===================== -->
<div class="modal fade" id="modalTambahKategori" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-tag me-2 text-info"></i>Tambah Kategori</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="tk-nama_kategori" placeholder="Cth: Tutorial">
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea class="form-control" id="tk-keterangan" rows="4" placeholder="Deskripsi singkat mengenai kategori..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary" onclick="simpanKategori()"><i class="bi bi-save me-1"></i>Simpan Data</button>
            </div>
        </div>
    </div>
</div>

<!-- ===================== MODAL: EDIT KATEGORI ===================== -->
<div class="modal fade" id="modalEditKategori" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Kategori</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="ek-id">
                <div class="mb-3">
                    <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="ek-nama_kategori">
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea class="form-control" id="ek-keterangan" rows="4"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-warning text-dark fw-bold" onclick="updateKategori()"><i class="bi bi-save me-1"></i>Perbarui Data</button>
            </div>
        </div>
    </div>
</div>

<!-- ===================== MODAL: HAPUS KATEGORI ===================== -->
<div class="modal fade" id="modalHapusKategori" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title"><i class="bi bi-trash me-2"></i>Hapus Kategori</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="bi bi-exclamation-triangle-fill text-danger mb-3" style="font-size: 3rem;"></i>
                <p class="fs-5 mb-1">Hapus <strong><span id="hapus-nama-kategori"></span></strong>?</p>
                <small class="text-muted">Tindakan ini tidak dapat dibatalkan.</small>
                <input type="hidden" id="hapus-id-kategori">
            </div>
            <div class="modal-footer justify-content-center">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-danger" onclick="hapusKategori()"><i class="bi bi-trash me-1"></i>Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- ===================== MODAL: TAMBAH ARTIKEL ===================== -->
<div class="modal fade" id="modalTambahArtikel" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-file-earmark-plus me-2 text-info"></i>Tambah Artikel</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <label class="form-label">Judul Artikel <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-lg fs-6" id="ta-judul" placeholder="Masukkan judul yang menarik...">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Penulis <span class="text-danger">*</span></label>
                        <select class="form-select" id="ta-id_penulis"></select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select" id="ta-id_kategori"></select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Isi Artikel <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="ta-isi" rows="6" placeholder="Tulis konten artikel di sini..."></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gambar Cover <span class="text-danger">*</span></label>
                    <input type="file" class="form-control" id="ta-gambar" accept="image/*" onchange="previewImg(this,'ta-preview')">
                    <img id="ta-preview" class="img-preview">
                    <small class="text-muted d-block mt-2">Maks. 2 MB. JPG/PNG/GIF/WEBP. Wajib diisi.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary" onclick="simpanArtikel()"><i class="bi bi-save me-1"></i>Simpan Artikel</button>
            </div>
        </div>
    </div>
</div>

<!-- ===================== MODAL: EDIT ARTIKEL ===================== -->
<div class="modal fade" id="modalEditArtikel" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Artikel</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="ea-id">
                <div class="mb-4">
                    <label class="form-label">Judul Artikel <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-lg fs-6" id="ea-judul">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Penulis <span class="text-danger">*</span></label>
                        <select class="form-select" id="ea-id_penulis"></select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select" id="ea-id_kategori"></select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Isi Artikel <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="ea-isi" rows="6"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gambar Cover <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                    <input type="file" class="form-control" id="ea-gambar" accept="image/*" onchange="previewImg(this,'ea-preview')">
                    <img id="ea-preview" class="img-preview">
                    <div id="ea-gambar-lama" class="mt-3 p-3 border rounded" style="border-color: var(--glass-border) !important; background: rgba(0,0,0,0.2);"></div>
                    <small class="text-muted d-block mt-2">Maks. 2 MB. JPG/PNG/GIF/WEBP.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-warning text-dark fw-bold" onclick="updateArtikel()"><i class="bi bi-save me-1"></i>Perbarui Artikel</button>
            </div>
        </div>
    </div>
</div>

<!-- ===================== MODAL: HAPUS ARTIKEL ===================== -->
<div class="modal fade" id="modalHapusArtikel" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title"><i class="bi bi-trash me-2"></i>Hapus Artikel</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="bi bi-exclamation-triangle-fill text-danger mb-3" style="font-size: 3rem;"></i>
                <p class="fs-5 mb-1">Hapus <strong><span id="hapus-judul-artikel"></span></strong>?</p>
                <small class="text-muted">Gambar cover artikel juga akan dihapus dari server secara permanen.</small>
                <input type="hidden" id="hapus-id-artikel">
            </div>
            <div class="modal-footer justify-content-center">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-danger" onclick="hapusArtikel()"><i class="bi bi-trash me-1"></i>Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- TOAST CONTAINER -->
<div id="toast-container"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
/* ========== UTILITIES ========== */
function esc(str) {
    const d = document.createElement('div');
    d.textContent = str ?? '';
    return d.innerHTML;
}

function showToast(msg, type = 'success') {
    const id = 'toast-' + Date.now();
    const bg = type === 'success' ? 'bg-success' : 'bg-danger';
    const icon = type === 'success' ? 'bi-check-circle-fill' : 'bi-x-circle-fill';
    document.getElementById('toast-container').insertAdjacentHTML('beforeend', `
        <div id="${id}" class="toast align-items-center text-white ${bg} border-0 mb-2 show" role="alert">
            <div class="d-flex">
                <div class="toast-body"><i class="bi ${icon} me-2"></i>${esc(msg)}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="document.getElementById('${id}').remove()"></button>
            </div>
        </div>`);
    setTimeout(() => { const el = document.getElementById(id); if (el) el.remove(); }, 4000);
}

function togglePw(inputId, icon) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') { input.type = 'text'; icon.classList.replace('bi-eye','bi-eye-slash'); }
    else { input.type = 'password'; icon.classList.replace('bi-eye-slash','bi-eye'); }
}

function previewImg(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

function getModal(id) { return bootstrap.Modal.getOrCreateInstance(document.getElementById(id)); }

/* ========== NAVIGATION ========== */
function showSection(section) {
    document.querySelectorAll('.section').forEach(s => s.classList.add('d-none'));
    document.querySelectorAll('#sidebar .nav-item a').forEach(a => a.classList.remove('active'));
    document.getElementById('section-' + section).classList.remove('d-none');
    document.getElementById('nav-' + section).classList.add('active');
    if (section === 'penulis') loadPenulis();
    if (section === 'artikel') loadArtikel();
    if (section === 'kategori') loadKategori();
    return false;
}

/* ====================================================
   PENULIS
==================================================== */
async function loadPenulis() {
    const tbody = document.getElementById('tabel-penulis');
    tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4"><div class="spinner-border spinner-border-sm text-info"></div> Memuat...</td></tr>';
    const res = await fetch('ambil_penulis.php');
    const json = await res.json();
    if (!json.data.length) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">Belum ada data penulis.</td></tr>';
        return;
    }
    tbody.innerHTML = json.data.map((p, i) => `
        <tr>
            <td>${i+1}</td>
            <td><img src="uploads_penulis/${esc(p.foto)}" width="45" height="45" onerror="this.src='uploads_penulis/default.png'"></td>
            <td class="fw-medium">${esc(p.nama_depan)} ${esc(p.nama_belakang)}</td>
            <td><code class="text-info bg-dark px-2 py-1 rounded border border-secondary">@${esc(p.user_name)}</code></td>
            <td><span class="badge bg-secondary opacity-75">Terenkripsi</span></td>
            <td class="text-end">
                <button class="btn btn-warning btn-sm me-1" onclick="openModalEditPenulis(${p.id})"><i class="bi bi-pencil"></i> Edit</button>
                <button class="btn btn-danger btn-sm" onclick="openModalHapusPenulis(${p.id}, '${esc(p.nama_depan)} ${esc(p.nama_belakang)}')"><i class="bi bi-trash"></i> Hapus</button>
            </td>
        </tr>`).join('');
}

function openModalTambahPenulis() {
    ['tp-nama_depan','tp-nama_belakang','tp-user_name','tp-password'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('tp-foto').value = '';
    document.getElementById('tp-preview').style.display = 'none';
    getModal('modalTambahPenulis').show();
}

async function simpanPenulis() {
    const fd = new FormData();
    fd.append('nama_depan',    document.getElementById('tp-nama_depan').value.trim());
    fd.append('nama_belakang', document.getElementById('tp-nama_belakang').value.trim());
    fd.append('user_name',     document.getElementById('tp-user_name').value.trim());
    fd.append('password',      document.getElementById('tp-password').value);
    const foto = document.getElementById('tp-foto').files[0];
    if (foto) fd.append('foto', foto);

    const res = await fetch('simpan_penulis.php', { method: 'POST', body: fd });
    const json = await res.json();
    showToast(json.message, json.status);
    if (json.status === 'success') { getModal('modalTambahPenulis').hide(); loadPenulis(); }
}

async function openModalEditPenulis(id) {
    const res = await fetch('ambil_satu_penulis.php?id=' + id);
    const json = await res.json();
    if (json.status !== 'success') { showToast(json.message, 'error'); return; }
    const p = json.data;
    document.getElementById('ep-id').value          = p.id;
    document.getElementById('ep-nama_depan').value  = p.nama_depan;
    document.getElementById('ep-nama_belakang').value = p.nama_belakang;
    document.getElementById('ep-user_name').value   = p.user_name;
    document.getElementById('ep-password').value    = '';
    document.getElementById('ep-foto').value         = '';
    document.getElementById('ep-preview').style.display = 'none';
    getModal('modalEditPenulis').show();
}

async function updatePenulis() {
    const fd = new FormData();
    fd.append('id',            document.getElementById('ep-id').value);
    fd.append('nama_depan',    document.getElementById('ep-nama_depan').value.trim());
    fd.append('nama_belakang', document.getElementById('ep-nama_belakang').value.trim());
    fd.append('user_name',     document.getElementById('ep-user_name').value.trim());
    fd.append('password',      document.getElementById('ep-password').value);
    const foto = document.getElementById('ep-foto').files[0];
    if (foto) fd.append('foto', foto);

    const res = await fetch('update_penulis.php', { method: 'POST', body: fd });
    const json = await res.json();
    showToast(json.message, json.status);
    if (json.status === 'success') { getModal('modalEditPenulis').hide(); loadPenulis(); }
}

function openModalHapusPenulis(id, nama) {
    document.getElementById('hapus-id-penulis').value = id;
    document.getElementById('hapus-nama-penulis').textContent = nama;
    getModal('modalHapusPenulis').show();
}

async function hapusPenulis() {
    const fd = new FormData();
    fd.append('id', document.getElementById('hapus-id-penulis').value);
    const res = await fetch('hapus_penulis.php', { method: 'POST', body: fd });
    const json = await res.json();
    showToast(json.message, json.status);
    if (json.status === 'success') { getModal('modalHapusPenulis').hide(); loadPenulis(); }
}

/* ====================================================
   KATEGORI
==================================================== */
async function loadKategori() {
    const tbody = document.getElementById('tabel-kategori');
    tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-4"><div class="spinner-border spinner-border-sm text-info"></div> Memuat...</td></tr>';
    const res = await fetch('ambil_kategori.php');
    const json = await res.json();
    if (!json.data.length) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-4">Belum ada data kategori.</td></tr>';
        return;
    }
    tbody.innerHTML = json.data.map((k, i) => `
        <tr>
            <td>${i+1}</td>
            <td class="fw-medium text-info">${esc(k.nama_kategori)}</td>
            <td class="text-muted">${esc(k.keterangan) || '<span class="opacity-50">-</span>'}</td>
            <td class="text-end">
                <button class="btn btn-warning btn-sm me-1" onclick="openModalEditKategori(${k.id})"><i class="bi bi-pencil"></i> Edit</button>
                <button class="btn btn-danger btn-sm" onclick="openModalHapusKategori(${k.id}, '${esc(k.nama_kategori)}')"><i class="bi bi-trash"></i> Hapus</button>
            </td>
        </tr>`).join('');
}

function openModalTambahKategori() {
    document.getElementById('tk-nama_kategori').value = '';
    document.getElementById('tk-keterangan').value = '';
    getModal('modalTambahKategori').show();
}

async function simpanKategori() {
    const fd = new FormData();
    fd.append('nama_kategori', document.getElementById('tk-nama_kategori').value.trim());
    fd.append('keterangan',    document.getElementById('tk-keterangan').value.trim());
    const res = await fetch('simpan_kategori.php', { method: 'POST', body: fd });
    const json = await res.json();
    showToast(json.message, json.status);
    if (json.status === 'success') { getModal('modalTambahKategori').hide(); loadKategori(); }
}

async function openModalEditKategori(id) {
    const res = await fetch('ambil_satu_kategori.php?id=' + id);
    const json = await res.json();
    if (json.status !== 'success') { showToast(json.message, 'error'); return; }
    const k = json.data;
    document.getElementById('ek-id').value             = k.id;
    document.getElementById('ek-nama_kategori').value  = k.nama_kategori;
    document.getElementById('ek-keterangan').value     = k.keterangan ?? '';
    getModal('modalEditKategori').show();
}

async function updateKategori() {
    const fd = new FormData();
    fd.append('id',            document.getElementById('ek-id').value);
    fd.append('nama_kategori', document.getElementById('ek-nama_kategori').value.trim());
    fd.append('keterangan',    document.getElementById('ek-keterangan').value.trim());
    const res = await fetch('update_kategori.php', { method: 'POST', body: fd });
    const json = await res.json();
    showToast(json.message, json.status);
    if (json.status === 'success') { getModal('modalEditKategori').hide(); loadKategori(); }
}

function openModalHapusKategori(id, nama) {
    document.getElementById('hapus-id-kategori').value = id;
    document.getElementById('hapus-nama-kategori').textContent = nama;
    getModal('modalHapusKategori').show();
}

async function hapusKategori() {
    const fd = new FormData();
    fd.append('id', document.getElementById('hapus-id-kategori').value);
    const res = await fetch('hapus_kategori.php', { method: 'POST', body: fd });
    const json = await res.json();
    showToast(json.message, json.status);
    if (json.status === 'success') { getModal('modalHapusKategori').hide(); loadKategori(); }
}

/* ====================================================
   ARTIKEL
==================================================== */
async function loadArtikel() {
    const tbody = document.getElementById('tabel-artikel');
    tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted py-4"><div class="spinner-border spinner-border-sm text-info"></div> Memuat...</td></tr>';
    const res = await fetch('ambil_artikel.php');
    const json = await res.json();
    if (!json.data.length) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted py-4">Belum ada data artikel.</td></tr>';
        return;
    }
    tbody.innerHTML = json.data.map((a, i) => `
        <tr>
            <td>${i+1}</td>
            <td><img src="uploads_artikel/${esc(a.gambar)}" width="80" height="55" onerror="this.src=''"></td>
            <td class="fw-medium">${esc(a.judul)}</td>
            <td><span class="badge bg-info text-dark">${esc(a.nama_kategori)}</span></td>
            <td class="text-muted"><i class="bi bi-person-circle me-1"></i>${esc(a.nama_penulis)}</td>
            <td><small class="text-muted"><i class="bi bi-clock me-1"></i>${esc(a.hari_tanggal)}</small></td>
            <td class="text-end">
                <button class="btn btn-warning btn-sm me-1" onclick="openModalEditArtikel(${a.id})"><i class="bi bi-pencil"></i> Edit</button>
                <button class="btn btn-danger btn-sm" onclick="openModalHapusArtikel(${a.id}, '${esc(a.judul)}')"><i class="bi bi-trash"></i> Hapus</button>
            </td>
        </tr>`).join('');
}

async function populateDropdowns(penulisSel, kategoriSel) {
    const [rP, rK] = await Promise.all([fetch('ambil_penulis.php'), fetch('ambil_kategori.php')]);
    const [jP, jK] = await Promise.all([rP.json(), rK.json()]);
    penulisSel.innerHTML  = '<option value="" class="text-muted">-- Pilih Penulis --</option>'  + jP.data.map(p => `<option value="${p.id}">${esc(p.nama_depan)} ${esc(p.nama_belakang)}</option>`).join('');
    kategoriSel.innerHTML = '<option value="" class="text-muted">-- Pilih Kategori --</option>' + jK.data.map(k => `<option value="${k.id}">${esc(k.nama_kategori)}</option>`).join('');
}

async function openModalTambahArtikel() {
    await populateDropdowns(document.getElementById('ta-id_penulis'), document.getElementById('ta-id_kategori'));
    ['ta-judul','ta-isi'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('ta-gambar').value = '';
    document.getElementById('ta-preview').style.display = 'none';
    getModal('modalTambahArtikel').show();
}

async function simpanArtikel() {
    const fd = new FormData();
    fd.append('id_penulis',  document.getElementById('ta-id_penulis').value);
    fd.append('id_kategori', document.getElementById('ta-id_kategori').value);
    fd.append('judul',       document.getElementById('ta-judul').value.trim());
    fd.append('isi',         document.getElementById('ta-isi').value.trim());
    const gambar = document.getElementById('ta-gambar').files[0];
    if (gambar) fd.append('gambar', gambar);

    const res = await fetch('simpan_artikel.php', { method: 'POST', body: fd });
    const json = await res.json();
    showToast(json.message, json.status);
    if (json.status === 'success') { getModal('modalTambahArtikel').hide(); loadArtikel(); }
}

async function openModalEditArtikel(id) {
    await populateDropdowns(document.getElementById('ea-id_penulis'), document.getElementById('ea-id_kategori'));
    const res = await fetch('ambil_satu_artikel.php?id=' + id);
    const json = await res.json();
    if (json.status !== 'success') { showToast(json.message, 'error'); return; }
    const a = json.data;
    document.getElementById('ea-id').value          = a.id;
    document.getElementById('ea-judul').value        = a.judul;
    document.getElementById('ea-isi').value          = a.isi;
    document.getElementById('ea-id_penulis').value   = a.id_penulis;
    document.getElementById('ea-id_kategori').value  = a.id_kategori;
    document.getElementById('ea-gambar').value        = '';
    document.getElementById('ea-preview').style.display = 'none';
    document.getElementById('ea-gambar-lama').innerHTML =
        `<small class="text-muted d-block mb-1">Gambar saat ini: </small><img src="uploads_artikel/${esc(a.gambar)}" height="80" class="rounded border border-secondary shadow-sm">`;
    getModal('modalEditArtikel').show();
}

async function updateArtikel() {
    const fd = new FormData();
    fd.append('id',          document.getElementById('ea-id').value);
    fd.append('id_penulis',  document.getElementById('ea-id_penulis').value);
    fd.append('id_kategori', document.getElementById('ea-id_kategori').value);
    fd.append('judul',       document.getElementById('ea-judul').value.trim());
    fd.append('isi',         document.getElementById('ea-isi').value.trim());
    const gambar = document.getElementById('ea-gambar').files[0];
    if (gambar) fd.append('gambar', gambar);

    const res = await fetch('update_artikel.php', { method: 'POST', body: fd });
    const json = await res.json();
    showToast(json.message, json.status);
    if (json.status === 'success') { getModal('modalEditArtikel').hide(); loadArtikel(); }
}

function openModalHapusArtikel(id, judul) {
    document.getElementById('hapus-id-artikel').value = id;
    document.getElementById('hapus-judul-artikel').textContent = judul;
    getModal('modalHapusArtikel').show();
}

async function hapusArtikel() {
    const fd = new FormData();
    fd.append('id', document.getElementById('hapus-id-artikel').value);
    const res = await fetch('hapus_artikel.php', { method: 'POST', body: fd });
    const json = await res.json();
    showToast(json.message, json.status);
    if (json.status === 'success') { getModal('modalHapusArtikel').hide(); loadArtikel(); }
}

/* ========== INIT ========== */
showSection('penulis');
</script>
</body>
</html>