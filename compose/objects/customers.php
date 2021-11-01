<?php
class Customers{

    // database connection and table name
    private $conn;
    private $table_name = "customers";

    // object properties
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $city;
    public $address;
    public $hazszam;
    public $emelet;
    public $ajto;
    public $szamlcity;
    public $szamladdress;
    public $szamlhazszam;
    public $szamlemelet;
    public $szamlajto;
    public $status;

    public function __construct($db){
        $this->conn = $db;
    }
    function create(){

        // insert query
        $query = "INSERT INTO " . $this->table_name . "
                    SET first_name=:first_name, last_name=:last_name, email=:email, phone=:phone, address=:address,
                    created=:created";
    
        $stmt = $this->conn->prepare($query);
    
        // posted values
        $this->first_name=htmlspecialchars(strip_tags($this->first_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->status=htmlspecialchars_decode($this->status);
    
        // to get time-stamp for 'created' field
        $this->timestamp = date('Y-m-d H:i:s');
    
        // bind values
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":created", $this->timestamp);
    
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
                    id, first_name, last_name, email, phone, address, status
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
                    id, first_name, last_name, email, phone, address, created
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

        $query = "SELECT first_name, last_name, email, phone, address, created
            FROM " . $this->table_name . "
            WHERE id = ?
            LIMIT 0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->first_name = $row['first_name'];
        $this->last_name = $row['last_name'];
        $this->email = $row['email'];
        $this->phone = $row['phone'];
        $this->address = $row['address'];
    }


    // used to read category name by its ID
    function readName(){

        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? limit 0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->first_name = $row['first_name'];
        $this->last_name = $row['last_name'];
        $this->email = $row['email'];
        $this->phone = $row['phone'];
        $this->city = $row['city'];
        $this->irsz = $row['irsz'];
        $this->address = $row['address'];
        $this->cegnev = $row['cegnev'];
        $this->adoszam = $row['adoszam'];
        $this->megjegyzes = $row['megjegyzes'];
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
                    name = :name, 
                    image = :image
                WHERE
                    id = :id";
    
        $stmt = $this->conn->prepare($query);
    
        // posted values
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->first_name=htmlspecialchars(strip_tags($this->first_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->status=htmlspecialchars_decode($this->status);
        
        
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":created", $this->timestamp);
    
        $stmt->bindParam(':id', $this->id);
    
    
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    
    }

    }
 
?>