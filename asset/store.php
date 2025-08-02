<?php
session_start();
require_once '../helper/connection.php';

$no_asset = $_POST['no_asset'];
$user = $_POST['user'];
$department = $_POST['department'];
$keterangan = $_POST['keterangan'];

$query = mysqli_query($connection, "INSERT INTO asset(no_asset, user, department, keterangan) VALUES('$no_asset', '$user', '$department', '$keterangan')");

if ($query) {
  // AUDIT LOG
  $data_after = json_encode([
    'no_asset' => $no_asset,
    'user' => $user,
    'department' => $department,
    'keterangan' => $keterangan
  ]);

  $username = $_SESSION['login'];
  mysqli_query($connection, "INSERT INTO audit_log (no_asset, action, data_after, username) VALUES ('$no_asset', 'create', '$data_after', '$username')");

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
