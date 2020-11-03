<?php
    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/servico.php';
     
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
     
    // prepare doctor object
    $servico = new Servico($db);
    
    // datepicker control
    $getmes = md5('mes');
    $getano = md5('ano');

    // query servico
    $sql = $servico->readAll($_GET[''.$getmes.''],$_GET[''.$getano.'']);
    
        // check if more than 0 record found
        if($sql->rowCount() > 0) {
            // servico array
            #$servico_arr = array();
            $servico_arr['servico'] = array();
        
                while($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                    // format date
                    $ano = substr($datado,0,4);
                    $mes = substr($datado,5,2);
                    $dia = substr($datado,8);
                    $datado = $dia."/".$mes."/".$ano;

                    // format time
                    $hora_inicio = substr($hora_inicio, 0, 5).'h';
                    !empty($hora_fim) ? $hora_fim = substr($hora_fim, 0, 5).'h' : $hora_fim = '--:--';

                    $servico_item = array(
                        'status' => true,
                        'idservico' => $idservico,
                        'cliente' => $cliente,
                        'solicitante' => $solicitante,
                        'situacao' => $situacao,
                        'datado' => $datado,
                        'inicio' => $hora_inicio,
                        'fim' => $hora_fim,
                        'solicitacao' => $solicitacao
                    );

                    array_push($servico_arr['servico'], $servico_item);
                }
        
            echo json_encode($servico_arr['servico']);
        } else {
            $servico_arr = array('status' => false);
            echo json_encode($servico_arr);
        }
?>