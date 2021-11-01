<?php

require_once 'compose/database.php';

if ($_POST['id']) {
echo['id'];
}

else echo 'sdf';

// Include the database config file

/*
// Fetch order details from database
$result = $db->query("SELECT r.*, c.first_name, c.last_name, c.email, c.phone, c.address, c.hazszam, c.emelet, c.ajto,c.fizmod FROM orders as r LEFT JOIN customers as c ON c.id = r.customer_id WHERE r.id = ".$_GET["orderID"]);

if($result->num_rows>0){
	$orderInfo = $result->fetch_assoc();
}else{
	header("Location: index.php");
}
include 'includes/header.php'
?>

<?php if(!empty($orderInfo)){ ?>
<section id='cart-box'>

	<div class="item-side">
        <?php
        if($ok) {
        echo "<h2>A bankkártyás fizetés sikeres!</h2>";
        }
        else {
        echo "<h2>A bankkártyás fizetés sikertelen!</h2>";

        }?>

				<div class="details">
					<h4>Rendelés információk</h4>
					<p><b>Rendelés azonosító:</b> #<?php echo $orderInfo['id']; ?></p>
					<p><b>Szállítási díj:</b> <?php if ($orderInfo['grand_total'] < 15000) {
                            $shipping = 2500;
                            echo "2500 Ft";
                        } else {
                            $shipping = 0;
                            echo '0 Ft';
                        } ?></p>
					<p><b>Összesen fizetendő:</b> <?php echo ''.$orderInfo['grand_total'].' Ft'; ?></p>
					<p><b>Rendelés időpontja:</b> <?php echo $orderInfo['created']; ?></p>
					<p><b>Szállítási név:</b> <?php echo $orderInfo['first_name'].' '.$orderInfo['last_name']; ?></p>
					<p><b>Szállítási cím:</b> <?php echo $orderInfo['address'].' '.$orderInfo['hazszam'].'. '.$orderInfo['emelet'].' / '.$orderInfo['ajto'] ; ?></p>
					<p><b>Email:</b> <?php echo $orderInfo['email']; ?></p>
					<p><b>Telefonszám:</b> <?php echo $orderInfo['phone']; ?></p>
                    <p><b>Választott fizetési mód:</b>
                        <?php
                        if ($orderInfo['fizmod'] == 0) {
                            echo "Utánvétel";
                        }
                        if ($orderInfo['fizmod'] == 1) {
                            echo "Bankkártyás fizetés";
                        }
                        if ($orderInfo['fizmod'] == 2) {
                            echo "Előre utalás";
                        }
                        ?>
                    </p>
				</div>

			</div>
				<!-- Order items -->
			
				<div class="order-side">
					<table class="table">
						<thead>
						  <tr>
                              <th>Terméknév</th>
                              <th>Mennyiség</th>
                              <th>Részösszeg</th>
						  </tr>
						</thead>

		<tbody>
        <?php
        // Get order items from the database

        $result = $db->query("SELECT i.*, p.name termeknev, p.ar termekar FROM order_items i, products p
			WHERE p.id=i.product_id AND i.order_id=" . $orderInfo['id']);

        $resultSumPrice = $db->query("SELECT grand_total FROM orders WHERE id=" . $orderInfo['id']);

        if ($result->num_rows > 0) {
            while ($item = $result->fetch_assoc()) {
                $name = $item["termeknev"];
                $ar = $item["termekar"];
                $quantity = $item["quantity"];
                $sub_total = ($ar * $quantity);


                ?>
                <tr>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $quantity; ?> db</td>
                    <td><?php echo '' . $sub_total . ' Ft'; ?></td>
                </tr>
            <?php }
        } ?>
		</tbody>
	</table>
    <a href="index.php" class='btn login-btn'>Vissza a főoldalra</a>
	<?php }else{ ?>
	<div class="alert alert-danger">Your order submission failed.</div>
	<?php } ?>
</section>

<?php include 'includes/footer.php'; ?>