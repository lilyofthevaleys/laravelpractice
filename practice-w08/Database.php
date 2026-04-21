<?php
class Database {
    private $host = "127.0.0.1";
    private $username = "root";
    private $password = "";
    private $database = "bookstore";
    private $port = 3306;
    private $conn;

    public function connect() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database, $this->port);
        
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        
        return $this->conn;
    }

    public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
