<?php
if (!isset($_POST['bookId'])) {
    header("Location: ../index.php");
} else {

    require_once '../class/geo.class.php';

    $usuarios = Geo::singleton();

    $id = $_POST['bookId'];
    $usuarios->delete_geo($id);
}
?>
