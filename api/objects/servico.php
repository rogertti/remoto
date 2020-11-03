<?php
    class Servico {
        // database connection and table name
        private $conn;
     
        // object properties
        public $idservico;
        public $idsolicitante;
        public $ticket;
        public $idsituacao;
        public $datado;
        public $inicio;
        public $fim;
        public $assunto;
        public $solicitacao;
        public $procedimento;
        public $monitor;
     
        // constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        function serviceInsertExist() {
            $sql = $this->conn->prepare("SELECT idservico FROM servico WHERE ticket = :ticket");
            $sql->bindParam(':ticket', $this->ticket, PDO::PARAM_STR);
            $sql->execute();

                if($sql->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }

            return $sql;
        }

        // read all situation records
        function readAllStatus() {
            $this->monitor = 'T';

            $sql = $this->conn->prepare("SELECT idsituacao,descricao FROM situacao WHERE monitor = :monitor ORDER BY descricao");
            $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
            $sql->execute();

            return $sql;
        }

        // read all records
        function readAll($mes,$ano) {
            $this->idsituacao = 3;
            $this->datado = $ano.'-'.$mes.'%';
            $this->monitor = 'T';

            $sql = $this->conn->prepare("SELECT servico.idservico,cliente.nome AS cliente,solicitante.nome AS solicitante,situacao.descricao AS situacao,servico.datado,servico.hora_inicio,servico.hora_fim,servico.solicitacao FROM servico INNER JOIN situacao ON servico.situacao_idsituacao = situacao.idsituacao INNER JOIN solicitante ON servico.solicitante_idsolicitante = solicitante.idsolicitante INNER JOIN cliente ON solicitante.cliente_idcliente = cliente.idcliente WHERE servico.datado LIKE :datado AND servico.monitor = :monitor AND solicitante.monitor = :monitor AND cliente.monitor = :monitor AND servico.situacao_idsituacao <> :idsituacao ORDER BY servico.datado,servico.hora_inicio DESC");
            $sql->bindParam(':datado', $this->datado, PDO::PARAM_STR);
            $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
            $sql->bindParam(':idsituacao', $this->idsituacao, PDO::PARAM_INT);
            $sql->execute();

            return $sql;
        }

        // read all records
        function readSingle($idservico) {
            $this->monitor = 'T';

            $sql = $this->conn->prepare("SELECT idservico,solicitante_idsolicitante,situacao_idsituacao,ticket,datado,hora_inicio,hora_fim,assunto,solicitacao,procedimento FROM servico WHERE idservico = :idservico AND monitor = :monitor");
            $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
            $sql->bindParam(':idservico', $idservico, PDO::PARAM_INT);
            $sql->execute();

            return $sql;
        }

        function readAllClient($idsolicitante) {
            #$this->monitor = 'T';

            $sql = $this->conn->prepare("SELECT servico.idservico,situacao.descricao AS situacao,servico.datado,servico.hora_inicio,servico.hora_fim,servico.solicitacao FROM servico INNER JOIN situacao ON servico.situacao_idsituacao = situacao.idsituacao INNER JOIN solicitante ON servico.solicitante_idsolicitante = solicitante.idsolicitante INNER JOIN cliente ON solicitante.cliente_idcliente = cliente.idcliente WHERE solicitante.idsolicitante = :idsolicitante ORDER BY servico.datado,servico.hora_inicio DESC");
            #$sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
            $sql->bindParam(':idsolicitante', $idsolicitante, PDO::PARAM_INT);
            $sql->execute();

            return $sql;
        }

        function search($keyword) {
            #$this->monitor = 'T';

            $sql = $this->conn->prepare("SELECT servico.idservico,cliente.nome AS cliente,solicitante.nome AS solicitante,situacao.descricao AS situacao,servico.ticket,servico.datado,servico.hora_inicio,servico.hora_fim,servico.assunto,servico.solicitacao,servico.procedimento,servico.monitor FROM servico INNER JOIN situacao ON servico.situacao_idsituacao = situacao.idsituacao INNER JOIN solicitante ON servico.solicitante_idsolicitante = solicitante.idsolicitante INNER JOIN cliente ON solicitante.cliente_idcliente = cliente.idcliente WHERE (servico.ticket LIKE :keyword) OR (servico.assunto LIKE :keyword) OR (solicitacao LIKE :keyword) OR (procedimento LIKE :keyword) ORDER BY servico.datado DESC, servico.hora_inicio DESC, situacao.descricao");
            $sql->bindParam(':keyword', $keyword, PDO::PARAM_STR);
            #$sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
            $sql->execute();

            return $sql;
        }

        function searchForClient($keyword) {
            #$this->monitor = 'T';

            $sql = $this->conn->prepare("SELECT cliente.nome AS cliente,solicitante.idsolicitante,solicitante.nome AS solicitante,COUNT(servico.ticket) AS ticket FROM solicitante INNER JOIN cliente ON solicitante.cliente_idcliente = cliente.idcliente INNER JOIN servico ON servico.solicitante_idsolicitante = solicitante.idsolicitante WHERE (cliente.nome LIKE :keyword) OR (solicitante.nome LIKE :keyword) GROUP BY solicitante.idsolicitante ORDER BY cliente.nome,solicitante.nome");
            $sql->bindParam(':keyword', $keyword, PDO::PARAM_STR);
            #$sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
            $sql->execute();

            return $sql;
        }

        function searchByDate($keyword) {
            #$this->monitor = 'T';

            $sql = $this->conn->prepare("SELECT servico.idservico,cliente.nome AS cliente,solicitante.nome AS solicitante,situacao.descricao AS situacao,servico.ticket,servico.datado,servico.hora_inicio,servico.hora_fim,servico.assunto,servico.solicitacao,servico.procedimento,servico.monitor FROM servico INNER JOIN situacao ON servico.situacao_idsituacao = situacao.idsituacao INNER JOIN solicitante ON servico.solicitante_idsolicitante = solicitante.idsolicitante INNER JOIN cliente ON solicitante.cliente_idcliente = cliente.idcliente WHERE servico.datado = :datado ORDER BY servico.datado DESC, servico.hora_inicio DESC, situacao.descricao");
            $sql->bindParam(':datado', $keyword, PDO::PARAM_STR);
            #$sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
            $sql->execute();

            return $sql;
        }

        // insert service
        function insert() {
            if($this->serviceInsertExist()) {
                die('Esse servi&ccedil;o j&aacute; est&aacute; cadastrado.');
            } else {
                $this->monitor = 'T';

                $sql = $this->conn->prepare("INSERT INTO servico (solicitante_idsolicitante,situacao_idsituacao,ticket,datado,hora_inicio,assunto,solicitacao,procedimento,monitor) VALUES (:idsolicitante,:idsituacao,:ticket,:datado,:inicio,:assunto,:solicitacao,:procedimento,:monitor)");
                $sql->bindParam(':idsolicitante', $this->idsolicitante, PDO::PARAM_INT);
                $sql->bindParam(':idsituacao', $this->idsituacao, PDO::PARAM_INT);
                $sql->bindParam(':ticket', $this->ticket, PDO::PARAM_STR);
                $sql->bindParam(':datado', $this->datado, PDO::PARAM_STR);
                $sql->bindParam(':inicio', $this->inicio, PDO::PARAM_STR);
                $sql->bindParam(':assunto', $this->assunto, PDO::PARAM_STR);
                $sql->bindParam(':solicitacao', $this->solicitacao, PDO::PARAM_STR);
                $sql->bindParam(':procedimento', $this->procedimento, PDO::PARAM_STR);
                $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
                $sql->execute();

                return $sql;
            }
        }

        // upate service
        function update() {
            $sql = $this->conn->prepare("UPDATE servico SET solicitante_idsolicitante = :idsolicitante,situacao_idsituacao = :idsituacao,hora_fim = :fim,assunto = :assunto,solicitacao = :solicitacao,procedimento = :procedimento WHERE idservico = :idservico");
            $sql->bindParam(':idsolicitante', $this->idsolicitante, PDO::PARAM_INT);
            $sql->bindParam(':idsituacao', $this->idsituacao, PDO::PARAM_INT);
            #$sql->bindParam(':ticket', $this->ticket, PDO::PARAM_STR);
            #$sql->bindParam(':datado', $this->datado, PDO::PARAM_STR);
            #$sql->bindParam(':inicio', $this->inicio, PDO::PARAM_STR);
            $sql->bindParam(':fim', $this->fim, PDO::PARAM_STR);
            $sql->bindParam(':assunto', $this->assunto, PDO::PARAM_STR);
            $sql->bindParam(':solicitacao', $this->solicitacao, PDO::PARAM_STR);
            $sql->bindParam(':procedimento', $this->procedimento, PDO::PARAM_STR);
            #$sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
            $sql->bindParam(':idservico', $this->idservico, PDO::PARAM_INT);
            $sql->execute();

            return $sql;
        }

        function delete() {
            $this->monitor = 'F';

            $sql = $this->conn->prepare("UPDATE servico SET monitor = :monitor WHERE idservico = :idservico");
            $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
            $sql->bindParam(':idservico', $this->idservico, PDO::PARAM_INT);
            $sql->execute();

            return $sql;
        }

        function recover() {
            $this->monitor = 'T';

            $sql = $this->conn->prepare("UPDATE servico SET monitor = :monitor WHERE idservico = :idservico");
            $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
            $sql->bindParam(':idservico', $this->idservico, PDO::PARAM_INT);
            $sql->execute();

            return $sql;
        }
    }
?>