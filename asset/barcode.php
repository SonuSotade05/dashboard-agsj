<?php
require_once '../helper/connection.php';
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$no_asset = isset($_GET['no_asset']) ? $_GET['no_asset'] : '';

if ($no_asset) {
  $stmt = $connection->prepare("SELECT * FROM asset WHERE no_asset = ?");
  $stmt->bind_param("s", $no_asset);
  $stmt->execute();
  $result = $stmt->get_result();
  $asset = $result->fetch_assoc();
} else {
  $asset = null;
}
?>

<?php require('../layout/_public_header.php') ?>

<section class="section">
  <div class="container">
    <h2 class="pb-3">Detail Asset</h2>

    <?php if ($asset): ?>
      <div class="container my-4">
        <div class="row g-4 align-items-start">
          <!-- QR Code Section -->
          <div class="col-md-auto text-center">
            <div id="qrcode"></div>
          </div>

          <!-- Asset Detail Table -->
          <div class="col-md">
            <div class="table-responsive">
              <table class="table table-white table-bordered border-light-subtle">
                <tbody>
                  <tr>
                    <th>No Asset</th>
                    <td><?= htmlspecialchars($asset['no_asset']) ?></td>
                  </tr>
                  <tr>
                    <th>User</th>
                    <td><?= htmlspecialchars($asset['user']) ?></td>
                  </tr>
                  <tr>
                    <th>Department</th>
                    <td><?= htmlspecialchars($asset['department']) ?></td>
                  </tr>
                  <tr>
                    <th>Keterangan</th>
                    <td><?= htmlspecialchars($asset['keterangan']) ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    <?php else: ?>
      <div class="alert alert-warning">
        Data asset tidak ditemukan atau parameter `no_asset` tidak dikirim.
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- Include QRCode.js -->
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
  <?php if ($asset): ?>
    // Generate QR Code isi dengan no_asset atau URL
    new QRCode(document.getElementById("qrcode"), {
      text: "<?= $_ENV['APPURL'] . '/asset/barcode.php?no_asset=' . urlencode($asset['no_asset']) ?>",
      width: 200,
      height: 200
    });
  <?php endif; ?>
</script>

<?php require('../layout/_bottom.php') ?>