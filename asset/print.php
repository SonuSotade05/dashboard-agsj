<?php
require_once '../helper/connection.php';
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$assets = mysqli_query($connection, "SELECT * FROM asset ORDER BY no_asset ASC");
$assetData = [];
while ($row = mysqli_fetch_assoc($assets)) {
  $assetData[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Print Asset Labels</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
    }

    @media print {
      body {
        margin: 0;
        padding: 0;
      }

      .no-print {
        display: none !important;
      }

      .page {
        page-break-after: always;
        page-break-inside: avoid;
      }

      .page:last-child {
        page-break-after: avoid;
      }

      .label-box {
        page-break-inside: avoid;
      }

      @page {
        margin: 0.3in;
        size: A4 portrait;
      }
    }

    .page {
      width: 100%;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      /* 4 columns for 40 items per page */
      gap: 4px;
      margin-bottom: 15px;
      padding: 8px;
    }

    .label-box {
      border: 1px solid #000;
      display: flex;
      flex-direction: row;
      align-items: stretch;
      height: 85px;
      /* Slightly increased height for better readability */
      width: 100%;
      background: white;
    }

    .qr-section {
      border-right: 1px solid #000;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      flex: 0 0 42%;
      /* Slightly increased width for better balance */
      padding: 3px;
      background: #f8f9fa;
    }

    .qr-container {
      width: 60;
      /* Slightly larger QR for better scanning */
      height: 60;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 3px;
      background: white;
      border: 1px solid #ddd;
    }

    .qr-container canvas {
      max-width: 60 !important;
      max-height: 60 !important;
    }

    .info-section {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 4px;
    }

    .logo-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 22px;
      /* Slightly increased logo area */
      margin-bottom: 3px;
    }

    .logo {
      max-height: 20px;
      max-width: 100%;
      object-fit: contain;
    }

    .logo-text {
      font-weight: bold;
      font-size: 11px;
      color: #333;
      text-align: center;
    }

    .label-text {
      font-size: 7px;
      /* Slightly larger text for better readability */
      text-align: center;
      line-height: 1.2;
      color: #333;
      margin-top: auto;
    }

    .asset-code {
      font-weight: bold;
      font-size: 8px;
      text-align: center;
      background-color: #000;
      color: white;
      padding: 2px;
      margin-top: 2px;
    }
  </style>
</head>

<body class="bg-white">

  <div class="container my-4 no-print">
    <div class="d-flex justify-content-between align-items-center">
      <h4 class="mb-3">Print Asset Labels</h4>
      <button class="btn btn-primary" onclick="window.print()">Print</button>
    </div>
  </div>

  <?php
  $chunked = array_chunk($assetData, 40); // 40 labels per page (10 rows × 4 columns)
  foreach ($chunked as $pageIndex => $pageAssets):
  ?>
    <div class="page">
      <?php foreach ($pageAssets as $assetIndex => $asset):
        $no_asset = $asset['no_asset'];
        $department = $asset['department'];
        $qrId = 'qr_' . $pageIndex . '_' . $assetIndex;
        $qrUrl = $_ENV['APPURL'] . "/asset/barcode.php?no_asset=" . urlencode($no_asset);
      ?>
        <div class="label-box">
          <div class="qr-section">
            <div class="qr-container" id="<?= $qrId ?>"></div>
            <div class="asset-code">AGSJ/<?= htmlspecialchars($no_asset) ?></div>
          </div>
          <div class="info-section">
            <div class="logo-container">
              <?php if (file_exists('../logo-agsj.png')): ?>
                <img src="../logo-agsj.png" alt="AGSJ" class="logo">
              <?php else: ?>
                <div class="logo-text">AGSJ</div>
              <?php endif; ?>
            </div>
            <div class="label-text">
              Property of AGSJ<br>
              Do Not Remove
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Wait a bit for the DOM to be fully ready
      setTimeout(function() {
        <?php
        foreach ($chunked as $pageIndex => $pageAssets) {
          foreach ($pageAssets as $assetIndex => $asset) {
            $no_asset = $asset['no_asset'];
            $qrId = 'qr_' . $pageIndex . '_' . $assetIndex;
            $qrUrl = $_ENV['APPURL'] . "/asset/barcode.php?no_asset=" . urlencode($no_asset);
            echo "
            try {
              var qrElement = document.getElementById('$qrId');
              if (qrElement && typeof QRCode !== 'undefined') {
                new QRCode(qrElement, {
                  text: '$qrUrl',
                  width: 60,
                  height: 60,
                  colorDark: '#000000',
                  colorLight: '#ffffff',
                  correctLevel: QRCode.CorrectLevel.L
                });
              } else {
                console.warn('QR element or QRCode library not found for $qrId');
              }
            } catch(e) {
              console.error('Error generating QR code for $qrId:', e);
            }
            ";
          }
        }
        ?>
      }, 500); // Wait 500ms for everything to load
    });

    // Alternative QR generation if the first attempt fails
    window.addEventListener('load', function() {
      setTimeout(function() {
        var qrElements = document.querySelectorAll('.qr-container');
        qrElements.forEach(function(element) {
          if (element.children.length === 0) {
            // If QR code didn't generate, show a placeholder
            element.innerHTML = '<div style="width:38px;height:38px;border:1px solid #ccc;display:flex;align-items:center;justify-content:center;font-size:7px;">QR</div>';
          }
        });
      }, 1000);
    });
  </script>
</body>

</html>