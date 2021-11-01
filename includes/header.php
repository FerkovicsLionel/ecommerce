<?php
include_once 'compose/Cart.class.php';
$cart = new Cart;
$url = 'http://192.168.0.18/ecommerce/';
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>printem.hu - Az online nyomda</title>
    <link rel="stylesheet" href="http://192.168.0.18/ecommerce/libs/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <meta name = "viewport" content = "width=device-width, minimum-scale=1.0, maximum-scale = 1.0, user-scalable = no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />

</head>
<body>
<?php $activePage = basename($_SERVER['PHP_SELF'], ".php");?>

<?= ($activePage == 'index') || ($activePage == 'kosaram') || ($activePage == 'penztar') || ($activePage == 'sikeres-rendeles') || ($activePage == 'bejelentkezes') || ($activePage == 'fiokom') || ($activePage == 'rendeleseim') || ($activePage == 'ertekeleseim') || ($activePage == 'rendeles-reszletek') || ($activePage == 'jelszo-modositasa') || ($activePage == 'termekek') ? '
            <nav class="navbar">
                <div class="container">
                    <div class="menu-btn">
                        <span class="first-span"></span>
                        <span class="center-span"></span>
                        <span class="last-span"></span>
                    </div>
                    <ul class="menu">
                        <li><a href="'.$url.'index.php">Főoldal</a></li>
                        <li><a href="rolunk.html">Menü</a></li>
                        <li><a href="'.$url.'kosaram.php">Kosár</a></li>
                    </ul>
                </div>
            </nav>':''; ?>
 
<?= ($activePage == 'termek') ? '<div class="top-bar-black"></div><a href="../index.php" class="back-btn"><i class="fas fa-chevron-left"></i></a>':''; ?>