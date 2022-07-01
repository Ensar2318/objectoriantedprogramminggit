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

    <!-- sliders İnsert İşlemi -->
    <?php if (isset($_GET['slidersInsert'])) { ?>
      <div class="card">
        <a style="margin-right: auto;" class="btn btn-danger btn-sm " href="sliders.php">kapat</a>
        <div class="card-header">
          <h3 class=""><b>slider Ekle</b></h3>
        </div>

        <div class="card-body">
          <?php
          if (isset($_POST['sliders_insert'])) {
            $status = $db->insert(
              "sliders",
              $_POST,
              [
                'insert_key' => 'sliders_insert',
                'dir_key' => 'sliders',
                'file_name' => 'sliders_file'

              ]
            );

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
              <input type="file" class="form-control" name="sliders_file" required>
            </div>
            <div class="col-md-12 mt-3">
              <label class="form-label">Ad Soyad</label>
              <input type="text" class="form-control" name="sliders_namesurname" required>
            </div>
            <div class="col-12 mt-3">
              <label class="form-label">Kullanıcı Adı</label>
              <input type="text" class="form-control" name="sliders_username" required>
            </div>
            <div class="col-12 mt-3">
              <label class="form-label">Password</label>
              <input type="text" class="form-control" name="sliders_pass" required>
            </div>
            <div class="col-12 mt-3">
              <label class="form-label">Kullanıcı durum</label>
              <select class="form-control" name="sliders_status">
                <option value="1" selected>Aktif</option>
                <option value="0">Pasif</option>
              </select>
            </div>

            <div class="col-12 mt-3">
              <button type="submit" class="btn btn-success" name="sliders_insert">Kaydet</button>
            </div>
          </form>
        </div>

      </div>
    <?php }
    ?>

    <!-- sliders Update İşlemi -->
    <?php if (isset($_GET['slidersUpdate'])) { ?>
      <div class="card">
        <a style="margin-right: auto;" class="btn btn-danger btn-sm " href="sliders.php">kapat</a>
        <div class="card-header">
          <h3 class=""><b>slider Düzenle</b></h3>
        </div>

        <div class="card-body">
          <?php
          if (isset($_POST['sliders_update'])) {
            $status = $db->update(
              "sliders",
              $_POST,
              [
                'insert_key' => 'sliders_update',
                'columns' => 'sliders_id',
                'dir_key' => 'sliders',
                'file_name' => 'sliders_file',
                'requiredpass_key' => 'sliders_pass',
                'file_delete' => 'old_image'
              ]
            );

            if ($status['status']) {
              echo "<div class='alert alert-success'>Kayıt Başarılı.</div>";
            } else {
              echo "<div class='alert alert-danger'>{$status['error']}</div>";
            }
          }
          $sql_selected = $db->wRead("sliders", "sliders_id", $_GET['sliders_id']);
          $row_selected = $sql_selected->fetch(PDO::FETCH_ASSOC);
          ?>

          <form class="row g-3" enctype="multipart/form-data" method="POST">

            <div class="col-md-12 border p-2">
              <label class="form-label">Yüklü Resim</label>
              <?php if (!empty($row_selected['sliders_file'])) { ?>
                <img width="100" src="dimg/sliders/<?php echo $row_selected['sliders_file'] ?>">
              <?php } else {
                echo "<h2>Resim yok</h2>";
              } ?>
            </div>
            <div class="col-md-12">
              <label class="form-label">Resim Seç</label>
              <input type="file" class="form-control" name="sliders_file">
              <input type="hidden" value="<?php echo $row_selected['sliders_file'] ?>" name="old_image">
            </div>
            <div class="col-md-12 mt-3">
              <label class="form-label">Ad Soyad</label>
              <input type="text" class="form-control" name="sliders_namesurname" required value="<?php echo $row_selected['sliders_namesurname'] ?>">
            </div>
            <div class="col-12 mt-3">
              <label class="form-label">Kullanıcı Adı</label>
              <input type="text" class="form-control" name="sliders_username" required value="<?php echo $row_selected['sliders_username'] ?>">
            </div>

            <div class="col-md-12 mt-3">
              <label class="form-label">Password</label>
              <input type="text" class="form-control" name="sliders_pass">
            </div>

            <div class="col-12 mt-3">
              <label class="form-label">Kullanıcı durum</label>
              <select class="form-control" name="sliders_status">
                <option value="1" <?php echo $row_selected['sliders_status'] == 1 ? 'selected' : '' ?>>Aktif</option>
                <option value="0" <?php echo $row_selected['sliders_status'] == 0 ? 'selected' : '' ?>>Pasif</option>
              </select>
            </div>
            <input type="text" hidden value="<?php echo $row_selected['sliders_id'] ?>" class="form-control" name="sliders_id">
            <div class="col-12 mt-3">
              <button type="submit" class="btn btn-success" name="sliders_update">Düzenle</button>
            </div>
          </form>
        </div>

      </div>
    <?php } ?>


    <div class="card">
      <!-- sliders Delete İşlemi -->
      <?php if (isset($_GET['slidersDelete'])) { ?>
        <?php $status = $db->delete("sliders", "sliders_id", $_GET['sliders_id'], $_GET['file_delete']); ?>
        <?php if ($status['status']) { ?>
          <script>
            Swal.fire({
              icon: 'success',
              text: 'Silme Başarılı'
            }).then(() => {
              location.href = "users.php";
            });
          </script>
        <?php } else { ?>
          <script>
            Swal.fire({
              icon: 'error',
              text: 'Silme Başarısız!'
            }).then(() => {
              location.href = "users.php";
            });
          </script>
        <?php } ?>
      <?php } ?>

      <div class="card-header">
        <h3 class="card-title">sliderler</h3>
      </div>
      <div class="card-body">
        <a class="btn btn-success" href="?slidersInsert=true">Yeni Ekle</a>
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th align="center" width="10">#</th>
              <th>Kullanıcı Adı</th>
              <th>Ad Soyad</th>
              <th>Durum</th>
              <th>Düzenle</th>
              <th>Sil</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = $db->read("sliders");
            $row = $sql->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php foreach ($row as $key => $val) { ?>
              <tr>
                <td><?php echo ($key + 1) ?></td>
                <td><?php echo $val['sliders_username'] ?></td>
                <td><?php echo $val['sliders_namesurname'] ?></td>
                <td><?php echo $val['sliders_status'] ? 'Aktif' : 'Pasif' ?></td>
                <td align="center" width="10"><a href="?slidersUpdate&sliders_id=<?php echo $val['sliders_id'] ?>"><i class="fas fa-edit"></i></a></td>
                <td align="center" width="10"><a sliders_id='<?php echo $val['sliders_id'] ?>' file='<?php echo $val['sliders_file'] ?>' href="" class="text-danger delete-data"><i class="fas fa-trash"></i></a></td>
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
<!-- slidersLTE App -->
<script src="dist/js/sliderslte.min.js"></script>
<!-- slidersLTE for demo purposes -->
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
        const id = $(this).attr("sliders_id");
        const file = $(this).attr("file");
        location.href = "?slidersDelete&sliders_id=" + id + "&file_delete=" + file;
      }
    })
  });
</script>