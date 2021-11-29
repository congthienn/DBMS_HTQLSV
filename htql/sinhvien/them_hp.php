<?php
    include_once __DIR__ . '/../../connect_db.php';
    $mahk = $_GET['mahk'];
    $mank  = $_GET['mank'];
    $mahp = $_GET['mahp'];
    $msv = $_GET['msv'];
    $query_KTHP = mysqli_query($conn,"CALL Kiemtra_HP('$msv','$mahp')");
    $result = mysqli_fetch_array($query_KTHP,MYSQLI_ASSOC);
    if($query_KTHP){
        $query_KTHP->close();
        $conn->next_result();
    }
    if($result == 0){
        $query_themHP = mysqli_query($conn,"CALL ThemHP('$msv','$mahk','$mank','$mahp')");
        echo json_encode('success');
    }else{
        echo json_encode('error');
    }
    
?>