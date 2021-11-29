<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống quản lý - Trường đại học Cần Thơ</title>
</head>
<?php
    $mank = isset($_POST['mank']) ? $_POST['mank'] : 3;
    $mahk = isset($_POST['mahk']) ? $_POST['mahk'] : 1;
?>
<?php include_once __DIR__ . '/../layouts/bootstrap.php'?>
<body>
    <?php include_once __DIR__ . '/../layouts/header.php'?>
    <div class="content wide">
        <?php
            include_once __DIR__ . '/../../connect_db.php';
            $query_hk = mysqli_query($conn,"CALL Select_HK()");
            $data_hk=[];
            while($result_HK = mysqli_fetch_array($query_hk,MYSQLI_ASSOC)){
                $data_hk[] = array(
                    'Ma_HK' => $result_HK['Ma_HK'],
                    'Ten_HK' => $result_HK['Ten_HK']
                );
            }
            if($query_hk){
                $query_hk->close();
                $conn->next_result();
            }
            $mssv = $_SESSION['user'];
            $query_sv = mysqli_query($conn,"CALL student_information('$mssv')");
            $result_sv = mysqli_fetch_array($query_sv,MYSQLI_ASSOC);
            $namBD = $result_sv['Nam_BD'];
            $date = getdate();
            $year_now = $date['year'];
            $length = $year_now - $namBD + 1;
            if($query_sv){
                $query_sv->close();
                $conn->next_result();
            }
            $dataNK=[];
            $query_NK = mysqli_query($conn,"CALL Select_NK_Dahoc('$namBD','$length')");
            while($result_NK = mysqli_fetch_array($query_NK,MYSQLI_ASSOC)){
                $dataNK[] = array(
                    'Ma_NK' => $result_NK['Ma_NK'],
                    'Ten_NK' => $result_NK['Ten_NK']
                );
            }
            if($query_NK){
                $query_NK->close();
                $conn->next_result();
            }
        ?>
        <?php
            $query_DiemHT = mysqli_query($conn,"CALL DiemHT_HK('$mssv','$mahk','$mank')");
            $dataDiemHT=[];
            $i=1;
            while($result_DiemHT = mysqli_fetch_array($query_DiemHT,MYSQLI_ASSOC)){
                $dataDiemHT[] = array(
                    'STT' => $i,
                    'Ma_mon' => $result_DiemHT['Ma_mon'],
                    'Ten_mon' => $result_DiemHT['Ten_mon'],
                    'Tin_chi' => $result_DiemHT['Tin_chi'],
                    'Diem_so' => $result_DiemHT['Diem_so'],
                    'Diem_chu' => $result_DiemHT['Diem_chu']
                );
                $i++;
            }
            if($query_DiemHT){
                $query_DiemHT->close();
                $conn->next_result();
            }
        ?>
        <div style="margin: 35px 25px 0 25px;">
            <div style="display: flex;column-gap: 5px;margin: 10px 0;">
                <div class="btn_khht">Xem kết quả học tập</div>
                <div class="btn_khht">In bảng điểm cá nhân</div>
            </div>
            <div>
               
                <table style="width: 100%;font-size: 13px;">
                    <tr>
                        <td colspan="6" class="td_item" style="text-align: center;background-color:#3872b2; color: white;font-weight: bold;">Xem điểm học kì</td>
                    </tr>
                    <tr>
                        <td style="background-color: #dae9f3;">
                            <form method="POST">
                                <div style="display: flex; align-items: center;justify-content: center; column-gap: 40px;height: 60px;">
                                    <div>
                                        <label for="mank" style="font-weight: bold;">Năm học: </label>
                                        <select name="mank" id="mank" style="border: 1px solid gray;width: 100px;">
                                            <?php foreach($dataNK as $val_NK):?>
                                                <?php if($mank == $val_NK['Ma_NK']):?>
                                                    <option value="<?=$val_NK['Ma_NK']?>" selected><?=$val_NK['Ten_NK']?></option>
                                                    <?php $ten_nk=$val_NK['Ten_NK']?>
                                                <?php else:?>
                                                    <option value="<?=$val_NK['Ma_NK']?>"><?=$val_NK['Ten_NK']?></option>
                                                <?php endif;?>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="mahk" style="font-weight: bold;">Học kỳ</label>
                                        <select name="mahk" id="mahk" style="border: 1px solid gray;width: 80px;">
                                        <?php $ten_nk;?>
                                            <?php foreach($data_hk as $val_hk):?>
                                                <?php if($mahk == $val_hk['Ma_HK']):?>
                                                    <option value="<?=$val_hk['Ma_HK']?>" selected><?=$val_hk['Ten_HK']?></option>
                                                  
                                                <?php else:?>
                                                    <option value="<?=$val_hk['Ma_HK']?>"><?=$val_hk['Ten_HK']?></option>
                                                <?php endif;?>
                                            <?php endforeach;?>
                                        </select>
                                        <button type="submit" style="border: 1px solid #3872b2;padding: 3px 6px;background-color:#3872b2;color: white;font-weight: 500;cursor: pointer;">Liệt kê</button>
                                    </div>
                                </div>
                            </form>
                        </td>
                    </tr>
                </table>
                <?php if(!empty($dataDiemHT)):?>
                <table style="width: 100%;font-size: 13px;margin-top: 20px;">
                    <tr>
                        <td colspan="7" class="td_item" style="text-align: center;background-color:#3872b2; color: white;font-weight: bold;">Điểm học tập học kỳ <?=$mahk?> - Năm học <?=$ten_nk?></td>
                    </tr>
                    <tr>
                        <td class="td_item"width="5%">STT</td>
                        <td class="td_item" width="15%">Mã học phần</td>
                        <td class="td_item" width="40%">Tên học phần</td>
                        <td class="td_item">Điều kiện</td>
                        <td class="td_item">Tín chỉ</td>
                        <td class="td_item">Điểm chữ</td>
                        <td class="td_item">Điểm số</td>
                    </tr>
                    <?php foreach($dataDiemHT as $valDiemHT):?>
                        <tr>
                            <td class="td_item"><?=$valDiemHT['STT']?></td>
                            <td class="td_value" style="text-align:center"><?=$valDiemHT['Ma_mon']?></td>
                            <td class="td_value" style="padding-left: 5px;"><?=$valDiemHT['Ten_mon']?></td>
                            <td class="td_value"></td>
                            <td class="td_value"style="text-align:center"><?=$valDiemHT['Tin_chi']?></td>
                            <td class="td_value"style="text-align:center"><?=$valDiemHT['Diem_chu']?></td>
                            <td class="td_value"style="text-align:center"><?=$valDiemHT['Diem_so']?></td>
                        </tr>
                    <?php endforeach;?>
                    <?php
                        $query_TBTL_HK = mysqli_query($conn,"CALL Diem_TBTL_HK('$mssv','$mahk','$mank')");
                        $result_TBTL_HK = mysqli_fetch_array($query_TBTL_HK,MYSQLI_ASSOC);
                        if($query_TBTL_HK){
                                $query_TBTL_HK->close();
                                $conn->next_result();
                        }
                    ?>
                    
                </table>
                    <?php if((number_format($result_TBTL_HK['tbtl'],0,',','.')!=0)):?>
                        <table style="font-weight: 500;font-size: 14px;">
                            <tr>
                                <td width="250px">
                                    <?php
                                        $query_TinchiHK = mysqli_query($conn,"CALL TongTC_TL_HK('$mssv','$mahk','$mank')");
                                        $result_TC = mysqli_fetch_array($query_TinchiHK,MYSQLI_ASSOC);
                                        if($query_TinchiHK){
                                            $query_TinchiHK->close();
                                            $conn->next_result();
                                        }
                                    ?>
                                    <span style="display:block;">Tổng số tín chỉ tích lũy học kỳ  </span>
                                </td>
                                <td width="150px"><?=$result_TC['TongTC']?></td>
                                <td  width="200px" style="font-weight: 500;font-size: 14px;">
                                    <span style="display:block;">Điểm trung bình học kỳ</span>
                                </td>
                                <td width=""><?=number_format($result_TBTL_HK['tbtl'],2,'.',',')?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 500;font-size: 14px;">
                                    <?php
                                        $query_TinchiTL = mysqli_query($conn,"CALL TongTC_TL('$mssv','$mahk','$mank')");
                                        $result_TCTL = mysqli_fetch_array($query_TinchiTL,MYSQLI_ASSOC);
                                        if($query_TinchiTL){
                                            $query_TinchiTL->close();
                                            $conn->next_result();
                                        }
                                    ?>
                                    <span style="display:block;">Tổng số tín chỉ tích lũy</span>
                                </td>
                                <td><?=$result_TCTL['TongTC']?></td>
                                <td style="font-weight: 500;font-size: 14px;">
                                    <?php
                                        $query_TBTL = mysqli_query($conn,"CALL DiemTb_TL('$mssv','$mahk','$mank')");
                                        $result_TBTL = mysqli_fetch_array($query_TBTL,MYSQLI_ASSOC);
                                    ?>
                                    <span style="display:block;">Điểm trung bình tích lũy</span>
                                </td>
                                <td><?=number_format($result_TBTL['tbtl'],2,'.',',')?></td>
                            </tr>
                        </table>
                    <?php endif;?>
                <?php endif; ?>
                <div style="font-size: 14px;margin-top: 35px;background-color: #F7F7F7;">
                    <ul style="list-style-type: none;">
                        <li>Nếu có sai sót các bạn vui lòng phản ánh về địa chỉ sau: <span style="color: red;">vantu@ctu.edu.vn </span>để kiểm tra.</li>
                        <li>Hệ thống đang xử lý điểm, SV xem điểm trung bình HK3 vào ngày 19/8/2021.</li>
                        <li>Cách tính điểm trung bình xem tại đây <span style="color: green;">[http://bit.ly/31raQo5]</span> .</li>
                        <li><span style="color:red">Theo quy chế học vụ <span style="color:green">(xem tại đây)</span> từ học kỳ 1 năm học 2016-2017 các học phần Giáo dục thể chất không tính vào điểm bình chung học kỳ</span>.</li>
                    </ul>
                </div>
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
    }
</style>
</html>