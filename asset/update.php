<?php
session_start();
require_once '../helper/connection.php';

$no_asset = $_POST['no_asset'];
$user = $_POST['user'];
$department = $_POST['department'];
$keterangan = $_POST['keterangan'];

$query = mysqli_query($connection, "UPDATE asset SET user = '$user', department = '$department', keterangan = '$keterangan' WHERE no_asset = '$no_asset'");
if ($query) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil mengubah data'
  ];
  header('Location: ./index.php');
} else {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => mysqli_error($connection)
  ];
  header('Location: ./index.php');
}
