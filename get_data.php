<?php
header('Content-Type: application/json');

$koneksi = new mysqli("localhost", "root", "mahasigma");

if ($koneksi->connect_error) {
    die(json_encode(["error" => "Gagal terhubung ke database: " . $koneksi->connect_error]));
}

$query = "SELECT jurusan, COUNT(*) as jumlah FROM mahasiswa GROUP BY jurusan";
$result = $koneksi->query($query);

if (!$result) {
    die(json_encode(["error" => "Query gagal: " . $koneksi->error]));
}

$labels = [];
$values = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['jurusan'];
    $values[] = $row['jumlah'];
}

echo json_encode(["labels" => $labels, "values" => $values]);

$koneksi->close();
?>
