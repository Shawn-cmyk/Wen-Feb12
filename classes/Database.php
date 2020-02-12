<?php
//inside classes Folder cuz it's classs
class Database
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "accumulator";
    public $conn;

    // constrator - that is a method that is automatically created when an object is created

    //check the connection
    public function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connectiion error:" . $this->conn->connect_error);
        }

        return $this->conn;
    }
}
