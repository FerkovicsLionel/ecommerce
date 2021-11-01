<?php 
    include_once "includes/header.php";
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
    include_once '../compose/database.php';
    include_once '../compose/objects/product.php';
    include_once '../compose/objects/category.php';
    $database = new Database();
    $db = $database->getConnection();
    $product = new Product($db);
    $category = new Category($db);
    $product->id = $id;
    $product->readOneAdmin();
?>
<main>
    
    <div class="container">
        <?php
            if($_POST){
 
                $product->name = $_POST['name'];
                $product->leiras = $_POST['leiras'];
                $product->ar = $_POST['ar'];
                $product->category_id = $_POST['category_id'];
             
                if($product->update()){
                    echo "<div class='alert alert-success alert-dismissable'>";
                        echo "Frissítetted a terméket.";
                    echo "</div>";
                }
                else{
                    echo "<div class='alert alert-danger alert-dismissable'>";
                        echo "Termékfrissítés nem sikerült.";
                    echo "</div>";
                }
            }
        ?>
        <div class="row">
            <div class="md-12">

                <h2><?php echo $product->name; ?> módosítása</h2>
            </div>
            <div class="md-4">
                <div class="box white-box">
                    <h3>Ár információk</h3>
                    <label for="firstname" class='input'>
                        <input type="text" id='name2' name="name" class="input-style" value='<?php echo $product->ar; ?>' required autocomplete="off">
                        <span class="text">Termék ára</span>
                        <div class="focus-border"></div>
                    </label>
                    <label for="firstname" class='input'>
                        <input type="text" id='name2' name="name" class="input-style" value='<?php echo $product->ar; ?>' required autocomplete="off">
                        <span class="text">Termék akciós ára</span>
                        <div class="focus-border"></div>
                    </label>
                </div>
                <div class="box white-box">
                    <h3>Láthatóság</h3>
                    <label for="rendelheto">
                        <input type="radio" name="product_status" id="rendelheto" value="0" checked> Rendelhető
                    </label>
                    <label for="keszleten">
                        <input type="radio" name="product_status" id="keszleten" value="1"> Készleten
                    </label>
                    <label for="rejtett">
                        <input type="radio" name="product_status" id="rejtett" value="2"> Rejtett
                    </label>

                </div>
            </div>
     
            <div class="md-8">
                <div class="box white-box">
                    <h3>Alapadatok</h3>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
                        <div class="row-50">
                            <label for="firstname" class='input'>
                                <input type="text" id='name' name="name" class="input-style" value='<?php echo $product->name; ?>' required autocomplete="off">
                                <span class="text">Terméknév</span>
                                <div class="focus-border"></div>
                            </label>
                            <label for="firstname" class='input'>
                                <input type="text" id='pagetitle' name="pagelink" class="input-style" value='<?php echo $product->pagelink; ?>' required autocomplete="off">
                                <span class="text">Oldal link</span>
                                <div class="focus-border"></div>
                            </label>
                        </div>

                        <label for="firstname" class='input'>
                            <input type="text" id='name2' name="name" class="input-style" value='<?php echo $product->name; ?>' required autocomplete="off">
                            <span class="text">Oldal cím</span>
                            <div class="focus-border"></div>
                        </label>
                        <label for="firstname" class='input'>
                            <b>Termékleírás</b>
                            <textarea name="description" id=""></textarea>
                        </label>

                    </form>
                </div>
            </div>
            
        </div>
    </div>
    <script>
        CKEDITOR.replace( 'description' );

    </script>

<script>
$('#name').keyup(function(){

$('#pagetitle').val(this.value.toLowerCase().replace(/ /g,"-").replace(/ö/g,"o").replace(/ő/g,"o").replace(/ó/g,"o").replace(/ü/g,"u").replace(/ű/g,"u").replace(/á/g,"a").replace(/í/g,"i").replace(/ú/g,"u").replace(/é/g,"e"));
});
    </script>
</main>