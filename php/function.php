<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
$conn = mysqli_connect("localhost","root","","pendaftaran_mahasiswa");

function create($data) {
    global $conn;

    $nama          = $data['nama'];
    $tanggal_lahir = $data['tanggal_lahir'];
    $alamat        = $data['alamat'];
    $jenis_kelamin = $data['jenis_kelamin'];
    $jurusan       = $data['jurusan'];
    $foto = upload();
    if (!$foto) {
        return false;
    }
    
    $sql = "INSERT INTO mahasiswa (nama, tanggal_lahir, alamat, jenis_kelamin, jurusan, foto)
    VALUES ('$nama', '$tanggal_lahir', '$alamat', '$jenis_kelamin', '$jurusan', '$foto')";

    mysqli_query($conn,$sql);
    return mysqli_affected_rows($conn);
    
}

  function upload(){
    $namafile = $_FILES['foto']['name'];
    $ukuranfile =$_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpname = $_FILES['foto']['tmp_name'];

    if ($error === 4) {
      echo "<script>
            alert('harap upload foto!!');
        </script>";
        return false;
    }

    $ekstensi =['jpg','jpeg','png'];
    $ekstensigambar = explode('.', $namafile);
    $ekstensigambar = strtolower(end($ekstensigambar));

    if (!in_array($ekstensigambar,$ekstensi)) {
      echo "<script>
        alert('Silahkan upload foto (jpg, jpeg, png)');
      </script>";
      return false;
    }

    //cek ukuran gambar
    if ($ukuranfile > 3000000) {
      echo "<script>
      alert('Ukuran terlalu besar!');
      </script>";
      return false;
    }

    //generate nama file baru
    $namafilebaru = uniqid();
    $namafilebaru .= '.';
    $namafilebaru.= $ekstensigambar;
    // lolos pengecekan
    move_uploaded_file($tmpname,'uploads/' . $namafilebaru);

    return $namafilebaru;

  }
?>