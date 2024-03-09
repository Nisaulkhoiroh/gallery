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
  <div class="row">
    <?php
  $query = mysqli_query($koneksi, "SELECT * FROM foto INNER JOIN user ON foto.UserID=user.UserID INNER JOIN album ON foto.AlbumID=album.AlbumID");
while ($data = mysqli_fetch_array($query)){
?>
<div class="col-md-3">
  <!-- Button trigger modal -->
<a type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['FotoID']?>">
 

            <div class="card mb-2">
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

                    
                    <a href="#" type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['FotoID']?>"><i class="fa-regular fa-comment"></i></a> 
                    <?php
                    $jmlkomen = mysqli_query($koneksi, "SELECT * FROM komentarfoto WHERE FotoID='$FotoID'");
                    echo mysqli_num_rows($jmlkomen).' Komentar';
                    ?>
                </div>
            </div>
            </a>
            <!-- Modal -->
          <div class="modal fade" id="komentar<?php echo $data['FotoID']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-x1">
            <div class="modal-content">
          <div class="modal-body">
           <div class="row">
            <div clss="col-md-8">
            <img src="../assets/img/<?php echo $data ['LokasiFile']?>" class="card-img-top" 
                title="<?php echo $data ['JudulFoto']?>">
            </div>
            <div class="col-md-4">
                      <div class="m-2">
                        <div class="overflow-auto">
                          <div class="sticky-top">
                           <strong><?php echo $data['JudulFoto']?></strong><br>
                           <span class="badge bg-secondary"><?php echo $data['NamaLengkap']?></span>
                           <span class="badge bg-secondary"><?php echo $data['TanggalUnggah']?></span>
                           <span class="badge bg-primary"><?php echo $data['NamaAlbum']?></span>
                          </div>
                          <hr>
                          <p align="left">
                          <?php echo $data['DeskripsiFoto']?>
                          </p>
                          <hr>
                          <?php
                            $FotoID = $data['FotoID'];
                            $komentar = mysqli_query($koneksi, "SELECT * FROM komentarfoto INNER JOIN  user ON komentarfoto.UserID=user.UserID
                            WHERE komentarfoto.FotoID='$FotoID'");
                            while($row = mysqli_fetch_array($komentar)){

                           ?>
                           <p align="left">
                            <strong><?php echo $row['NamaLengkap'] ?></strong>
                            <?php echo $row['IsiKomentar']?>
                           </p>
                           <?php } ?>
                          <hr>
                          <div class="sticky-bottom">
                            <form action="../config/proses_komentar.php" method="POST">
                              <div class="input-group">
                                <input type="hidden" name="FotoID" value="<?php echo $data['FotoID']?>">
                                <input type="text" name="IsiKomentar" class="form-control" placeholder="Tambah Komentar">
                                <div class="input-group-prepend">
                                  <button type="submit" name="KirimKomentar" class="btn btn-primary">Kirim</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
            </div>
           </div>
          </div>
    </div>
  </div>
</div>
        </div>
        <?php } ?>
  </div>
</div>

<footer class="d-flex justify-content-center border-top mt-3 bg-lilght fixed-bottom">
    <p>&copy;  UKK RPL 2024 | Nisa</p>
</footer>

<script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>