<?php
include_once("koneksi.php");
$query = "SELECT kategori, COUNT(*) as total FROM tb_buku GROUP BY kategori";
$hasil = mysqli_query($conn, $query);
$labels = [];
$data = [];

while ($row = mysqli_fetch_array($hasil)) {
    $labels[] = $row['kategori'];
    $data[] = $row['total'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Chart Buku</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-success text-center">
            <h2>GRAFIK BUKU BERDASARKAN KATEGORI</h2>
        </div>
        <canvas id="myChart"></canvas>
        <a href="index.php" class="btn btn-secondary mt-3">Kembali</a>
    </div>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Jumlah Buku',
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>