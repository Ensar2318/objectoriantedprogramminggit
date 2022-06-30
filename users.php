<?php
require_once("header.php");
require_once("sidebar.php");
$sql = $db->read("users");
$row = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
    </div>
  </div>



  <section class="content">
    <?php if (isset($_GET['delete'])) { ?>
      <?php if ($_GET['delete']) { ?>

      <?php } ?>
    <?php } ?>

    <?php if (isset($_GET['usersInsert'])) { ?>
      <div class="card">
        <a style="margin-right: auto;" class="btn btn-danger btn-sm " href="users.php">kapat</a>
        <div class="card-header">
          <h3 class=""><b>Kullanıcı Ekle</b></h3>
        </div>

        <div class="card-body">
          <?php
          if (isset($_POST['users_insert'])) {
            $status = $db->insert("users", $_POST, ['insert_key' => 'users_insert', 'dir_key' => 'users', 'file_name' => 'users_file']);
            if ($status['status']) {
              echo "<div class='alert alert-success'>Kayıt Başarılı.</div>";
            } else {
              echo "<div class='alert alert-danger'>{$status['error']}</div>";
            }
          }
          ?>
          <form class="row g-3" enctype="multipart/form-data" method="POST">
            <div class="col-md-12">
              <label class="form-label">Resim Seç</label>
              <input type="file" class="form-control" name="users_file" required>
            </div>
            <div class="col-md-12 mt-3">
              <label class="form-label">Ad Soyad</label>
              <input type="text" class="form-control" name="users_namesurname" required>
            </div>
            <div class="col-12 mt-3">
              <label class="form-label">Mail</label>
              <input type="text" class="form-control" name="users_mail" required>
            </div>
            <div class="col-12 mt-3">
              <label class="form-label">Password</label>
              <input type="text" class="form-control" name="users_pass" required>
            </div>
            <div class="col-12 mt-3">
              <label class="form-label">Kullanıcı durum</label>
              <select class="form-control" name="users_status">
                <option value="1" selected>Aktif</option>
                <option value="0">Pasif</option>
              </select>
            </div>

            <div class="col-12 mt-3">
              <button type="submit" class="btn btn-success" name="users_insert">Kaydet</button>
            </div>
          </form>
        </div>

      </div>
    <?php } ?>

    <?php if (isset($_GET['usersUpdate'])) { ?>
      <div class="card">
        <a style="margin-right: auto;" class="btn btn-danger btn-sm " href="users.php">kapat</a>
        <div class="card-header">
          <h3 class=""><b>Kullanıcı Düzenle</b></h3>
        </div>

        <div class="card-body">
          <?php
          if (isset($_POST['users_update'])) {
            $status = $db->update(
              "users",
              $_POST,
              [
                'insert_key' => 'users_update',
                'columns' => 'users_id',
                'dir_key' => 'users',
                'file_name' => 'users_file',
                'requiredpass_key' => 'users_pass',
                'file_delete' => 'old_image'
              ]
            );
            if ($status['status']) {
              echo "<div class='alert alert-success'>Kayıt Başarılı.</div>";
            } else {
              echo "<div class='alert alert-danger'>{$status['error']}</div>";
            }
          }
          $sql_selected = $db->wRead("users", "users_id", $_GET['users_id']);
          $row_selected = $sql_selected->fetch(PDO::FETCH_ASSOC);
          ?>
          <form class="row g-3" enctype="multipart/form-data" method="POST">
            <div class="col-md-12 border p-2">
              <label class="form-label">Yüklü Resim</label>
              <?php if (!empty($row_selected['users_file'])) { ?>
                <img width="100" src="dimg/users/<?php echo $row_selected['users_file'] ?>">
              <?php } else {
                echo "<h2>Resim yok</h2>";
              } ?>
            </div>
            <div class="col-md-12">
              <label class="form-label">Resim Seç</label>
              <input type="file" class="form-control" name="users_file" >
            </div>
            <div class="col-md-12 mt-3">
              <label class="form-label">Ad Soyad</label>
              <input type="text" class="form-control" name="users_namesurname" required value="<?php echo $row_selected['users_namesurname'] ?>">
            </div>
            <div class="col-12 mt-3">
              <label class="form-label">Mail</label>
              <input type="text" class="form-control" name="users_mail" required value="<?php echo $row_selected['users_mail'] ?>">
            </div>
            <div class="col-12 mt-3">
              <label class="form-label">Password</label>
              <input type="text" class="form-control" name="users_pass">
            </div>
            <div class="col-12 mt-3">
              <label class="form-label">Kullanıcı durum</label>
              <select class="form-control" name="users_status">
                <option <?php echo $row_selected['users_status']==1?'selected':'' ?> value="1" selected>Aktif</option>
                <option <?php echo $row_selected['users_status']==0?'selected':'' ?> value="0">Pasif</option>
              </select>
            </div>
            <input type="hidden" name="old_image" value="<?php echo $row_selected['users_file'] ?>">
            <input type="hidden" name="users_id" value="<?php echo $row_selected['users_id'] ?>">
            <div class="col-12 mt-3">
              <button type="submit" class="btn btn-success" name="users_update">Güncelle</button>
            </div>
          </form>
        </div>

      </div>
    <?php } ?>

    <div class="card">

      <div class="card-header">
        <h3 class="card-title">Kullanıcılar</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <a class="btn btn-success" href="?usersInsert=true">Yeni Ekle</a>
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th align="center" width="10">#</th>
              <th>Ad Soyad</th>
              <th>Mail</th>
              <th>Durum</th>
              <th>Düzenle</th>
              <th>Sil</th>
            </tr>
          </thead>
          <tbody>

            <?php foreach ($row as $key => $val) { ?>
              <tr>
                <td><?php echo ($key + 1) ?></td>
                <td><?php echo $val['users_namesurname'] ?></td>
                <td><?php echo $val['users_mail'] ?></td>
                <td><?php echo $val['users_status'] ? 'Aktif' : 'Pasif' ?></td>
                <td align="center" width="10"><a href="users.php?usersUpdate&users_id=<?php echo $val['users_id'] ?>"><i class="fas fa-edit"></i></a></td>
                <td align="center" width="10"><a class="text-danger delete-data" href="javascript:void(0)"><i class="fas fa-trash"></i></a></td>
              </tr>
            <?php } ?>




          </tbody>
        </table>
      </div>
    </div>

  </section>

</div>




<?php
require_once("footer.php");
?>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function() {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

  });
</script>

<script>
  $(".delete-data").click(function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Silmek istiyormusunuz?',
      showDenyButton: true,
      showCancelButton: true,
      showConfirmButton: false,
      denyButtonText: `Sil`,
      cancelButtonText: `Kapat`
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isDenied) {
        location.href = "?delete=true";
      }
    })
  });
</script>