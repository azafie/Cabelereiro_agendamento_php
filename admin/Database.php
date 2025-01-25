<?php

class Database {
    private $conn;
    private $servername = "localhost"; // Altere para o seu servidor
    private $username = "emerson"; // Altere para o seu usuário
    private $password = "41512212"; // Altere para a sua senha
    private $dbname = "salao"; // Altere para o nome do seu banco

    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Conexão falhou: " . $this->conn->connect_error);
        }
        $this->conn->set_charset("utf8"); // Define o charset para UTF-8
    }

    public function query($sql) {
        $result = $this->conn->query($sql);
        if (!$result) {
            die("Erro na query: " . $this->conn->error . " SQL: " . $sql); // Exibe o erro e o SQL para debug
        }
        return $result;
    }

    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        return $this->query($sql);
    }

    public function update($table, $data, $where) {
         $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = '$value'";
        }
        $set = implode(", ", $set);
        $sql = "UPDATE $table SET $set WHERE $where";
        return $this->query($sql);
    }


    public function delete($table, $where) {
        $sql = "DELETE FROM $table WHERE $where";
        return $this->query($sql);
    }

    public function select($table, $where = null, $columns = "*") {
        $sql = "SELECT $columns FROM $table";
        if ($where) {
            $sql .= " WHERE $where";
        }
        return $this->query($sql);
    }

      public function escape_string($string) {
        return $this->conn->real_escape_string($string);
    }

    public function close() {
        $this->conn->close();
    }
}
?>