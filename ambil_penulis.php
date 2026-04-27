<?php
header('Content-Type: application/json');
require 'koneksi.php';

$result = $koneksi->query("SELECT * FROM penulis ORDER BY id ASC");
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode(['status' => 'success', 'data' => $data]);
