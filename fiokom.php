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
    $nepszeru=$product->countNepszeru();
    $total_rows=$product->countAll();
    $total_rows2=$category->countAll();
?>  

<main>

        <?php
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true && $_SESSION['access_level']=='Customer'){
        ?>
        <div class="arches">

        </div>
        <div class="container">
            <div class="row">
                <div class="md-12 profile-menu-padding">
                    <div class="box">
                        <h2 class='white'>Üdvözlünk Kedves <?php echo $_SESSION['lastname']; ?>!</h2>                      
                    </div>
                </div>
                <br>
                <div class="md-12 profile-menu-padding">
                    <div class="box profile-menu-list">
                        <li><a href="rendeleseim.php">Rendeléseim<i class="fas fa-angle-right"></i></a></li>
                        <li><a href="ertekeleseim.php">Értékeléseim<i class="fas fa-angle-right"></i></a></li>
                        <li><a href="garancia.php">Garancia<i class="fas fa-angle-right"></i></a></li>
                        <li><a href="szallitasi-cimem.php">Szállítási címem<i class="fas fa-angle-right"></i></a></li>
                        <li><a href="jelszo-modositasa.php">Jelszó módosítása<i class="fas fa-angle-right"></i></a></li>
                        <li><a href="hirlevel.php">Hírlevél<i class="fas fa-angle-right"></i></a></li>
                        <li><a href="altalanos-szerzodesi-feltetelek.php">ÁSZF<i class="fas fa-angle-right"></i></a></li>
                        <li><a href="adatvedelmi-nyilatkozat.php">Adatvédelmi nyilatkozat<i class="fas fa-angle-right"></i></a></li>
                        <li><a href="logout.php">Kijelentkezés<i class="fas fa-angle-right"></i></a></li>
                    </div>
                </div>
            </div>
        </div>


            <?php
            }else{
            ?>
            <!-- NINCS BEJELENTKEZVE -->
            <div class="row">
                <div class="md-12">
                    <div class="box">
                        <div class="not-log">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                viewBox="0 0 471.7 471.7" style="enable-background:new 0 0 471.7 471.7;" xml:space="preserve">
                                <path d="M360.8,200.6v-74.7c0.2-33.8-13.3-66.3-37.4-90C300.1,12.7,269.6,0,237.3,0c-0.5,0-1.1,0-1.6,0
                                c-68.9,0.1-124.9,56.5-124.9,125.9v74.7c-26,3.1-45,24.9-45,51.3v167.8c0,28.5,22.8,52,51.3,52h237.5c28.5,0,51.3-23.5,51.3-52
                                V251.9C405.8,225.6,386.8,203.7,360.8,200.6z M130.7,125.9h0.1c0-58.4,47.1-106.2,105-106.2h0.1c27.5-0.1,53.9,10.8,73.4,30.2
                                c20.3,20.1,31.6,47.5,31.4,76v74.8h-22v-74.8c0.2-22.7-8.8-44.5-24.9-60.5c-15.2-15.2-35.8-23.8-57.3-23.8h-0.6
                                c-46,0-83.2,37.8-83.2,84.2v74.9h-22V125.9z M298.8,125.9v74.8h-126v-74.8c0-35.4,28.2-64.2,63.2-64.2h0.6
                                c16.2,0,31.8,6.5,43.3,18C292.1,91.9,299,108.6,298.8,125.9z M386.8,420L386.8,420c0,17.5-14.2,31.7-31.7,31.7H117.5
                                c-17.5,0-31.7-14.2-31.7-31.7V252.4c0-17.5,14.2-31.7,31.7-31.7h237.6c17.5,0,31.7,14.2,31.7,31.7V420z"/>
                                <path d="M270.4,330c-4.4-15.5-18.5-26.1-34.6-26.1c-19.9,0-36.1,16.1-36.1,36.1c0,16.1,10.6,30.2,26.1,34.6v28c0,5.5,4.5,10,10,10
                                s10-4.5,10-10v-28C264.9,369.1,276,349.1,270.4,330z M235.8,356c-8.9,0-16.1-7.2-16.1-16.1c0-8.9,7.2-16.1,16.1-16.1
                                c8.9,0,16.1,7.2,16.1,16.1C251.9,348.8,244.7,356,235.8,356z"/>
                            </svg>
                        </div>
                        <div class="alert alert-danger">
                            <h2>Nem vagy bejelentkezve</h2>
                            <p>A fiókod eléréséhez jelentkezz be. Amennyiben nincs még fiókod regisztrálj, hogy kedvezményekben részesülj.</p>
                        </div>
         
               
                        <a class='btn btn-details' href="bejelentkezes.php">Bejelentkezés / Regisztráció</a>

                        </div>
                    </div>
                </div>
            </div>
                <!-- NINCS BEJELENTKEZVE VÉGE -->
    <?php } ?>


</main>


<?php include 'includes/footer.php' ?>