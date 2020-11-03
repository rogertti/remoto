<?php
    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/cliente.php';

    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare client object
    $cliente = new Cliente($db);

    // vars to control this script
    $msg = "Campo obrigat&oacute;rio vazio.";

        //filtering the inputs
        if(empty($_POST['rand'])) { die('Vari&aacute;vel de controle nula.'); }
        if(empty($_POST['idcliente'])) { die('Vari&aacute;vel de controle nula.'); } else {
            $filtro = 1;
            $cliente->idcliente = $_POST['idcliente'];
        }
        if(empty($_POST['cliente'])) { die($msg); } else {
            $filtro++;
            $_POST['cliente'] = str_replace("'","&#39;",$_POST['cliente']);
            $_POST['cliente'] = str_replace('"','&#34;',$_POST['cliente']);
            $_POST['cliente'] = str_replace('%','&#37;',$_POST['cliente']);
            $cliente->nome = ucwords($_POST['cliente']);
        }
        if(empty($_POST['solicitante_original'])) { die('Vari&aacute;vel de controle nula.'); } else {
            $filtro++;
            #$cliente->solicitante_original = $_POST['solicitante_original'];
        }
        if(empty($_POST['solicitante'])) {
            $_POST['solicitante'] = $_POST['solicitante_original'];
        }

        if($filtro == 3) {
            // Será necessário uma comparação entre os solicitantes originais e os que estão no banco
            $solicitante_original = explode(',', $_POST['solicitante_original']);
            $solicitante_post = explode(',', $_POST['solicitante']);            
            $solicitantes = array_diff($solicitante_original, $solicitante_post);
            $count_solicitantes = count($solicitantes);

                // Se existir diferença, exclui os solicitantes que estão no banco
                if($count_solicitantes > 0) {
                    foreach($solicitantes as $solicitante => $idsolicitante) {
                        if(!$cliente->requesterLinkDelete($idsolicitante)) {
                            die(var_dump($db->errorInfo()));
                        }
                    }
                }

            // query all solicitantes from cliente
            $sql = $cliente->requesterLink($cliente->idcliente);

                if($sql->rowCount() > 0) {
                    // nova comparação com os solicitantes atualizados no banco
                    $row = $sql->fetchAll(PDO::FETCH_ASSOC);
                    $solicitante = array_column($row, 'idsolicitante');
                    $solicitantes = array_diff($solicitante_post, $solicitante);
                    $count_solicitantes = count($solicitantes);

                        if($count_solicitantes > 0) {
                            foreach($solicitantes as $solicitante => $idsolicitante) {
                                // se a diferença encontrada não for numérica, significa que é um novo solicitante
                                if(!is_numeric($idsolicitante)) {
                                    $cliente->solicitante = $idsolicitante;

                                        if(!$cliente->requesterInsert()) {
                                            die(var_dump($db->errorInfo()));
                                        }
                                }
                            }
                        }
                }

                if($cliente->update()) {
                    echo'true';
                } else {
                    die(var_dump($db->errorInfo()));
                }
        } else {
            die('Vari&aacute;vel de controle nula.');
        }

    unset($database,$db,$cliente,$msg,$filtro);
?>