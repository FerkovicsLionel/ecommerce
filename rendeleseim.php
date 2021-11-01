<?php
include_once 'compose/core.php';
include_once 'compose/database.php';

include_once 'compose/objects/rendelesek.php';
include_once 'compose/objects/customers.php';
include_once 'compose/objects/user.php';
$database = new Database();
$db = $database->getConnection();
$rendelesek = new Rendelesek($db);
$customers = new Customers($db);
$user = new User($db);
include_once "includes/header.php";
$stmt = $rendelesek->readAll($from_record_num, $records_per_page);
$total_rows=$rendelesek->countAll();
$user->id=$_SESSION['user_id'];
$user->readOne();
$email=$user->email;
$customerresult=$db->query("SELECT o.* FROM customers c, orders o WHERE o.customer_id=c.id AND c.email='".$email."'");

?>

<main>
    <div class="container">
        <div class="row">
            <div class="md-12">
                <div class="box">
                    <h2>Rendeléseim</h2>
                    <?php
                    foreach ($customerresult as $customer) {
                    $customer['created'] = date("Y.m.d.");
                    echo "<a href='rendeles-reszletek.php?date=".$customer['created']."&email=".$email."&id=".$customer['id']."' class='order-box'>
                        <div class='order-date'>
                        ".$customer['created']."
                        </div>
                        <div class='order-name'>
                            12 termék - ".$customer['grand_total']." Ft
                        </div>
                        <i class='fas fa-angle-right'></i>
                    </a>";
                }
                ?>
                    <a href='rendeles-reszletek.php' class="order-box">
                        <div class="order-date">
                            2021.10.14.
                        </div>
                        <div class="order-name">
                            12 termék - 43.332 Ft
                        </div>
                        <i class="fas fa-angle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include 'includes/footer.php' ?>