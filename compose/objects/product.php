<?php
error_reporting(-1);
ini_set('display_errors', 1);

class Product{

    // database connection and table name
    private $conn;
    private $table_name = "products";

    // object properties
    public $id;
    public $name;
    public $ar;
    public $leiras;
    public $image;
    public $kiemelt;
    public $barcode;
    public $db;
    public $group_id;
    public $category_id;
    public $sizes;
    public $timestamp;
    public $dbs;

    public function __construct($db){
        $this->conn = $db;
    }

    // create product
    function create(){

        // insert query
        $query = "INSERT INTO " . $this->table_name . "
                    SET name=:name, leiras=:leiras, ar=:ar, kiemelt=:kiemelt,
                        category_id=:category_id, image=:image, created=:created, db=:db, group_id=:group_id";

        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->leiras=htmlspecialchars_decode($this->leiras);
        $this->ar=htmlspecialchars(strip_tags($this->ar));
        $this->image=htmlspecialchars(strip_tags($this->image));
        $this->kiemelt=htmlspecialchars(strip_tags($this->kiemelt));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->group_id=htmlspecialchars(strip_tags($this->group_id));
        $this->timestamp = date('Y-m-d H:i:s');

$insert=true;
        foreach ($this->dbs as $key=>$db) {
            $stmt = $this->conn->prepare($query);
            // bind values
            $stmt->bindValue(":leiras", $this->leiras);
            $stmt->bindValue(":category_id", $this->category_id);
            $stmt->bindValue(":image", $this->image);
            $stmt->bindValue(":kiemelt", $this->kiemelt);
            $stmt->bindValue(":created", $this->timestamp);
            $stmt->bindValue(":group_id", $this->group_id);
            $namestring=$this->name." ".$db;
            $stmt->bindValue(":name", $namestring);
            $stmt->bindValue(":ar", $this->sizes[$key]);
            $stmt->bindValue(":db", $db);

            $insert&=$stmt->execute();
        }

        if ($insert) {
            return true;
        }
        else {
            return false;
        }

    }
    function readKategorizalt($from_record_num, $records_per_page){

        $query = "SELECT * FROM " . $this->table_name . "
                   WHERE category_id LIKE :id ORDER BY name ASC LIMIT {$from_record_num}, {$records_per_page}";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindValue(":id", '%'.$this->category_id.'%');
        $stmt->execute();

        return $stmt;
    }

    function readKiemelt($from_record_num, $records_per_page){

        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . "
                WHERE kiemelt = '1'
                ORDER BY
                    name ASC
                LIMIT
                    {$from_record_num}, {$records_per_page}";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
    }
    function read(){
        //select all data
        $query = "SELECT
                    id, name
                FROM
                    " . $this->table_name . "
                ORDER BY
                    id ASC";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
    }
    public function countKategorizalt(){

        $query = "SELECT category_id FROM " . $this->table_name . " WHERE category_id LIKE :id";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindValue(":id", '%'.$this->category_id.'%');
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }
    public function countKiemelt(){

        $query = "SELECT id 
        FROM " . $this->table_name . "
        WHERE kiemelt = '1'
        LIMIT 0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }
    function readNepszeru($from_record_num, $records_per_page){

        $query = "SELECT * FROM " . $this->table_name . "
        WHERE kiemelt='1' 
        LIMIT {$from_record_num}, {$records_per_page}";
        
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":id", $this->category_id);
        $stmt->execute();

return $stmt;
}
function readName(){
    $query = "SELECT id, name, ar, image FROM " . $this->table_name . " WHERE id = ? limit 0,1";

    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->name = $row['name'];
    $this->ar = $row['ar'];
    $this->image = $row['image'];
    $this->termekid = $row['id'];

}
    
    function readAll($from_record_num, $records_per_page,$where=""){

        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . "
                 WHERE 1 ".$where." ORDER BY
                    name ASC
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
    public function countNepszeru(){

        $query = "SELECT * FROM " . $this->table_name . "
        WHERE kiemelt = '1'
        LIMIT 0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }

    function readOne(){

        $query = "SELECT *
            FROM " . $this->table_name . "
            WHERE pagelink = ?
            LIMIT 0,1";


        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        $this->leiras = $row['leiras'];
        $this->image = $row['image'];
        $this->kiemelt = $row['kiemelt'];
        $this->termekid = $row['id'];
        $this->ar = $row['ar'];
        $this->category_id = $row['category_id'];

    }
    function readOneAdmin(){

        $query = "SELECT *
            FROM " . $this->table_name . "
            WHERE id = ?
            LIMIT 0,1";


        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        $this->leiras = $row['leiras'];
        $this->image = $row['image'];
        $this->pagelink = $row['pagelink'];
        $this->kiemelt = $row['kiemelt'];
        $this->termekid = $row['id'];
        $this->ar = $row['ar'];
        $this->category_id = $row['category_id'];

    }

    function update(){

        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name = :name, 
                    leiras = :leiras,
                    ar = :ar,
                    image = :image, 
                    mainimage = :mainimage, 
                    category_id = :category_id,
                    kiemelt=:kiemelt
                WHERE
                    id = :id";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->leiras=htmlspecialchars_decode($this->leiras);
        $this->ar=htmlspecialchars(strip_tags($this->ar));
        $this->image=htmlspecialchars(strip_tags($this->image));
        $this->kiemelt=htmlspecialchars(strip_tags($this->kiemelt));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->id=htmlspecialchars(strip_tags($this->id));
        

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':leiras', $this->leiras);
        $stmt->bindParam(':ar', $this->ar);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':mainimage', $this->image);
        $stmt->bindParam(':kiemelt', $this->kiemelt);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);



        // execute the query
        if($stmt->execute()){
            $query = "DELETE FROM products_sizes
                    WHERE pid=:pid";

            $stmts = $this->conn->prepare($query);
            $stmts->bindParam(":pid", $this->id);
            $stmts->execute();
            $pid=$this->id;
            foreach ($this->sizes as $size) {
                $query = "INSERT INTO products_sizes
                    SET pid=:pid, sid=:sid";

                $stmts = $this->conn->prepare($query);
                $stmts->bindParam(":pid", $pid);
                $stmts->bindParam(":sid", $size);
                $stmts->execute();
            }
            return true;
        }

        return false;

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

    public function search($search_term, $from_record_num, $records_per_page){

        // select query
        $query = "SELECT
                    c.name as category_name, p.id, p.name, p.leiras, p.ar, p.image, p.category_id, p.created
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                WHERE
                    p.name LIKE ? OR p.leiras LIKE ?
                ORDER BY
                    p.name ASC
                LIMIT
                    ?, ?";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind variable values
        $search_term = "%{$search_term}%";
        $stmt->bindParam(1, $search_term);
        $stmt->bindParam(2, $search_term);
        $stmt->bindParam(3, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(4, $records_per_page, PDO::PARAM_INT);

        // execute query
        $stmt->execute();

        // return values from database
        return $stmt;
    }

    public function countAll_BySearch($search_term){

        // select query
        $query = "SELECT
                    COUNT(*) as total_rows
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                WHERE
                    p.name LIKE ?";

                    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind variable values
        $search_term = "%{$search_term}%";
        $stmt->bindParam(1, $search_term);

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }


        function uploadPhoto(){

            $result_message="";
    
            // now, if image is not empty, try to upload the image
            if($this->image){
    
                // sha1_file() function is used to make a unique file name
                $target_directory = "uploads/";
                $target_file = $target_directory . $this->image;
                $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
    
                // error message is empty
                $file_upload_error_messages="";
    
                // make sure that file is a real image
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if($check!==false){
                    // submitted file is an image
                }else{
                    $file_upload_error_messages.="<div>Submitted file is not an image.</div>";
                }
    
                // make sure certain file types are allowed
                $allowed_file_types=array("jpg", "jpeg", "png", "gif");
                if(!in_array($file_type, $allowed_file_types)){
                    $file_upload_error_messages.="<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                }
    
                // make sure file does not exist
                if(file_exists($target_file)){
                    $file_upload_error_messages.="<div>Image already exists. Try to change file name.</div>";
                }
    
                // make sure submitted file is not too large, can't be larger than 1 MB
                if($_FILES['image']['size'] > (102400000)){
                    $file_upload_error_messages.="<div>Image must be less than 10 MB in size.</div>";
                }
    
                // make sure the 'uploads' folder exists
                // if not, create it
                if(!is_dir($target_directory)){
                    mkdir($target_directory, 0777, true);
                }
    
                // if $file_upload_error_messages is still empty
                if(empty($file_upload_error_messages)){
                    // it means there are no errors, so try to upload the file
                    if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
                        // it means photo was uploaded
                    }else{
                        $result_message.="<div class='alert alert-danger'>";
                            $result_message.="<div>Unable to upload photo.</div>";
                            $result_message.="<div>Update the record to upload photo.</div>";
                        $result_message.="</div>";
                    }
                }
    
                // if $file_upload_error_messages is NOT empty
                else{
                    // it means there are some errors, so show them to user
                    $result_message.="<div class='alert alert-danger'>";
                        $result_message.="{$file_upload_error_messages}";
                        $result_message.="<div>Update the record to upload photo.</div>";
                    $result_message.="</div>";
                }
    
            }
    
            return $result_message;
        }
    
    
    }
    ?>
    