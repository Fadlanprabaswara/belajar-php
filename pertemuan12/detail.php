<?php
session_start();

if (!isset($_SESSION['login'])) {
  header("location: login.php");
  exit;
}

require 'functions.php';

// ambil id dari url
$id = $_GET['id'];

// query mahasiswa bedasarkan id
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Mahasiswa</title>
</head>

<body>
  <h3>Detail Mahasiswa</h3>
  <ul>
    <li><img src="image/<?= $mhs['gambar']; ?>" width="90"></li>
    <li>NPM : <?= $mhs['npm']; ?></li>
    <li>Nama : <?= $mhs['name']; ?></li>
    <li>Email : <?= $mhs['email']; ?></li>
    <li>Jurusan : <?= $mhs['jurusan']; ?></li>
    <li><a href="ubah.php?id=<?= $mhs['id']; ?>">ubah</a>|<a href="hapus.php?id=<?= $mhs['id']; ?>" onclick="return confirm
    ('apakah anda yakin?');">hapus</a></li>
    <li><a href="index.php">Kembai ke daftar mahasiswa</a></li>
  </ul>
</body>

</html>