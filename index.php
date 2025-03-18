<?php
include_once("koneksi.php");
$query = "SELECT * FROM tb_buku";
$hasil = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Koleksi Buku</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-success text-center">
            <h2>DATA KOLEKSI BUKU PERPUSTAKAAN</h2>
        </div>
        <a href="tambahbuku.php" class="btn btn-primary mb-3">Tambah Buku</a>
        <a href="chart.php" class="btn btn-info mb-3">Lihat Chart</a>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>ID Buku</th>
                    <th>Judul Buku</th>
                    <th>Pengarang</th>
                    <th>Tahun Terbit</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_array($hasil)) { ?>
                    <tr>
                        <td><?php echo $data['id_buku']; ?></td>
                        <td><?php echo $data['judul_buku']; ?></td>
                        <td><?php echo $data['pengarang']; ?></td>
                        <td><?php echo $data['tahun_terbit']; ?></td>
                        <td><?php echo $data['kategori']; ?></td>
                        <td>
                            <a href="editbuku.php?id=<?php echo $data['id_buku']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapusbuku.php?id=<?php echo $data['id_buku']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>