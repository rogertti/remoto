<?php
    require_once 'appConfig.php';

        if(empty($_SESSION['key'])) {
            header ('location:./');
        }

    $menu = 4;
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
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- AdminLTE App -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Custom App -->
    <link rel="stylesheet" href="dist/css/main.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  </head>
  <body class="hold-transition layout-navbar-fixed sidebar-mini sidebar-collapse text-sm">
    <!-- Site wrapper -->
    <div class="wrapper">

      <?php
        include_once 'appNavbar.php';
        include_once 'appSidebar.php';
      ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-12">
                <h1>
                  <span>Usu&aacute;rio</span>
                  <span class="float-right">
                    <a href="#" class="btn btn-primary" title="Clique para cadastrar um novo usu&aacute;rio" data-toggle="modal" data-target="#modal-new-usuario">
                      <i class="fas fa-user"></i> Novo usu&aacute;rio
                    </a>
                  </span>
                  <span></span>
                </h1>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          <?php include_once 'appSearch.php'; ?>

          <!-- Default box -->
          <div class="card">
            <div class="card-body">
              <div class="div-load-page d-none"></div>

              <table class="table table-bordered table-hover table-data d-none">
                <thead>
                  <tr>
                    <th>Nome</th>
                    <th>Usu&aacute;rio</th>
                    <th>Email</th>
                    <th style="max-width: 100px;width: 90px;"></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                  <tr>
                    <th>Nome</th>
                    <th>Usu&aacute;rio</th>
                    <th>Email</th>
                    <th style="max-width: 100px;width: 90px;"></th>
                  </tr>
                </tfoot>
              </table>

              <blockquote class="blockquote-data d-none">
                <h5>Nada encontrado</h5>
                <p>Nenhum  cadastrado.</p>
              </blockquote>
            </div>
          </div>
          <!-- /.card -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <div class="modal fade" id="modal-new-usuario">
        <div class="modal-dialog">
          <div class="modal-content">
            <form class="form-new-usuario">
              <div class="modal-header">
                <h4 class="modal-title">
                  <span>Novo usu&aacute;rio</span>
                  <span class="text-muted">
                    <small>(<i class="fas fa-bell"></i> Campo obrigat&oacute;rio)</small>
                  </span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="rand" id="rand" value="<?php echo md5(mt_rand()); ?>">

                <div class="form-group">
                  <label for="nome"><i class="fas fa-bell"></i> Nome</label>
                  <input type="text" name="nome" id="nome" maxlength="200" class="form-control" placeholder="Nome" required>
                </div>
                <div class="form-group">
                  <label for="usuario"><i class="fas fa-bell"></i> Usu&aacute;rio</label>
                  <input type="text" name="usuario" id="usuario" maxlength="10" class="form-control" placeholder="Usu&aacute;rio" required>
                </div>
                <div class="form-group">
                  <label for="senha"><i class="fas fa-bell"></i> Senha</label>
                  <input type="password" name="senha" id="senha" maxlength="10" class="form-control" autocomplete="senha" spellcheck="false" autocorrect="off" autocapitalize="off" placeholder="Senha" required>
                </div>
                <div class="form-group">
                  <label for="email"><i class="fas fa-bell"></i> Email</label>
                  <input type="email" name="email" id="email" maxlength="100" class="form-control" placeholder="Email" required>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary btn-new-usuario">Salvar</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal fade" id="modal-edit-usuario">
          <div class="modal-dialog">
              <div class="modal-content"></div>
          </div>
      </div>

      <?php include_once 'appFootbar.php'; ?>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- Password Toggle -->
    <script src="plugins/bootstrap-show-password/bootstrap.show.password.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- Custom App -->
    <script defer src="dist/js/main.js"></script>
    <script defer>
        $(document).ready(function() {
            const fade = 150, delay = 100, timeout = 60000,
                Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1000
                });

            /* PULL DATA */

            (function pullData() {
                $.ajax({
                    type: 'GET',
                    url: 'api/usuario/readAll.php',
                    dataType: 'json',
                    cache: false,
                    beforeSend: function(result) {                        
                        $('.div-load-page').removeClass('d-none').append('<p class="lead text-center"><i class="fas fa-cog fa-spin"></i></p>');
                    },
                    error: function(result) {
                        Swal.fire({icon: 'error',html: result.responseText,showConfirmButton: false});
                    },
                    success: function(data) {
                        if(!data[0]) {
                            $('.div-load-page').addClass('d-none');
                            $('.table-data').addClass('d-none');
                            $('.blockquote-data').removeClass('d-none');

                            Swal.fire({icon: 'error',title: 'Nenhum usu&aacute;rio encontrado.'}).then((result) => {
                                window.setTimeout("location.href='sair'", delay);
                            });
                        } else {
                            if(data[0].status == true) {
                                let response = '', logon = <?php echo $_SESSION['id']; ?>;

                                    for (let i in data) {
                                        if (data[i].idusuario != logon) {
                                            if (data[i].nome != 'Root') {
                                                response += '<tr>'
                                                + '<td>' + data[i].nome + '</td>'
                                                + '<td>' + data[i].usuario + '</td>'
                                                + '<td>' + data[i].email + '</td>'
                                                + '<td class="td-action">'
                                                + '<span class="bg bg-warning"><a class="fas fa-pen a-edit-usuario" href="usuarioEdit.php?78eafd55d38a6cdcf6611ca998b01e44=' + data[i].idusuario + '" title="Editar usu&aacute;rio"></a></span>'
                                                + '<span class="bg bg-danger"><a class="fas fa-trash a-delete-usuario" id="78eafd55d38a6cdcf6611ca998b01e44-' + data[i].idusuario + '" href="#" title="Excluir usu&aacute;rio"></a></span>'
                                                + '</td></tr>';
                                            }
                                        }  else {
                                            response += '<tr>'
                                            + '<td>' + data[i].nome + ' <span class="bg-success">Logado</span></td>'
                                            + '<td>' + data[i].usuario + '</td>'
                                            + '<td>' + data[i].email + '</td>'
                                            + '<td class="td-action">'
                                            + '<span class="bg bg-warning"><a class="fas fa-pen a-edit-usuario" href="usuarioEdit.php?78eafd55d38a6cdcf6611ca998b01e44=' + data[i].idusuario + '&f8032d5cae3de20fcec887f395ec9a6a=' + data[i].usuario + '" title="Editar usu&aacute;rio"></a></span>'
                                            + '</td></tr>';
                                        }
                                    }

                                $('.div-load-page').addClass('d-none');
                                $('.blockquote-data').addClass('d-none');
                                $('.table-data').removeClass('d-none');
                                //$(response).appendTo($('.table-data'));
                                $('.table-data tbody').html(response);

                                /* TOOLTIP */

                                $('div a, td span a, span a').tooltip({boundary: 'window'});

                                /* DATATABLE */

                                $('.table-data').DataTable({
                                    "paging": true,
                                    "lengthChange": false,
                                    "searching": true,
                                    "ordering": true,
                                    "info": true,
                                    "autoWidth": false,
                                    "responsive": true,
                                    "destroy": true
                                });
                            } else {
                                $('.div-load-page').addClass('d-none');
                                $('.table-data').addClass('d-none');
                                $('.blockquote-data').removeClass('d-none');

                                Swal.fire({icon: 'error',title: 'Nenhum usu&aacute;rio encontrado.'}).then((result) => {
                                    window.setTimeout("location.href='sair'", delay);
                                });
                            }
                        }
                    },
                    complete: setTimeout(function() { pullData(); }, timeout),
                    timeout: timeout
                });
            })();

            /* SHOW PASS */

            $('#senha').password();

            /* MODAL */

            $('.table-data').on('click', '.a-edit-usuario', function(e) {
                e.preventDefault();
                $('#modal-edit-usuario').modal('show').find('.modal-content').load($(this).attr('href'));
            });

            /* NOVO USUÁRIO */

            $('.form-new-usuario').submit(function(e) {
                e.preventDefault();

                $.post('api/usuario/insert.php', $(this).serialize(), function(data) {
                    $('.btn-new-usuario').html('<img src="dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                    switch(data) {
                    case 'true':
                        Toast.fire({icon: 'success',title: 'Usu&aacute;rio cadastrado.'}).then((result) => {
                            window.setTimeout("location.href='usuario'", delay);
                        });
                        break;

                    default:
                        Toast.fire({icon: 'error',title: data});
                        break;
                    }

                    $('.btn-new-usuario').html('Salvar').fadeTo(fade, 1);
                });

                return false;
            });

            /* DELETE USUÁRIO */

            $('.table-data').on('click', '.a-delete-usuario', function(e) {
                e.preventDefault();
                
                let click = this.id.split('-'),
                    py = click[0],
                    id = click[1];
                
                Swal.fire({
                    icon: 'question',
                    title: 'Excluir o usu&aacute;rio',
                    showCancelButton: true,
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não',
                }).then((result) => {
                    if(result.value == true) {
                        $.ajax({
                            type: 'GET',
                            url: 'api/usuario/delete.php?' + py + '=' + id,
                            dataType: 'json',
                            cache: false,
                            error: function(result) {
                                Swal.fire({icon: 'error',html: result.responseText,showConfirmButton: false});
                            },
                            success: function(data) {
                                if(data == true) {
                                    Toast.fire({icon: 'success',title: 'Usu&aacute;rio exclu&iacute;do.'}).then((result) => {
                                        window.setTimeout("location.href='usuario'", delay);
                                    });
                                } else {
                                    Toast.fire({icon: 'success',title: 'Usu&aacute;rio exclu&iacute;do.'}).then((result) => {
                                        window.setTimeout("location.href='index'", delay);
                                    });
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
  </body>
</html>