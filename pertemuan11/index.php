<?php
require 'functions.php';
$mahasiswa = query("SELECT * FROM mahasiswa");

// ketika tombol cari diklik
if (isset($_POST['cari'])) {
  $mahasiswa = cari($_POST['keyword']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Mahasiswa</title>
</head>

<body>
  <!-- untuk menampilakn tabel dan konfigurasi data base -->
  <h3>Daftar Mahasiswa</h3>

  <a href="tambah.php">Tambah Data Mahasiwsa</a>
  <br><br>

  <form action="" method="POST">
    <input type="text" name="keyword" size="30" placeholder="MASUKAN KEYWORD PENCARIAN" autocomplete="off" autofocus>
    <button type="Submit" name="cari">Cari</button>
  </form>
  <br>

  <table border="1" cellpadding="10" cellspacing="0">
    <tr>
      <th>#</th>
      <th>Gambar</th>
      <th>Nama</th>
      <th>Aksi</th>
    </tr>

    <?php if (empty($mahasiswa)) : ?>
      <tr>
        <td colspan="4">
          <p>data mahasiswa tidak ditemukan</p>
        </td>
      </tr>
    <?php endif; ?>

    <?php $i = 1;
    foreach ($mahasiswa as $mhs) : ?>
      <tr>
        <td><?= $i++; ?></td>
        <td><img src="image/<?= $mhs['gambar']; ?>" width="90"></td>
        <td><?= $mhs['name']; ?></td>
        <td>
          <a href="detail.php?id=<?= $mhs['id']; ?>">lihat detail</a>
        </td>
      </tr>
    <?php endforeach; ?>

  </table>
</body>

</html>