<?php
    require_once 'appConfig.php';

        if(empty($_SESSION['key'])) {
            header ('location:./');
        }

    $menu = 2;
    #echo md5('cliente');
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
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
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
                  <span>Cliente</span>
                  <span class="float-right">
                    <a href="#" class="btn btn-primary" title="Clique para cadastrar um novo cliente" data-toggle="modal" data-target="#modal-new-cliente">
                      <i class="fas fa-user-tie"></i> Novo cliente
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
                  <th>Cliente</th>
                  <th>Solicitante</th>
                  <th style="max-width: 100px;width: 90px;"></th>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                  <th>Cliente</th>
                  <th>Solicitante</th>
                  <th style="max-width: 100px;width: 90px;"></th>
                </tfoot>
              </table>

              <blockquote class="blockquote-data d-none">
                <h5>Nada encontrado</h5>
                <p>Nenhum cliente cadastrado.</p>
              </blockquote>
            </div>
          </div>
          <!-- /.card -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <div class="modal fade" id="modal-new-cliente">
        <div class="modal-dialog">
          <div class="modal-content">
            <form class="form-new-cliente">
              <div class="modal-header">
                <h4 class="modal-title">
                  <span>Novo cliente</span>
                  <span class="text-muted">
                    <small>(<i class="fas fa-bell"></i> Campo obrigat&oacute;rio)</small>
                  </span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type="hidden" id="solicitante_select">

                <div class="form-group">
                  <label for="cliente"><i class="fas fa-bell"></i> Cliente</label>
                  <input type="text" name="cliente" id="cliente" maxlength="200" class="form-control" placeholder="Nome do cliente" required>
                </div>
                <div class="form-group">
                  <label for="solicitante"><i class="fas fa-bell"></i> Solicitante</label>
                  <select name="solicitante" id="solicitante" class="form-control" data-placeholder="Nome do solicitante" style="width: 100%;" multiple required></select>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary btn-new-cliente">Salvar</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <div class="modal fade" id="modal-edit-cliente">
          <div class="modal-dialog">
              <div class="modal-content"></div>
          </div>
      </div>

      <div class="modal fade" id="modal-edit-solicitante">
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
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
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
                    url: 'api/cliente/readAll.php',
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
                                let response = '',
                                    res_a = '',
                                    res_b = '',
                                    url_cliente_edit = '',
                                    url_solicitante_edit = '',
                                    solicitante = '',
                                    idcliente = '',
                                    count = data.length,
                                    x = 1;

                                    for(let i in data) {
                                        if(x == 1) {
                                            //URL Encode
                                            url_cliente_edit = 'clienteEdit.php?2a826b467343694898894908cd75fafe=' + data[i].idcliente + '&4983a0ab83ed86e0e7213c8783940193=' + data[i].cliente;
                                            url_cliente_edit = encodeURI(url_cliente_edit);
                                            url_solicitante_edit = 'solicitanteEdit.php?a517e3878bd46c123429f28a9401dbae=' + data[i].idsolicitante + '&98d67645f4e06add08ee1dccd2c79148=' + data[i].solicitante + '&4983a0ab83ed86e0e7213c8783940193=' + data[i].cliente;
                                            url_solicitante_edit = encodeURI(url_solicitante_edit);

                                            res_a = '<tr><td>' + data[i].cliente + '</td><td>';

                                            res_b = '</td><td class="td-action">'
                                            + '<span class="bg bg-warning"><a class="fas fa-pen a-edit-cliente" href="' + url_cliente_edit + '" title="Editar cliente"></a></span>'
                                            + '<span class="bg bg-danger"><a class="fas fa-trash a-delete-cliente" id="2a826b467343694898894908cd75fafe-' + data[i].idcliente + '" href="#" title="Excluir cliente"></a></span>'
                                            + '</td></tr>';

                                            solicitante += '<span class="bg bg-light bg-data">' + data[i].solicitante
                                            + ' <a class="fas fa-pen a-edit-solicitante" href="' + url_solicitante_edit + '" title="Editar solicitante"></a>'
                                            + ' <a class="fas fa-trash a-delete-solicitante" id="a517e3878bd46c123429f28a9401dbae-' + data[i].idsolicitante + '" href="#" title="Excluir solicitante"></a></span>';
                                        } else {
                                            url_solicitante_edit = 'solicitanteEdit.php?a517e3878bd46c123429f28a9401dbae=' + data[i].idsolicitante + '&98d67645f4e06add08ee1dccd2c79148=' + data[i].solicitante + '&4983a0ab83ed86e0e7213c8783940193=' + data[i].cliente;
                                            url_solicitante_edit = encodeURI(url_solicitante_edit);

                                            if(idcliente == data[i].idcliente) {
                                                if(x < count) {
                                                    solicitante += '<span class="bg bg-light bg-data">' + data[i].solicitante
                                                    + ' <a class="fas fa-pen a-edit-solicitante" href="' + url_solicitante_edit + '" title="Editar solicitante"></a>'
                                                    + ' <a class="fas fa-trash a-delete-solicitante" id="a517e3878bd46c123429f28a9401dbae-' + data[i].idsolicitante + '" href="#" title="Excluir solicitante"></a></span>';
                                                } else {
                                                    solicitante += '<span class="bg bg-light bg-data">' + data[i].solicitante
                                                    + ' <a class="fas fa-pen a-edit-solicitante" href="' + url_solicitante_edit + '" title="Editar solicitante"></a>'
                                                    + ' <a class="fas fa-trash a-delete-solicitante" id="a517e3878bd46c123429f28a9401dbae-' + data[i].idsolicitante + '" href="#" title="Excluir solicitante"></a></span>';

                                                    response += res_a + solicitante + res_b;
                                                }
                                            } else {
                                                response += res_a + solicitante + res_b;
                                                solicitante = '';

                                                //URL Encode
                                                url_cliente_edit = 'clienteEdit.php?2a826b467343694898894908cd75fafe=' + data[i].idcliente + '&4983a0ab83ed86e0e7213c8783940193=' + data[i].cliente;
                                                url_cliente_edit = encodeURI(url_cliente_edit);

                                                res_a = '<tr><td>' + data[i].cliente + '</td><td>';

                                                res_b = '</td><td class="td-action">'
                                                + '<span class="bg bg-warning"><a class="fas fa-pen a-edit-cliente" href="' + url_cliente_edit + '" title="Editar cliente"></a></span>'
                                                + '<span class="bg bg-danger"><a class="fas fa-trash a-delete-cliente" id="2a826b467343694898894908cd75fafe-' + data[i].idcliente + '" href="#" title="Excluir cliente"></a></span>'
                                                + '</td></tr>';

                                                solicitante += '<span class="bg bg-light bg-data">' + data[i].solicitante
                                                + ' <a class="fas fa-pen a-edit-solicitante" href="' + url_solicitante_edit + '" title="Editar solicitante"></a>'
                                                + ' <a class="fas fa-trash a-delete-solicitante" id="a517e3878bd46c123429f28a9401dbae-' + data[i].idsolicitante + '" href="#" title="Excluir solicitante"></a></span>';
                                            }
                                        }

                                        idcliente = data[i].idcliente;
                                        x++;
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

            $('.table-data').on('click', '.a-edit-solicitante', function(e) {
                e.preventDefault();
                $('#modal-edit-solicitante').modal('show').find('.modal-content').load($(this).attr('href'));
            });
            
            $('.table-data').on('click', '.a-edit-cliente', function(e) {
                e.preventDefault();
                $('#modal-edit-cliente').modal('show').find('.modal-content').load($(this).attr('href'));
		        });

            /* SELECT MULTIPLE */

            $('#solicitante').show(function () {
                $('#solicitante').select2({
                    tags: true
                });

                $('#solicitante').change(function (e) {
                    let obj = $('#solicitante').select2('val');
                    $('#solicitante_select').attr('value', obj);
                });
            });

            /* NOVO CLIENTE */

            $('.form-new-cliente').submit(function(e) {
                e.preventDefault();

                $.post('api/cliente/insert.php', { cliente: $('#cliente').val(), solicitante: $('#solicitante_select').val(), rand: Math.random()}, function(data) {
                    $('.btn-new-cliente').html('<img src="dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                    switch(data) {
                    case 'true':
                        Toast.fire({icon: 'success',title: 'Cliente cadastrado.'}).then((result) => {
                            window.setTimeout("location.href='cliente'", delay);
                        });
                        break;

                    default:
                        Toast.fire({icon: 'error',title: data});
                        break;
                    }

                    $('.btn-new-cliente').html('Salvar').fadeTo(fade, 1);
                });

                return false;
            });

            /* DELETE CLIENTE */

            $('.table-data').on('click', '.a-delete-cliente', function(e) {
                e.preventDefault();
                
                let click = this.id.split('-'),
                    py = click[0],
                    id = click[1];
                
                Swal.fire({
                    icon: 'question',
                    title: 'Excluir o cliente',
                    showCancelButton: true,
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não',
                }).then((result) => {
                    if(result.value == true) {
                        $.ajax({
                            type: 'GET',
                            url: 'api/cliente/delete.php?' + py + '=' + id,
                            dataType: 'json',
                            cache: false,
                            error: function(result) {
                                Swal.fire({icon: 'error',html: result.responseText,showConfirmButton: false});
                            },
                            success: function(data) {
                                if(data == true) {
                                    Toast.fire({icon: 'success',title: 'Cliente exclu&iacute;do.'}).then((result) => {
                                        window.setTimeout("location.href='cliente'", delay);
                                    });
                                }
                            }
                        });
                    }
                });
            });

            /* DELETE SOLICITANTE */

            $('.table-data').on('click', '.a-delete-solicitante', function(e) {
                e.preventDefault();
                
                let click = this.id.split('-'),
                    py = click[0],
                    id = click[1];
                
                Swal.fire({
                    icon: 'question',
                    title: 'Excluir o solicitante',
                    showCancelButton: true,
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não',
                }).then((result) => {
                  if(result.value == true) {
                        $.ajax({
                            type: 'GET',
                            url: 'api/cliente/solicitanteDelete.php?' + py + '=' + id,
                            dataType: 'json',
                            cache: false,
                            error: function(result) {
                                Swal.fire({icon: 'error',html: result.responseText,showConfirmButton: false});
                            },
                            success: function(data) {
                                if(data == true) {
                                    Toast.fire({icon: 'success',title: 'Solicitante exclu&iacute;do.'}).then((result) => {
                                        window.setTimeout("location.href='cliente'", delay);
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