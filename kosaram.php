<?php
include_once 'compose/Cart.class.php';
$cart = new Cart;
include 'includes/header.php';
include_once 'compose/core.php';
include_once 'compose/database.php';
include_once 'compose/objects/product.php';
include_once 'compose/objects/category.php';
$database = new Database();
$db = $database->getConnection();
$product = new Product($db);
$category = new Category($db);

?>
<main id='cart'>
    <div class="container">
        <div class="row">
            <div class="md-8">
                <div class="box">
                    <h2>Bevásárlókosár (<?php echo ($cart->total_items() > 0)?$cart->total_items().'':'0'; ?>)</h2>
                    <?php
                    if($cart->total_items() > 0){
                    $cartItems = $cart->contents();
                    foreach($cartItems as $item){ 
                    ?>
                    <div class="cart-product-box">
                        <div class="cart-product-image">
                            <div class="background" style='background-image:url(assets/<?php echo $item["image"]; ?>)'></div>
                        </div>
                        <div class="cart-product-name">
                            <div class="flex-box">
                                <div class="f-box">
                                    <h3><?php echo $item["name"]; ?></h3>

                                </div>
                                <div class="f-box">
                                    <div class="number-input">
                                        <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"></button>
                                        <input class="quantity qty" min="0" name="quantity" value="<?php echo $item["qty"]; ?>" type="number">
                                        <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
                                    </div>
                                </div>
                                <div class="f-box">
                                <div class="cart-product-price">
                                    <?php echo ''.$item["subtotal"]; ?>  Ft
                                </div>
                                </div>

                            </div>
                     
                        </div>
                        
                        <button class='btn btn-alert' onclick="return confirm('Biztosan törlöd a kosaradból?')?window.location.href='compose/cartAction.php?action=removeCartItem&id=<?php echo $item['rowid']; ?>':false;">Törlés</button>
                    </div>
                    <?php } ?>
                </div>
            </div>
                <div class="md-4 white-box-in-cart">
                    

                    <div class="total-in-cart">
                    <div class="grand-total">
                        <li class='flex-1'>Kuponkód</li>
                        <li class='flex-2'> 
                     
                            <form class='coupon-form' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                                <input type="text" class="input-style"><button class="btn btn-alert">Megad</button>
                            </form>
                        </li>
                    </div>
                    <div class="grand-total">
                        <li >Termék(ek) ára</li>
                        <?php if($cart->total_items() > 0){ ?>
    
                        <li class='right'><?php echo ''.$cart->total().' Ft'; ?></li>
                    </div>
                    <div class="grand-total">
                        <?php
                        if ($cart->total()<20000) {
                        echo '<li>Várható szállítási díj:</li>
                        <li class="right" data-price="2500">2500 Ft</li>';
                        }
                        else {
                        echo '<li>Várható szállítási díj:</li> 
                        <li class="right" data-price="0">ingyenes</li>';
                        }?>
                        <?php } ?>
                    </div>
                    <div class="grand-total totals">
                        <li><b>Összesen:</b></li>
                        <li class='right'><b> <?php echo ''.$cart->total().' Ft'; ?></b></li>
                        
                    </div>
                    <a href="penztar.php" class="btn btn-details">Tovább a pénztárhoz</a>

                    </div>
                </div>
        </div>
    </div>
</main>
                   
        






    <?php }else{ ?>
    <div class="no-in-cart">
    <h3>A kosarad üres<h3>
    <a href="kategoriak.php" class="next-to-products">Tovább a termékekhez</a>
    </div>
            
        <?php } ?>
    
</main>

<?php include 'includes/footer.php' ?>