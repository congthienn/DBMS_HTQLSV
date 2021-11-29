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
    $mahk = isset($_POST['mahk']) ? $_POST['mahk'] : 2;
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
            }$mssv = $_SESSION['user'];
            $query_sv = mysqli_query($conn,"CALL student_information('$mssv')");
            $result_sv = mysqli_fetch_array($query_sv,MYSQLI_ASSOC);
            $namBD = $result_sv['Nam_BD'];
            if($query_sv){
                $query_sv->close();
                $conn->next_result();
            }
            $date = getdate();
            $year_now = $date['year'];
            $dataNK=[];
            $query_NK = mysqli_query($conn,"CALL Select_NK_DKHP('$year_now')");
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
        <div style="margin: 35px 25px 0 25px;">
            <div style="display: flex;column-gap: 5px;margin: 10px 0;">
                <a class="btn_khht" href="/../DBMS_HTQLSV/htql/sinhvien/khht.php">Xem KHHT toàn khóa</a>
                <a class="btn_khht" href="/../DBMS_HTQLSV/htql/sinhvien/skhht.php">Sắp KHHT theo học kỳ</a>
            </div>
            <div>
                <table style="width: 100%;font-size: 13px;">
                    <tr>
                        <td colspan="6" class="td_item" style="text-align: center;background-color:#3872b2; color: white;font-weight: bold;">Điều chỉnh kế hoạch học tập theo học kỳ</td>
                    </tr>
                    <tr>
                        <td style="background-color: #dae9f3;">
                            <form method="POST">
                                <div style="display: flex; align-items: center;justify-content: center; column-gap: 40px;height: 44px;">
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
                            <div style="border-top: 1px solid #80b5d7;padding: 10px 0;display: flex;justify-content: center;align-items: center;column-gap: 10px;">
                                <label style="font-weight: bold;" for="ma_hp">Mã học phần</label>
                                <div>
                                    <input type="text" id="ma_hp">
                                    <button type="submit" id="search_HP" style="border: 1px solid #3872b2;padding: 3px 6px;background-color:#3872b2;color: white;font-weight: 500;cursor: pointer;">Tìm HP</button>
                                </div>
                            </div>
                            <div>
                                <?php
                                    $query_mh = mysqli_query($conn,"CALL Select_Monhoc()");
                                    $dataMH = [];
                                    while($row = mysqli_fetch_array($query_mh,MYSQLI_ASSOC)){
                                        $dataMH[] = array(
                                            'Ma_mon' => $row['Ma_mon'],
                                            'Ten_mon' => $row['Ten_mon'],
                                            'Tin_chi' => $row['Tin_chi']
                                        );
                                    }
                                    if($query_mh){
                                        $query_mh->close();
                                        $conn->next_result();
                                    }
                                ?>
                                <table id='dshp' style="font-weight: 600;font-size: 14px;">
                                    <?php foreach($dataMH as $valMH):?>
                                        <tr class="HP" data-HP="<?=$valMH['Ma_mon']?>" id="<?=$valMH['Ma_mon']?>">
                                            <td style="padding: 0 20px;" width="200px">Mã học phần: <?=$valMH['Ma_mon']?></td>
                                            <td width="400px">Tên học phần: <?=$valMH['Ten_mon']?></td>
                                            <td width="237px">Tín chỉ: <?=$valMH['Tin_chi']?> TC</td>
                                            <td style="padding-right: 20px;"> <button type="submit" class="btn_them_HP" data-msv="<?=$mssv?>" data-mhk="<?=$mahk?>" data-mnk="<?=$mank?>" data-mhp="<?=$valMH['Ma_mon']?>">Thêm HP</button></td>
                                        </tr>
                                    <?php endforeach;?>
                                   <div class="error" style="font-weight: 600;font-size: 14px;text-align: center;padding: 5px 0;border-top: 1px solid #80b5d7;">Không tìm thấy học phần phù hợp</div>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%;font-size: 13px;margin-top: 20px;">
                    <tr>
                        <td colspan="7" class="td_item" style="text-align: center;background-color:#3872b2; color: white;font-weight: bold;">Kế hoạch tập học kỳ <?=$mahk?> - Năm học <?=$ten_nk?></td>
                    </tr>
                    <tr>
                        <td class="td_item"width="5%">STT</td>
                        <td class="td_item" width="15%">Mã học phần</td>
                        <td class="td_item" width="40%">Tên học phần</td>
                        <td class="td_item">Điều kiện</td>
                        <td class="td_item">Tín chỉ</td>
                        <td class="td_item">Xóa HP</td>
                    </tr>
                    <?php
                        $data_HP=[];
                        $query_HP_HK = mysqli_query($conn,"CALL SelectHP_HK('$mssv','$mahk','$mank')");
                        $i=1;
                        while($row = mysqli_fetch_array($query_HP_HK,MYSQLI_ASSOC)){
                            $data_HP[] = array(
                                'STT' => $i,
                                'Ma_mon' => $row['Ma_mon'],
                                'Ten_mon' => $row['Ten_mon'],
                                'Tin_chi' => $row['Tin_chi'],
                                'DKHP' => $row['DKHP'],
                            );
                            $i++;
                        }
                        if($query_HP_HK){
                            $query_HP_HK->close();
                            $conn->next_result();
                        }
                    ?>
                    <?php foreach($data_HP as $val_HP):?>
                        <tr>
                            <td class="td_item"><?=$val_HP['STT']?></td>
                            <td class="td_value"><?=$val_HP['Ma_mon']?></td>
                            <td style="padding-left: 5px; text-align: left;" class="td_value"><?=$val_HP['Ten_mon']?></td>
                            <td class="td_value"></td>
                            <td class="td_value"><?=$val_HP['Tin_chi']?></td>
                            <td class="td_value" style="color: #bd2130;">
                                <?php if($val_HP['DKHP']==0):?>
                                    <i class="fas fa-times btn_exit" data-msv="<?=$mssv?>" data-mhk="<?=$mahk?>" data-mnk="<?=$mank?>" data-mhp="<?=$val_HP['Ma_mon']?>"></i>
                                <?php else:?>
                                    <i class="fas fa-check" style="color: green;"></i>
                                <?php endif;?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function(){
        $("#search_HP").click(function(){ 
            $(".HP").removeClass("show");
            $(".error").hide();
            const HP = $("#ma_hp").val();
            var searchHP = $("#dshp").find("#"+HP);
            if(searchHP.length !=0){
                $("#"+HP).addClass("show");
            }else{
                $(".error").show();
            }
        });
        $(".btn_them_HP").click(function(){
            var mahk = $(this).data('mhk');
            var mank = $(this).data('mnk');
            var mahp = $(this).data('mhp');
            var msv = $(this).data('msv');
            $.ajax({
                url:'/../../../DBMS_HTQLSV/htql/sinhvien/them_hp.php',
                type:'get',
                dataType:'json',
                data:{
                    mahk,mank,mahp,msv
                },
                success:function(data){
                    if(data === 'success'){
                        location.reload();
                    }else{
                        alert("Học phần đã tồn tại trong KHHT");
                    }
                }

            })
        });
        $(".btn_exit").click(function(){
            var mahp = $(this).data('mhp');
            var msv = $(this).data('msv');
            $.ajax({
                url:'/../../../DBMS_HTQLSV/htql/sinhvien/xoa_hp.php',
                type:'get',
                data:{
                    mahp,msv
                },
                success:function(data){
                    location.reload()
                }

            })
        })
    });
</script>
<style>
    .btn_them_HP{
        border: 1px solid #3872b2;padding: 3px 6px;background-color:#3872b2;color: white;font-weight: 500;cursor: pointer;font-size: 13px;
    }
    .error{
        display: none;
    }
    .HP{
        display: none;
        border: 1px solid #80b5d7;

    }
    .HP.show{
        display: block;
    }
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
        text-decoration: none;
        color: black;
    }
    .btn_khht:hover{
        text-decoration: none;
        color: black;
    }
    label{
        margin-bottom:0 !important;
    }
    .btn_exit{
        cursor: pointer;
    }
</style>
</html>