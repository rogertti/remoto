<?php
    /* CLEAR CACHE */
    
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    //header("Content-Type: application/xml; charset=utf-8");

    require_once 'appConfig.php';
    include_once 'api/config/database.php';
    include_once 'api/objects/situacao.php';

        if(empty($_SESSION['key'])) {
            header ('location:./');
        }
    
    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare objects
    $situacao = new Situacao($db);

    // GET variables
    $py_idsituacao = md5('idsituacao');

    $sql = $situacao->readSingle($_GET[''.$py_idsituacao.'']);

        if($sql->rowCount() > 0) {
            #while($row = $sql->fetch(PDO::FETCH_OBJ)) {}
            $row = $sql->fetch(PDO::FETCH_OBJ);
?>
<form class="form-edit-situacao">
    <div class="modal-header">
        <h4 class="modal-title">
            <span>Editar situa&ccedil;&atilde;o</span>
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
        <input type="hidden" name="idsituacao" id="idsituacao" value="<?php echo $_GET[''.$py_idsituacao.'']; ?>">

        <div class="form-group">
            <label for="descricao"><i class="fas fa-bell"></i> Descri&ccedil;&atilde;o</label>
            <input type="text" name="descricao" id="descricao_edit" maxlength="100" value="<?php echo $row->descricao; ?>" class="form-control" placeholder="Descri&ccedil;&atilde;o da situa&ccedil;&atilde;o" required>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary btn-edit-situacao">Salvar</button>
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
        
        /* EDITAR SITUAÇÂO */

        $('.form-edit-situacao').submit(function(e) {
            e.preventDefault();

            $.post('api/situacao/update.php', $(this).serialize(), function(data) {
                $('.btn-edit-situacao').html('<img src="dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                switch(data) {
                case 'true':
                    Toast.fire({icon: 'success',title: 'Situa&ccedil;&atilde;o editada.'}).then((result) => {
                        window.setTimeout("location.href='situacao'", delay);
                    });
                    break;

                default:
                    Toast.fire({icon: 'error',title: data});
                    break;
                }

                $('.btn-edit-situacao').html('Salvar').fadeTo(fade, 1);
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
                <p>A situa&ccedil;&atilde;o não foi encontrada.</p>
            </blockquote>';
        }
?>