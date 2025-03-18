<?php
include_once("koneksi.php");
$id = $_GET['id'];
$query = "SELECT * FROM tb_buku WHERE id_buku = $id";
$hasil = mysqli_query($conn, $query);
$data = mysqli_fetch_array($hasil);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Buku</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-success text-center">
            <h2>EDIT BUKU</h2>
        </div>
        <form method="post" action="proseseditbuku.php">
            <div class="form-group">
                <label>ID Buku</label>
                <input type="text" name="id_buku" class="form-control" value="<?php echo $data['id_buku']; ?>" readonly>
            </div>
            <div class="form-group">
                <label>Judul Buku</label>
                <input type="text" name="judul" class="form-control" value="<?php echo $data['judul_buku']; ?>" required>
            </div>
            <div class="form-group">
                <label>Pengarang</label>
                <input type="text" name="pengarang" class="form-control" value="<?php echo $data['pengarang']; ?>" required>
            </div>
            <div class="form-group">
                <label>Tahun Terbit</label>
                <input type="number" name="tahun_terbit" class="form-control" value="<?php echo $data['tahun_terbit']; ?>" required>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <input type="text" name="kategori" class="form-control" value="<?php echo $data['kategori']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>