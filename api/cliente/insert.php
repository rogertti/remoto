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
        if(empty($_POST['cliente'])) { die($msg); } else {
            $filtro = 1;
            $_POST['cliente'] = str_replace("'","&#39;",$_POST['cliente']);
            $_POST['cliente'] = str_replace('"','&#34;',$_POST['cliente']);
            $_POST['cliente'] = str_replace('%','&#37;',$_POST['cliente']);
            $cliente->nome = ucwords($_POST['cliente']);
        }
        if(empty($_POST['solicitante'])) { die($msg); } else {
            $filtro++;
            $cliente->solicitante = $_POST['solicitante'];
        }

        if($filtro == 2) {
            if($cliente->insert()) {
                echo'true';
            } else {
                die(var_dump($db->errorInfo()));
            }
        } else {
            die('Vari&aacute;vel de controle nula.');
        }

    unset($database,$db,$cliente,$msg);
?>