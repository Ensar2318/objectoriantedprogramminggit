<?php
require_once 'netting/class.crud.php';
$db = new crud();
if (isset($_SESSION['admins'])) {
    header('location:index.php');
}
if (isset($_POST['admins_login'])) {
    $sonuc = $db->adminsLogin(htmlspecialchars($_POST['admins_username']), htmlspecialchars($_POST['admins_pass']), isset($_POST['rememberMe']));

    if ($sonuc['status']) {
        header('location:index.php');
        exit;
    }
}

$username = "";
$pass = "";


if (isset($_COOKIE['adminsLogin'])) {
    $login = json_decode($_COOKIE['adminsLogin']);
    $username = $login->admins_username;
    $pass = $login->admins_pass;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Creative | Mc</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>Creative</b>MC</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Giriş yapmak için bilgilerinizi girin.</p>

                <?php if (isset($_POST['admins_login'])) { ?>
                    <?php if (!$sonuc['status']) { ?>
                        <div class="alert alert-danger "> Bilgilerinizi kontrol edin...</div>
                    <?php } ?>
                <?php } ?>

                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input name="admins_username" value="<?php echo $username ?>" type="text" class="form-control" placeholder="Kullanıcı adı">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input name="admins_pass" value="<?php echo $pass ?>" type="password" class="form-control" placeholder="Şifre">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="rememberMe" id="remember" <?php echo isset($_COOKIE['adminsLogin']) ? 'checked' : '' ?>>
                                <label for="remember">
                                    Beni hatırla
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" name="admins_login" class="btn btn-primary btn-block">Giriş Yap</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>


            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
</body>

</html>