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

    //GET variables
    $py_idsolicitante = md5('idsolicitante');
    $py_solicitante = md5('solicitante');
    $py_cliente = md5('cliente');
?>
<form class="form-edit-solicitante">
    <div class="modal-header">
        <h4 class="modal-title">
            <span>Editar solicitante</span>
            <span class="text-muted">
                <small>(<i class="fas fa-bell"></i> Campo obrigat&oacute;rio)</small>
            </span>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" id="idsolicitante_edit" value="<?php echo $_GET[''.$py_idsolicitante.'']; ?>">

        <div class="form-group">
            <label for="cliente_edit"><i class="fas fa-bell"></i> Cliente</label>
            <input type="text" name="cliente_edit" id="cliente_edit" value="<?php echo $_GET[''.$py_cliente.'']; ?>" maxlength="200" class="form-control" placeholder="Nome do solicitante" disabled>
        </div>

        <div class="form-group">
            <label for="solicitante_edit"><i class="fas fa-bell"></i> Solicitante</label>
            <input type="text" name="solicitante_edit" id="solicitante_edit" value="<?php echo $_GET[''.$py_solicitante.'']; ?>" maxlength="200" class="form-control" placeholder="Nome do solicitante" required>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary btn-edit-solicitante">Salvar</button>
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
        
        /* EDITAR SOLICITANTE */

        $('.form-edit-solicitante').submit(function(e) {
            e.preventDefault();

            $.post('api/cliente/solicitanteUpdate.php', { idsolicitante: $('#idsolicitante_edit').val(), solicitante: $('#solicitante_edit').val(), rand: Math.random()}, function(data) {
                $('.btn-edit-solicitante').html('<img src="dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                switch(data) {
                case 'true':
                    Toast.fire({icon: 'success',title: 'Solicitante editado.'}).then((result) => {
                        window.setTimeout("location.href='cliente'", delay);
                    });
                    break;

                default:
                    Toast.fire({icon: 'error',title: data});
                    break;
                }

                $('.btn-edit-solicitante').html('Salvar').fadeTo(fade, 1);
            });

            return false;
        });
    });
</script>