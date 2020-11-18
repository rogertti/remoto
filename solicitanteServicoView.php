<?php
    require_once 'appConfig.php';

        if(empty($_SESSION['key'])) {
            header ('location:./');
        }

    /* CLEAR CACHE */
    
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    //header("Content-Type: application/xml; charset=utf-8");

    require_once 'appConfig.php';
    include_once 'api/config/database.php';
    include_once 'api/objects/servico.php';

        if(empty($_SESSION['key'])) {
            header ('location:./');
        }
    
    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare objects
    $servico = new Servico($db);

    // GET variables
    $py_idsolicitante = md5('idsolicitante');
    $py_solicitante = md5('solicitante');
    $py_cliente = md5('cliente');

    $sql = $servico->readAllClient($_GET[''.$py_idsolicitante.'']);

        if($sql->rowCount() > 0) {
            if($sql->rowCount() > 1) {
                $modal_title = 'Solicita&ccedil;&otilde;es de '.$_GET[''.$py_solicitante.''];
            } else {
                $modal_title = 'Solicita&ccedil;&atilde;o de '.$_GET[''.$py_solicitante.''];
            }
?>
<div class="modal-header">
    <h4 class="modal-title">
        <span><?php echo $modal_title; ?></span>
    </h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table class="table table-bordered table-hover table-data">
        <thead>
            <tr>
                <th>Cliente</th>
                <th style="max-width: 160px;width: 150px;">In&iacute;cio</th>
                <th style="max-width: 160px;width: 150px;">Fim</th>
                <th>Situa&ccedil;&atilde;o</th>
                <th>Solicita&ccedil;&atilde;o</th>
                <th style="max-width: 115px;width: 111px;"></th>
            </tr>
        </thead>
        <tbody>
        <?php
            while($row = $sql->fetch(PDO::FETCH_OBJ)) {
                // format date
                $ano = substr($row->data_inicio,0,4);
                $mes = substr($row->data_inicio,5,2);
                $dia = substr($row->data_inicio,8);
                $row->data_inicio = $dia."/".$mes."/".$ano;

                if (!empty($row->data_fim)) {
                    $ano = substr($row->data_fim,0,4);
                    $mes = substr($row->data_fim,5,2);
                    $dia = substr($row->data_fim,8);
                    $row->data_fim = $dia."/".$mes."/".$ano;
                } else {
                    $row->data_fim = '--/--/----';
                }

                // format time
                $row->hora_inicio = substr($row->hora_inicio, 0, 5).'h';
                !empty($row->hora_fim) ? $row->hora_fim = substr($row->hora_fim, 0, 5).'h' : $row->hora_fim = '--:--';

                    switch($row->situacao) {
                        case 'Aberta': $row->situacao = '<span class="bg bg-info">'.$row->situacao.'</span>'; break;
                        case 'Finalizada': $row->situacao = '<span class="bg bg-success">'.$row->situacao.'</span>'; break;
                        case 'Pendente': $row->situacao = '<span class="bg bg-warning">'.$row->situacao.'</span>'; break;
                        default: $row->situacao = '<span class="bg bg-secondary">'.$row->situacao.'</span>'; break;
                    }

                echo'
                <tr>
                    <td>'.$_GET[''.$py_cliente.''].'</td>
                    <td>'.$row->data_inicio.' &#149; '.$row->hora_inicio.'</td>
                    <td>'.$row->data_fim.' &#149; '.$row->hora_fim.'</td>
                    <td>'.$row->situacao.'</td>
                    <td>'.$row->solicitacao.'</td>
                    <td class="td-action">
                        <span class="bg bg-warning"><a class="fas fa-pen a-edit-servico" href="servicoEdit.php?740b5bc9996b9dee9d3ab266ef54722c='.$row->idservico.'" title="Editar solicita&ccedil;&atilde;o"></a></span>
                        <span class="bg bg-danger"><a class="fas fa-trash a-delete-servico" id="740b5bc9996b9dee9d3ab266ef54722c-'.$row->idservico.'" href="#" title="Excluir solicita&ccedil;&atilde;o"></a></span>
                    </td>
                </tr>';
            }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Cliente</th>
                <th style="max-width: 160px;width: 150px;">In&iacute;cio</th>
                <th style="max-width: 160px;width: 150px;">Fim</th>
                <th>Situa&ccedil;&atilde;o</th>
                <th>Solicita&ccedil;&atilde;o</th>
                <th style="max-width: 115px;width: 111px;"></th>
            </tr>
        </tfoot>
    </table>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
    <!-- <button type="submit" class="btn btn-primary btn-edit-situacao">Salvar</button> -->
</div>
<script defer>
    $(document).ready(function() {
        const fade = 150, delay = 100,
            Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1000
            });

        /* TOOLTIP */

        $('td span a').tooltip({boundary: 'window'});

        /* MODAL */

        $('.table-data').on('click', '.a-edit-servico', function(e) {
            e.preventDefault();
            $('#modal-edit-servico').modal('show').find('.modal-content').load($(this).attr('href'));
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
                        error: function(result) {
                            Swal.fire({icon: 'error',html: result.responseText,showConfirmButton: false});
                        },
                        success: function(data) {
                            if(data == true) {
                                Toast.fire({icon: 'success',title: 'Solicita&ccedil;&atilde;o exclu&iacute;da.'}).then((result) => {
                                    window.setTimeout(location.href='inicio', delay);
                                });
                            }
                        }
                    });
                }
            });
        });
    });
</script>
<?php
        } else {
            echo'
            <blockquote class="quote-danger">
                <h5>Erro</h5>
                <p>A solicita&ccedil;&atilde;o não foi encontrada.</p>
            </blockquote>';
        }
?>