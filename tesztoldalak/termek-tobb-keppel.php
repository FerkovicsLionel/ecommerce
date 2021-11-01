<?php
include 'includes/header.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
include_once 'compose/core.php';
include_once 'compose/objects/product.php';
include_once 'compose/objects/comments.php';
include_once 'compose/database.php';
include_once 'compose/objects/user.php';
include_once 'compose/objects/images.php';
include_once 'compose/objects/category.php';
include_once 'compose/Cart.class.php';
$database = new Database();
$db = $database->getConnection();
$product = new Product($db);
$category = new Category($db);
$comments = new Comments($db);
$images = new Images($db);
$user = new User($db);
$category->id = $id;
$comments->product_id = $id;
$images->product_id = $id;
$product->id = $id;
$product->readOne();
$stmt = $comments->readKategorizalt($from_record_num, $records_per_page);
$total_rows=$comments->countKategorizalt();
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true && $_SESSION['access_level']=='Customer'){
$user->id=$_SESSION['user_id'];
$user->readOne();
}
else{
}
$stmt2 = $images->readKategorizalt($from_record_num, $records_per_page);
$kepek=$images->countKategorizalt();
?>
<main>
    <div class="container product-side">
        <div class="row">
            <div class="md-6">
            <?php echo $product->id ?>
            <?php echo $product->termekid ?>
                <div class="box product-image-box">
                    <div class="image-box">
                    <div class="owl-carousel" id="slider">
                            <?php
                            if ($kepek > 0) {
                            while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            echo "<div class='slider'>";
                            echo "<div class='background' style='background-image: url($url/assets/$image)'></div>";
                            echo "</div>";
                            }
                            }
                            else {
                            echo "<div class='alert alert-danger'>Nincs kép a termékhez.</div>";
                            }
                            ?>
                        </div>
                    </div>
                    <?php        
                        $query = "SELECT id FROM comments WHERE comments_id";
                        $stmt2 = $db->prepare( $query );
                        $num = $stmt->rowCount();
                        echo "{$num} értékelés";
                    ?>
                </div>
            </div>
            <div class="md-6">
                <div class="box">
                    <div class="product-details-box">
                        <div class="product-name"><?php echo $product->name ?></div>
                        <div class="product-price"><?php echo $product->ar ?> HUF</div>
                        <div class="product-description">
                            <p>
                                <?php echo $product->leiras ?>
                            </p>
                        </div>
                        <input type='number' step='1' min='1' max='10000' name='quantity' value='1' title='Qty' class='qty' size='4' pattern='' inputmode=''>
                        
                        <?php echo "<button class='btn btn-details add-to-cart w-100'>Kosárba</button>";?>       

                    </div>
                </div>
            </div>
            <div class="md-12">
                <?php
                    if($_POST){
                    $comments->name = $_POST['name'];
                    $comments->product_id = $_POST['product_id'];
                    $comments->comment = $_POST['comment'];

                    if($comments->create()){
                    echo "<div class='alert alert-success'>Értékelésed sikeresen beküldted</div>";
                    }
                    else{
                    echo "<div class='alert alert-danger'>Sikertelen értékelés leadás</div>";
                    }
                    }
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?id=<?php echo $product->id ?>" method="post" enctype="multipart/form-data">
                <div class="row-50">
                    <label for="name" class="input">
                        <input type='text' name='name' class='input-style' required />
                        <span class="text">E-mail cím</span>
                        <div class="focus-border"></div>
                    </label>
                </div>    
                <div class="row-50">
                    <label for="">
                        <textarea type='text' cols="30" rows="6" name='comment' class='input-style' placeholder='Vélemény írása...' required ></textarea>
                    </label>
                    <label for="" style='display:none' >
                        <b>Termék</b>
                        <input type='text' name='product_id' class='form-control' value='<?php echo $product->id ?>' />
                    </label>
                </div>
                <div class="row-50">

                    <button type="submit" class="btn btn-details">Vélemény küldése</button>
                </div>

                </form>
            </div>
            
        </div>
        <?php
    if ($total_rows > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
        echo "<div class='comment-box'>";
        echo "<div class='comment'>";
        echo "<p>$comment</p>";
        echo "<div class='comment-info'>";
        echo "<li>$name</li>";
        $created = date("Y.m.d.");

        echo "<li class='right'>$created </li>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        }
    }
        else {
            echo "<div class='alert alert-danger'>Nincs leadott értékelés.</div>";
        }
    ?>
    </div>
</main>

<script>
$(document).ready(function () {
    $(".add-to-cart").click(function () {        
    var id = `<?php echo $product->termekid ?>`;
    window.open('http://localhost/ecommerce/compose/cartAction.php?action=addToCart&id=' + id + '&qty=' + $(".qty").val(),'_self');
     
    })
})
</script>
<script>
    $(document).ready(function() {
 
 $("#slider").owlCarousel({
    navigation : true, // Show next and prev buttons
    slideSpeed : 700,
    paginationSpeed : 1000,
    items : 1,
    nav:false,
    dots:false,
    loop:true,
    itemsDesktop : false,
    itemsDesktopSmall : false,
    itemsTablet: false,
    itemsMobile : false,
    autoplay:true,
    autoplayTimeout:4000,
    autoplayHoverPause:true
});
$('.play').on('click',function(){
    owl.trigger('play.owl.autoplay',[4000])
})
$('.stop').on('click',function(){
    owl.trigger('stop.owl.autoplay')
})

});
</script>


<?php include 'includes/footer.php' ?>
