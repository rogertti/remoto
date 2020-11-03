<?php
    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/situacao.php';

    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare service object
    $situacao = new Situacao($db);
    $py_idsituacao = md5('idsituacao');
    $situacao->idsituacao = $_GET[''.$py_idsituacao.''];

        if($situacao->delete()) {
            echo'true';
        } else {
            die(var_dump($db->errorInfo()));
        }
   
    unset($database,$db,$situacao,$py_idsituacao);
?>