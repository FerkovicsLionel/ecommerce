<?php
class Size{

    // database connection and table name
    private $conn;
    private $table_name = "size";

    // object properties
    public $id;
    public $size_name;

    public function __construct($db){
        $this->conn = $db;
    }
    function create(){

        // insert query
        $query = "INSERT INTO " . $this->table_name . "
                    SET size_name=:name";
    
        $stmt = $this->conn->prepare($query);
    
        // posted values
        $this->size_name=htmlspecialchars(strip_tags($this->name));
    
        // to get time-stamp for 'created' field

        // bind values
        $stmt->bindParam(":size_name", $this->size_name);
    
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    
    }
    // used by select drop-down list
    function read(){
        //select all data
        $query = "SELECT
                    id, size_name, size_ar
                FROM
                    " . $this->table_name . "
                ORDER BY
                    id ASC";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
    }

    function readAll($from_record_num, $records_per_page){

        $query = "SELECT
                    id, size_name, size_ar
                FROM
                    " . $this->table_name . "
                ORDER BY
                    created DESC
                LIMIT
                    {$from_record_num}, {$records_per_page}";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
    
        return $stmt;
    }
    public function countAll(){
    
        $query = "SELECT id FROM " . $this->table_name . "";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
    
        $num = $stmt->rowCount();
    
        return $num;
    }
    function readOne(){

        $query = "SELECT size_name, size_ar
            FROM " . $this->table_name . "
            WHERE id = ?
            LIMIT 0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->size_name = $row['size_name'];
        $this->size_ar = $row['size_ar'];
    }


    // used to read category name by its ID
    function readName(){

        $query = "SELECT size_name FROM " . $this->table_name . " WHERE id = ? limit 0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->size_name = $row['size_name'];
    }
        // delete the product
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
    function update(){

        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    size_name = :size_name, 
                WHERE
                    id = :id";
    
        $stmt = $this->conn->prepare($query);
    
        // posted values
        $this->size_name=htmlspecialchars(strip_tags($this->size_name));
        $this->id=htmlspecialchars(strip_tags($this->id));
        
    
        $stmt->bindParam(':size_name', $this->size_name);
        $stmt->bindParam(':id', $this->id);
    
    
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;



}}

?>