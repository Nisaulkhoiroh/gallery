<?php
session_start();
include 'koneksi.php';

if (isset($_POST['tambah'])) {
    $JudulFoto=$_POST['JudulFoto'];
    $DeskripsiFoto=$_POST['DeskripsiFoto'];
    $TanggalUnggah=date('Y-m-d');
    $AlbumID=$_POST['AlbumID'];
    $UserID=$_SESSION['UserID'];
    $Foto=$_POST['LokasiFile']['name'];
    $tmp=$_FILES['LokasiFile']['tmp_name'];
    $lokasi='../assets/img/';
    $namafoto=rand().'-'.$foto;

    move_uploaded_file($tmp, $lokasi.$namafoto);

    $sql=mysqli_query($koneksi,"INSERT INTO foto VALUES('',
        '$JudulFoto','$DeskripsiFoto','$TanggalUnggah','$namafoto','$AlbumID','$UserID')");

    echo "<script>
    alert('Data berhasil disimpan!');
    location.href='../admin/foto.php';
    </script>";
}

if (isset($_POST['edit'])) {
    $FotoID=$_POST['FotoID'];
    $JudulFoto=$_POST['JudulFoto'];
    $DeskripsiFoto=$_POST['DeskripsiFoto'];
    $TanggalUnggah=date('Y-m-d');
    $AlbumID=$_POST['AlbumID'];
    $UserID=$_SESSION['UserID'];
    $Foto=$_POST['LokasiFile']['name'];
    $tmp=$_FILES['LokasiFile']['tmp_name'];
    $lokasi='../assets/img/';
    $namafoto=rand().'-'.$foto;

    if ($foto == null) {
        $sql = mysqli_query($koneksi, "UPDATE foto SET JudulFoto='$JudulFoto',DeskripsiFoto='$DeskripsiFoto',
        TanggalUnggah='$TanggalUnggah',AlbumID='$AlbumID' WHERE FotoID='$FotoID'");
    }else{
        $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE FotoID='$FotoID'");
        $data = mysqli_fetch_array($query);
        if (is_file('../assets/img/'.$data['LokasiFile'])) {
            unlink('../assets/img/'.$data['LokasiFile']);
        }
        move_uploaded_file($tmp, $lokasi.$namafoto);
        $sql = mysqli_query($koneksi, "UPDATE foto SET JudulFoto='$JudulFoto',DeskripsiFoto='$DeskripsiFoto',
        TanggalUnggah='$TanggalUnggah',LokasiFile='$namafoto',AlbumID='$AlbumID' WHERE FotoID='$FotoID'");
    }
    echo "<script>
    alert('Data berhasil diperbarui!');
    location.href='../admin/foto.php';
    </script>";
}

if (isset($_POST['hapus'])) {
    $FotoID=$_POST['FotoID'];

    $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE FotoID='$FotoID'");
        $data = mysqli_fetch_array($query);
        if (is_file('../assets/img/'.$data['LokasiFile'])) {
            unlink('../assets/img/'.$data['LokasiFile']);
        }
        $sql=mysqli_query($koneksi, "DELETE FROM foto WHERE FotoID='$FotoID'");

        echo "<script>
        alert('Data berhasil dihapus!');
        location.href='../admin/foto.php';
        </script>";
}

?>