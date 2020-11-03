<?php
    class Situacao {
        // database connection and table name
        private $conn;
        
        // object properties
        public $idsituacao;
        public $descricao;
        public $monitor;
        
        // constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // read all records
        function readAll() {
            $this->monitor = 'T';

            $sql = $this->conn->prepare("SELECT idsituacao,descricao FROM situacao WHERE monitor = :monitor ORDER BY descricao");
            $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
            $sql->execute();

            return $sql;
        }

        // read single record
        function readSingle($idsituacao) {
            $this->monitor = 'T';

            $sql = $this->conn->prepare("SELECT idsituacao,descricao FROM situacao WHERE idsituacao = :idsituacao AND monitor = :monitor");
            $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
            $sql->bindParam(':idsituacao', $idsituacao, PDO::PARAM_INT);
            $sql->execute();

            return $sql;
        }

        function statusInsertExist() {
            $sql = $this->conn->prepare("SELECT idsituacao FROM situacao WHERE descricao = :descricao");
            $sql->bindParam(':descricao', $this->descricao, PDO::PARAM_STR);
            $sql->execute();

                if($sql->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }

            return $sql;
        }

        // insert status
        function insert() {
            if($this->statusInsertExist()) {
                die('Essa servi&ccedil;o j&aacute; est&aacute; cadastrada.');
            } else {
                $this->monitor = 'T';

                $sql = $this->conn->prepare("INSERT INTO situacao (descricao,monitor) VALUES (:descricao,:monitor)");
                $sql->bindParam(':descricao', $this->descricao, PDO::PARAM_STR);
                $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
                $sql->execute();

                return $sql;
            }
        }

        function statusUpdateExist() {
            $sql = $this->conn->prepare("SELECT idsituacao FROM situacao WHERE descricao = :descricao AND idsituacao <> :idsituacao");
            $sql->bindParam(':descricao', $this->descricao, PDO::PARAM_STR);
            $sql->bindParam(':idsituacao', $this->idsituacao, PDO::PARAM_INT);
            $sql->execute();

                if($sql->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }

            return $sql;
        }

        // update status
        function update() {
            if($this->statusUpdateExist()) {
                die('Essa servi&ccedil;o j&aacute; est&aacute; cadastrada.');
            } else {
                $sql = $this->conn->prepare("UPDATE situacao SET descricao = :descricao WHERE idsituacao = :idsituacao");
                $sql->bindParam(':descricao', $this->descricao, PDO::PARAM_STR);
                $sql->bindParam(':idsituacao', $this->idsituacao, PDO::PARAM_INT);
                $sql->execute();

                return $sql;
            }
        }

        // delete status
        function delete() {
            $this->monitor = 'F';

            $sql = $this->conn->prepare("UPDATE situacao SET monitor = :monitor WHERE idsituacao = :idsituacao");
            $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
            $sql->bindParam(':idsituacao', $this->idsituacao, PDO::PARAM_INT);
            $sql->execute();

            return $sql;
        }
    }
?>