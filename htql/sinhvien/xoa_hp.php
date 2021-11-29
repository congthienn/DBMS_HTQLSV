<?php
    include_once __DIR__ . '/../../connect_db.php';
    $mahp = $_GET['mahp'];
    $msv = $_GET['msv'];
    $query_xoaHP = mysqli_query($conn,"CALL Xoa_HP('$msv','$mahp')");
?>