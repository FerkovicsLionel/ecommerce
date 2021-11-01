<?php
class Comments{

    // database connection and table name
    private $conn;
    private $table_name = "comments";

    // object properties
    public $id;
    public $product_id;
    public $title;
    public $name;
    public $comment;
    public $timestamp;

    public function __construct($db){
        $this->conn = $db;
    }

    // create product
    function create(){

        // insert query
        $query = "INSERT INTO " . $this->table_name . "
                    SET product_id=:product_id, name=:name, title=:title, comment=:comment, created=:created";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->comment=htmlspecialchars_decode($this->comment);
        $this->title=htmlspecialchars_decode($this->title);
        $this->product_id=htmlspecialchars(strip_tags($this->product_id));

        // to get time-stamp for 'created' field
        $this->timestamp = date('Y-m-d H:i:s');

        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":comment", $this->comment);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":created", $this->timestamp);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }
    function readKategorizalt($from_record_num, $records_per_page){

        $query = "SELECT * FROM " . $this->table_name . "
                   WHERE product_id LIKE :id  ORDER BY name LIMIT {$from_record_num}, {$records_per_page}";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindValue(":id", '%'.$this->product_id.'%');
        $stmt->execute();

        return $stmt;
    }

    function readKiemelt($from_record_num, $records_per_page){

        $query = "SELECT
                    id, name, product_id, title, comment, created
                FROM
                    " . $this->table_name . "
                ORDER BY
                    created ASC
                LIMIT
                    {$from_record_num}, {$records_per_page}";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
    }

    public function countKategorizalt(){

        $query = "SELECT product_id FROM " . $this->table_name . " WHERE product_id=:id";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":id", $this->product_id);
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }
    public function countKiemelt(){

        $query = "SELECT id 
        FROM " . $this->table_name . "
        WHERE kiemelt = 'igen'
        LIMIT 0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }
    function readNepszeru($from_record_num, $records_per_page){

        $query = "SELECT * FROM " . $this->table_name . "
        WHERE kiemelt='Igen' 
        LIMIT {$from_record_num}, {$records_per_page}";
        
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":id", $this->category_id);
        $stmt->execute();

return $stmt;
}
    
    function readAll($from_record_num, $records_per_page){

        $query = "SELECT
                    id, name, image, leiras, ar, category_id, created
                FROM
                    " . $this->table_name . "
                ORDER BY
                    category_id ASC
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
        WHERE kiemelt = 'Igen'
        LIMIT 0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }

    function readOne(){

        $query = "SELECT name, title, comment, product_id, created
            FROM " . $this->table_name . "
            WHERE id = ?
            LIMIT 0,1";


        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        $this->title = $row['title'];
        $this->comment = $row['comment'];
        $this->product_id = $row['product_id'];
        $this->created = $row['created'];
    }

    function update(){

        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name = :name, 
                    leiras = :leiras,
                    ar = :ar,
                    image = :image, 
                    category_id = :category_id
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
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);



        // execute the query
        if($stmt->execute()){
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
    