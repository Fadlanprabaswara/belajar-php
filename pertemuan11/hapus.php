<?php
require 'functions.php';

//jika tidak ada id
if (!isset($_GET['id'])) {
  header("Location: index.php");
  exit;
}


//mengambil id dari url
$id = $_GET['id'];

if (hapus($id) > 0) {
  echo "<script>
            alert('Data telah berhasil dihapus brader');
            document.location.href = 'index.php';
            </script>";
} else {
  echo "data Gagal bro coba lagi!!!";
}
