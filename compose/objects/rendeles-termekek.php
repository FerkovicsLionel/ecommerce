<?php
class OItems{

    // database connection and table name
    private $conn;
    private $table_name = "order_items";

    // object properties
    public $id;
    public $order_id;
    public $product_id;
    public $quantity;
    public function __construct($db){
        $this->conn = $db;
    }
    function readKategorizalt($from_record_num, $records_per_page){

        $query = "SELECT * FROM " . $this->table_name . "
                   WHERE order_id LIKE :id ORDER BY order_id LIMIT {$from_record_num}, {$records_per_page}";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindValue(":id", '%'.$this->order_id.'%');
        $stmt->execute();

        return $stmt;
    }
    public function countKategorizalt(){

        $query = "SELECT order_id FROM " . $this->table_name . " WHERE order_id=:id";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":id", $this->order_id);
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }
    function read(){
        //select all data
        $query = "SELECT
                    id, product_id, order_id
                FROM
                    " . $this->table_name . "
                ORDER BY
                    id ASC";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
    }

}
?>