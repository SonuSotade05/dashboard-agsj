<?php
session_start();
require_once '../helper/connection.php';
$username = isset($_SESSION['login']['username']) ? $_SESSION['login']['username'] : 'unknown';

$no_asset = $_POST['no_asset'];
$user = $_POST['user'];
$department = $_POST['department'];
$keterangan = $_POST['keterangan'];

// Ambil data sebelum update
$old = mysqli_query($connection, "SELECT * FROM asset WHERE no_asset = '$no_asset'");
$data_before = json_encode(mysqli_fetch_assoc($old));

$query = mysqli_query($connection, "UPDATE asset SET user = '$user', department = '$department', keterangan = '$keterangan' WHERE no_asset = '$no_asset'");

if ($query) {
  // AUDIT LOG
  $data_after = json_encode([
    'no_asset' => $no_asset,
    'user' => $user,
    'department' => $department,
    'keterangan' => $keterangan
  ]);

  // $username = $_SESSION['login'];
  mysqli_query($connection, "INSERT INTO audit_log (no_asset, action, data_before, data_after, username) VALUES ('$no_asset', 'update', '$data_before', '$data_after', '$username')");

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
