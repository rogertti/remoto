<?php
    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/situacao.php';
     
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
     
    // prepare object
    $situacao = new Situacao($db);
     
    // query situacao
    $sql = $situacao->readAll();
    
        // check if more than 0 record found
        if($sql->rowCount() > 0) {
            // situacao array
            #$situacao_arr = array();
            $situacao_arr['situacao'] = array();
        
                while($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                    $situacao_item = array(
                        'status' => true,
                        'idsituacao' => $idsituacao,
                        'descricao' => $descricao
                    );

                    array_push($situacao_arr['situacao'], $situacao_item);
                }
        
            echo json_encode($situacao_arr['situacao']);
        } else {
            $situacao_arr = array('status' => false);
            echo json_encode($situacao_arr);
        }
?>