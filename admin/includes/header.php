<?php
if(!isset($_SESSION['cart'])){
	$_SESSION['cart']=array();
}

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LionE</title>
    <link rel="stylesheet" href="libs/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

</head>
<body>
<div class="navigation">
<?php $activePage = basename($_SERVER['PHP_SELF'], ".php");
?>
    <ul>


    
    <li class="list <?= ($activePage == 'index') ? 'active-link':''; ?>">
            <a href="index.php">
                <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                <span class="title">Kezdőlap</span>
            </a>
        </li>
        <li class="list <?= ($activePage == 'project') ? 'active-link':''; ?>">
            <a href="project.php">
                <span class="icon"><ion-icon name="add-outline"></ion-icon></span>
                <span class="title">Új projekt</span>
            </a>
        </li>
        <li class="list <?= ($activePage == 'termekcsoport-letrehozas') ? 'active-link':''; ?>">
            <a href="termekcsoport-letrehozas.php">
                <span class="icon"><ion-icon name="cube-outline"></ion-icon></span>
                <span class="title">Termék csoportok</span>
            </a>
        </li>
        <li class="list <?= ($activePage == 'termekek') ? 'active-link':''; ?>">
            <a href="termekek.php">
                <span class="icon"><ion-icon name="cube-outline"></ion-icon></span>
                <span class="title">Termékek</span>
            </a>
        </li>
        <li class="list <?= ($activePage == 'clients') || ($activePage == 'search-client') || ($activePage == 'edit-clients') || ($activePage == 'clients-project') ? 'active-link':''; ?>">
            <a href="clients.php">
                <span class="icon"><ion-icon name="people"></ion-icon></span>
                <span class="title">Ügyfelek</span>
            </a>
        </li>

        <li class="list <?= ($activePage == 'setup') ? 'active-link':''; ?>">
            <a href="setup.php">
                <span class="icon"><ion-icon name="settings-outline"></ion-icon></span>
                <span class="title">Beállítások</span>
            </a>
        </li>
        <li class="list <?= ($activePage == 'archive') ? 'active-link':''; ?>">
            <a href="archive.php">
                <span class="icon"><ion-icon name="archive"></ion-icon></span>
                <span class="title">Archív</span>
            </a>
        </li>
        <li class="list <?= ($activePage == 'logout') ? 'active-link':''; ?>">
            <a href="logout.php">
                <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                <span class="title">Kijelentkezés</span>
            </a>
        </li>
    </ul>
</div>
