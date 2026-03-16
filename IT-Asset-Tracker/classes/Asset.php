<?php
class Asset {
    private $conn; 
    private $table_name = "assets";
    private $serial_number;
    private $device_name;
    private $price;
    private $status;
    private $category_id;

    public function __construct($db, $serial_number = null, $device_name = null, $price = null, $status = null, $category_id = null) {
        $this->conn = $db; 
        $this->serial_number = $serial_number;
        $this->device_name = $device_name;
        $this->price = $price;
        $this->status = $status;
        $this->category_id = $category_id;
    }
   
    public function get_serial_number() {
        return $this->serial_number;
    }

    public function create() {
    $query = "INSERT INTO " . $this->table_name . " 
              (serial_number, device_name, price, status, category_id) 
              VALUES (:serial, :name, :price, :status, :category)";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':serial', $this->serial_number);
    $stmt->bindParam(':name', $this->device_name);
    $stmt->bindParam(':price', $this->price);
    $stmt->bindParam(':status', $this->status);
    $stmt->bindParam(':category', $this->category_id);

    if($stmt->execute()) {
        return true;
    }
    return false;
}
public function getAll() {
    $query = "SELECT a.*, c.type as category_name 
              FROM " . $this->table_name . " a 
              INNER JOIN categories c ON a.category_id = c.id";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function delete() {
    $query = "DELETE FROM " . $this->table_name . " WHERE serial_number = :serial";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':serial', $this->serial_number);
    if($stmt->execute()) {
        return true;
    }
    return false;
}
public function update() {
    $query = "UPDATE " . $this->table_name . "
              SET device_name = :name,
                  price = :price,
                  status = :status,
                  category_id = :category
              WHERE serial_number = :serial";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':name', $this->device_name);
    $stmt->bindParam(':price', $this->price);
    $stmt->bindParam(':status', $this->status);
    $stmt->bindParam(':category', $this->category_id);
    $stmt->bindParam(':serial', $this->serial_number);

    if($stmt->execute()) {
        return true;
    }
    return false;
}
public function search($keyword) {
    $query = "SELECT a.*, c.type as category_name 
              FROM " . $this->table_name . " a 
              INNER JOIN categories c ON a.category_id = c.id
              WHERE a.device_name LIKE :keyword 
              OR a.serial_number LIKE :keyword";

    $stmt = $this->conn->prepare($query);
    $search_term = "%" . $keyword . "%";
    $stmt->bindParam(':keyword', $search_term);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getTotalValue() {
    $query = "SELECT SUM(price) as total_price FROM " . $this->table_name;
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['total_price'] ?? 0; 
}
}
?>