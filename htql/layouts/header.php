<?php
    if(session_id()===''){
        session_start();
    }
    include_once __DIR__.'/../../connect_db.php';
        $result_user['Ho_ten']='';
        $result_user['MSSV']='';
        if(isset($_SESSION['user'])){
            $sv = $_SESSION['user'];
            $query = mysqli_query($conn,"CALL student_information('$sv')");
            $result_user = mysqli_fetch_array($query,MYSQLI_ASSOC);
            if($query){
                $query->close();
                $conn->next_result();
            }
        }
    ?>
<header style="position:relative">
    <img src="/../DBMS_HTQLSV/htql/images/Screenshot 2021-11-27 093116.png" width="100%">
    <?php if(isset($_SESSION['user'])):?>
        <div class="btn_logout"><img src="/../DBMS_HTQLSV/htql/images/btn_logout.png"></div>
    <?php endif;?>
    <a href="/../DBMS_HTQLSV/htql/sinhvien/hindex.php" class="home"></a>
    <div class="user_login"><?=$result_user['Ho_ten'].' ('.$result_user['MSSV'].')'?></div>
</header>
<style>
    *{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }
    ::-webkit-scrollbar {
        width: 0px;
        background: transparent; /* make scrollbar transparent */
    }
    .content{
        background-color: white;
        margin-top: 5px;
        border: 1px solid lightgray;
        min-height: 620px;
        border-radius: 2px;
    }
    .wide{
        max-width: 980px;
        margin: 0 auto;
    }
    body{
        background-color:#e8f4ff
    }
    .home{
        position: absolute;
        display: block;
        height: 30px;
        width: 110px;
        top: 33px;
        right: 290px;
        background-color: transparent;
    }
    .btn_logout{
        position: absolute;
        display: block;
        height: 30px;
        width: 110px;
        top: 2px;
        right: 257px;
    }
    .user_login{
        position: absolute;
        font-size: 13px;
        font-weight: 700;
        top: 65px;
        right: 290px;
        color: white;
    }
</style>
