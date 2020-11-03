<?php
    require_once 'appConfig.php';
    include_once 'api/config/database.php';
    include_once 'api/objects/usuario.php';

        if(file_exists('appInstall.php')) {
            header('location:instalacao');
        }

        if(isset($_SESSION['key'])) {
            header('location:inicio');

            /*if($_SESSION['key'] == 'A') {
                header('location:inicio-adm');
            }

            if($_SESSION['key'] == 'U') {
                header('location:inicio');
            }*/
        }

    $database = new Database();
    $db = $database->getConnection();
    $login = new Usuario($db);
    $sql = $login->check();

        if($sql->rowCount() == 0) {
            rename('appInstallDone.php','appInstall.php');
            echo'reload';
        }

    unset($database,$db,$login,$sql);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $cfg['head_title']; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="dist/img/favicon.png">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- AdminLTE App -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Custom App -->
    <link rel="stylesheet" href="dist/css/main.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <?php echo $cfg['login_title']; ?>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Entre para iniciar sua sess&atilde;o</p>

          <form class="form-login">
            <div class="input-group mb-3">
              <input type="text" id="usuario" class="form-control" maxlength="15" placeholder="Usu&aacute;rio" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" id="senha" class="form-control" maxlength="15" placeholder="Senha" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8"></div>
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block btn-login">Entrar</button>
              </div>
            </div>
          </form>

          <!--<p class="mb-1">
            <a href="#">Eu esqueci minha senha</a>
          </p>-->
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- Custom -->
    <script>
        $(document).ready(function () {
            const fade = 150, delay = 100,
                Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });

            $('.form-login').submit(function(e) {
                e.preventDefault();
                let usuario = btoa($('#usuario').val()), senha = btoa($('#senha').val());

                $.post('api/usuario/trust.php', {usuario: usuario, senha: senha, rand: Math.random()}, function(data) {
                    $('.btn-login').html('<img src="dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);
                    
                        switch(data) {
                        case 'reload':
                            Toast.fire({icon: 'warning',title: 'Aguarde...'}).then((result) => {
                                location.reload();
                            });
                            break;

                        case 'true':
                            Toast.fire({icon: 'success',title: 'Login efetuado.'}).then((result) => {
                                window.setTimeout("location.href='inicio'", delay);
                            });
                            break;

                        default:
                            Toast.fire({icon: 'error',title: data});
                            break;
                        }

                    $('.btn-login').html('Entrar').fadeTo(fade, 1);
                });

                return false;
            });
        });
    </script>
  </body>
</html>
