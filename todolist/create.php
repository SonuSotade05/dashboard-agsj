<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$prodi = mysqli_query($connection, "SELECT * FROM todolist"); //before-prodi
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah List Task</h1>
    <a href="./index.php" class="btn btn-light">Kembali</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- // Form -->
          <form action="./store.php" method="POST">
            <table cellpadding="8" class="w-100">
              <tr>
                <td>Task</td>
                <td><input class="form-control" type="text" name="task"></td>
              </tr>
              <tr>
                <td>Tag</td>
                <td>
                  <select class="form-control" name="tag" id="tag" required>
                    <option value="">Select Tag</option>
                    <option value="low">Guest</option>
                    <option value="medium">User</option>
                    <option value="high">Troubleshoot</option>
                    <option value="high">Maintenance</option>
                    <option value="high">Project</option>
                    <option value="high">Training</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Start Date</td>
                <td><input class="form-control" type="date" id="datepicker" name="startdate"></td>
              </tr>
              <tr>
                <td>Deadline</td>
                <td><input class="form-control" type="date" id="datepicker" name="dateline"></td>
              </tr>
              <tr>
                <td>Priority</td>
                <td>
                  <select class="form-control" name="priority" id="priority" required>
                    <option value="">Select Priority</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Status</td>
                <td>
                  <select class="form-control" name="status" id="status" required>
                    <option value="">Select Status</option>
                    <option value="todo">To Do</option>
                    <option value="onprogress">On Progress</option>
                    <option value="done">Done</option>
                    <option value="cancel">Cancel</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Person</td>
                <td><input class="form-control" type="text" name="person" size="20"></td>
              </tr>
              <tr>
                <td>Noted</td>
                <td><textarea name="noted" class="form-control"></textarea></td>
              </tr>
              <tr>
                <td>
                  <input class="btn btn-primary" type="submit" name="proses" value="Simpan">
                  <input class="btn btn-danger" type="reset" name="batal" value="Bersihkan">
                </td>
              </tr>
            </table>
          </form>
        </div>
      </div>
    </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>