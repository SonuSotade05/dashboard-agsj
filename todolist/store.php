<?php
session_start();
require_once '../helper/connection.php';

$task = $_POST['task'];
$tag = $_POST['tag'];
$startdate = $_POST['startdate'];
$deadline = $_POST['deadline'];
$priority = $_POST['priority'];
$status = $_POST['status'];
$person = $_POST['person'];
$noted = $_POST['noted'];

$query = mysqli_query($connection, "insert into todolist (task, tag, startdate, deadline, priority, status, person, noted) value('$task', '$tag', '$startdate', '$deadline', '$priority', '$status', '$person', '$noted')");
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
