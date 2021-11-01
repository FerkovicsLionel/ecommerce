<?php
error_reporting(-1);
ini_set('display_errors', 1);

include_once '../compose/core.php';
include_once '../compose/database.php';

include_once '../compose/objects/product.php';
include_once '../compose/objects/category.php';
$database = new Database();
$db = $database->getConnection();
$product = new Product($db);
$category = new Category($db);
$stmt = $product->readAll($from_record_num, $records_per_page);
$total_rows=$product->countAll();
include_once "includes/header.php";
?>
<main>
    <div class="container">
        <div class="row">
            <div class="md-12">
                <div class="box white-box">

                    <?php

                    if($total_rows>0){

                                echo "<table id='order-detail' class='stripe hover'>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>Kép</th>";
                                echo "<th>Terméknév</th>";
                                echo "<th>Ár</th>";
                                echo "<th>Kategória</th>";
                                echo "<th>Szerkeszt</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                                extract($row);
                                echo "<tr>";
                                echo "<td>";
                                echo "<div class='product-image-box'>";
                                echo "<div class='background-img' style='background-image: url(../assets/$image)'></div>";
                                echo "</div>";
                                echo "</td>";
                                echo "<td>{$name}</td>";
                                echo "<td>{$ar} Ft</td>";
                                echo "<td>";
                                $category->id = $category_id;
                                $category->readName();
                                echo $category->name;
                                echo "</td>";
                            
                                echo "<td>";
                                    echo "<a href='termek-frissit.php?id={$id}' class='btn btn-details btn-small'>";
                                        echo "<span class='glyphicon glyphicon-list'></span> Módosítás";
                                    echo "</a>";
                                    echo "<a delete-id='{$id}' class='btn btn-alert delete-object btn-small'>";
                                        echo "<span class='glyphicon glyphicon-remove'></span> Törlés";
                                    echo "</a>";
                                echo "</td>";
                            echo "</tr>";

                        }

                    echo "</tbody>";
                    echo "</table>";

                    // paging buttons
                    }

                    // tell the user there are no products
                    else{
                    echo "<div class='alert alert-danger'>Nincs megrendelés.</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
$(document).ready(function() {
    $('#order-detail').DataTable( {
        searching: false,
        paging: false,
        info: false,
        ordering: false,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/hu.json'
        }
    } );
} );
</script>
<?php include 'includes/footer.php' ?>