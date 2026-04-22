<?php

class Note {
    private $conn;
    private $table = "notes";

    public function __construct($db) {
        $this->conn = $db;
    }

    // READ
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // CREATE
    public function create($content) {
        $query = "INSERT INTO " . $this->table . " (title, content) VALUES ('Note', :content)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':content', $content);

        return $stmt->execute();
    }

    // DELETE
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
    
    public function update($id, $content) {
    $query = "UPDATE " . $this->table . " SET content = :content WHERE id = :id";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':id', $id);

    return $stmt->execute();
}
}
