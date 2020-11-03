<?php
    class Cliente {
        // database connection and table name
        private $conn;
     
        // object properties
        public $idcliente;
        public $nome;
        public $cliente;
        public $idsolicitante;
        public $solicitante;
        public $solicitante_original;
        public $monitor;
     
        // constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // check by same record on database
        function clientInsertExist() {
            $nome_capitalize = ucfirst($this->nome);

            $sql = $this->conn->prepare("SELECT idcliente FROM cliente WHERE nome = :nome");
            $sql->bindParam(':nome', $nome_capitalize, PDO::PARAM_STR);
            $sql->execute();

                if($sql->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }

            return $sql;
        }

        // check by same record on database
        function clientUpdateExist() {
            $nome_capitalize = ucfirst($this->nome);

            $sql = $this->conn->prepare("SELECT idcliente FROM cliente WHERE nome = :nome AND idcliente <> :idcliente");
            $sql->bindParam(':nome', $nome_capitalize, PDO::PARAM_STR);
            $sql->bindParam(':idcliente', $this->idcliente, PDO::PARAM_INT);
            $sql->execute();

                if($sql->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }

            return $sql;
        }

        // check by same record on database
        function requesterInsertExist() {
            $nome_capitalize = ucfirst($this->nome);

            $sql = $this->conn->prepare("SELECT idsolicitante FROM solicitante WHERE nome = :nome AND cliente_idcliente = :idcliente");
            $sql->bindParam(':nome', $nome_capitalize, PDO::PARAM_STR);
            $sql->bindParam(':idcliente', $this->idcliente, PDO::PARAM_INT);
            $sql->execute();

                if($sql->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }

            return $sql;
        }

        // check by same record on database
        function requesterUpdateExist() {
            $nome_capitalize = ucfirst($this->solicitante);

            $sql = $this->conn->prepare("SELECT idsolicitante FROM solicitante WHERE nome = :nome AND idsolicitante <> :idsolicitante");
            $sql->bindParam(':nome', $nome_capitalize, PDO::PARAM_STR);
            $sql->bindParam(':idsolicitante', $this->idsolicitante, PDO::PARAM_INT);
            $sql->execute();

                if($sql->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }

            return $sql;
        }

        // read all records
        function readAll() {
            $this->monitor = 'T';

            $sql = $this->conn->prepare("SELECT cliente.idcliente,cliente.nome AS cliente,solicitante.idsolicitante,solicitante.nome AS solicitante FROM cliente INNER JOIN solicitante ON solicitante.cliente_idcliente = cliente.idcliente WHERE cliente.monitor = :monitor AND solicitante.monitor = :monitor ORDER BY cliente.nome,solicitante.nome");
            $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
            $sql->execute();

            return $sql;
        }

        // insert client
        function insert() {
            if($this->clientInsertExist()) {
                die('Esse cliente j&aacute; est&aacute; cadastrado.');
            } else {
                $this->monitor = 'T';
                #$this->nome = ucfirst($this->nome);

                $sql = $this->conn->prepare("INSERT INTO cliente (nome,monitor) VALUES (:nome,:monitor)");
                $sql->bindParam(':nome', $this->nome, PDO::PARAM_STR);
                $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
                #$sql->execute();

                    if($sql->execute()) {
                        $this->idcliente = $this->conn->lastInsertId();
                        $solicitantes = explode(',', $this->solicitante);
                        $count_solicitantes = count($solicitantes);
                        $count = 0;
                        
                            foreach($solicitantes as $solicitante) {
                                $solicitante = ucfirst($solicitante);
                                $sql = $this->conn->prepare("INSERT INTO solicitante (cliente_idcliente,nome,monitor) VALUES (:idcliente,:nome,:monitor)");
                                $sql->bindParam(':idcliente', $this->idcliente, PDO::PARAM_INT);
                                $sql->bindParam(':nome', $solicitante, PDO::PARAM_STR);
                                $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
                                
                                    if($sql->execute()) {
                                        $count++;
                                    }
                            }

                            if($count_solicitantes == $count) {
                                return $sql;
                            }
                    }

                #return $sql;
            }
        }

        // update client
        function update() {
            if($this->clientUpdateExist()) {
                die('Esse cliente j&aacute; est&aacute; cadastrado.');
            } else {
                $this->nome = ucfirst($this->nome);

                $sql = $this->conn->prepare("UPDATE cliente SET nome = :nome WHERE idcliente = :idcliente");
                $sql->bindParam(':nome', $this->nome, PDO::PARAM_STR);
                $sql->bindParam(':idcliente', $this->idcliente, PDO::PARAM_INT);
                $sql->execute();

                return $sql;
            }
        }

        // delete client
        function delete() {
            $this->monitor = 'F';

            $sql = $this->conn->prepare("UPDATE cliente SET monitor = :monitor WHERE idcliente = :idcliente");
            $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
            $sql->bindParam(':idcliente', $this->idcliente, PDO::PARAM_INT);
            $sql->execute();

            return $sql;
        }

        // select requesters linked with client
        function requesterLink($idcliente) {
            $this->monitor = 'T';

            $sql = $this->conn->prepare("SELECT idsolicitante,nome FROM solicitante WHERE cliente_idcliente = :idcliente AND monitor = :monitor");
            $sql->bindParam(':idcliente', $idcliente, PDO::PARAM_INT);
            $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
            $sql->execute();

            return $sql;
        }

        // delete requesters linked with client
        function requesterLinkDelete($idsolicitante) {
            $this->monitor = 'F';

            $sql = $this->conn->prepare("UPDATE solicitante SET monitor = :monitor WHERE idsolicitante = :idsolicitante");
            $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
            $sql->bindParam(':idsolicitante', $idsolicitante, PDO::PARAM_INT);
            $sql->execute();

            return $sql;
        }

        // insert requester
        function requesterInsert() {
            if($this->requesterInsertExist()) {
                die('Esse solicitante j&aacute; est&aacute; cadastrado.');
            } else {
                $this->solicitante = ucfirst($this->solicitante);
                $this->monitor = 'T';

                $sql = $this->conn->prepare("INSERT INTO solicitante (cliente_idcliente,nome,monitor) VALUES (:idcliente,:nome,:monitor)");
                $sql->bindParam(':idcliente', $this->idcliente, PDO::PARAM_INT);
                $sql->bindParam(':nome', $this->solicitante, PDO::PARAM_STR);
                $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
                $sql->execute();

                return $sql;
            }
        }

        // update requester
        function requesterUpdate() {
            if($this->requesterUpdateExist()) {
                die('Esse solicitante j&aacute; est&aacute; cadastrado.');
            } else {
                $this->solicitante = ucfirst($this->solicitante);

                $sql = $this->conn->prepare("UPDATE solicitante SET nome = :solicitante WHERE idsolicitante = :idsolicitante");
                $sql->bindParam(':solicitante', $this->solicitante, PDO::PARAM_STR);
                $sql->bindParam(':idsolicitante', $this->idsolicitante, PDO::PARAM_INT);
                $sql->execute();

                return $sql;
            }
        }

        // delete requester
        function requesterDelete() {
            $this->monitor = 'F';

            $sql = $this->conn->prepare("UPDATE solicitante SET monitor = :monitor WHERE idsolicitante = :idsolicitante");
            $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
            $sql->bindParam(':idsolicitante', $this->idsolicitante, PDO::PARAM_INT);
            $sql->execute();

            return $sql;
        }
    }
?>