<?php
    // configure php
    #ini_set('display_errors', 'off');

    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/servico.php';
     
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
     
    // prepare doctor object
    $servico = new Servico($db);

    // manipuling keyword
    $dia = substr($_GET['search_keyword'], 0, 2);
    $mes = substr($_GET['search_keyword'], 3, 2);
    $ano = substr($_GET['search_keyword'], 6);

        // check search
        if((is_numeric($dia)) AND (is_numeric($mes)) AND (is_numeric($ano))) {
            if(checkdate($mes, $dia, $ano)) {
                $search_type = 'date';
                $sql = $servico->searchByDate($ano.'-'.$mes.'-'.$dia);
            }
        } elseif(strstr($_GET['search_keyword'], '#')) {
            $search_type = 'client';

            // replace special characters
            $_GET['search_keyword'] = str_replace("'", "&#39;", $_GET['search_keyword']);
            $_GET['search_keyword'] = str_replace('"', '&#34;', $_GET['search_keyword']);
            $_GET['search_keyword'] = str_replace('%', '&#37;', $_GET['search_keyword']);

            // remove hashtag
            $_GET['search_keyword'] = substr($_GET['search_keyword'], 1);

            $sql = $servico->searchForClient('%'.$_GET['search_keyword'].'%');
        } else {
            $search_type = 'common';

            // replace special characters
            $_GET['search_keyword'] = str_replace("'", "&#39;", $_GET['search_keyword']);
            $_GET['search_keyword'] = str_replace('"', '&#34;', $_GET['search_keyword']);
            $_GET['search_keyword'] = str_replace('%', '&#37;', $_GET['search_keyword']);

            $sql = $servico->search('%'.$_GET['search_keyword'].'%');
        }
    
        if(!empty($search_type)) {
            if($search_type != 'client') {
                // check if more than 0 record found
                if($sql->rowCount() > 0) {
                        if($sql->rowCount() > 1) {
                            echo'
                            <h3 class="text-center">'.$sql->rowCount().' registros encontrados</h3>
                            <hr><div class="row row-search-data">';
                        } else {
                            echo'
                            <h3 class="text-center">'.$sql->rowCount().' registro encontrado</h3>
                            <hr><div class="row row-search-data">';
                        }

                        while($row = $sql->fetch(PDO::FETCH_OBJ)) {
                            // format status
                            switch($row->situacao) {
                                case 'Aberta': $row->situacao = '<span class="bg bg-info">'.$row->situacao.'</span>'; break;
                                case 'Finalizada': $row->situacao = '<span class="bg bg-success">'.$row->situacao.'</span>'; break;
                                case 'Pendente': $row->situacao = '<span class="bg bg-warning">'.$row->situacao.'</span>'; break;
                                default: $row->situacao = '<span class="bg bg-secondary">'.$row->situacao.'</span>'; break;
                            }

                            // format monitor
                            switch($row->monitor) {
                                case 'T':
                                    $row->monitor = '
                                    <span class="bg bg-warning"><a class="fas fa-pen a-edit-servico" href="servicoEdit.php?740b5bc9996b9dee9d3ab266ef54722c='.$row->idservico.'" title="Editar solicita&ccedil;&atilde;o"></a></span>
                                    <span class="bg bg-danger"><a class="fas fa-trash a-delete-servico" id="740b5bc9996b9dee9d3ab266ef54722c-'.$row->idservico.'" href="#" title="Excluir solicita&ccedil;&atilde;o"></a></span>';
                                    break;
                                case 'F':
                                    $row->monitor = '
                                    <span class="bg bg-warning"><a class="fas fa-pen a-edit-servico" href="servicoEdit.php?740b5bc9996b9dee9d3ab266ef54722c='.$row->idservico.'" title="Editar solicita&ccedil;&atilde;o"></a></span>
                                    <span class="bg bg-purple"><a class="fas fa-redo-alt a-recover-servico" id="740b5bc9996b9dee9d3ab266ef54722c-'.$row->idservico.'" href="#" title="Recuperar solicita&ccedil;&atilde;o"></a></span>';
                                    break;
                            }

                            // format date
                            $ano = substr($row->datado,0,4);
                            $mes = substr($row->datado,5,2);
                            $dia = substr($row->datado,8);
                            $row->datado = $dia."/".$mes."/".$ano;

                            // format time
                            $row->hora_inicio = substr($row->hora_inicio, 0, 5);
                            !empty($row->hora_fim) ? $row->hora_fim = substr($row->hora_fim, 0, 5).'h' : $row->hora_fim = '--:--';

                            echo'
                            <div class="col-6 col-search-data">
                                <p>                        
                                    <span class="bg bg-olive"><strong><i class="fas fa-tag"></i> '.$row->ticket.'</strong></span>
                                    '.$row->situacao.'
                                    '.$row->monitor.'
                                </p>
                                <h6>'.$row->cliente.' : '.$row->solicitante.'</h6>
                                <h6>'.$row->datado.' : '.$row->hora_inicio.'h &#149; '.$row->hora_fim.'</h6>
                                <h6>Assunto: '.$row->assunto.'</h6>
                                <h6>Solicita&ccedil;&atilde;o: '.$row->solicitacao.'</h6>
                                <h6>Procedimento: '.$row->procedimento.'</h6>
                            </div>';
                        }

                    echo"
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

                            $('p span a').tooltip({boundary: 'window'});

                            /* MODAL */

                            $('.row-search-data').on('click', '.a-edit-servico', function(e) {
                                e.preventDefault();
                                $('#modal-edit-servico').modal('show').find('.modal-content').load($(this).attr('href'));
                            });

                            /* DELETE SERVIÇO */

                            $('.row-search-data').on('click', '.a-delete-servico', function(e) {
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

                            /* RECOVER SERVIÇO */

                            $('.row-search-data').on('click', '.a-recover-servico', function(e) {
                                e.preventDefault();
                                
                                let click = this.id.split('-'),
                                    py = click[0],
                                    id = click[1];
                                
                                Swal.fire({
                                    icon: 'question',
                                    title: 'Recuperar a solicita&ccedil;&atilde;o',
                                    showCancelButton: true,
                                    confirmButtonText: 'Sim',
                                    cancelButtonText: 'Não',
                                }).then((result) => {
                                    if(result.value == true) {
                                        $.ajax({
                                            type: 'GET',
                                            url: 'api/servico/recover.php?' + py + '=' + id,
                                            dataType: 'json',
                                            cache: false,
                                            error: function(result) {
                                                Swal.fire({icon: 'error',html: result.responseText,showConfirmButton: false});
                                            },
                                            success: function(data) {
                                                if(data == true) {
                                                    Toast.fire({icon: 'success',title: 'Solicita&ccedil;&atilde;o recuperada.'}).then((result) => {
                                                        window.setTimeout(location.href='inicio', delay);
                                                    });
                                                }
                                            }
                                        });
                                    }
                                });
                            });
                        });
                    </script>";
                } else {
                    echo'
                    <blockquote class="blockquote-data">
                        <h5>Nada encontrado</h5>
                        <p>Nenhum registro encontrado.</p>
                    </blockquote>';
                }
            } else {
                // check if more than 0 record found
                if($sql->rowCount() > 0) {
                        if($sql->rowCount() > 1) {                        
                            echo'
                            <h3 class="text-center">'.$sql->rowCount().' registros encontrados</h3>
                            <hr><div class="row row-search-data">';
                        } else {
                            echo'
                            <h3 class="text-center">'.$sql->rowCount().' registro encontrado</h3>
                            <hr><div class="row row-search-data">';
                        }

                        while($row = $sql->fetch(PDO::FETCH_OBJ)) {
                            $url_solicitante = 'solicitanteServicoView.php?a517e3878bd46c123429f28a9401dbae='.$row->idsolicitante.'&98d67645f4e06add08ee1dccd2c79148='.urlencode($row->solicitante).'&4983a0ab83ed86e0e7213c8783940193='.urlencode($row->cliente).'';

                                if($row->ticket > 1) {
                                    $row->ticket = '
                                    <span class="bg bg-olive"><strong><i class="fas fa-tag"></i> Ticket(s): '.$row->ticket.'</strong></span>
                                    <span class="bg bg-info"><a class="fas fa-eye a-view-servico" href="'.$url_solicitante.'" title="Visualizar solicita&ccedil;&otilde;es"></a></span>';
                                } else {
                                    $row->ticket = '
                                    <span class="bg bg-olive"><strong><i class="fas fa-tag"></i> Ticket: '.$row->ticket.'</strong></span>
                                    <span class="bg bg-info"><a class="fas fa-eye a-view-servico" href="'.$url_solicitante.'" title="Visualizar solicita&ccedil;&atilde;o"></a></span>';
                                }

                            echo'
                            <div class="col-6 col-search-data">
                                <h6>Cliente: '.$row->cliente.'</h6>
                                <h6>Solicitante: '.$row->solicitante.'</h6>
                                <p>'.$row->ticket.'</p>
                            </div>';
                        }

                    echo"
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

                            $('p span a').tooltip({boundary: 'window'});

                            /* MODAL */

                            $('.row-search-data').on('click', '.a-view-servico', function(e) {
                                e.preventDefault();
                                $('#modal-view-servico').modal('show').find('.modal-content').load($(this).attr('href'));
                            });
                        });
                    </script>";
                } else {
                    echo'
                    <blockquote class="blockquote-data">
                        <h5>Nada encontrado</h5>
                        <p>Nenhum registro encontrado.</p>
                    </blockquote>';
                }
            }
        } else {
            echo'
            <blockquote class="blockquote-data">
                <h5>Nada encontrado</h5>
                <p>Nenhum registro encontrado.</p>
            </blockquote>';
        }
?>