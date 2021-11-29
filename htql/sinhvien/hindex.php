<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống quản lý đào tạo - Trường đại học Cần Thơ</title>
</head>
<?php include_once __DIR__ . '/../layouts/bootstrap.php'?>
<body>
    <?php include_once __DIR__ . '/../layouts/header.php'?>
    <div class="content wide">
        <div style="display: flex;">
            <div>
                <div class="student_information">
                    <?php
                        include_once __DIR__ . '/../../connect_db.php';
                        if(session_id()===''){
                            session_start();
                        }
                        $mssv = $_SESSION['user'];
                        $query_student = mysqli_query($conn,"CALL student_information('$mssv')");
                        $sv = mysqli_fetch_array($query_student,MYSQLI_ASSOC);
                    ?>
                    <div style="margin:10px 10px 10px 20px;padding: 2px 5px; border: 1px solid lightgray;border-radius: 2px;">
                        <div style="text-transform: uppercase;font-size: 14px;font-weight: 700;color: darkblue;text-align: center;margin: 15px 0;">Thông tin sinh viên</div>
                        <div style="font-size: 14px;">
                            <div class="info_item">
                                <span class="label">Mã sinh viên:</span>
                                <span class="value"><?=$sv['MSSV']?></span>
                            </div>
                            <div class="info_item">
                                <span class="label">Họ và tên:</span>
                                <span class="value"><?=$sv['Ho_ten']?></span>
                            </div>
                            <div class="info_item">
                                <span class="label">Ngày sinh:</span>
                                <span class="value"><?=date('d-m-Y',strtotime($sv['Ngay_sinh']))?></span>
                            </div>
                            <div class="info_item">
                                <span class="label">Giới tính:</span>
                                <span class="value"><?=($sv['Gioi_tinh'] == 1 ? 'Nam' : 'Nữ')?></span>
                            </div>
                            <div class="info_item">
                                <span class="label">Địa chỉ: </span>
                                <span class="value"><?=$sv['Dia_chi']?></span>
                            </div>
                            <div class="info_item">
                                <span class="label">Lớp học: </span>
                                <span class="value"><?=$sv['Ma_lop']?></span>
                            </div>
                            <div class="info_item">
                                <span class="label">Ngành học: </span>
                                <span class="value"><?=$sv['Ten_nganh']?></span>
                            </div>
                            <div class="info_item">
                                <span class="label">Khóa học: </span>
                                <span class="value"><?=$sv['Khoa_hoc']?> (<?=$sv['Nam_BD']?>)</span>
                            </div>
                            <div class="info_item">
                                <span class="label">Khoa: </span>
                                <span class="value">Công nghệ thông tin và truyền thông</span>
                            </div>
                        </div>
                    </div>
                    <div style="margin:10px 10px 10px 20px;padding: 2px 5px; border: 1px solid lightgray;border-radius: 2px;">
                        <div style="text-transform: uppercase;font-size: 14px;font-weight: 700;color: darkblue;text-align: center;margin: 5px 0;">Cố vấn học tập</div>
                        <div style="font-size: 14px;">
                            <div class="info_item">
                                <span class="label">Mã giảng viên:</span>
                                <span class="value"><?=$sv['Ma_GV']?></span>
                            </div>
                            <div class="info_item">
                                <span class="label">Tên giảng viên:</span>
                                <span class="value"><?=$sv['Ten_GV']?></span>
                            </div>
                            <div class="info_item">
                                <span class="label">Email:</span>
                                <span class="value"><?=$sv['Email']?></span>
                            </div>
                            <div class="info_item">
                                <span class="label">Số điện thoại:</span>
                                <span class="value"><?=$sv['SoDienthoai']?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="flex: 1;">
                <div style="margin:10px 20px 10px 10px;padding: 2px 5px; border: 1px solid lightgray;border-radius: 2px;min-height: 420px;">
                    <div style="display: flex;flex-wrap: wrap;align-items: center;justify-content: center;">
                        <div class="link">
                            <a href="/../DBMS_HTQLSV/htql/sinhvien/khht.php"><img src="/../DBMS_HTQLSV/htql/images/khht.gif" width="50px"></a>
                            <div>Kế hoạch học tập</div>
                        </div>
                        <div class="link">
                            <a href="/../DBMS_HTQLSV/htql/sinhvien/dkhp.php"><img src="/../DBMS_HTQLSV/htql/images/hetinchi.gif"  width="50px"></a>
                            <div>Đăng ký học phần</div>
                        </div>
                        <div class="link">
                            <a href="/../DBMS_HTQLSV/htql/sinhvien/kqht.php"><img src="/../DBMS_HTQLSV/htql/images/ql_diem.gif"  width="50px"></a>
                            <div>Kết quả học tập</div>
                        </div>
                        <div class="link">
                            <img src="/../DBMS_HTQLSV/htql/images/ctdt.gif"  width="50px">
                            <div>Kết quả tốt nghiệp</div>
                        </div> 
                        <div class="link">
                            <img src="/../DBMS_HTQLSV/htql/images/icon-nckh.jpg"  width="50px">
                            <div>Nghiên cứu khoa học</div>
                        </div>
                        <div class="link">
                            <img src="/../DBMS_HTQLSV/htql/images/ktx.png"  width="50px">
                            <div>Ký túc xá</div>
                        </div>
                        <div class="link">
                            <img src="/../DBMS_HTQLSV/htql/images/icon-oss.jpg"  width="50px">
                            <div>Lấy ý kiến trực tuyến</div>
                        </div>
                        <div class="link">
                            <img src="/../DBMS_HTQLSV/htql/images/hetinchi (1).gif"  width="50px">
                            <div>Điểm rèn luyện</div>
                        </div>
                        <div class="link">
                            <img src="/../DBMS_HTQLSV/htql/images/HuyHieuDoan.jpg"  width="50px">
                            <div>Đoàn viên</div>
                        </div>
                        <div class="link">
                            <img src="/../DBMS_HTQLSV/htql/images/qlph.gif"  width="50px">
                            <div>Phòng học</div>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<style>
    
    .label{
        display: inline-block;
        min-width: 90px;
        background-color: #f0f0f0;
        margin-right: 10px;
    }
    .value{
        color: darkblue;
        font-weight: 500;
    }
    .info_item{
      
        padding: 7px 0;
        border-top: 1px gainsboro solid;
    }
    .link{
        margin: 8px 0;
        min-width: 200px;
        text-align: center;
    }
    .link div{
        font-weight: 500;
        color: black;
    }
</style>
</html>