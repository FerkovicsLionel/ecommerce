<?php
    include 'includes/header.php';
    
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
    require_once '../compose/database.php';
    include_once '../compose/core.php';
    include_once '../compose/objects/rendelesek.php';
    include_once '../compose/objects/customers.php';
    include_once '../compose/objects/rendeles-termekek.php';
    include_once '../compose/objects/product.php';

    $database = new Database();
    $db = $database->getConnection();
    $rendelesek = new Rendelesek($db);
    $customers = new Customers($db);
    $oitems = new OItems($db);
    $product = new Product($db);

    $rendelesek->id = $id;
    $rendelesek->readOne();
    $customers->id=$rendelesek->customer_id;
    $oitems->order_id = $id;
    $stmt = $oitems->readKategorizalt($from_record_num, $records_per_page);
    $total_rows=$oitems->countKategorizalt();
    $customers->readName();

?>

<main>
    <div class="container">
        <div class="row">
            <div class="md-12">
                <div class="box">
                    <h2>#<?php echo $rendelesek->id ?> számú megrendelés</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="md-3">
                <div class="box green-box">
                    <div class="box-icon">
                        <div class="icon">
                            
                        </div>
                    </div>
                    <div class="box-titles">
                        <div class='sub-title'>Merendelés dátuma</div>
                        <span><?php echo $rendelesek->created ?></span>
                    </div>
                </div>
            </div>
            <div class="md-3">
                <div class="box red-box">
                    <div class="box-icon">
                        <div class="icon">
                            
                        </div>
                    </div>
                    <div class="box-titles">
                        <div class='sub-title'>Merendelő neve</div>
                        <span><?php echo $customers->first_name ?> <?php echo $customers->last_name ?></span>
                    </div>
                </div>
            </div>
           
            <div class="md-3">
                <div class="box yellow-box">
                <div class="box-icon">
                        <div class="icon">
                            
                        </div>
                    </div>
                    <div class="box-titles">
                        <div class='sub-title'>E-mail cím</div>
                        <span><?php echo $customers->email ?></span>
                    </div>
                </div>
            </div>
            <div class="md-3">
                <div class="box blue-box">
                <div class="box-icon">
                        <div class="icon">
                            
                        </div>
                    </div>
                    <div class="box-titles">
                        <div class='sub-title'>Telefonszám</div>
                        <span><?php echo $customers->phone ?></span>
                    </div>
                </div>
            </div>

            <div class="md-4">
                <div class="box white-box">
                    <h4>Szállítási adatok</h4>
                    <div class="list-box">
                        <li>Név:</li>
                        <li><?php echo $customers->first_name ?> <?php echo $customers->last_name ?></li>
                    </div>
                    <div class="list-box">
                        <li>Cím:</li>
                        <li><?php echo $customers->irsz ?> <?php echo $customers->city ?>, <?php echo $customers->address ?></li>
                    </div>
                    <div class="list-box">
                        <li>Telefonszám:</li>
                        <li><?php echo $customers->phone ?></li>
                    </div>
                    <div class="list-box">
                        <li>E-mail:</li>
                        <li><?php echo $customers->email ?></li>
                    </div>
                    
                </div>
            </div>
            <div class="md-4">
                <div class="box white-box">
                    <h4>Számlázási adatok</h4>
                    <div class="list-box">
                        <li>Név (Cégnév):</li>
                        <li><?php echo $customers->cegnev ?></li>
                    </div>
                    <div class="list-box">
                        <li>Cím:</li>
                        <li><?php echo $customers->irsz ?> <?php echo $customers->city ?>, <?php echo $customers->address ?></li>
                    </div>
                    <div class="list-box">
                        <li>Adószám:</li>
                        <li><?php echo $customers->adoszam ?></li>
                    </div>
                    <div class="list-box">
                        <li>Telefonszám:</li>
                        <li><?php echo $customers->phone ?></li>
                    </div>

                </div>
            </div>
            <div class="md-4">
                <div class="box white-box">
                    <h4>További adatok</h4>
                    <div class="list-box">
                        <li>Számla:</li>
                        <li><a href="#">#<?php echo $rendelesek->id ?></a></li>
                    </div>
                    <div class="list-box">
                        <li>Megjegyzés:</li>
                        <li><?php echo $customers->megjegyzes ?></li>
                    </div>
                </div>
            </div>

            <div class="md-8">
                <div class="box white-box">
                    <h4>Rendelés összesítő</h4>
                    <?php
                    if ($total_rows > 0) {
                        
                        echo "<table id='order-detail' class='stripe hover'>";
                        echo  "<thead>
                        <tr>
                        <th>Terméknév</th>
                        <th></th>
                        <th>Menny.</th>
                        <th>Br. egységár</th>
                        <th>Nettó egységár</th>
                        <th>Ár</th>
                        </tr>
                        </thead>";
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        $product->id = $product_id;
                        $product->readName();
                        $termekar = $product->ar*$quantity;
                        $netto = $product->ar/1.27;
                        $nettovegosszeg = $rendelesek->grand_total/1.27;
                        $shipping = 1990;
                        $vegosszeg = $rendelesek->grand_total+$shipping;
                        echo "<tbody>";
                        echo "<tr>";
                        echo "<td>$product->name</td>";
                        echo "<td>";
                        echo "<div class='product-image-box'>";
                        echo "<div class='background-img' style='background-image: url(../uploads/$product->image)'></div>";
                        echo "</div>";
                        echo "</td>";
                        echo "<td>$quantity db</td>";
                        echo "<td>$product->ar Ft</td>";
                        echo "<td>";
                        echo(round($netto));
                        echo " Ft</td>";
                        echo "<td>$termekar Ft</td>";
                        echo "</tr>";
                        echo "</tbody>";
                    }
                        echo "</table>";
                    }
                    else {
                        echo "<div class='alert alert-danger'>Nincs leadott termék.</div>";
                    }
                    ?>
            
                    <div class="total-box">
   
                        <div class="list-box">
                            <li>Nettó</li>
                            <li><?php echo (round($nettovegosszeg)) ?> Ft</li>
                        </div>
                        <div class="list-box">
                            <li>Szállítási díj</li>
                            <li><?php echo $shipping ?> Ft</li>
                        </div>
                        <div class="list-box grand-total">
                            <li>Összesen</li>
                            <li><?php echo $vegosszeg ?> Ft</li>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="md-4">
                <div class="box white-box">
                    <h4>Megrendelés státusza</h4>
                    <label for="">
                        <b>Rendelés azonosító</b>
                        <input type="text" class="input-style" value="<?php echo $rendelesek->id ?>">
                    </label>
                    <label for="">
                        <b>Státusz</b>
                        <div class="select">
                        <select id="standard-select">
                          <option value="<?php echo $rendelesek->status ?>"><?php echo $rendelesek->status ?></option>
                          <option value="Készletre vár">Készletre vár</option>
                          <option value="Elfogadva">Elfogadva</option>
  
                        </select>
                      </div>
                    </label>
                    <label for="">
                        <b>Fizetés</b>
                        <div class="select">
                        <select id="standard-select">
                          <option value="Option 1">Bankkártyával fizetve</option>
                          <option value="Option 2">Option 2</option>
                          <option value="Option 3">Option 3</option>
                          <option value="Option 4">Option 4</option>
                          <option value="Option 5">Option 5</option>
                          <option value="Option length">Option that has too long of a value to fit</option>
                        </select>
                      </div>
                    </label>
                    <label for="">
                        <b>Megjegyzés</b>
                        <textarea name="" id="" cols="30" rows="10" class="input-style"></textarea>
                    </label>
                    <button class="btn btn-details btn-block">Változtatások mentése</button>
                    
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