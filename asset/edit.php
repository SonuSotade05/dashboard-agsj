<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$no_asset = $_GET['no_asset'];
$query = mysqli_query($connection, "SELECT * FROM asset WHERE no_asset='$no_asset'");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Ubah Data Asset</h1>
    <a href="./index.php" class="btn btn-light">Kembali</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- // Form -->
          <form action="./update.php" method="post">
            <?php
            while ($row = mysqli_fetch_array($query)) {
            ?>
              <input type="hidden" name="no_asset" value="<?= $row['no_asset'] ?>">
              <table cellpadding="8" class="w-100">
                <tr>
                  <td>No Asset</td>
                  <td><input class="form-control" type="number" name="no_asset" size="20" required value="<?= $row['no_asset'] ?>" disabled></td>
                </tr>
                <tr>
                  <td>User</td>
                  <td><input class="form-control" type="text" name="user" size="20" required value="<?= $row['user'] ?>"></td>
                </tr>
                <tr>
                  <td>Department</td> 
                  <td>
                    <select class="form-control" name="department" id="department" required>
                      <option value="IT" <?php if ($row['department'] == "IT") {
                                              echo "selected";
                                            } ?>>IT</option>
                      <option value="FO" <?php if ($row['department'] == "FO") {
                                                echo "selected";
                                              } ?>>Front Office</option>
                      <option value="FA" <?php if ($row['department'] == "FA") {
                                                echo "selected";
                                              } ?>>Finance And Accounting</option>
                      <option value="SM" <?php if ($row['department'] == "SM") {
                                                echo "selected";
                                              } ?>>Sales Marketing</option> 
                      <option value="LP" <?php if ($row['department'] == "LP") {
                                                echo "selected";
                                              } ?>>Loss Prevention</option> 
                      <option value="HK" <?php if ($row['department'] == "HK") {
                                                echo "selected";
                                              } ?>>Housekeeping</option>
                      <option value="ENG" <?php if ($row['department'] == "ENG") {
                                                echo "selected";
                                              } ?>>Engineering</option>
                      <option value="FBS" <?php if ($row['department'] == "FBS") {
                                                echo "selected";
                                              } ?>>FB Service</option>
                      <option value="FBP" <?php if ($row['department'] == "FBP") {
                                                echo "selected";
                                              } ?>>FB Product</option>
                      <option value="A&G" <?php if ($row['department'] == "A&G") {
                                                echo "selected";
                                              } ?>>Admin & General</option>
                      <option value="AF" <?php if ($row['department'] == "AF") {
                                                echo "selected";
                                              } ?>>Atlete Floor</option>                                              
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>Keterangan</td>
                  <td colspan="3"><textarea class="form-control" name="keterangan" id="keterangan" required><?= $row['keterangan'] ?></textarea></td>
                </tr>
                <tr>
                  <td>
                    <input class="btn btn-primary d-inline" type="submit" name="proses" value="Ubah">
                    <a href="./index.php" class="btn btn-danger ml-1">Batal</a>
                  <td>
                </tr>
              </table>

            <?php } ?>
          </form>
        </div>
      </div>
    </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>