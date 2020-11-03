<?php
    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/usuario.php';

    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare service object
    $usuario = new Usuario($db);
    $py_idusuario = md5('idusuario');
    $usuario->idusuario = $_GET[''.$py_idusuario.''];

        if($usuario->delete()) {
            $sql = $usuario->check();

                if($sql->rowCount() == 0) {
                    $usuario->truncate();
                    rename('appInstallDone.php','appInstall.php');
                    echo'reload';
                } else {
                    echo'true';
                }
        } else {
            die(var_dump($db->errorInfo()));
        }
   
    unset($database,$db,$usuario,$py_idusuario);
?>