<?php
include_once "compose/core.php";
session_destroy();
header("Location: {$home_url}bejelentkezes.php");
?>