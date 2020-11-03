<?php
    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/situacao.php';

    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare service object
    $situacao = new Situacao($db);

    // vars to control this script
    $msg = "Campo obrigat&oacute;rio vazio.";

        //filtering the inputs
        if(empty($_POST['rand'])) { die('Vari&aacute;vel de controle nula.'); }
        if(empty($_POST['idsituacao'])) { die('Vari&aacute;vel de controle nula.'); } else {
            $situacao->idsituacao = $_POST['idsituacao'];
        }
        if(empty($_POST['descricao'])) { die($msg); } else {
            $filtro = 1;
            $_POST['descricao'] = str_replace("'","&#39;",$_POST['descricao']);
            $_POST['descricao'] = str_replace('"','&#34;',$_POST['descricao']);
            $_POST['descricao'] = str_replace('%','&#37;',$_POST['descricao']);
            $situacao->descricao = $_POST['descricao'];
        }
        
        if($filtro == 1) {
            if($situacao->update()) {
                echo'true';
            } else {
                die(var_dump($db->errorInfo()));
            }
        } else {
            die('Vari&aacute;vel de controle nula.');
        }

    unset($database,$db,$situacao,$msg);
?>