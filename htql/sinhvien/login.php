<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đào tạo - TRƯỜNG ĐẠI HỌC CẦN THƠ</title>
</head>
<?php include_once __DIR__ . '/../layouts/bootstrap.php'?>
<?php
    if(session_id()===''){
        session_start();
    }
?>
<body style="background-color:#e8f4ff">
    <div class="content wide">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-2"></div>
                <div class="col-lg-6 col-md-8 login-box">
                    <div style="display: flex;align-items: center;column-gap: 25px;padding: 0 25px;margin: 25px 0 15px;" >
                        <div class="login-key">
                        <img src="/../DBMS_HTQLSV/htql/images/1200px-Logo_Dai_hoc_Can_Tho.svg.png" width="120px">
                        </div>
                        <div class=" login-title">
                            HỆ THỐNG QUẢN LÝ
                        </div>
                    </div>
                    <div class="col-lg-12 login-form">
                        <div class="col-lg-12 login-form">
                            <form  method="post">
                                <div class="form-group">
                                    <label class="form-control-label" for="mssv" >MÃ SỐ SINH VIÊN</label>
                                    <input type="text" class="form-control" name="mssv" id="mssv">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="password">MẬT KHẨU</label>
                                    <input type="password" class="form-control" name="password" id="password">
                                </div>

                                <div class="col-lg-12 loginbttm">
                                    <div class="col-lg-6 login-btm login-text">
                                    </div>
                                    <div class="col-lg-6 login-btm login-button">
                                        <button type="submit" class="btn btn-outline-primary" name="login">LOGIN</button>
                                    </div>
                                </div>
                            </form>
                            <?php
                                include_once __DIR__ . '/../../connect_db.php';
                                if(isset($_POST['login'])){
                                    $mssv = trim($_POST['mssv']);
                                    $password = trim($_POST['password']);
                                    $query_login = mysqli_query($conn,"CALL login_user('$mssv','$password')");
                                    $user = mysqli_fetch_array($query_login,MYSQLI_ASSOC);
                                    if($user == 0){
                                        echo "<script>alert('Tên đăng nhập hoặc mật khẩu không đúng')</script>";
                                    }else{
                                        $_SESSION['user'] = $user['MSSV'];
                                        echo "<script>location.replace('/../../../DBMS_HTQLSV/htql/sinhvien/hindex.php')</script>";
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<style>
    .content{
        display: flex;
        margin: auto;
    }
    body {
    background: #222D32;
    font-family: 'Roboto', sans-serif;
    }
    .login-box {
        margin-top: 120px;
        height: auto;
        background: white;
        text-align: center;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        border-radius: 4px;
    }

    .login-title {
        margin-top: 15px;
        text-align: center;
        font-size: 30px;
        letter-spacing: 2px;
        margin-top: 15px;
        font-weight: bold;
        color: black;
    }

    .login-form {
        margin-top: 25px;
        text-align: left;
    }

    input[type=text] {
        background-color: white;
        border: none;
        border-bottom: 1px solid black;
        border-top: 0px;
        border-radius: 0px;
        font-size: 17px;
        outline: 0;
        margin-bottom: 20px;
        padding-left: 0px;
        color: black;
    }

    input[type=password] {
        background-color: white;
        border: none;
        border-bottom: 1px solid black;
        border-top: 0px;
        border-radius: 0px;
        font-size: 17px;
        outline: 0;
        padding-left: 0px;
        margin-bottom: -10px;
        color: black;
    }

    .form-group {
        margin-bottom: 40px;
        outline: 0px;
    }

    .form-control:focus {
        border-color: inherit;
        -webkit-box-shadow: none;
        box-shadow: none;
        border-bottom: 1px solid black;
        outline: 0;
        background-color: white;
        color: black;
    }

    input:focus {
        outline: none;
        box-shadow: 0 0 0;
    }

    label {
        margin-bottom: 0px;
    }

    .form-control-label {
        font-size: 17px;
        color: black;
        font-weight: bold;
        letter-spacing: 1px;
    }

    .btn-outline-primary {
        border-color: black;
        color: black;
        border-radius: 0px;
        font-weight: bold;
        letter-spacing: 1px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
    }

    .btn-outline-primary:hover {
        background-color: black;
        right: 0px;
    }

    .login-btm {
        float: right;
    }

    .login-button {
        padding-right: 0px;
        text-align: right;
        margin-bottom: 40px;
    }

    .login-text {
        text-align: left;
        padding-left: 0px;
        color: #A2A4A4;
    }

    .loginbttm {
        padding: 0px;
    }
</style>
</html>