<?php

class Note {
    private $conn;
    private $table = "notes";

    public function __construct($db) {
        $this->conn = $db;
    }

    // READ
    public function getAll($user_id) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE user_id = :user_id 
                  ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        return $stmt;
    }

    // CREATE
    public function create($content, $user_id) {
        $query = "INSERT INTO " . $this->table . " (title, content, user_id) 
                  VALUES ('Note', :content, :user_id)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':user_id', $user_id);

        return $stmt->execute();
    }

    // UPDATE
    public function update($id, $content, $user_id) {
        $query = "UPDATE " . $this->table . " 
                  SET content = :content 
                  WHERE id = :id AND user_id = :user_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $user_id);

        return $stmt->execute();
    }

    // DELETE
    public function delete($id, $user_id) {
        $query = "DELETE FROM " . $this->table . " 
                  WHERE id = :id AND user_id = :user_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $user_id);

        return $stmt->execute();
    }
}
