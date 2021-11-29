<?php
    include_once __DIR__ . '/../../connect_db.php';
    $msv = $_GET["mssv"];
    $mahp = $_GET["mahp"];
    $query_dkmh = mysqli_query($conn,"CALL Huy_DKMH('$msv','$mahp')");
?>