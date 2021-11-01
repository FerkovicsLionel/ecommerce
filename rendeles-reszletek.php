<?php
include_once 'compose/core.php';
include_once 'compose/database.php';
$database = new Database();
$db = $database->getConnection();
include_once "includes/header.php";
$email=$_GET["email"];
$date=$_GET["date"];
$id=$_GET["id"];
$customerresult=$db->query("SELECT o.quantity mennyiseg ,p.ar ar, p.name name, p.id pid FROM order_items o, products p WHERE p.id=o.product_id AND order_id=".$id);
?>
<main>
    <div class="container">
        <div class="row">
            <div class="md-12">
                <div class="box">
                    <?php echo $email ?>
                    <?php echo $date ?>
                    <?php echo $id ?>
                <?php
                    foreach ($customerresult as $customer) {
                        echo "<li>
                        <a href='product.php?id=".$customer['pid']."'>
                        <b>".$customer['name']."</b>
                        <b class='center'>".$customer['mennyiseg']." db</b>
                        <b class='right'>".$customer['ar']." Ft</b></a>
                        </li>";
                    
                    }
                ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
include_once "includes/footer.php";
?>