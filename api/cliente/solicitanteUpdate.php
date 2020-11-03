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
        if(empty($_POST['idsolicitante'])) { die('Vari&aacute;vel de controle nula.'); } else {
            $filtro = 1;
            $cliente->idsolicitante = $_POST['idsolicitante'];
        }
        if(empty($_POST['solicitante'])) { die($msg); } else {
            $filtro++;
            $_POST['solicitante'] = str_replace("'","&#39;",$_POST['solicitante']);
            $_POST['solicitante'] = str_replace('"','&#34;',$_POST['solicitante']);
            $_POST['solicitante'] = str_replace('%','&#37;',$_POST['solicitante']);
            $cliente->solicitante = $_POST['solicitante'];
        }
        

        if($filtro == 2) {
            if($cliente->requesterUpdate()) {
                echo'true';
            } else {
                die(var_dump($db->errorInfo()));
            }
        } else {
            die('Vari&aacute;vel de controle nula.');
        }

    unset($database,$db,$cliente,$msg);
?>