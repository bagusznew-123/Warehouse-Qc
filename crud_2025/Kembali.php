<?php
session_start();
session_destroy();

// balik ke halaman login di folder Login Warehouse
header("Location:indexmenu.php");
exit;
?>