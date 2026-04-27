<?php
header('Content-Type: application/json');
require 'koneksi.php';

$id_penulis  = (int)($_POST['id_penulis']  ?? 0);
$id_kategori = (int)($_POST['id_kategori'] ?? 0);
$judul       = trim($_POST['judul']        ?? '');
$isi         = trim($_POST['isi']          ?? '');

if (!$id_penulis || !$id_kategori || !$judul || !$isi) {
    echo json_encode(['status' => 'error', 'message' => 'Semua field wajib diisi']);
    exit;
}

// Upload gambar (wajib)
if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'error', 'message' => 'Gambar artikel wajib diunggah']);
    exit;
}

$finfo   = new finfo(FILEINFO_MIME_TYPE);
$mime    = $finfo->file($_FILES['gambar']['tmp_name']);
$allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

if (!in_array($mime, $allowed)) {
    echo json_encode(['status' => 'error', 'message' => 'Tipe file tidak diizinkan. Hanya JPG, PNG, GIF, WEBP']);
    exit;
}
if ($_FILES['gambar']['size'] > 2 * 1024 * 1024) {
    echo json_encode(['status' => 'error', 'message' => 'Ukuran file maksimal 2 MB']);
    exit;
}

$ext    = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
$gambar = uniqid('artikel_', true) . '.' . strtolower($ext);
move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads_artikel/' . $gambar);

// Generate hari_tanggal
date_default_timezone_set('Asia/Jakarta');
$hari   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$bulan  = [
    1=>'Januari', 2=>'Februari', 3=>'Maret',
    4=>'April',   5=>'Mei',      6=>'Juni',
    7=>'Juli',    8=>'Agustus',  9=>'September',
    10=>'Oktober',11=>'November',12=>'Desember'
];
$sekarang    = new DateTime();
$nama_hari   = $hari[$sekarang->format('w')];
$tanggal     = $sekarang->format('j');
$nama_bulan  = $bulan[(int)$sekarang->format('n')];
$tahun       = $sekarang->format('Y');
$jam         = $sekarang->format('H:i');
$hari_tanggal = "$nama_hari, $tanggal $nama_bulan $tahun | $jam";

$stmt = $koneksi->prepare(
    "INSERT INTO artikel (id_penulis, id_kategori, judul, isi, gambar, hari_tanggal) VALUES (?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param('iissss', $id_penulis, $id_kategori, $judul, $isi, $gambar, $hari_tanggal);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Artikel berhasil ditambahkan']);
} else {
    if (file_exists('uploads_artikel/' . $gambar)) {
        unlink('uploads_artikel/' . $gambar);
    }
    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan artikel']);
}
