<?php

function koneksi()
{
  return mysqli_connect('localhost', 'root', '', 'phpdasar');
}

function query($query)
{
  $conn = koneksi();

  $result = mysqli_query($conn, $query);

  // jika hasilnya satu data 
  if (mysqli_num_rows($result) == 1) {
    return mysqli_fetch_assoc($result);
  }

  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;
}

function tambah($data)
{
  $conn = koneksi();

  $nama = htmlspecialchars($data['name']);
  $npm = htmlspecialchars($data['npm']);
  $email = htmlspecialchars($data['email']);
  $jurusan = htmlspecialchars($data['jurusan']);
  $gambar = htmlspecialchars($data['gambar']);

  $query = "INSERT INTO
              mahasiswa
            VALUES
            (null, '$nama', '$npm', '$email', '$jurusan', '$gambar');
          ";
  mysqli_query($conn, $query);

  //mengembalikan nilai
  echo mysqli_error($conn);
  return mysqli_affected_rows($conn);
}

//menambahkan function hapus
//bagian function hapus
function hapus($id)
{
  $conn = koneksi();
  mysqli_query($conn, "DELETE FROM mahasiswa WHERE id= $id") or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

// menmabhakna function hapus
function ubah($data)
{
  $conn = koneksi();

  $id = $data['id'];
  $nama = htmlspecialchars($data['name']);
  $npm = htmlspecialchars($data['npm']);
  $email = htmlspecialchars($data['email']);
  $jurusan = htmlspecialchars($data['jurusan']);
  $gambar = htmlspecialchars($data['gambar']);

  $query = "UPDATE mahasiswa SET
              name = '$nama',
              npm = '$npm',
              email = '$email',
              jurusan = '$jurusan',
              gambar = 'gambar'
            WHERE id = $id";
  mysqli_query($conn, $query);

  //mengembalikan nilai
  echo mysqli_error($conn);
  return mysqli_affected_rows($conn);
}
