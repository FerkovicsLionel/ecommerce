<?php
// Initialize shopping cart class
require_once 'Cart.class.php';
$cart = new Cart;
error_reporting(-1);
ini_set('display_errors', 1);

// Include the database config file
require_once 'database.php';

// Default redirect page
$redirectLoc = 'http://192.168.0.18/ecommerce/index.php';

// Process request based on the specified action
if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])){
        $productID = $_REQUEST['id'];
		$size = $_REQUEST['size'];
		$qty = $_REQUEST['qty'];
		$szoveg = $_REQUEST['szoveg'];
		$lenyomatszin = $_REQUEST['lenyomatszin'];

        // Get product details
        $query = $db->query("SELECT * FROM products WHERE id = ".$productID);

        $row = $query->fetch_assoc();

        if ($row["category_id"]) {
            $itemData = array(
                'id' => $row['id'],
                'name' => $row['name'],
                'ar' => $row['ar'],
                'image' => $row['image'],
                'leiras' => $row['leiras'],
                'category_id' => $row["category_id"],
                'size'=>$size,
                'qty' => $qty,
                'szoveg' => $szoveg,
                'lenyomatszin' => $lenyomatszin,
            );
        }
        else {
            $itemData = array(
                'id' => $row['id'],
                'name' => $row['name'],
                'ar' => $row['ar'],
                'image' => $row['image'],
                'leiras' => $row['leiras'],
                'category_id' =>$row["category_id"],
                'size'=>$size,
                'qty' => $qty,
                'szoveg' => $szoveg,
                'lenyomatszin' => $lenyomatszin
            );
        }
        
		// Insert item to cart
        $insertItem = $cart->insert($itemData);
		
		// Redirect to cart page
        $redirectLoc = $insertItem? 'http://192.168.0.18/ecommerce/kosaram.php':'http://192.168.0.18/ecommerce/kosaram.php';
    }elseif($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])){
		// Update item data in cart
        $itemData = array(
            'rowid' => $_REQUEST['id'],
            'qty' => $_REQUEST['qty']
        );
        $updateItem = $cart->update($itemData);
		
		// Return status
        echo $updateItem?'ok':'err';die;
    }elseif($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])){
		// Remove item from cart
        $deleteItem = $cart->remove($_REQUEST['id']);
        
		// Redirect to cart page
		$redirectLoc = 'http://192.168.0.18/ecommerce/kosaram.php';
    }elseif($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0){
		$redirectLoc = 'http://192.168.0.18/ecommerce/penztar.php';
		
		// Store post data
		$_SESSION['postData'] = $_POST;
	
		$first_name = strip_tags($_POST['first_name']);
		$last_name = strip_tags($_POST['last_name']);
        $email = strip_tags($_POST['email']);
        $phone = strip_tags($_POST['phone']);
        $address = strip_tags($_POST['address']);
        $city = strip_tags($_POST['city']);
        $hazszam = strip_tags($_POST['hazszam']);
        $emelet = strip_tags($_POST['emelet']);
        $ajto = strip_tags($_POST['ajto']);
        $csengo = strip_tags($_POST['csengo']);
        $fizmod=strip_tags($_POST['fizmod']);
        $atvetel=strip_tags($_POST['atvetel']);
        $szfirst_name = strip_tags($_POST['szfirst_name']);
        $szemail = strip_tags($_POST['szemail']);
        $szphone = strip_tags($_POST['szphone']);
        $szaddress = strip_tags($_POST['szaddress']);
        $szcity = strip_tags($_POST['szcity']);
        $szhazszam = strip_tags($_POST['szhazszam']);
        $szemelet = strip_tags($_POST['szemelet']);
        $szajto = strip_tags($_POST['szajto']);
        $szcsengo = strip_tags($_POST['szcsengo']);
		$megjegyzes=strip_tags($_POST['szmegjegyzes']);
		$cegnev=strip_tags($_POST['cegnev']);
		$adoszam=strip_tags($_POST['adoszam']);
		$irsz=strip_tags($_POST['irsz']);
		$szirsz=strip_tags($_POST['szirsz']);

		$errorMsg = '';
		if(empty($first_name)){
			$errorMsg .= 'Please enter your first name.<br/>';
		}
		if(empty($email)){
			$errorMsg .= 'Please enter your email address.<br/>';
		}
		if(empty($phone)){
			$errorMsg .= 'Please enter your phone number.<br/>';
		}
		if(empty($address)){
			$errorMsg .= 'Please enter your address.<br/>';
		}
		
		if(empty($errorMsg)){
            $db->query("UPDATE users SET firstname='".$first_name."', lastname='".$last_name."', email='".$email."', contact_number='".$phone."',city='".$city."', address='".$address."', hsz='".$hazszam."', emelet='".$emelet."', ajto='".$ajto."',csengo='".$csengo."', adoszam='".$adoszam."', irsz='".$irsz."' WHERE id=".$_SESSION["user_id"]);

            $insertCust = $db->query("INSERT INTO customers (adoszam, cegnev,first_name, last_name, email, phone,city, address, hazszam, emelet, ajto, szfirst_name, szlast_name, szemail, szphone,szcity, szaddress, szhazszam, szemelet,szcsengo, szajto,irsz,szirsz, fizmod, created, modified, megjegyzes,csengo,atvetel) VALUES ('".$adoszam."','".$cegnev."','".$first_name."', '".$last_name."', '".$email."', '".$phone."','".$city."', '".$address."', '".$hazszam."', '".$emelet."', '".$ajto."','".$szfirst_name."', '".$szlast_name."', '".$szemail."', '".$szphone."','".$szcity."', '".$szaddress."', '".$szhazszam."', '".$szemelet."', '".$szcsengo."', '".$szajto."','".$irsz."','".$szirsz."','".$fizmod."', NOW(), NOW(),'".$megjegyzes."','".$csengo."','".$atvetel."')");

			if($insertCust){
				$custID = $db->insert_id;
				
				// Insert order info in the database
				$insertOrder = $db->query("INSERT INTO orders (customer_id, grand_total, created, status) VALUES ($custID, '".$cart->total()."', NOW(), 'Függőben')");
			
				if($insertOrder){
					$orderID = $db->insert_id;
					
					$cartItems = $cart->contents();
					
					foreach($cartItems as $item){
                        $insertOrderItems = $db->query("INSERT INTO order_items (order_id, product_id, quantity) VALUES ('".$orderID."', '".$item['id']."', '".$item['qty']."')");
				}
					

					if($insertOrderItems){

						$cart->destroy();

                        $id = $orderID;
                        $result = $db->query("SELECT r.*, c.first_name, c.last_name, c.address, c.hazszam, c.emelet, c.ajto, c.email, c.phone FROM orders as r LEFT JOIN customers as c ON c.id = r.customer_id WHERE r.id = " . $id);
                        $orderInfo = $result->fetch_assoc();
                        $query = $db->query("SELECT c.email FROM customers c, orders o WHERE c.id=o.customer_id AND o.id=" . $id);
                        $email = $query->fetch_assoc();
                        if ($orderInfo['grand_total']>15000  || $orderInfo['atvetel']=="Személyes átvétel") {
                            $shipping=0;
                        }
                        else {
                            $shipping=1300;
                        }
                        $vegosszeg=$orderInfo['grand_total']+$shipping;

						$redirectLoc = 'http://192.168.0.18/ecommerce/sikeres-rendeles.php?id='. base64_encode($orderID);
					}else{
						$sessData['status']['type'] = 'error';
						$sessData['status']['msg'] = 'Some problem occurred, please try again.';
					}
				}else{
					$sessData['status']['type'] = 'error';
					$sessData['status']['msg'] = 'Some problem occurred, please try again.';
				}
			}else{
				$sessData['status']['type'] = 'error';
				$sessData['status']['msg'] = 'Some problem occurred, please try again.';
			}
		}else{
			$sessData['status']['type'] = 'error';
			$sessData['status']['msg'] = 'Please fill all the mandatory fields.<br>'.$errorMsg; 
		}
		$_SESSION['sessData'] = $sessData;
    }
}

// Redirect to the specific page
header("Location: $redirectLoc");
exit();