<?php
$order_id = $_GET['id'];

$id = base64_decode($order_id);

require_once 'compose/database.php';

// Fetch order details from database
$result = $db->query("SELECT r.*, c.first_name, c.last_name, c.email, c.phone, c.address, c.hazszam, c.emelet, c.ajto FROM orders as r LEFT JOIN customers as c ON c.id = r.customer_id WHERE r.id = ".$id);

if($result->num_rows>0){
	$orderInfo = $result->fetch_assoc();
}else{
	header("Location: index.php");
}
include 'includes/header.php'
?>
<?php if (!empty($orderInfo)) { ?>

    <script src="https://js.stripe.com/v3/"></script>
    <div class="search-box">
        </div>  
        <main>
            <div class="container">
                <div class="md-12">
                    <div class="box">
                    <div class="correct">
                        <svg viewBox="0 0 496 496" xmlns="http://www.w3.org/2000/svg"><path d="m248 8c-132.546875 0-240 107.453125-240 240s107.453125 240 240 240 240-107.453125 240-240-107.453125-240-240-240zm-40 324-88-88 88 88 168-168zm0 0" fill="#c2fb3b"/><g fill="#231f20"><path d="m248 0c-136.964844 0-248 111.035156-248 248s111.035156 248 248 248 248-111.035156 248-248c-.160156-136.902344-111.097656-247.839844-248-248zm0 480c-128.128906 0-232-103.871094-232-232s103.871094-232 232-232 232 103.871094 232 232c-.140625 128.070312-103.929688 231.859375-232 232zm0 0"/><path d="m370.34375 158.34375-162.34375 162.34375-82.34375-82.34375c-3.140625-3.03125-8.128906-2.988281-11.214844.097656-3.085937 3.085938-3.128906 8.074219-.097656 11.214844l88 88c3.125 3.121094 8.1875 3.121094 11.3125 0l168-168c3.03125-3.140625 2.988281-8.128906-.097656-11.214844-3.085938-3.085937-8.074219-3.128906-11.214844-.097656zm0 0"/></g></svg>
                    </div>
                    <h2 class='center-title'>Sikeres megrendelés!</h2>
                    <div class="btn btn-details osszesen-fizetendo">
                        Összesen fizetendő: <?php echo '' . $orderInfo['grand_total']+$shipping . ' Ft'; ?>
                    </div>
                    <a href="index.php" class="btn btn-alert btn-block">Vissza a főoldalra</a>
                </div>
            </div>
            <div class="md-12">
                <div class="box white-box">
                    A rendelésed átvételével kapcsolatban értesíteni fogunk! <br><br>  Amennyiben kérdésed van rendeléseddel kapcsolatban, ügyfélszolgálatunk áll rendelkezésedre az info@domain.hu e-mail címen
                </div>
            </div>
        </div>
    </main>

    <?php } ?>

<?php include 'includes/footer.php' ?>