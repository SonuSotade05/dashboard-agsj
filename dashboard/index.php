<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$asset = mysqli_query($connection, "SELECT COUNT(*) FROM asset"); //before-mahasiswa
$todolist = mysqli_query($connection, "SELECT COUNT(*) FROM todolist"); //before-dosen

$total_asset = mysqli_fetch_array($asset)[0];
$total_todolist = mysqli_fetch_array($todolist)[0];
?>

<section class="section">
  <div class="section-header">
    <h1>Dashboard</h1>
  </div>
  <div class="column">
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="far fa-file"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Inventory Asset</h4>
            </div>
            <div class="card-body">
              <?= $total_asset ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-danger">
            <i class="far fa-file"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total To Do List</h4>
            </div>
            <div class="card-body">
              <?= $total_todolist ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>