<?php
include_once 'compose/core.php';
include_once 'compose/database.php';
include_once 'compose/objects/customers.php';
include_once 'compose/objects/user.php';
include_once 'compose/objects/product.php';
$database = new Database();
$db = $database->getConnection();
$customers = new Customers($db);
$user = new User($db);
$product = new Product($db);
include_once "includes/header.php";
$user->id=$_SESSION['user_id'];
$user->readOne();
$email=$user->email;
$customerresult=$db->query("SELECT * FROM comments WHERE name='".$email."'");

?>

<main>
    <div class="container">
        <div class="row">
            <div class="md-12">
                <div class="box">
                    <h2>Értékeléseim</h2>
                    <?php
                    foreach ($customerresult as $comments) {
                    echo "<a href='termek/".$comments['product_id']."' class='order-box'>";
                    echo "<div class='order-date'>";
                    echo "".$comments['created']."";
                    echo "</div>";
                    echo "<div class='evaluation-product-name'>";
                    echo "".$comments['product_id']."";
                    echo "</div>";
                    echo "<div class='order-name evaluation'>";
                    echo "".$comments['comment']."";
                    echo "</div>";
                    echo "</a>";
                }
                ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include 'includes/footer.php' ?>