<?php
header('Content-Type: application/json');
require 'koneksi.php';

$id          = (int)($_POST['id']          ?? 0);
$id_penulis  = (int)($_POST['id_penulis']  ?? 0);
$id_kategori = (int)($_POST['id_kategori'] ?? 0);
$judul       = trim($_POST['judul']        ?? '');
$isi         = trim($_POST['isi']          ?? '');

if (!$id || !$id_penulis || !$id_kategori || !$judul || !$isi) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    exit;
}

// Ambil gambar lama
$stmtGet = $koneksi->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmtGet->bind_param('i', $id);
$stmtGet->execute();
$current = $stmtGet->get_result()->fetch_assoc();
if (!$current) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
    exit;
}
$gambar_lama = $current['gambar'];
$gambar      = $gambar_lama;

// Handle gambar baru (opsional saat update)
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
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
}

$stmt = $koneksi->prepare(
    "UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=?, gambar=? WHERE id=?"
);
$stmt->bind_param('iisssi', $id_penulis, $id_kategori, $judul, $isi, $gambar, $id);

if ($stmt->execute()) {
    if ($gambar !== $gambar_lama && file_exists('uploads_artikel/' . $gambar_lama)) {
        unlink('uploads_artikel/' . $gambar_lama);
    }
    echo json_encode(['status' => 'success', 'message' => 'Artikel berhasil diperbarui']);
} else {
    if ($gambar !== $gambar_lama && file_exists('uploads_artikel/' . $gambar)) {
        unlink('uploads_artikel/' . $gambar);
    }
    echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui artikel']);
}
