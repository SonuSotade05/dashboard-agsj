<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<!-- Modal QR -->
<div id="qrModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
  <div style="background:#fff; padding:20px; border-radius:8px; text-align:center;">
    <h3>QR Code Asset</h3>
    <div id="qrcode"></div>
    <br>
    <button onclick="closeQRModal()">Tutup</button>
  </div>
</div>
<button onclick="showQR('<?= $row['no_asset'] ?>', '<?= $row['user'] ?>', '<?= $row['department'] ?>', '<?= $row['keterangan'] ?>')" class="btn btn-dark btn-sm">
  <i class="fas fa-barcode"></i>
</button>
