<?php

class Database
{
    private string $servername;
    private int $port;
    private string $username;
    private string $password;
    private string $database;
    private ?mysqli $conn = null;

    public function __construct(
        string $servername = "127.0.0.1",
        int $port = 2233,
        string $username = "root",
        string $password = "",
        string $database = "bookstore_db"
    ) {
        $this->servername = $servername;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function connect(): mysqli
    {
        if ($this->conn === null) {
            $this->conn = new mysqli(
                $this->servername,
                $this->username,
                $this->password,
                $this->database,
                $this->port
            );

            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }

        return $this->conn;
    }

    public function connectWithoutDatabase(): mysqli
    {
        $conn = new mysqli(
            $this->servername,
            $this->username,
            $this->password,
            "",
            $this->port
        );

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

    public function close(): void
    {
        if ($this->conn !== null) {
            $this->conn->close();
            $this->conn = null;
        }
    }
}
