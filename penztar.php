<?php
include_once 'compose/database.php';
$database = new Database();
$db2 = $database->getConnection();
include_once 'compose/Cart.class.php';
$cart = new Cart;
error_reporting(-1);
ini_set('display_errors', 1);
include_once 'compose/objects/user.php';
if (isset($_SESSION['user_id'])) {
    $user = new User($db2);
    $user->id=$_SESSION['user_id'];
    $user->readOne();
}
$postData = !empty($_SESSION['postData'])?$_SESSION['postData']:array();
unset($_SESSION['postData']);

$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
include 'includes/header.php';
?> 
<main>
    <div class="container">
        <div class="row">
            <div class="md-8">
                <div class="box white-box">
                    <form method="post" action="compose/cartAction.php" class='check'>
                        <h3>Szállítási adatok</h3>
                        
                        <div class="row-50">
                            <label for="szamlazasi_veznev" class='input'>
                                <input type="text" id='szamlazasi_veznev' class="input-style" name="first_name" value="<?php if (isset($user->firstname)) echo $user->firstname;?>" required autocomplete="off">
                                <span class="text">Vezetéknév</span>
                                <div class="focus-border"></div>
                            </label>
                            <label for="szamlazasi_kernev" class='input'>
                                <input type="text" id='szamlazasi_kernev' class="input-style" name="last_name" value="<?php if (isset($user->lastname)) echo $user->lastname;?>" required autocomplete="off">
                                <span class="text">Keresztnév</span>
                                <div class="focus-border"></div>
                            </label>                
                            <label for="szamlazasi_email" class='input'>
                                <input type="text" id='szamlazasi_email' class="input-style" name="email" value="<?php if (isset($user->email)) echo $user->email;?>" required autocomplete="off">
                                <span class="text">E-mail</span>
                                <div class="focus-border"></div>
                            </label> 
                            <label for="szamlazasi_tel" class='input'>
                                <input type="text" id='szamlazasi_tel' class="input-style" name="phone" value="<?php if (isset($user->contact_number)) echo $user->contact_number;?>" required autocomplete="off">
                                <span class="text">Telefonszám</span>
                                <div class="focus-border"></div>
                            </label> 
                        </div>
                        <div class="row-25">
                            <label for="szamlazasi_irsz" class='input'>
                                <input type="text" id='szamlazasi_irsz' class="input-style" name="irsz" value="<?php if (isset($user->irsz)) echo $user->irsz;?>" required autocomplete="off">
                                <span class="text">Irányítószám</span>
                                <div class="focus-border"></div>
                            </label> 
                            <label for="szamlazasi_varos" class='input'>
                                <input type="text" id='szamlazasi_varos' class="input-style" name="city" value="<?php if (isset($user->city)) echo $user->city;?>" required autocomplete="off">
                                <span class="text">Város</span>
                                <div class="focus-border"></div>
                            </label> 
                            <label for="szamlazasi_utca" class='input'>
                                <input type="text" id='szamlazasi_utca' class="input-style" name="address" value="<?php if (isset($user->address)) echo $user->address;?>" required autocomplete="off">
                                <span class="text">Utca, házszám</span>
                                <div class="focus-border"></div>
                            </label> 
                            <label for="szamlazasi_ajto" class='input'>
                                <input type="text" id='szamlazasi_ajto' class="input-style" name="ajto" value="<?php if (isset($user->ajto)) echo $user->ajto;?>" required autocomplete="off">
                                <span class="text">Ajtó</span>
                                <div class="focus-border"></div>
                            </label> 
                        </div>
                        <div class="row-label">
                            <label for="copy" class='checkbox-box'>
                                <input type="checkbox" name="copy" id="copy" class='m-15'>
                                <b>A számlázási adatok megegyeznek a szállítási adatokkal</b>
                            </label>
                        </div>
                            
                        <h3>Számlázási adatok</h3>
                        <div class="row-50">
                            <label for="szallitasi_veznev" class='input'>
                                <input type="text" id='szallitasi_veznev' class="input-style" name="szfirst_name" value="" required autocomplete="off">
                                <span class="text">Vezetéknév</span>
                                <div class="focus-border"></div>
                            </label>
                            <label for="szallitasi_kernev" class='input'>
                                <input type="text" id='szallitasi_kernev' class="input-style" name="szlast_name" value="" required autocomplete="off">
                                <span class="text">Keresztnév</span>
                                <div class="focus-border"></div>
                            </label>                
                 
                            <label for="cegnev" class='input'>
                                <input type="text" id='cegnev' class="input-style" name="cegnev" value="" required autocomplete="off">
                                <span class="text">Cégnév</span>
                                <div class="focus-border"></div>
                            </label> 
                            <label for="adoszam" class='input'>
                                <input type="text" id='adoszam' class="input-style" name="adoszam" value="" required autocomplete="off">
                                <span class="text">Adószám</span>
                                <div class="focus-border"></div>
                            </label> 
                        </div>
                        <div class="row-25">
                            <label for="szallitasi_irsz" class='input'>
                                <input type="text" id='szallitasi_irsz' class="input-style" name="szirsz" value="<?php if (isset($user->irsz)) echo $user->irsz;?>" required autocomplete="off">
                                <span class="text">Irányítószám</span>
                                <div class="focus-border"></div>
                            </label> 
                            <label for="szallitasi_varos" class='input'>
                                <input type="text" id='szallitasi_varos' class="input-style" name="cszity" value="<?php if (isset($user->city)) echo $user->city;?>" required autocomplete="off">
                                <span class="text">Város</span>
                                <div class="focus-border"></div>
                            </label> 
                            <label for="szallitasi_utca" class='input'>
                                <input type="text" id='szallitasi_utca' class="input-style" name="szaddress" value="<?php if (isset($user->address)) echo $user->address;?>" required autocomplete="off">
                                <span class="text">Utca, házszám</span>
                                <div class="focus-border"></div>
                            </label> 
                            <label for="szallitasi_ajto" class='input'>
                                <input type="text" id='szallitasi_ajto' class="input-style" name="szajto" value="<?php if (isset($user->ajto)) echo $user->ajto;?>" required autocomplete="off">
                                <span class="text">Ajtó</span>
                                <div class="focus-border"></div>
                            </label> 
                        </div>
                        <div class="row-50">
                            <label for="">
                                <b>Szállítási mód</b>
                                <div class="select">
                                    <select name='fizmod' id="standard-select">
                                        <option value="Bankkártyás">Bankkártyás fizetés</option>
                                        <option value="Előre utalás">Előre utalás</option>
                                        <option value="Utánvét">Utánvét (személyes átvétel esetén helyben)</option>
                                    </select>
                                </div>
                            </label>
                            <label for="">
                                <b>Fizetési mód</b>
                                <div class="select">
                                    <select name="atvetel" id="standard-select">
                                    <option value="Személyes átvétel">Személyes átvétel</option>
                                            <option value="Futárszolgálat">Futárszolgálat</option>
                                    </select>
                                </div>
                            </label>
                        </div>
                        <div class="row-50">
                            <label for="">
                                <a href="" class="btn btn-alert btn-block">Vissza a kosárhoz</a>
                            </label>
                            <label for="">
                                <input type="hidden" name="action" value="placeOrder"/> 
                                <input class="btn btn-details btn-block" type="submit" name="checkoutSubmit" value="Rendelés leadása">
                            </label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="md-4">
                <div class="box">
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
                                    <h4><?php echo $item["name"]; ?></h4><br>
                                    <?php echo $item["qty"]; ?> db
                                </div>
                                <div class="f-box">
                                    <div class="cart-product-price">
                                        <?php echo ''.$item["subtotal"]; ?> Ft
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php } ?>
                    <div class="box white-box">

                        <h3 class='cart-title'>A rendelés összegzése</h3>
                        <div class="grand-total">
                            <li>Termék(ek) ára</li>
                            <?php if($cart->total_items() > 0){ ?>
        
                            <li class='right' id='vegosszeg'><?php echo ''.$cart->total(); ?></li>Ft
                        </div>
                        <div class="grand-total">
                            <li>Áfa tartalom</li>
                        
                            <li class='right' id='afatartalom'></li>
                        </div>
                        <div class="grand-total">
                            <?php
                            if ($cart->total()<15000) {
                            echo '<li>Szállítási díj:</li>
                            <li class="right" data-price="1300">1300 Ft</li>';
                            }
                            else {
                            echo '<li>Szállítási díj:</li> 
                            <li class="right" data-price="0">ingyenes</li>';
                            }?>
                            <?php } ?>
                        </div>
                        <div class="grand-total totals">
                            <li>Összesen</li>
                            <li class='right'><?php echo ''.$cart->total().' Ft'; ?></li>
                   
                        <?php }else{} ?>
                    </div>
                </div>
                    </div>
        </div>
    </div>
</main>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $('#copy').click(function () {
        if ($(this).is(':checked')) {
            $('#szallitasi_veznev').val($('#szamlazasi_veznev').val());
            $('#szallitasi_kernev').val($('#szamlazasi_kernev').val());
            $('#szallitasi_irsz').val($('#szamlazasi_irsz').val());
            $('#szallitasi_varos').val($('#szamlazasi_varos').val());
            $('#szallitasi_utca').val($('#szamlazasi_utca').val());
            $('#szallitasi_ajto').val($('#szamlazasi_ajto').val());
            $('#szallitasi_csengo').val($('#szamlazasi_csengo').val());
            $('#sztel').val($('#szamlazasi_tel').val());
        }
        else {
            $('#szallitasi_veznev').val('');
            $('#szallitasi_kernev').val('');
            $('#szallitasi_irsz').val('');
            $('#szallitasi_varos').val('');
            $('#szallitasi_utca').val('');
            $('#szallitasi_ajto').val('');
            $('#szallitasi_csengo').val('');
            $('#sztel').val('');
        }
    })
let vegosszeg = Number(document.querySelector('#vegosszeg').innerHTML);
let afatartalom = vegosszeg / 1.27;
let afa = Math.floor(vegosszeg - afatartalom);
let afaBox = document.querySelector('#afatartalom');
afaBox.innerHTML = afa;
</script>
<?php include 'includes/footer.php' ?>