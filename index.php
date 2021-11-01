<?php 

    include 'includes/header.php';
    include_once 'compose/core.php';
    include_once 'compose/objects/product.php';
    include_once 'compose/database.php';
    include_once 'compose/objects/category.php';
    include_once 'compose/objects/fokategoria.php';
    include_once 'compose/Cart.class.php';
    $database = new Database();
    $db = $database->getConnection();
    $product = new Product($db);
    $category = new Category($db);
    $focategory = new Fokategoria($db);
    $cart = new Cart;
    $stmt = $product->readAll($from_record_num, $records_per_page);
    $stmt2 = $category->readAll($from_record_num, $records_per_page);

    $page_url = "index.php?";
    $total_rows=$product->countAll();
    $total_rows2=$category->countAll();
?>  
<main>

    <div class="container">
        <header class="header">
             
        </header>
        <div class="container">
            <div class="dotnav">
                <li class='active-dotnav'></li>
                <li></li>
                <li></li>
                <li></li>
            </div>
        </div>
    </div>
        <div class="category-nav">
            <?php
                if ($total_rows2 > 0) {
                    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);       
                        $query = "SELECT id FROM products WHERE category_id";
                        $stmt3 = $db->prepare($query);
                        $stmt3->execute();
                        $num = $stmt3->rowCount();
                echo "<li><a href='#'><div class='category-image'>{$image}</div><div class='category-name'>{$name}<br><i>{$num} termék</i></div></a></li>";             
                    }
                }
                else {
                echo "<div class='alert alert-danger'>Nincs kategória.</div>";
                }
            ?>
    </div>
    <div class="container">
        <div class="row">
            <div class="md-12">
                <h2>Népszerű termékek</h2>
                <div class="product-grid">
                <?php
                    if ($total_rows > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            echo "<a href='termek/{$pagelink}' class='product'>";
                            echo "<div class='product-image'>";
                            echo "<img src='https://laptopokolcson.hu/uploads/E5510.png'>";
                            echo "</div>";
                            echo '<div class="product-price-details">';
                            echo '<div class="product-name">';
                            echo "<h3>{$name}</h3>";
                            echo "<h4>Dell</h4>";
                            echo "</div>";
                            echo '<div class="product-price">';
                            echo "<b>{$ar} Ft</b>";
                            echo '<div class="right">';
                            echo '<div class="next btn-grad">';
                            echo "&rsaquo;";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</a>";
                }
            }
            else {
                echo "<div class='alert alert-danger'>Nincs termék.</div>";
            }
        ?>
                    
                </div>
            </div>
        </div>
       


</main>

<script>
    $(document).ready(function() {
 
 $("#projects").owlCarousel({
    navigation : true, // Show next and prev buttons
    slideSpeed : 700,
    paginationSpeed : 1000,
    margin: 50,
    autoWidth:true,
    nav: true,
    dots:false,
    loop:false,

});
$('.play').on('click',function(){
    owl.trigger('play.owl.autoplay',[4000])
})
$('.stop').on('click',function(){
    owl.trigger('stop.owl.autoplay')
})

});
</script>
<?php include 'includes/footer.php'?>
