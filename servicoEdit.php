<?php
    /* CLEAR CACHE */
    
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    //header("Content-Type: application/xml; charset=utf-8");

    require_once 'appConfig.php';
    include_once 'api/config/database.php';
    include_once 'api/objects/servico.php';
    include_once 'api/objects/cliente.php';

        if(empty($_SESSION['key'])) {
            header ('location:./');
        }
    
    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare objects
    $servico = new Servico($db);
    $cliente = new Cliente($db);

    // GET variables
    $py_idservico = md5('idservico');

    $sql = $servico->readSingle($_GET[''.$py_idservico.'']);

        if($sql->rowCount() > 0) {
            #while($row = $sql->fetch(PDO::FETCH_OBJ)) {}
            $row = $sql->fetch(PDO::FETCH_OBJ);
?>
<form class="form-edit-servico">
    <div class="modal-header">
        <h4 class="modal-title">
            <span>Editar solicita&ccedil;&atilde;o</span>
            <span class="text-muted">
            <small>(<i class="fas fa-bell"></i> Campo obrigat&oacute;rio)</small>
            </span>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" name="rand" id="rand_edit" value="<?php echo md5(mt_rand()); ?>">
        <input type="hidden" name="idservico" id="idservico" value="<?php echo $_GET[''.$py_idservico.'']; ?>">

        <div class="form-group">
            <label for="ticket" class="lead text-success">Ticket <?php echo $row->ticket; ?></label>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="datado"><i class="fas fa-bell"></i> Data</label>
                    <input type="date" name="datado" id="datado_edit" maxlength="10" value="<?php echo $row->datado; ?>" class="form-control" placeholder="Data" disabled>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="inicio"><i class="fas fa-bell"></i> In&iacute;cio</label>
                    <input type="time" name="inicio" id="inicio_edit" maxlength="8" min="08:30" max="18:00" value="<?php echo $row->hora_inicio; ?>" class="form-control" placeholder="In&iacute;cio" disabled>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="fim">Fim</label>
                    <input type="time" name="fim" id="fim_edit" maxlength="8" min="08:30" max="18:00" value="<?php echo $row->hora_fim; ?>" class="form-control" placeholder="Fim">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="situacao"><i class="fas fa-bell"></i> Situa&ccedil;&atilde;o</label>
            <select name="situacao" id="situacao_edit" class="form-control" data-placeholder="Busque a situa&ccedil;&atilde;o" style="width: 100%;" required>
            <?php
                $sql = $servico->readAllStatus();

                    if($sql->rowCount() > 0) {
                        while($row2 = $sql->fetch(PDO::FETCH_OBJ)) {
                            if($row2->idsituacao == $row->situacao_idsituacao) {
                                echo'<option value="'.$row2->idsituacao.'" selected>'.$row2->descricao.'</option>';
                            } else {
                                echo'<option value="'.$row2->idsituacao.'">'.$row2->descricao.'</option>';
                            }
                        }
                    } else {
                        echo'<option value="" selected>Nenhum solicitante cadastrado</option>';
                    }
            ?>
            </select>
        </div>
        <div class="form-group">
            <label for="solicitante"><i class="fas fa-bell"></i> Solicitante</label>
            <select name="solicitante" id="solicitante_edit" class="form-control" data-placeholder="Busque o solicitante" style="width: 100%;" required>
            <?php
                $sql = $cliente->readAll();

                    if($sql->rowCount() > 0) {
                        while($row2 = $sql->fetch(PDO::FETCH_OBJ)) {
                            if($row2->idsolicitante == $row->solicitante_idsolicitante) {
                                echo'<option value="'.$row2->idsolicitante.'" selected>'.$row2->cliente.': '.$row2->solicitante.'</option>';
                            } else {
                                echo'<option value="'.$row2->idsolicitante.'">'.$row2->cliente.': '.$row2->solicitante.'</option>';
                            }
                        }
                    } else {
                        echo'<option value="" selected>Nenhum solicitante cadastrado</option>';
                    }
            ?>
            </select>
        </div>
        <div class="form-group">
            <label for="assunto">Assunto</label>
            <input type="text" name="assunto" id="assunto_edit" maxlength="45" class="form-control" value="<?php echo $row->assunto; ?>" placeholder="Assunto">
        </div>
        <div class="form-group">
            <label for="solicitacao"><i class="fas fa-bell"></i> Solicita&ccedil;&atilde;o</label>
            <input type="text" name="solicitacao" id="solicitacao_edit" maxlength="100" class="form-control" value="<?php echo $row->solicitacao; ?>" placeholder="Solicita&ccedil;&atilde;o" required>
        </div>
        <div class="form-group">
            <label for="procedimento">Procedimento</label>
            <textarea name="procedimento" id="procedimento_edit" rows="3" class="form-control" placeholder="Procedimento"><?php echo $row->procedimento; ?></textarea>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary btn-edit-servico">Salvar</button>
    </div>
</form>
<script defer>
    $(document).ready(function() {
        const fade = 150, delay = 100,
            Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });

        /* SELECT MULTIPLE */

        $('#solicitante_edit').show(function () {
            $('#solicitante_edit').select2({
                tags: true
            });
        });

        $('#situacao_edit').show(function () {
            $('#situacao_edit').select2({
                tags: true
            });
        });
        
        /* EDITAR SERVIÇO */

        $('.form-edit-servico').submit(function(e) {
            e.preventDefault();

            $.post('api/servico/update.php', $(this).serialize(), function(data) {
                $('.btn-edit-servico').html('<img src="dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                switch(data) {
                case 'true':
                    Toast.fire({icon: 'success',title: 'Solicita&ccedil;&atilde;o editada.'}).then((result) => {
                        window.setTimeout("location.href='inicio'", delay);
                    });
                    break;

                default:
                    Toast.fire({icon: 'error',title: data});
                    break;
                }

                $('.btn-edit-servico').html('Salvar').fadeTo(fade, 1);
            });

            return false;
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