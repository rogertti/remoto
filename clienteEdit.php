<?php
    require_once 'appConfig.php';
    include_once 'api/config/database.php';
    include_once 'api/objects/cliente.php';

        if(empty($_SESSION['key'])) {
            header ('location:./');
        }
    
    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare client object
    $cliente = new Cliente($db);

    /* CLEAR CACHE */
    
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    //header("Content-Type: application/xml; charset=utf-8");

    // GET variables
    $py_idcliente = md5('idcliente');
    $py_cliente = md5('cliente');

    // query all solicitantes from cliente
    $sql = $cliente->requesterLink($_GET[''.$py_idcliente.'']);

        if($sql->rowCount() > 0) {
            $row = $sql->fetchAll(PDO::FETCH_ASSOC);
            $solicitante = array_column($row, 'idsolicitante');
            $solicitantes = implode(',', $solicitante);
        }
?>
<form class="form-edit-cliente">
    <div class="modal-header">
        <h4 class="modal-title">
            <span>Editar cliente</span>
            <span class="text-muted">
                <small>(<i class="fas fa-bell"></i> Campo obrigat&oacute;rio)</small>
            </span>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" id="idcliente_edit" value="<?php echo $_GET[''.$py_idcliente.'']; ?>">
        <input type="hidden" id="solicitante_select_original" value="<?php echo $solicitantes; ?>">
        <input type="hidden" id="solicitante_select_edit">

        <div class="form-group">
            <label for="cliente_edit"><i class="fas fa-bell"></i> Cliente</label>
            <input type="text" name="cliente_edit" id="cliente_edit" maxlength="200" value="<?php echo $_GET[''.$py_cliente.'']; ?>" class="form-control" placeholder="Nome do cliente" required>
        </div>
        <div class="form-group">
            <label for="solicitante_edit"><i class="fas fa-bell"></i> Solicitante</label>
            <select name="solicitante_edit" id="solicitante_edit" class="form-control" data-placeholder="Nome do solicitante" style="width: 100%;" multiple required>
            <?php
                $sql = $cliente->requesterLink($_GET[''.$py_idcliente.'']);

                    if($sql->rowCount() > 0) {
                        while($row = $sql->fetch(PDO::FETCH_OBJ)) {
                            echo'<option value="'.$row->idsolicitante.'" selected>'.$row->nome.'</option>';
                        }
                    }
            ?>
            </select>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary btn-edit-cliente">Salvar</button>
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

            $('#solicitante_edit').change(function (e) {
                let obj = $('#solicitante_edit').select2('val');
                $('#solicitante_select_edit').attr('value', obj);
            });
        });
        
        /* EDITAR CLIENTE */

        $('.form-edit-cliente').submit(function(e) {
            e.preventDefault();

            $.post('api/cliente/update.php', { idcliente: $('#idcliente_edit').val(), cliente: $('#cliente_edit').val(), solicitante_original: $('#solicitante_select_original').val(), solicitante: $('#solicitante_select_edit').val(), rand: Math.random()}, function(data) {
                $('.btn-edit-cliente').html('<img src="dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                switch(data) {
                case 'true':
                    Toast.fire({icon: 'success',title: 'Cliente editado.'}).then((result) => {
                        window.setTimeout("location.href='cliente'", delay);
                    });
                    break;

                default:
                    Toast.fire({icon: 'error',title: data});
                    break;
                }

                $('.btn-edit-cliente').html('Salvar').fadeTo(fade, 1);
            });

            return false;
        });
    });
</script>