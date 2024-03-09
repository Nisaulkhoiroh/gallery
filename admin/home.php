<?php
session_start();
$UserID = $_SESSION['UserID'];
include '../config/koneksi.php';
if ($_SESSION['Status'] != 'login'){
    echo "<script>
    alert('Anda belum Login');
    location.href='../index.php';
    </script>";
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Galeri Foto</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="index.php">Website Galeri Foto</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
      <div class="navbar-nav me-auto">
        <a href="home.php" class="nav-link">Home</a>
        <a href="album.php" class="nav-link">Album</a>
        <a href="foto.php" class="nav-link">Foto</a>
      </div>

    </div>
    <a href="../config/aksi_logout.php" class="btn btn-outline-danger m-1">Keluar</a>
  </div>
</nav>
<div class="container mt-3">
      Album:
      <?php
      $album = mysqli_query($koneksi, "SELECT * FROM album WHERE UserID='$UserID'");
      while($row = mysqli_fetch_array($album)) { ?>
        <a href="home.php?AlbumID=<?php echo $row['AlbumID']?>" class="btn btn-outline-primary">
        <?php echo $row['NamaAlbum']?></a>
      <?php }
      ?>  
   
   <div class="row">
    <?php
    if (isset($_GET['AlbumID'])) {
        $AlbumID = $_GET['AlbumID'];
        $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE UserID='$UserID' and AlbumID='$AlbumID'");
        while($data = mysqli_fetch_array($query)) { ?>
        <div class="col-md-3 mt-2">
            <div class="card">
                <img src="../assets/img/<?php echo $data ['LokasiFile']?>" class="card-img-top" 
                title="<?php echo $data ['JudulFoto']?>" style="height:12rem;">
                <div class="card-footer text-center">
                     
                    <?php
                    $FotoID = $data['FotoID'];
                    $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE FotoID='$FotoID' and UserID='$UserID'");
                    if (mysqli_num_rows($ceksuka) == 1) { ?>
                        <a href="../config/proses_like.php?FotoID=<?php echo $data['FotoID']?>" type="submit"
                        name="batalsuka"><i class="fa fa-heart"></i></a>
                    <?php }else{ ?>
                        <a href="../config/proses_like.php?FotoID=<?php echo $data['FotoID']?>" type="submit"
                        name="suka"><i class="fa-regular fa-heart"></i></a>
                    <?php }
                    $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE FotoID='$FotoID'");
                    echo mysqli_num_rows($like). 'Suka';

                    ?>
                    
                    <a href=""><i class="fa-regular fa-comment"></i></a> 
                </div>
            </div>
        </div>

    <?php } }else{ 
$query = mysqli_query($koneksi, "SELECT * FROM foto WHERE UserID='$UserID'");
while ($data = mysqli_fetch_array($query)){
?>
<div class="col-md-3 mt-2">
            <div class="card">
                <img src="../assets/img/<?php echo $data ['LokasiFile']?>" class="card-img-top" 
                title="<?php echo $data ['JudulFoto']?>" style="height:12rem;">
                <div class="card-footer text-center">
                     
                    <?php
                    $FotoID = $data['FotoID'];
                    $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE FotoID='$FotoID' and UserID='$UserID'");
                    if (mysqli_num_rows($ceksuka) == 1) { ?>
                        <a href="../config/proses_like.php?FotoID=<?php echo $data['FotoID']?>" type="submit"
                        name="batalsuka"><i class="fa fa-heart"></i></a>
                    <?php }else{ ?>
                        <a href="../config/proses_like.php?FotoID=<?php echo $data['FotoID']?>" type="submit"
                        name="suka"><i class="fa-regular fa-heart"></i></a>
                    <?php }
                    $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE FotoID='$FotoID'");
                    echo mysqli_num_rows($like). 'Suka';

                    ?>
                    
                    <a href=""><i class="fa-regular fa-comment"></i></a> Komentar
                </div>
            </div>
        </div>

<?php } } ?>
    </div>
</div>
<footer class="d-flex justify-content-center border-top mt-3 bg-lilght fixed-bottom">
    <p>&copy;  UKK RPL 2024 | Nisa</p>
</footer>

<script src="../assets/js/bootstrap.min.js"></script>
</body>
</html> 