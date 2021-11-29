<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống quản lý - Trường đại học Cần Thơ</title>
</head>
<?php include_once __DIR__ . '/../layouts/bootstrap.php'?>
<body>
    <?php include_once __DIR__ . '/../layouts/header.php'?>
    <?php
        include_once __DIR__ . '/../../connect_db.php';
        $sv = $_SESSION['user'];
        $query_sv = mysqli_query($conn,"CALL student_information('$sv')");
        $khht_sv = mysqli_fetch_array($query_sv,MYSQLI_ASSOC);
        if($query_sv){
            $query_sv->close();
            $conn->next_result();
        }
        $query_khht = mysqli_query($conn,"CALL khht('$sv')");
        $data_khht= [];
        $i=1;
        while($row = mysqli_fetch_array($query_khht,MYSQLI_ASSOC)){
            $data_khht[] = array(
                'STT' => $i,
                'Ma_mon' => $row['Ma_mon'],
                'Ten_mon' => $row['Ten_mon'],
                'Tin_chi' => $row['Tin_chi'],
                'Ten_HK' => $row['Ten_HK'],
                'Ten_NK' => $row['Ten_NK'],
            );
            $i++;
        }
        if($query_khht){
            $query_khht->close();
            $conn->next_result();
        }
    ?>
    <?php
        $query_TC = mysqli_query($conn,"CALL TongTC_KHHT('$sv','','')");
        $result_TC = mysqli_fetch_array($query_TC,MYSQLI_ASSOC);
    ?>
    <div class="content wide">
        
        <div style="margin: 35px 25px 0 25px;">
            <div style="display: flex;column-gap: 5px;margin: 10px 0;">
                <a class="btn_khht" href="/../DBMS_HTQLSV/htql/sinhvien/khht.php">Xem KHHT toàn khóa</a>
                <a class="btn_khht" href="/../DBMS_HTQLSV/htql/sinhvien/skhht.php">Sắp KHHT theo học kỳ</a>
            </div>
            <div>
                <table border="0" style="width: 100%;font-size: 13px;">
                    <tr>
                        <td colspan="6" class="td_item" style="text-align: center;background-color:#3872b2; color: white;font-weight: bold;">Kế Hoạch Học Tập Toàn Khóa</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="td_item" style="text-align: center;background-color: #dae9f3;font-weight: bold;">Mã sinh viên: <?=$khht_sv['MSSV']?> - Họ tên: <?=$khht_sv['Ho_ten']?> - Lớp: <?=$khht_sv['Ma_lop']?></td>
                    </tr>
                    <tr style="background-color:#dae9f3;">
                        <td class="td_item"width="5%">STT</td>
                        <td class="td_item" width="15%">Mã học phần</td>
                        <td class="td_item" width="40%">Tên học phần</td>
                        <td class="td_item">Số TC</td>
                        <td class="td_item">Năm học</td>
                        <td class="td_item">Học kỳ</td>
                    </tr>
                    <?php foreach($data_khht as $val_item):?>
                    <tr>
                        <td class="td_item"><?=$val_item['STT']?></td>
                        <td class="td_value" style="text-align: center;"><?=$val_item['Ma_mon']?></td>
                        <td class="td_value" style="padding-left: 5px;"><?=$val_item['Ten_mon']?></td>
                        <td class="td_value" style="text-align: center;"><?=$val_item['Tin_chi']?></td>
                        <td class="td_value" style="text-align: center;"><?=$val_item['Ten_NK']?></td>
                        <td class="td_value" style="text-align: center;"><?=$val_item['Ten_HK']?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div style="font-size: 15px;font-weight:400;margin: 5px 0 20px 0;color: green;">
                Tổng số tín chỉ: <?=$result_TC['TongTC']?>
            </div>
        </div>
    </div>
</body>
<style>
    .td_item{
        border: 1px solid #80b5d7;
        text-align: center;
        font-weight: bold;
        background-color: #dae9f3
    }
    .td_value{
        border: 1px solid #EBEBE4;
        font-weight: 480;
    }
    td{
        height: 32px;
    }
    .btn_khht{
        border: 1px solid gray;
        background-color: #f7f7f7;
        padding: 5px;
        font-size: 13px;
        cursor: pointer;
        text-decoration: none;
        color: black;
    }
    .btn_khht:hover{
        text-decoration: none;
        color: black;
    }
</style>
</html>