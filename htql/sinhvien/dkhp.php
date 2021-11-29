<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống quản lý - Trường đại học Cần Thơ</title>
</head>
<?php
    $mank = 3;
    $mahk = 2;
?>
<?php include_once __DIR__ . '/../layouts/bootstrap.php'?>
<body>
    <?php include_once __DIR__ . '/../layouts/header.php'?>
    <div class="content wide">
        <?php
            include_once __DIR__ . '/../../connect_db.php';
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
        ?>
        <?php
            $query_DKHP = mysqli_query($conn,"CALL SelectHP_HK('$mssv','$mahk','$mank')");
            $dataDKHP=[];
            $i=1;
            while($result_DKHP = mysqli_fetch_array($query_DKHP,MYSQLI_ASSOC)){
                $dataDKHP[] = array(
                    'STT' => $i,
                    'Ma_mon' => $result_DKHP['Ma_mon'],
                    'Ten_mon' => $result_DKHP['Ten_mon'],
                    'Tin_chi' => $result_DKHP['Tin_chi'],
                    'DKHP' => $result_DKHP['DKHP']
                );
                $i++;
            }
            if($query_DKHP){
                $query_DKHP->close();
                $conn->next_result();
            }
        ?>
        <div style="margin: 35px 25px 0 25px;">
            <div style="display: flex;column-gap: 5px;margin: 10px 0;">
                <div class="btn_khht">Đăng ký học phần</div>
                <div class="btn_khht">Thời khóa biểu</div>
            </div>
            <div>
                <form action="">
                    <table style="width: 100%;font-size: 13px;margin-top: 20px;">
                        <tr>
                            <td colspan="7" class="td_item" style="text-align: center;background-color:#3872b2; color: white;font-weight: bold;">Điểm học tập học kỳ 2 - Năm học 2021 - 2022</td>
                        </tr>
                        <tr>
                            <td class="td_item"width="5%">STT</td>
                            <td class="td_item" width="15%">Mã học phần</td>
                            <td class="td_item" width="40%">Tên học phần</td>
                            <td class="td_item">Nhóm học</td>
                            <td class="td_item">Tín chỉ</td>
                            <td class="td_item">Đăng ký</td>
                        </tr>
                        <?php foreach($dataDKHP as $val_DKHP):?>
                            <tr>
                                <td class="td_item"width="5%"><?=$val_DKHP['STT']?></td>
                                <td class="td_value" width="15%"><?=$val_DKHP['Ma_mon']?></td>
                                <td class="td_value" style="text-align: left;padding-left: 5px;" width="40%"><?=$val_DKHP['Ten_mon']?></td>
                                <td class="td_value">0<?=$val_DKHP['STT']?></td>
                                <td class="td_value"><?=$val_DKHP['Tin_chi']?></td>
                                <td class="td_value">
                                    <?php if($val_DKHP['DKHP']==0):?>
                                    <input type="checkbox" name="DKHP" class="dkhp" data-mssv="<?=$mssv?>" value="<?=$val_DKHP['Ma_mon']?>">
                                    <?php else:?>
                                        <span style="color:#bd2130;"data-mssv="<?=$mssv?>" data-mhp="<?=$val_DKHP['Ma_mon']?>" class="btn_exit"><i class="fas fa-times"></i></span>
                                    <?php endif;?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </form>
                <div style="font-size: 14px;margin-top: 35px;background-color: #F7F7F7;">
                    <ul style="list-style-type: none;">
                        <li>Thời gian sinh viên đăng ký học phần cho học kỳ 2 năm học 2021 - 2022 diễn ra từ ngày <span style="color: red;">29/11/2021 đến hết ngày 5/12/2021</span></li>
                        <li>Số tín chỉ đăng ký tối đa: <span style="font-weight: 600;">25</span> (Bao gồm tín chỉ đăng ký chính thức và đăng ký nhu cầu)</li>
                        <li>Sinh viên xem thêm thông tin chi tiết về kế hoạch đăng ký học phần tại <a style="color: red;" href="https://qldt.ctu.edu.vn/htql/dkmh/student/index.php?action=qdinh_dky">Quy định đăng ký học phần</a> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $(".dkhp").click(function() {
            var mssv = $(this).data("mssv");
            var mahp = $(this).val();
            $.ajax({
                url:"/../../../DBMS_HTQLSV/htql/sinhvien/dkmh.php",
                type:"GET",
                dataType:'json',
                data:{
                    mssv,mahp
                },
                success:function(reponsive){
                    if(reponsive === 'success'){
                        location.reload();
                    }else{
                        alert('Số tín chỉ đăng ký đã vượt qua 25 chỉ');
                    }
                }
            });
        });
        $(".btn_exit").click(function(){
            var mssv = $(this).data("mssv");
            var mahp = $(this).data("mhp");
            $.ajax({
                url:"/../../../DBMS_HTQLSV/htql/sinhvien/xoamh.php",
                type:"GET",
                data:{
                    mssv,mahp
                },
                success:function(reponsive){
                    location.reload();
                }
            });
        });
    });
</script>
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
        text-align: center;
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