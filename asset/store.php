<?php
session_start();
require_once '../helper/connection.php';

$no_asset = $_POST['no_asset'];
$user = $_POST['user'];
$department = $_POST['department'];
$keterangan = $_POST['keterangan'];

$query = mysqli_query($connection, "insert into asset(no_asset, user, department, keterangan) value('$no_asset', '$user', '$department', '$keterangan')");
if ($query) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil menambah data'
  ];
  header('Location: ./index.php');
} else {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => mysqli_error($connection)
  ];
  header('Location: ./index.php');
}
