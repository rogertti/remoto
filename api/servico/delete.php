<?php
    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/servico.php';

    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare service object
    $servico = new Servico($db);
    $py_idservico = md5('idservico');
    $servico->idservico = $_GET[''.$py_idservico.''];

        if($servico->delete()) {
            echo'true';
        } else {
            die(var_dump($db->errorInfo()));
        }
   
    unset($database,$db,$servico,$py_idservico);
?>