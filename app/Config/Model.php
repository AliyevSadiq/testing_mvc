<?php

class Model
{
    protected string $table;

    protected $connection;

    public function __construct()
    {
        $this->connection = new PDO("mysql:host=localhost;dbname=testing_mvc", "dbadmin", "dbadmin!1");
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function find($id)
    {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $safeData = array_map('htmlspecialchars', $data);

        $columns = implode(', ', array_keys($safeData));
        $values = implode(', ', array_fill(0, count($safeData), '?'));

        $query = "INSERT INTO $this->table ($columns) VALUES ($values)";
        $statement = $this->connection->prepare($query);
        $statement->execute(array_values($safeData));

        return $this->connection->lastInsertId();
    }

}
