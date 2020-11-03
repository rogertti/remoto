<?php
    require_once 'appConfig.php';

        if(empty($_SESSION['key'])) {
            header ('location:./');
        }

    $menu = 3;
    #echo md5('idsituacao');
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
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
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
  <body class="hold-transition layout-navbar-fixed sidebar-mini sidebar-collapse text-sm">
    <!-- Site wrapper -->
    <div class="wrapper">

      <?php
        include_once 'appNavbar.php';
        include_once 'appSidebar.php';
      ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <?php include_once 'appSearch.php'; ?>

        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-12">
                <h1>
                  <span>Nova situa&ccedil;&atilde;o</span>
                  <span class="float-right">
                    <a href="#" class="btn btn-primary" title="Clique para cadastrar uma nova situa&ccedil;&atilde;o" data-toggle="modal" data-target="#modal-new-situacao">
                      <i class="fas fa-user"></i> Nova situa&ccedil;&atilde;o
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
          <!-- Default box -->
          <div class="card">
            <div class="card-body">
              <div class="div-load-page d-none"></div>
              
              <table class="table table-bordered table-hover table-data d-none">
                <thead>
                  <th>Descri&ccedil;&atilde;o</th>
                  <th style="max-width: 100px;width: 90px;"></th>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                  <th>Descri&ccedil;&atilde;o</th>
                  <th style="max-width: 100px;width: 90px;"></th>
                </tfoot>
              </table>

              <blockquote class="blockquote-data d-none">
                <h5>Nada encontrado</h5>
                <p>Nenhuma situa&ccedil;&atilde;o cadastrada.</p>
              </blockquote>
            </div>
          </div>
          <!-- /.card -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <div class="modal fade" id="modal-new-situacao">
        <div class="modal-dialog">
          <div class="modal-content">
            <form class="form-new-situacao">
              <div class="modal-header">
                <h4 class="modal-title">
                  <span>Nova situa&ccedil;&atilde;o</span>
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
                  <label for="descricao"><i class="fas fa-bell"></i> Descri&ccedil;&atilde;o</label>
                  <input type="text" name="descricao" id="descricao" maxlength="100" class="form-control" placeholder="Descri&ccedil;&atilde;o da situa&ccedil;&atilde;o" required>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary btn-new-situacao">Salvar</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <div class="modal fade" id="modal-edit-situacao">
          <div class="modal-dialog">
              <div class="modal-content"></div>
          </div>
      </div>

      <div class="modal fade" id="modal-view-servico">
          <div class="modal-dialog modal-xl">
              <div class="modal-content"></div>
          </div>
      </div>

      <div class="modal fade" id="modal-edit-servico">
          <div class="modal-dialog">
              <div class="modal-content"></div>
          </div>
      </div>
      <!-- /.modal -->

      <?php include_once 'appFootbar.php'; ?>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
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
                    url: 'api/situacao/readAll.php',
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
                        } else {
                            if(data[0].status == true) {
                                let response = '';

                                    for(let i in data) {
                                        response += '<tr>'
                                        + '<td>' + data[i].descricao + '</td>'
                                        + '<td class="td-action">'
                                        + '<span class="bg bg-warning"><a class="fas fa-pen a-edit-situacao" href="situacaoEdit.php?43b17a78400ddccc5e4af2cda2697b13=' + data[i].idsituacao + '" title="Editar situa&ccedil;&atilde;o"></a></span>'
                                        + '<span class="bg bg-danger"><a class="fas fa-trash a-delete-situacao" id="43b17a78400ddccc5e4af2cda2697b13-' + data[i].idsituacao + '" href="#" title="Excluir situa&ccedil;&atilde;o"></a></span>'
                                        + '</td></tr>';

                                        situacao = '';
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
                            }
                        }
                    },
                    complete: setTimeout(function() { pullData(); }, timeout),
                    timeout: timeout
                });
            })();

            /* MODAL */

            $('.table-data').on('click', '.a-edit-situacao', function(e) {
                e.preventDefault();
                $('#modal-edit-situacao').modal('show').find('.modal-content').load($(this).attr('href'));
            });

            /* NOVO SERVIÇO */

            $('.form-new-situacao').submit(function(e) {
                e.preventDefault();

                $.post('api/situacao/insert.php', $(this).serialize(), function(data) {
                    $('.btn-new-situacao').html('<img src="dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                    switch(data) {
                    case 'true':
                        Toast.fire({icon: 'success',title: 'Solicita&ccedil;&atilde;o aberta.'}).then((result) => {
                            window.setTimeout("location.href='situacao'", delay);
                        });
                        break;

                    default:
                        Toast.fire({icon: 'error',title: data});
                        break;
                    }

                    $('.btn-new-situacao').html('Salvar').fadeTo(fade, 1);
                });

                return false;
            });

            /* DELETE SERVIÇO */

            $('.table-data').on('click', '.a-delete-situacao', function(e) {
                e.preventDefault();
                
                let click = this.id.split('-'),
                    py = click[0],
                    id = click[1];
                
                Swal.fire({
                    icon: 'question',
                    title: 'Excluir a situa&ccedil;&atilde;o',
                    showCancelButton: true,
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não',
                }).then((result) => {
                    if(result.value == true) {
                        $.ajax({
                            type: 'GET',
                            url: 'api/situacao/delete.php?' + py + '=' + id,
                            dataType: 'json',
                            cache: false,
                            error: function(result) {
                                Swal.fire({icon: 'error',html: result.responseText,showConfirmButton: false});
                            },
                            success: function(data) {
                                if(data == true) {
                                    Toast.fire({icon: 'success',title: 'Situa&ccedil;&atilde;o exclu&iacute;da.'}).then((result) => {
                                        window.setTimeout("location.href='situacao'", delay);
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