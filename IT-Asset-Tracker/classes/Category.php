<?php
class Category { 
    private $conn; 
    private $table_name = "categories";
    private $id;
    private $type;

    public function __construct($db, $id = null, $type = null){
        $this->conn = $db;
        $this->id = $id;
        $this->type = $type;
    }

    public function get_id(){
        return $this->id;
    }

    public function getAll(){
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>