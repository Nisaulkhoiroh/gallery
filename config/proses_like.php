<?php
session_start();
include 'koneksi.php';
$FotoID = $_GET['FotoID'];
$UserID =$_SESSION['UserID'];

$ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE FotoID='$FotoID' and UserID='$UserID'");

if(mysqli_num_rows($ceksuka) ==1) {
    while($row = mysqli_fetch_array($ceksuka)){
        $LikeID = $row['LikeID'];
        $query = mysqli_query($koneksi, "DELETE FROM likefoto WHERE LikeID='$LikeID'");
 echo "<script>
location.href='../admin/index.php';
</script>";
    }
}else{
    $TanggalLike= date('Y-m-d');
    $query = mysqli_query($koneksi, "INSERT INTO likefoto VALUES('','$FotoID','$UserID','$TanggalLike')");
echo "<script>
location.href='../admin/index.php';
</script>";
}
?>
