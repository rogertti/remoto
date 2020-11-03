<?php
    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/cliente.php';

    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare client object
    $cliente = new Cliente($db);
    $py_idcliente = md5('idcliente');
    $cliente->idcliente = $_GET[''.$py_idcliente.''];

        if($cliente->delete()) {
            echo'true';
        } else {
            die(var_dump($db->errorInfo()));
        }
   
    unset($database,$db,$cliente,$py_idcliente);
?>