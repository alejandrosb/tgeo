<?php
if (!isset($_POST['Newcli'])) {
    header("Location: ../");
} else {

    require_once '../class/geo.class.php';

    $usuarios = Geo::singleton();
    
    $descripcion = $_POST['descri'];
    $lati = $_POST['cu'];
    $lngi = $_POST['cd'];
    $usuarios->insert_usuario($descripcion,$lati,$lngi);
}
?>
