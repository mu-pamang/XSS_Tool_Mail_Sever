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
$db_host = "3.39.23.243";
$db_user = "  ";
$db_password = "  ";
$db_name_getin = "getin";

// 연결 생성
$conn_getin = mysqli_connect($db_host, $db_user, $db_password, $db_name_getin);

if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $getid = isset($_REQUEST['id']) ? mysqli_real_escape_string($conn_getin, $_REQUEST['id']) : '';
    $getemail = isset($_REQUEST["email"]) ? mysqli_real_escape_string($conn_getin, $_REQUEST["email"]) : '';

    if (!empty($getid) && !empty($getemail)) {
        $query = "INSERT INTO users (getid, getemail) VALUES ('$getid', '$getemail')";
        
        if (mysqli_query($conn_getin, $query)) {
            echo "<div style='text-align: center;'>";
            echo "<br>";
            echo "<div style=''><h1 style='font-weight: bold;'>데이터 입력 폼 </h1>";
            echo '데이터 삽입 성공여부<br>';
            echo 'Id, Email saved successfully';
            echo "<br>";
        } else {
            echo "<div style='text-align: center;'>";
            echo "<br>";
            echo "<div style=''><h1 style='font-weight: bold;'>데이터 입력 폼 </h1>";
            echo '데이터 삽입 실패: ' . mysqli_error($conn_getin);
            echo "<br>";
        }
    } else {
        // 에러 - 형식이 올바르지 않을 때
        echo "<div style='text-align: center;'>";
        echo "<br>";
        echo "<div style=''><h1 style='font-weight: bold;'>데이터 입력 폼 </h1>";
        echo '데이터 삽입 성공여부<br>';
        echo 'Id, Email Storage Failure';
        echo "<br>";
        //echo "<script>alert('올바르지 않는 형식')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
    <style>
       .sendata{
        text-align: center;
        margin-bottom: 20px;
       }
       .sendata body {
        text-align: center; 
        }

        .sendata {
            margin-top: 50px; 
        }

        .sendata form {
            display: inline-block; 
            padding: 20px; 
            border: 1px solid #ccc; 
            border-radius: 10px; 
        }

        .sendata label {
            display: block; 
            margin-bottom: 10px; 
        }

        .sendata input {
            margin-bottom: 15px; 
        }
        .savebtn {
        text-align: center; 
        margin-top: 20px; 
        }

        input[type="submit"] {
            padding: 10px 20px; 
            font-size: 16px; 
            background-color: black; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: black; 
        }
    </style>
<head>
    <meta charset="UTF-8">
    <title>xss 자동화 도구</title>
</head>
<body>
    <div class="sendata">
    <form method="GET">
        <label for="id">ID: </label>
        <input type="text" id="id" name="id" required>
        <label for="email">Email: </label>
        <input type="email" id="email" name="email" required>
        <div class="savebtn">
        <input type="submit" value="Save">
    </div>
    </form>
</body>
</html>
