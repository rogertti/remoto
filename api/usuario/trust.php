<?php
    // include database and object files
    require_once '../../appConfig.php';
    include_once '../config/database.php';
    include_once '../objects/usuario.php';

        //encrypt password by openssl
        function encrypt($data, $key) {
            $len = strlen($key);
            
                if($len < 16) {
                    $key = str_repeat($key, ceil(16 / $len));
                    #if($m = strlen($data) % 8)
                    $m = strlen($data) % 8;
                    $data .= str_repeat("\x00",  8 - $m);
                    $val = openssl_encrypt($data, 'AES-256-OFB', $key, 0, $key);
                    $val = base64_encode($val);
                } else {
                    $val = '';
                }

            return $val;
        }
     
    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare usuario object
    $usuario = new Usuario($db);

    // vars to control this script
    $msg = "Campo obrigat&oacute;rio vazio.";
    $enigma = base64_encode('?');

        //filtering the inputs
        if(empty($_POST['rand'])) { die('Vari&aacute;vel de controle nula.'); }
        if(empty($_POST['usuario'])) { die($msg); } else {
            $filtro = 1;
            #$_POST['usuario'] = base64_decode($_POST['usuario']);
            $usuario->usuario = encrypt(base64_decode($_POST['usuario']), $enigma);
        }
        if(empty($_POST['senha'])) { die($msg); } else {
            $filtro++;
            #$_POST['senha'] = base64_decode($_POST['senha']);
            $usuario->senha = encrypt(base64_decode($_POST['senha']), $enigma);
        }

        if($filtro == 2) {
            // read the details of usuario to be edited
            $sql = $usuario->trust();

            if($sql->rowCount() > 0) {
                // get retrieved row
                $row = $sql->fetch(PDO::FETCH_OBJ);

                    if($row->monitor == 'F') {
                        die('Usu&aacute;rio desativado no sistema.');
                    } else {
                        $_SESSION['id'] = $row->idusuario;
                        $_SESSION['name'] = $row->nome;
                        $_SESSION['user'] = $row->usuario;
                        $_SESSION['key'] = $row->stamp;
                        echo'true';
                        
                            /*switch($row->tipo) {
                                case 'A': echo'admin'; break;
                                case 'R': echo'root'; break;
                                case 'U': echo'user'; break;
                            }*/
                    }
            } else {
                $sql = $usuario->check();

                    if($sql->rowCount() == 0) {
                        rename('appInstallDone.php','appInstall.php');
                        echo'reload';
                    } else {
                        echo'Login inv&aacute;lido.';
                    }
            }
        } else {
            die('Vari&aacute;vel de controle nula.');
        }
    
    unset($database,$db,$usuario,$msg,$enigma);
?>