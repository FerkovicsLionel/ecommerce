<?php
include_once "includes/header.php";
include_once '../compose/core.php';
include_once '../compose/database.php';
include_once '../compose/objects/rendelesek.php';
include_once '../compose/objects/customers.php';
$database = new Database();
$db = $database->getConnection();
$rendelesek = new Rendelesek($db);
$customers = new Customers($db);
$stmt = $rendelesek->readAll($from_record_num, $records_per_page);
$page_url = "index.php?";
 
$total_rows=$rendelesek->countAll();
 

?>
<main>
    <div class="container">
        <div class="row">
            <div class="md-12">
                <div class="box white-box">
                    <?php
                    if($total_rows>0){
                        echo "<table id='myTable' class='stripe'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>ID</th>";
                        echo "<th>Vásárló neve</th>";
                        echo "<th>Rendelés időpontja</th>";
                        echo "<th>Fizetési mód</th>";
                        echo "<th>Végösszeg</th>";
                        echo "<th>Státusz</th>";
                        echo "</tr>";                        
                        echo "</thead>";
                        echo "<tbody>";

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
                        extract($row);
                        echo "<tr>";
                        echo "<td>{$id}</td>";
                        echo "<td>";
                        $customers->id = $customer_id;
                        $customers->readName();
                        echo $customers->first_name . ' ' .$customers->last_name;
                        echo "</td>";
                        echo "<td>{$created}</td>";
                        echo "<td>{$status}</td>";
                        echo "<td>{$grand_total} Ft</td>";
                        echo "<td>";
                        echo "<a href='rendeles-reszletek.php?id={$id}' class='btn btn-details btn-small'>";
                        echo "<span class='glyphicon glyphicon-list'></span> Metrekint";
                        echo "</a>";         
                        echo "<a delete-id='{$id}' class='btn btn-alert delete-object btn-small'>";
                        echo "<span class='glyphicon glyphicon-remove'></span> Töröl";
                        echo "</a>";
                        echo "</td>";
                        echo "</tr>";
         
                    }
         
            echo "</tbody>";
            echo "</table>";
        }
        else{
            echo "<div class='alert alert-danger'>No products found.</div>";
        }

                    ?>
       
                       
                </div>
            </div>
        </div>
    </div>

</main>
<script>
$(document).ready(function() {
    $('#myTable').DataTable( {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/hu.json'
        }
    } );
} );
</script>
<?php include 'includes/footer.php' ?>