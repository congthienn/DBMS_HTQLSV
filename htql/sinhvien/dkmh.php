<?php
    include_once __DIR__ . '/../../connect_db.php';
    $msv = $_GET["mssv"];
    $mahp = $_GET["mahp"];
    $query_TongTC_DKHP = mysqli_query($conn,"CALL TongTC_DKHP('$msv','2','3')");
    $result_TongTC = mysqli_fetch_array($query_TongTC_DKHP,MYSQLI_ASSOC);
    if($query_TongTC_DKHP){
        $query_TongTC_DKHP->close();
        $conn->next_result();
    }
    $query_TCMH = mysqli_query($conn, "CALL Tinchi_MH('$mahp')");
    $result_TC = mysqli_fetch_array($query_TCMH,MYSQLI_ASSOC);
    if($query_TCMH){
        $query_TCMH->close();
        $conn->next_result();
    }
    if($result_TongTC['TongTC'] + $result_TC['Tin_chi'] > 25){
        echo json_encode('error');
    }else{
        $query_dkmh = mysqli_query($conn,"CALL DKMH('$msv','$mahp')");
        echo json_encode('success');
    }  
?>