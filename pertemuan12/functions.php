<?php

use LDAP\Result;

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

// menmabhakna function tambah
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
              nama = '$nama',
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

//menambahkan function cari
function cari($keyword)
{
  $conn = koneksi();

  $query = "SELECT * FROM mahasiswa
              WHERE 
              name LIKE '%$keyword%' OR
              npm LIKE '%$keyword%'
            ";

  $result = mysqli_query($conn, $query);

  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;
}

//menambahkan functions form login
function login($data)
{
  $conn = koneksi();

  $username = htmlspecialchars($data['username']);
  $password = htmlspecialchars($data['password']);

  //cek dulu usernamenya 
  if ($user = query("SELECT * FROM user WHERE username = '$username'")) {
    //cek paswword
    if (password_verify($password, $user['password'])) {
      //set session
      $_SESSION['login'] = true;

      header("location: index.php");
      exit;
    }
    return [
      'error' => true,
      'pesan' => 'USERNAME / PASSWORD SALAH'
    ];
  }
}

//menambahkan function registrasi
function registrasi($data)
{
  $conn = koneksi();

  $username = htmlspecialchars(strtolower($data['username']));
  $password = mysqli_real_escape_string($conn, $data['password']);
  $password2 = mysqli_real_escape_string($conn, $data['password2']);

  // jika username / password kosong 
  if (empty($username) || empty($password) || empty($password2)) {
    echo "<script>
            alert('Data telah berhasil brader');
            document.location.href = 'registrasi.php';
            </script>";
    return false;
  }

  // jika username sudah ada di data base
  if (query("SELECT * FROM user WHERE username = '$username' ")) {
    echo "<script>
              alert('username / password tidak bolehkosong!');
              document.location.href = 'registrasi.php';
          </script>";
    return false;
  }

  //jika konfirmasi password tidak sesuai
  if ($password !== $password2) {
    echo "<script>
            alert('Konformasi password tidak sesuai');
            document.location.href = 'registrasi.php';
            </script>";
    return false;
  }

  // jika pasword <5 digit
  if (strlen($password) < 5) {
    echo "<script>
            alert('password terlalu pendek bro');
            document.location.href = 'registrasi.php';
            </script>";
    return false;
  }

  //jika username & password sudah sesuai
  //enskripsi password 
  $password_baru = password_hash($password, PASSWORD_DEFAULT);
  // insert ke tabel user
  $query = "INSERT INTO user
              VALUES
              (null, '$username', '$password_baru')
            ";
  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}
