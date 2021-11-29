<?php
     $server_name = 'localhost';
     $user_name = 'root';
     $password = '';
     $db = 'dbms_htqlsv';
     $conn = mysqli_connect($server_name,$user_name,$password,$db);
     mysqli_set_charset($conn,'UTF8');
     mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
?>