<?php
require_once '../helper/connection.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=audit_log.csv');

$output = fopen('php://output', 'w');

// Header kolom
fputcsv($output, ['No Asset', 'Nama Aset', 'Aksi', 'Username', 'Waktu', 'Data Sebelum', 'Data Sesudah']);

// Ambil data
$query = mysqli_query($connection, "
  SELECT al.*, a.keterangan AS asset_name
  FROM audit_log al
  LEFT JOIN asset a ON al.no_asset = a.no_asset
  ORDER BY al.created_at DESC
");

while ($row = mysqli_fetch_assoc($query)) {
  fputcsv($output, [
    $row['no_asset'],
    $row['asset_name'],
    strtoupper($row['action']),
    $row['username'],
    date('j F Y H:i', strtotime($row['created_at'])),
    $row['data_before'],
    $row['data_after']
  ]);
}
fclose($output);
exit;
