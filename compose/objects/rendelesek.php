<?php
class Rendelesek{

    // database connection and table name
    private $conn;
    private $table_name = "orders";

    // object properties
    public $id;
    public $customer_id;
    public $grand_total;
    public $status;
    public $timestamp;

    public function __construct($db){
        $this->conn = $db;
    }

    function readAll($from_record_num, $records_per_page){

        $query = "SELECT
                    id, customer_id, grand_total, status, created
                FROM
                    " . $this->table_name . "
                ORDER BY
                    id DESC
                LIMIT
                    {$from_record_num}, {$records_per_page}";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
    }

    // used for paging products
    public function countAll(){

        $query = "SELECT id FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }

    function readOne(){

        $query = "SELECT customer_id, grand_total, status, created
            FROM " . $this->table_name . "
            WHERE id = ?
            LIMIT 0,1";


        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->customer_id = $row['customer_id'];
        $this->grand_total = $row['grand_total'];
        $this->status = $row['status'];
        $this->created = $row['created'];
    }

    function update(){

        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    customer_id = :customer_id, 
                    grand_total = :grand_total,
                    status = :status
                WHERE
                    id = :id";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));
        $this->grand_total=htmlspecialchars(strip_tags($this->grand_total));
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->id=htmlspecialchars(strip_tags($this->id));
        

        $stmt->bindParam(':customer_id', $this->customer_id);
        $stmt->bindParam(':grand_total', $this->grand_total);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);



        // execute the query
        if($stmt->execute()){
            return true;
        }

        return false;

    }
    function delete(){

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if($result = $stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

}
    ?>