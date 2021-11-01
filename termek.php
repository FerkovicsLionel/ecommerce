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
<main id='product'>
    <div class="container">
        <div class="row">
            <div class="md-6 product-in-image">
                <div class="box">
                    <div class="row">
                        <div class="md-3 thumbnail-image">
                            <img src="../assets/<?php echo $product->image ?>" alt="">
                            <img src="../assets/<?php echo $product->image ?>" alt="">
                            <img src="../assets/<?php echo $product->image ?>" alt="">
                            <img src="../assets/<?php echo $product->image ?>" alt="">

                        </div>
                        <div class="md-9 product-main-image">
                            <!--                         <?php
                            if ($kepek > 0) {
                                echo    "<div class='owl-carousel' id='slider'>";
                                    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row);
                                echo "<div class='slider'>";
                                echo "<div class='background' style='background-image: url($url/assets/$image)'></div>";
                                echo "</div>";
                            }
                            echo "</div>";
                                }
                                else {
                                echo "<div class='alert alert-danger'>Nincs kép a termékhez.</div>";
                                }
                                ?> -->
                                <header class='product-page-image'>
                                    <img src="../assets/<?php echo $product->image ?>" alt="">
                                </header>
                        </div>
                    </div>

                </div>
            </div>
            <div class="md-6">
                <div class="box">
                    <div class="product-name"><?php echo $product->name ?></div>
                    <div class="row price-and-com">
                        <div class="md-6 default-md-6">
                            <div class="product-price-in"><?php echo $product->ar ?> HUF</div>

                        </div>
                        <div class="md-6 default-md-6 right">
                            <?php        
                                $query = "SELECT id FROM comments WHERE comments_id";
                                $stmt2 = $db->prepare( $query );
                                $num = $stmt->rowCount();
                                echo "<i class='fas fa-star'></i> {$num} értékelés";
                            ?>
                        </div>
                        <div class="md-12 product-description">
                            <h3>Termékleírás</h3>
                            <p>
                                <?php echo $product->leiras ?>
                            </p>
                            <div class="mobile-fixed">
                                <div class="flex-half-box">
                                    <h3>Mennyiség</h3>
                                    <div class="number-input">
                                        <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"></button>
                                        <input class="quantity qty" min="0" name="quantity" value="1" type="number">
                                        <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
                                    </div>
                
                                </div>
                                <div class="cart-btn-box">

                                    <?php echo "<button class='btn btn-details add-to-cart w-100'><i class='fas fa-shopping-cart'></i> Hozzáadás a kosárhoz</button>";?>       
                                </div>
                            </div>
                            <h3>Megosztás</h3>
                            <ul class='social-box'>
                                <li><i class="fab fa-facebook"></i></li>
                                <li><i class="fab fa-facebook-messenger"></i></li>
                                <li><i class="fab fa-instagram"></i></li>
                            </ul>
                        </div>
                </div>
            </div>
        </div>
        <div class="row p-10">
            <div class="md-12">
                <div class="box product-details-description">
                    <h2>Termékleírás</h2>
                    <p>
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Natus, repudiandae error? Expedita amet possimus laboriosam explicabo accusantium vel ipsam, blanditiis a error debitis, dolores consequatur cum saepe suscipit mollitia hic.
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Architecto consequatur aspernatur et ducimus obcaecati culpa illum tempora nulla quasi aliquam eaque eos dignissimos, praesentium, amet consectetur eum hic? Impedit, obcaecati. <br>
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dignissimos, exercitationem. Officiis, recusandae iusto. Nobis nemo ratione, mollitia numquam ad et dolor voluptate quod, corrupti repudiandae accusamus praesentium aliquid maxime necessitatibus.
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem, libero eos. Sapiente placeat, consequatur est reprehenderit accusamus labore doloremque saepe enim nam facilis expedita ipsum aperiam itaque dolore voluptatibus dolorum. <br>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo incidunt perspiciatis sed! Modi consectetur, molestiae autem ipsa aliquid at esse ab officia doloribus recusandae, magnam odit labore facilis quas laboriosam.
                    </p>
                </div>
            </div>
            <div class="md-6">

                <div class="box product-details-description">
                    <h2>Vélemény írása</h2>
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
                        <div class="row-100">
                            <label for="name" class="input">
                                <input type='text' name='name' class='input-style' required />
                                <span class="text">E-mail cím</span>
                                <div class="focus-border"></div>
                            </label>
                        </div>    
                        <div class="row-100">
                            <label for="">
                                <textarea type='text' cols="30" rows="6" name='comment' class='input-style' placeholder='Vélemény írása...' required ></textarea>
                            </label>
                        </div>
                            <input type='text' hidden name='product_id' class='form-control' value='<?php echo $product->id ?>' />
                            <button type="submit" class="btn btn-details btn-block">Vélemény küldése</button>
                    </form>
                </div>
            </div>
            <div class="md-6">
                <div class="box product-details-description">
                    <h2>Vélemények (<?php        
                            $query = "SELECT id FROM comments WHERE comments_id";
                            $stmt2 = $db->prepare( $query );
                            $num = $stmt->rowCount();
                            echo "{$num} értékelés";
                            ?>)</h2>
                    <?php
                        if ($total_rows > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<div class='comment-box'>";
                        echo "<div class='comment'>";
                        echo "<div class='comment-info'>";
                        echo "<li>$name</li>";
                        $created = date("Y.m.d.");

                        echo "<li class='right'>$created </li>";
                        echo "</div>";
                        echo "<p>$comment</p>";
                        echo "</div>";
                        echo "</div>";
                        }
                        }
                        else {
                        echo "<div class='alert alert-danger'>Nincs leadott értékelés.</div>";
                        }
                    ?>
                </div>
            </div>         
        </div>
    </div>
</div>
</main>

<script>
$(document).ready(function () {
    $(".add-to-cart").click(function () {        
    var id = `<?php echo $product->termekid ?>`;
    window.open('http://192.168.0.18/ecommerce/compose/cartAction.php?action=addToCart&id=' + id + '&qty=' + $(".qty").val(),'_self');
     
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
var header = $('header img');
var range = 300;

$(window).on('scroll', function () {
  
  var scrollTop = $(this).scrollTop(),
      height = header.outerHeight(),
      offset = height / 1,
      calc = 1 - (scrollTop - offset + range) / range;

  header.css({ 'opacity': calc });

  if (calc > '1') {
    header.css({ 'opacity': 1 });
  } else if ( calc < '0' ) {
    header.css({ 'opacity': 0 });
  }
  
});
</script>


<?php include 'includes/footer.php' ?>
