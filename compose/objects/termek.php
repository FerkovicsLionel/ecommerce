<?php
class Product{

private $db;
private $fm;   

public function __construct(){
    $this->db = new Database();
    $this->fm = new Format();

}

public function productInsert($data, $file){
    $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
    $catId = mysqli_real_escape_string($this->db->link, $data['catId']);
    $body = mysqli_real_escape_string($this->db->link, $data['body']);
    $price = mysqli_real_escape_string($this->db->link, $data['price']);
    $type = mysqli_real_escape_string($this->db->link, $data['type']);
    $town = mysqli_real_escape_string($this->db->link, $data['town']);
    $quantity = mysqli_real_escape_string($this->db->link, $data['quantity']);
    $email = mysqli_real_escape_string($this->db->link, $data['email']);
    $phone = mysqli_real_escape_string($this->db->link, $data['phone']);
    $contactName = mysqli_real_escape_string($this->db->link, $data['contactName']);


    $permited  = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = $file['image']['name'];
    $file_size = $file['image']['size'];
    $file_temp = $file['image']['tmp_name'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
    $uploaded_image = "../uploads/".$unique_image;

    if($productName == "" || $catId == "" || $price == "" || $file_name == "" || $town == ""  || $quantity == "" || $email == "" || $phone == "" || $contactName == ""){
        $msg = "<span class='error'>Fields must not be empty!</span>";
        return $msg;

    } elseif ($file_size >1048567) {
         echo "<span class='error'>Image Size should be less then 1MB!
     </span>";

    } elseif (in_array($file_ext, $permited) === false) {
        echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";

    } else{
        move_uploaded_file($file_temp, $uploaded_image);
        $query = "INSERT INTO products(productName, catId, body, price, image, type, town, quantity, email, phone, contactName) VALUES('$productName','$catId','$body','$price','$uploaded_image', '$type','$town','$quantity','$email','$phone','$contactName')";
        $inserted_row = $this->db->insert($query);

            if($inserted_row){
                    $msg = "<span class='success'> Your Offer is Added Successfully. </span>";
                    return $msg;
                } else{
                    $msg = "<span class='error'> Sorry! Your offer is not added! Try again later. </span>";
                    return $msg;
                }
    }
}