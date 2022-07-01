<?php
require_once("header.php");
require_once("sidebar.php");



?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
    </div>
  </div>



  <section class="content">
    <!-- settings Update İşlemi -->
    <?php if (isset($_GET['settingsUpdate'])) { ?>
      <div class="card">
        <a style="margin-right: auto;" class="btn btn-danger btn-sm " href="settings.php">kapat</a>
        <div class="card-header">
          <h3 class=""><b>Ayar Düzenle</b></h3>
        </div>

        <div class="card-body">
          <?php
          if (isset($_POST['settings_update'])) {
            $status = $db->update(
              "settings",
              $_POST,
              [
                'insert_key' => 'settings_update',
                'columns' => 'settings_id',
                'dir_key' => 'settings',
                'file_name' => 'settings_value',
                'file_delete' => 'old_image'
              ]
            );


            if ($status['status']) {
              echo "<div class='alert alert-success'>Kayıt Başarılı.</div>";
            } else {
              echo "<div class='alert alert-danger'>{$status['error']}</div>";
            }
          }
          $sql_selected = $db->wRead("settings", "settings_id", $_GET['settings_id']);
          $row_selected = $sql_selected->fetch(PDO::FETCH_ASSOC);
          ?>

          <form class="row g-3" enctype="multipart/form-data" method="POST">

            <div class="col-md-12 mt-3">
              <label class="form-label">Açıklama</label>
              <input type="text" disabled class="form-control" value="<?php echo $row_selected['settings_description'] ?>">
            </div>

            <?php if ($row_selected['settings_type'] == "file") { ?>
              <div class="col-md-12">
                <label class="form-label">Resim Seç</label>
                <input type="file" class="form-control" name="settings_value">
                <input type="hidden" value="<?php echo $row_selected['settings_value'] ?>" name="old_image">
              </div>
            <?php } ?>

            <div class="col-md-12 mt-3">
              <label class="form-label">İçerik</label>
              <?php if ($row_selected['settings_type'] == "text") { ?>
                <input type="text" class="form-control" name="settings_value" required value="<?php echo $row_selected['settings_value'] ?>">
              <?php } ?>

              <?php if ($row_selected['settings_type'] == "textarea") { ?>
                <textarea class="form-control" name="settings_value"><?php echo $row_selected['settings_value'] ?></textarea>
              <?php } ?>

              <?php if ($row_selected['settings_type'] == "file") { ?>
                <div class="col-md-12 border p-2">
                  <?php if (!empty($row_selected['settings_value'])) { ?>
                    <a href="dimg/settings/<?php echo $row_selected['settings_value'] ?>" target="_blank"><img width="100" src="dimg/settings/<?php echo $row_selected['settings_value'] ?>"></a>
                  <?php } else {
                    echo "<h3>Resim yok</h3>";
                  } ?>
                </div>
              <?php } ?>
            </div>

            <input type="hidden" name="settings_id" value="<?php echo $row_selected['settings_id'] ?>">

            <div class="col-12 mt-3">
              <button type="submit" class="btn btn-success" name="settings_update">Düzenle</button>
            </div>
          </form>
        </div>

      </div>
    <?php } ?>


    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Ayarlar</h3>
      </div>
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Ad</th>
              <th>İçerik</th>
              <th>Key</th>
              <th>Düzenle</th>

            </tr>
          </thead>
          <tbody>
            <?php
            $sql = $db->read("settings");
            $row = $sql->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php foreach ($row as $key => $val) { ?>
              <tr>
                <td><?php echo $val['settings_description'] ?></td>
                <td><?php echo $val['settings_value'] ?></td>
                <td><?php echo $val['settings_key'] ?></td>
                <td align="center" width="10"><a href="?settingsUpdate&settings_id=<?php echo $val['settings_id'] ?>"><i class="fas fa-edit"></i></a></td>
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
<!-- settingsLTE App -->
<script src="dist/js/settingslte.min.js"></script>
<!-- settingsLTE for demo purposes -->
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