<?php
    require_once 'appConfig.php';
    include_once 'api/config/database.php';
    include_once 'api/objects/servico.php';
    include_once 'api/objects/cliente.php';

        if(empty($_SESSION['key'])) {
            header ('location:./');
        }

        //criando um ticket
        function createTicket() {
            if (PHP_VERSION >= 7) {
                $bytes = random_bytes(5);
                $bytes = strtoupper(bin2hex($bytes));
            } else {
                $bytes = openssl_random_pseudo_bytes(ceil(20 / 2));
                $bytes = strtoupper(substr(bin2hex($bytes), 10));
            }

            return $bytes;
        }
    
    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare objects
    $servico = new Servico($db);
    $cliente = new Cliente($db);

    $sql = $servico->readAllStatus();

        if($sql->rowCount() > 0) {
            #while($row = $sql->fetch(PDO::FETCH_OBJ)) {}
            $row = $sql->fetch(PDO::FETCH_OBJ);
            $status = $row->idsituacao;
        } else {
            $status = '';
        }

    // datepicker control
    $getmes = md5('mes');
    $getano = md5('ano');

        if(isset($_GET[''.$getmes.''])) {
            $mes = $_GET[''.$getmes.''];
        } else {
            $mes = date('m');
        }

        if(isset($_GET['left'])) {
            if($mes == '12') {
                $ano = $_GET[''.$getano.''] - 1;
            } else {
                $ano = $_GET[''.$getano.''];
            }
        }

        if(isset($_GET['right'])) {
            if($mes == '01') {
                $ano = $_GET[''.$getano.''] + 1;
            } else {
                $ano = $_GET[''.$getano.''];
            }
        }

        if(isset($_GET['pick'])) {
            $ano = $_GET[''.$getano.''];
        }

        if ((!isset($_GET['left'])) and (!isset($_GET['right'])) and (!isset($_GET['pick']))) {
            $ano = date('Y');
        }

        function mes_extenso($fmes) {
            switch ($fmes) {
                case '01': $fmes = 'Janeiro'; break;
                case '02': $fmes = 'Fevereiro'; break;
                case '03': $fmes = 'Mar&ccedil;o'; break;
                case '04': $fmes = 'Abril'; break;
                case '05': $fmes = 'Maio'; break;
                case '06': $fmes = 'Junho'; break;
                case '07': $fmes = 'Julho'; break;
                case '08': $fmes = 'Agosto'; break;
                case '09': $fmes = 'Setembro'; break;
                case '10': $fmes = 'Outubro'; break;
                case '11': $fmes = 'Novembro'; break;
                case '12': $fmes = 'Dezembro'; break;
            }

            return $fmes;
        }

    $mesleft = $mes - 1;
    $mesright = $mes + 1;

        if(strlen($mesleft) == 1) {
            $mesleft = '0'.$mesleft;

                if($mesleft == '00') {
                    $mesleft = '12';
                }
        }

        if(strlen($mesright) == 1) {
            $mesright = '0'.$mesright;

                if($mesright == '13') {
                    $mesright = '01';
                }
        } else {
            if($mesright == '13') {
                $mesright = '01';
            }
        }

    $menu = 1;
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
    <!-- DatePicker -->
    <link rel="stylesheet" href="plugins/datepicker/css/datepicker.min.css">
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
                  <span>Solicita&ccedil;&otilde;es abertas e pendentes</span>
                  <span class="float-right">
                    <a href="#" class="btn btn-primary" title="Clique para cadastrar um nova solicita&ccedil;&atilde;o" data-toggle="modal" data-target="#modal-new-servico">
                      <i class="fas fa-chalkboard-teacher"></i> Nova solicita&ccedil;&atilde;o 
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

              <div class="div-time d-none">
                  <div class="div-time-left text-center">
                      <a class="lead" href="inicio?<?php echo $getmes; ?>=<?php echo $mesleft; ?>&<?php echo $getano; ?>=<?php echo $ano; ?>&left=1" title="M&ecirc;s anterior">
                          <i class="fas fa-arrow-left"></i>
                      </a>
                  </div>
                  <div class="div-time-center">
                      <p class="lead text-center">
                          <input type="text" class="date-pick text-center" value="<?php echo mes_extenso($mes); ?> de <?php echo $ano; ?>" readonly>
                      </p>
                  </div>
                  <div class="div-time-right text-center">
                      <a class="lead" href="inicio?<?php echo $getmes; ?>=<?php echo $mesright; ?>&<?php echo $getano; ?>=<?php echo $ano; ?>&right=1" title="Pr&oacute;ximo m&ecirc;s">
                          <i class="fas fa-arrow-right"></i>
                      </a>
                  </div>
              </div>

              <table class="table table-bordered table-hover table-data d-none">
                <thead>
                    <tr>
                        <th>Cliente: Solicitante</th>
                        <th style="max-width: 160px;width: 150px;">Data: In&iacute;cio &#149; Fim</th>
                        <th>Situa&ccedil;&atilde;o</th>
                        <th>Solicita&ccedil;&atilde;o</th>
                        <th style="max-width: 100px;width: 90px;"></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Cliente: Solicitante</th>
                        <th style="max-width: 160px;width: 150px;">Data: In&iacute;cio &#149; Fim</th>
                        <th>Situa&ccedil;&atilde;o</th>
                        <th>Solicita&ccedil;&atilde;o</th>
                        <th style="max-width: 100px;width: 90px;"></th>
                    </tr>
                </tfoot>
              </table>

              <blockquote class="blockquote-data d-none">
                <h5>Nada encontrado</h5>
                <p>Nenhuma solicitação aberta.</p>
              </blockquote>
            </div>
          </div>
          <!-- /.card -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <div class="modal fade" id="modal-new-servico">
        <div class="modal-dialog">
          <div class="modal-content">
            <form class="form-new-servico">
              <div class="modal-header">
                <h4 class="modal-title">
                  <span>Nova solicita&ccedil;&atilde;o</span>
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
                <input type="hidden" name="idsituacao" id="idsituacao" value="<?php echo $status; ?>">
                <input type="hidden" name="ticket" id="ticket" value="<?php $ticket = createTicket(); echo $ticket; ?>">

                <div class="form-group">
                  <label for="ticket" class="lead text-success">Ticket <?php echo $ticket; ?></label>
                </div>
                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <label for="datado"><i class="fas fa-bell"></i> Data</label>
                      <input type="date" name="datado" id="datado" maxlength="10" value="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="Data" readonly>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label for="inicio"><i class="fas fa-bell"></i> In&iacute;cio</label>
                      <input type="time" name="inicio" id="inicio" maxlength="8" min="08:30" max="18:00" value="<?php echo date('H:i'); ?>" class="form-control" placeholder="In&iacute;cio" readonly>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="solicitante"><i class="fas fa-bell"></i> Solicitante</label>
                  <select name="solicitante" id="solicitante" class="form-control" data-placeholder="Busque o solicitante" style="width: 100%;" required>
                  <?php
                      $sql = $cliente->readAll();

                          if($sql->rowCount() > 0) {
                              echo'<option value="" selected>Busque o solicitante</option>';

                                  while($row = $sql->fetch(PDO::FETCH_OBJ)) {
                                      echo'<option value="'.$row->idsolicitante.'">'.$row->cliente.': '.$row->solicitante.'</option>';
                                  }
                          } else {
                              echo'<option value="" selected>Nenhum solicitante cadastrado</option>';
                          }
                  ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="assunto">Assunto</label>
                  <input type="text" name="assunto" id="assunto" maxlength="45" class="form-control" placeholder="Assunto">
                </div>
                <div class="form-group">
                  <label for="solicitacao"><i class="fas fa-bell"></i> Solicita&ccedil;&atilde;o</label>
                  <input type="text" name="solicitacao" id="solicitacao" maxlength="100" class="form-control" placeholder="Solicita&ccedil;&atilde;o" required>
                </div>
                <div class="form-group">
                  <label for="procedimento">Procedimento</label>
                  <textarea name="procedimento" id="procedimento" rows="3" class="form-control" placeholder="Procedimento"></textarea>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary btn-new-servico">Salvar</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- DatePicker -->
    <script src="plugins/datepicker/js/datepicker.min.js"></script>
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
                    type: 'GET', //url funciona sem parâmetros também, modifique servico/readAll.php e o objeto servico.php 
                    url: 'api/servico/readAll.php?<?php echo $getmes; ?>=<?php echo $mes; ?>&<?php echo $getano; ?>=<?php echo $ano; ?>',
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
                                let response = '', situacao = '';

                                    for(let i in data) {
                                        switch(data[i].situacao) {
                                        case 'Aberta': situacao = '<span class="bg bg-info">' + data[i].situacao + '</span>'; break;
                                        //case 'Finalizada': situacao = '<span class="bg bg-secondary">' + data[i].situacao + '</span>'; break;
                                        case 'Pendente': situacao = '<span class="bg bg-warning">' + data[i].situacao + '</span>'; break;
                                        default: situacao = '<span class="bg bg-secondary">' + data[i].situacao + '</span>'; break;
                                        }

                                        response += '<tr><td>' + data[i].cliente + ': ' + data[i].solicitante + '</td>'
                                        + '<td>' + data[i].datado + ': ' + data[i].inicio + ' &#149; ' + data[i].fim + '</td>'
                                        + '<td>' + situacao + '</td>'
                                        + '<td>' + data[i].solicitacao + '</td>'
                                        + '<td class="td-action">'
                                        + '<span class="bg bg-warning"><a class="fas fa-pen a-edit-servico" href="servicoEdit.php?740b5bc9996b9dee9d3ab266ef54722c=' + data[i].idservico + '" title="Editar solicita&ccedil;&atilde;o"></a></span>'
                                        + '<span class="bg bg-danger"><a class="fas fa-trash a-delete-servico" id="740b5bc9996b9dee9d3ab266ef54722c-' + data[i].idservico + '" href="#" title="Excluir solicita&ccedil;&atilde;o"></a></span>'
                                        + '</td></tr>';

                                        situacao = '';
                                    }

                                $('.div-load-page').addClass('d-none');
                                $('.blockquote-data').addClass('d-none');
                                $('.div-time').removeClass('d-none');
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
                                $('.div-time').addClass('d-none');
                                $('.table-data').addClass('d-none');
                                $('.blockquote-data').removeClass('d-none');
                            }
                        }
                    },
                    complete: setTimeout(function() { pullData(); }, timeout),
                    timeout: timeout
                });
            })();

            /* DATEPICKER */

            $(".date-pick").show(function () {
                $(".date-pick").datepicker({
                    language: 'pt-BR',
                    format: "mm yyyy",
                    startView: 1,
                    minViewMode: 1
                }).on('hide', function(e) {
                    let dt = e.target.value.split(' ');
                    location.href = "inicio?<?php echo $getmes; ?>=" + dt[0] + "&<?php echo $getano; ?>=" + dt[1] + "&pick=1";
                });
            });

            /* MODAL */

            $('.table-data').on('click', '.a-edit-servico', function(e) {
                e.preventDefault();
                $('#modal-edit-servico').modal('show').find('.modal-content').load($(this).attr('href'));
            });

            /* SELECT MULTIPLE */

            $('#solicitante').show(function () {
                $('#solicitante').select2({
                    tags: true
                });

                /*$('#solicitante').change(function (e) {
                    let obj = $('#solicitante').select2('val');
                    $('#solicitante_select').attr('value', obj);
                });*/
            });

            /* NOVO SERVIÇO */

            $('.form-new-servico').submit(function(e) {
                e.preventDefault();

                $.post('api/servico/insert.php', $(this).serialize(), function(data) {
                    $('.btn-new-servico').html('<img src="dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                    switch(data) {
                    case 'true':
                        Toast.fire({icon: 'success',title: 'Solicita&ccedil;&atilde;o aberta.'}).then((result) => {
                            window.setTimeout("location.href='inicio'", delay);
                        });
                        break;

                    default:
                        Toast.fire({icon: 'error',title: data});
                        break;
                    }

                    $('.btn-new-servico').html('Salvar').fadeTo(fade, 1);
                });

                return false;
            });

            /* DELETE SERVIÇO */

            $('.table-data').on('click', '.a-delete-servico', function(e) {
                e.preventDefault();
                
                let click = this.id.split('-'),
                    py = click[0],
                    id = click[1];
                
                Swal.fire({
                    icon: 'question',
                    title: 'Excluir a solicita&ccedil;&atilde;o',
                    showCancelButton: true,
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não',
                }).then((result) => {
                    if(result.value == true) {
                        $.ajax({
                            type: 'GET',
                            url: 'api/servico/delete.php?' + py + '=' + id,
                            dataType: 'json',
                            cache: false,
                            beforeSend: function(result) {                        
                                $('#search-result').empty().append('<p style="position: relative;top: 15px;" class="lead"><i class="fas fa-cog fa-spin"></i> Processando...</p>');
                            },
                            error: function(result) {
                                Swal.fire({icon: 'error',html: result.responseText,showConfirmButton: false});
                            },
                            success: function(data) {
                                if(data == true) {
                                    Toast.fire({icon: 'success',title: 'Solicita&ccedil;&atilde;o exclu&iacute;da.'}).then((result) => {
                                        window.setTimeout("location.href='inicio'", delay);
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