<?php
header('Content-Type: application/json');
require 'koneksi.php';

$id = (int)($_POST['id'] ?? 0);
if (!$id) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
    exit;
}

// Cek apakah penulis masih memiliki artikel
$stmtCek = $koneksi->prepare("SELECT COUNT(*) AS total FROM artikel WHERE id_penulis = ?");
$stmtCek->bind_param('i', $id);
$stmtCek->execute();
$total = $stmtCek->get_result()->fetch_assoc()['total'];
if ($total > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Penulis tidak dapat dihapus karena masih memiliki artikel']);
    exit;
}

// Ambil data foto
$stmtGet = $koneksi->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmtGet->bind_param('i', $id);
$stmtGet->execute();
$row = $stmtGet->get_result()->fetch_assoc();
if (!$row) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
    exit;
}

$stmt = $koneksi->prepare("DELETE FROM penulis WHERE id = ?");
$stmt->bind_param('i', $id);
if ($stmt->execute()) {
    // Hapus foto jika bukan default
    if ($row['foto'] !== 'default.png' && file_exists('uploads_penulis/' . $row['foto'])) {
        unlink('uploads_penulis/' . $row['foto']);
    }
    echo json_encode(['status' => 'success', 'message' => 'Penulis berhasil dihapus']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data']);
}
