<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$result = mysqli_query($connection, "SELECT al.*, a.keterangan AS asset_name FROM audit_log al LEFT JOIN asset a ON al.no_asset = a.no_asset ORDER BY al.created_at DESC");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Audit Log</h1>
    <div class="d-grid gap-2">
      <a href="exportcsv.php" class="btn btn-success">Export CSV</a>
      <a href="../asset/index.php" class="btn btn-secondary">Kembali</a>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="audit-table">
              <thead>
                <tr>
                  <th>No Asset</th>
                  <th>Aksi</th>
                  <th>Username</th>
                  <th>Waktu</th>
                  <th>Detail</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($log = mysqli_fetch_assoc($result)) : ?>
                  <tr>
                    <td><?= htmlspecialchars($log['no_asset']) ?></td>
                    <td><span class="badge bg-<?= $log['action'] == 'create' ? 'success' : ($log['action'] == 'update' ? 'warning text-dark' : 'danger') ?>">
                        <?= strtoupper($log['action']) ?></span></td>
                    <td><?= htmlspecialchars($log['username']) ?></td>
                    <td><?= date('j F Y H:i', strtotime($log['created_at'])) ?></td>
                    <td>
                      <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#logModal<?= $log['id'] ?>">
                        Lihat
                      </button>

                      <!-- Modal -->
                      <div class="modal fade" id="logModal<?= $log['id'] ?>" tabindex="-1" aria-labelledby="logModalLabel<?= $log['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="logModalLabel<?= $log['id'] ?>">Detail Log - <?= $log['action'] ?> (<?= $log['no_asset'] ?>)</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-6">
                                  <h6>Data Sebelum:</h6>
                                  <pre><?= $log['data_before'] ? json_encode(json_decode($log['data_before']), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '-' ?></pre>
                                </div>
                                <div class="col-md-6">
                                  <h6>Data Sesudah:</h6>
                                  <pre><?= $log['data_after'] ? json_encode(json_decode($log['data_after']), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '-' ?></pre>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- End Modal -->

                    </td>
                  </tr>
                <?php endwhile ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</section>

<?php require_once '../layout/_bottom.php'; ?>

<!-- Page Specific JS File -->
<script src="../assets/js/page/modules-datatables.js"></script>
<script>
  // Init DataTable
  $(document).ready(function() {
    $('#audit-table').DataTable({
      order: [
        [3, 'desc']
      ]
    });
  });
</script>