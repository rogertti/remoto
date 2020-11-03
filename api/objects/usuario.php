<?php
    class Usuario {
        // database connection and table name
        private $conn;
        
        // object properties
        public $idusuario;
        public $nome;
        public $usuario;
        public $senha;
        public $email;
        public $monitor;
        
        // constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // validate login data
        function trust() {
            $sql = $this->conn->prepare("SELECT idusuario,nome,usuario,senha,email,monitor,stamp FROM usuario WHERE usuario = :usuario AND senha = :senha");
            $sql->bindParam(':usuario', $this->usuario, PDO::PARAM_STR);
            $sql->bindParam(':senha', $this->senha, PDO::PARAM_STR);
            $sql->execute();

            return $sql;
        }

        // check for records on table usuario
        function check() {
            $sql = $this->conn->prepare("SELECT idusuario FROM usuario");
            $sql->execute();

            return $sql;
        }

        // truncate table usuario e situacao
        function truncate() {
            $sql = $this->conn->prepare("TRUNCATE TABLE situacao");
            $sql->execute();
            $sql = $this->conn->prepare("TRUNCATE TABLE usuario");
            $sql->execute();

            return $sql;
        }

        // check by same record on database
        function userInsertExist() {
            $sql = $this->conn->prepare("SELECT idusuario FROM usuario WHERE email = :email");
            $sql->bindParam(':email', $this->email, PDO::PARAM_STR);
            $sql->execute();

                if($sql->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }

            return $sql;
        }

        // install the first user
        function install() {
            if($this->userInsertExist()) {
                die('Esse email j&aacute; est&aacute; cadastrado.');
                #return false;
            } else {
                $this->monitor = 'T';

                // cadastra o usuário

                $sql = $this->conn->prepare("INSERT INTO usuario (nome,usuario,senha,email,monitor) VALUES (:nome,:usuario,:senha,:email,:monitor)");
                $sql->bindParam(':nome', $this->nome, PDO::PARAM_STR);
                $sql->bindParam(':usuario', $this->usuario, PDO::PARAM_STR);
                $sql->bindParam(':senha', $this->senha, PDO::PARAM_STR);
                $sql->bindParam(':email', $this->email, PDO::PARAM_STR);
                $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
                $sql->execute();
                $sql->closeCursor();

                $descricao1 = 'Aberta';
                $descricao2 = 'Pendente';
                $descricao3 = 'Finalizada';

                // cadastra os 3 tipos de situação mais comuns
                $sql = $this->conn->prepare("INSERT INTO situacao (descricao,monitor) VALUES (:descricao1,:monitor), (:descricao2,:monitor), (:descricao3,:monitor)");
                $sql->bindParam(':descricao1', $descricao1, PDO::PARAM_STR);
                $sql->bindParam(':descricao2', $descricao2, PDO::PARAM_STR);
                $sql->bindParam(':descricao3', $descricao3, PDO::PARAM_STR);
                $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
                $sql->execute();

                return $sql;
            }
        }

        // read all records
        function readAll() {
            $this->monitor = 'T';

            $sql = $this->conn->prepare("SELECT idusuario,nome,usuario,senha,email FROM usuario WHERE monitor = :monitor ORDER BY nome,usuario");
            $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
            $sql->execute();

            return $sql;
        }

        // read single record
        function readSingle($idusuario) {
            $this->monitor = 'T';

            $sql = $this->conn->prepare("SELECT idusuario,nome,usuario,senha,email FROM usuario WHERE idusuario = :idusuario AND monitor = :monitor");
            $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
            $sql->bindParam(':idusuario', $idusuario, PDO::PARAM_INT);
            $sql->execute();

            return $sql;
        }

        // insert status
        function insert() {
            if($this->userInsertExist()) {
                die('Esse email j&aacute; est&aacute; cadastrado.');
            } else {
                $this->monitor = 'T';

                $sql = $this->conn->prepare("INSERT INTO usuario (nome,usuario,senha,email,monitor) VALUES (:nome,:usuario,:senha,:email,:monitor)");
                $sql->bindParam(':nome', $this->nome, PDO::PARAM_STR);
                $sql->bindParam(':usuario', $this->usuario, PDO::PARAM_STR);
                $sql->bindParam(':senha', $this->senha, PDO::PARAM_STR);
                $sql->bindParam(':email', $this->email, PDO::PARAM_STR);
                $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
                $sql->execute();

                return $sql;
            }
        }

        function userUpdateExist() {
            $sql = $this->conn->prepare("SELECT idusuario FROM usuario WHERE email = :email AND idusuario <> :idusuario");
            $sql->bindParam(':email', $this->email, PDO::PARAM_STR);
            $sql->bindParam(':idusuario', $this->idusuario, PDO::PARAM_INT);
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
            if($this->userUpdateExist()) {
                die('Essa usu&aacute;rio j&aacute; est&aacute; cadastrado.');
            } else {
                $sql = $this->conn->prepare("UPDATE usuario SET nome = :nome, usuario = :usuario, senha = :senha, email = :email WHERE idusuario = :idusuario");
                $sql->bindParam(':nome', $this->nome, PDO::PARAM_STR);
                $sql->bindParam(':usuario', $this->usuario, PDO::PARAM_STR);
                $sql->bindParam(':senha', $this->senha, PDO::PARAM_STR);
                $sql->bindParam(':email', $this->email, PDO::PARAM_STR);
                $sql->bindParam(':idusuario', $this->idusuario, PDO::PARAM_INT);
                $sql->execute();

                return $sql;
            }
        }

        // delete status
        function delete() {
            $this->monitor = 'F';

            $sql = $this->conn->prepare("UPDATE usuario SET monitor = :monitor WHERE idusuario = :idusuario");
            $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_STR);
            $sql->bindParam(':idusuario', $this->idusuario, PDO::PARAM_INT);
            $sql->execute();

            return $sql;
        }
    }
?>