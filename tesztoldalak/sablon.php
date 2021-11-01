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
                $num = $stmt->rowCount();
                echo "<li><a href='#'><div class='category-image'>{$image}</div><div class='category-name'>{$name}<br><i>{$num} termék</i></div></a></li>";             
                    }
                }
                else {
                echo "<div class='alert alert-danger'>Nincs kategória.</div>";
                }
            ?>
    </div>
    <div class="container">
        <div id="alert_message"></div>
<!--         <div class="alert alert-danger fadeintop">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Non placeat, accusamus ratione amet tenetur soluta numquam mollitia perferendis dolore sed ut perspiciatis repellat in iste repellendus doloribus nemo cum! Sunt.</div>
 -->    <div class="alert alert-danger">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Non placeat, accusamus ratione amet tenetur soluta numquam mollitia perferendis dolore sed ut perspiciatis repellat in iste repellendus doloribus nemo cum! Sunt.</div>
        <div class="alert alert-success">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Non placeat, accusamus ratione amet tenetur soluta numquam mollitia perferendis dolore sed ut perspiciatis repellat in iste repellendus doloribus nemo cum! Sunt.</div>
        <div class="row">
            <div class="md-8">
            <h2>Üdvözlünk Kedves <?php echo $_SESSION['lastname']; ?>!</h2>                          

                <div class="box">
                    
                    <form action="">
                        <div class="row-50">
                            <label for="firstname" class='input'>
                                <input type="text" id='firstname' class="input-style" required autocomplete="off">
                                <span class="text">Vezetéknév</span>
                                <div class="focus-border"></div>
                            </label>
                            <label for="lastname" class='input'>
                                <input type="text" id='lastname' class="input-style" required autocomplete="off">
                                <span class="text">Keresztnév</span>
                                <div class="focus-border"></div>
                            </label>
                            <label for="email" class='input'>
                                <input type="text" id='email' class="input-style" required autocomplete="off">
                                <span class="text">E-mail cím</span>
                                <div class="focus-border"></div>
                            </label>
                            <label for="telephone" class='input'>
                                <input type="text" id='telephone' class="input-style" required autocomplete="off">
                                <span class="text">Telefonszám</span>
                                <div class="focus-border"></div>
                            </label>
                        </div>
                        <div class="row-25">
                            <label for="telephone" class='input'>
                                <input type="text" id='telephone' class="input-style" required autocomplete="off">
                                <span class="text">Irányítószám</span>
                                <div class="focus-border"></div>
                            </label>
                            <label for="telephone" class='input'>
                                <input type="text" id='telephone' class="input-style" required autocomplete="off">
                                <span class="text">Város</span>
                                <div class="focus-border"></div>
                            </label>
                            <label for="telephone" class='input'>
                                <input type="text" id='telephone' class="input-style" required autocomplete="off">
                                <span class="text">Utca</span>
                                <div class="focus-border"></div>
                            </label>
                            <label for="telephone" class='input'>
                                <input type="text" id='telephone' class="input-style" required autocomplete="off">
                                <span class="text">Házszám</span>
                                <div class="focus-border"></div>
                            </label>
                        </div>
                        <div class="row-25 optional">
                            <b>Opcionális adatok</b>
                            <label for="telephone" class='input'>
                                <input type="text" id='telephone' class="input-style" required autocomplete="off">
                                <span class="text">Épület</span>
                                <div class="focus-border"></div>
                            </label>
                            <label for="telephone" class='input'>
                                <input type="text" id='telephone' class="input-style" required autocomplete="off">
                                <span class="text">Emelet</span>
                                <div class="focus-border"></div>
                            </label>
                            <label for="telephone" class='input'>
                                <input type="text" id='telephone' class="input-style" required autocomplete="off">
                                <span class="text">Ajtó</span>
                                <div class="focus-border"></div>
                            </label>
                            <label for="telephone" class='input'>
                                <input type="text" id='telephone' class="input-style" required autocomplete="off">
                                <span class="text">Csengő</span>
                                <div class="focus-border"></div>
                            </label>
                        </div>
                        <a href="" class="btn btn-details">Rendelés leadása</a>

                    </form>
          
                </div>
            </div>
            <div class="md-4">
                <div class="box">
                    <a href="" class="btn btn-alert">Biztos vagy benne?</a>
                    <div class="select">
                        <select id="standard-select">
                          <option value="Option 1">Option 1</option>
                          <option value="Option 2">Option 2</option>
                          <option value="Option 3">Option 3</option>
                          <option value="Option 4">Option 4</option>
                          <option value="Option 5">Option 5</option>
                          <option value="Option length">Option that has too long of a value to fit</option>
                        </select>
                      </div>
                </div>
            </div>
        </div>
        <div class="md-12">
            <div class="box">
                <div class="product-list">
                    <a href="" class="product">
                        
                    </a>
                    <a href="" class="product">
    
                    </a>
                    <a href="" class="product">
    
                    </a>
                    <a href="" class="product">
    
                    </a>
                    <a href="" class="product gs-2">
    
                    </a>
                    <a href="" class="product gs-2">
    
                    </a>
                </div>
            </div>
        </div>
    </div>

<div class="container">

    <div class="md-12">
        <div class="box">
            <div class="projects owl-carousel" id='projects'>
                <div class="project">
                    <span class="date">12 jun 2019</span>
                    <h2>Mobile App design</h2>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <div class="projects-count">
                        <div class="circles-box">
                            <div class="circle orange-circle"></div>
                            <div class="circle yellow-circle"></div>
                            <div class="circle green-circle"></div>
                            <div class="circle red-circle"></div>
                        </div>
                        Design Team
                    </div>
                </div>
                <div class="project">
                    <span class="date">12 jun 2019</span>
                    <h2>Mobile App design</h2>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <div class="projects-count">
                        <div class="circles-box">
                            <div class="circle orange-circle"></div>
                            <div class="circle yellow-circle"></div>
                            <div class="circle green-circle"></div>
                            <div class="circle red-circle"></div>
                        </div>
                        Design Team
                    </div>
                </div>
                <div class="project">
                    <span class="date">12 jun 2019</span>
                    <h2>Mobile App design</h2>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <div class="projects-count">
                        <div class="circles-box">
                            <div class="circle orange-circle"></div>
                            <div class="circle yellow-circle"></div>
                            <div class="circle green-circle"></div>
                            <div class="circle red-circle"></div>
                        </div>
                        Design Team
                    </div>
                </div>
                <div class="project">
                    <span class="date">12 jun 2019</span>
                    <h2>Mobile App design</h2>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <div class="projects-count">
                        <div class="circles-box">
                            <div class="circle orange-circle"></div>
                            <div class="circle yellow-circle"></div>
                            <div class="circle green-circle"></div>
                            <div class="circle red-circle"></div>
                        </div>
                        Design Team
                    </div>
                </div>
                <div class="project">
                    <span class="date">12 jun 2019</span>
                    <h2>Mobile App design</h2>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <div class="projects-count">
                        <div class="circles-box">
                            <div class="circle orange-circle"></div>
                            <div class="circle yellow-circle"></div>
                            <div class="circle green-circle"></div>
                            <div class="circle red-circle"></div>
                        </div>
                        Design Team
                    </div>
                </div>
                <div class="project">
                    <span class="date">12 jun 2019</span>
                    <h2>Mobile App design</h2>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <div class="projects-count">
                        <div class="circles-box">
                            <div class="circle orange-circle"></div>
                            <div class="circle yellow-circle"></div>
                            <div class="circle green-circle"></div>
                            <div class="circle red-circle"></div>
                        </div>
                        Design Team
                    </div>
                </div>
            </div>
        </div>
        
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="md-12">
            <div class="box">
                <div class="products">

            <?php
                    if ($total_rows > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            echo "<div class='product-card'>";
                            echo '<div class="product-image">';
                            echo "<div class='background' style='background-image:url(assets/{$image})'></div>";
                            echo '</div>';
                            echo '<div class="product-info">';
                            echo "<h5>{$name}</h5>";
                            echo "<h6>{$ar} Ft</h6>";
                            echo "<a class='btn btn-details' href='termek/{$pagelink}'>Részletek</a>";
                            echo '</div>';
                            echo '</div>';

                        }
                    }
                    else {
                        echo "<div class='alert alert-danger'>Nincs termék.</div>";
                    }
                ?>
                </div>
            </div>
        </div>
    </div>
</div>

</main>
<script>
    $(document).ready(function() {
 
 $("#slider").owlCarousel({
    navigation : true, // Show next and prev buttons
    slideSpeed : 700,
    paginationSpeed : 1000,
    items : 1,
    nav:true,
    dots:true,
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
    const fadeInTop = document.querySelector('.fadeintop');
    fadeInTop.style.transform="translateY(0) translateX(-50%)";
    fadeInTop.style.opacity="1";
</script>
<?php include 'includes/footer.php'?>
