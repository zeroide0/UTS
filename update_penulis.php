<?php
header('Content-Type: application/json');
require 'koneksi.php';

$id            = (int)($_POST['id']            ?? 0);
$nama_depan    = trim($_POST['nama_depan']    ?? '');
$nama_belakang = trim($_POST['nama_belakang'] ?? '');
$user_name     = trim($_POST['user_name']     ?? '');
$password      = $_POST['password']           ?? '';

if (!$id || !$nama_depan || !$nama_belakang || !$user_name) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    exit;
}

// Get current data
$stmtGet = $koneksi->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmtGet->bind_param('i', $id);
$stmtGet->execute();
$current = $stmtGet->get_result()->fetch_assoc();
if (!$current) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
    exit;
}
$foto_lama = $current['foto'];
$foto = $foto_lama;

// Handle foto upload
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $finfo   = new finfo(FILEINFO_MIME_TYPE);
    $mime    = $finfo->file($_FILES['foto']['tmp_name']);
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    if (!in_array($mime, $allowed)) {
        echo json_encode(['status' => 'error', 'message' => 'Tipe file tidak diizinkan. Hanya JPG, PNG, GIF, WEBP']);
        exit;
    }
    if ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'error', 'message' => 'Ukuran file maksimal 2 MB']);
        exit;
    }

    $ext  = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $foto = uniqid('foto_', true) . '.' . strtolower($ext);
    move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads_penulis/' . $foto);
}

// Build query
if ($password) {
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $koneksi->prepare(
        "UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, password=?, foto=? WHERE id=?"
    );
    $stmt->bind_param('sssssi', $nama_depan, $nama_belakang, $user_name, $hash, $foto, $id);
} else {
    $stmt = $koneksi->prepare(
        "UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, foto=? WHERE id=?"
    );
    $stmt->bind_param('ssssi', $nama_depan, $nama_belakang, $user_name, $foto, $id);
}

if ($stmt->execute()) {
    // Remove old photo if changed
    if ($foto !== $foto_lama && $foto_lama !== 'default.png' && file_exists('uploads_penulis/' . $foto_lama)) {
        unlink('uploads_penulis/' . $foto_lama);
    }
    echo json_encode(['status' => 'success', 'message' => 'Data penulis berhasil diperbarui']);
} else {
    if ($foto !== $foto_lama && file_exists('uploads_penulis/' . $foto)) {
        unlink('uploads_penulis/' . $foto);
    }
    $err = $koneksi->errno === 1062 ? 'Username sudah digunakan' : 'Gagal memperbarui data';
    echo json_encode(['status' => 'error', 'message' => $err]);
}
