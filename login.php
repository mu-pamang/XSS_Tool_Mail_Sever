<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$wu = 0; 
$wp = 0; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = isset($_POST['userID']) ? $_POST['userID'] : null;
    $userPW = isset($_POST['userPW']) ? $_POST['userPW'] : null;

    if (!empty($userID) && !empty($userPW)) {
        $db_id = "  ";
        $db_pw = "  ";
        $db_name = "mem";
        $db_host = "3.39.23.243";

        $conn = mysqli_connect($db_host, $db_id, $db_pw, $db_name);

        if (mysqli_connect_errno()) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT userpwd FROM member WHERE userid = '$userID'";
        $result = mysqli_query($conn, $sql);
        //echo $sql;

        if(!$result){
            die("Query failed: " . mysqli_error($conn));
        }

        $stored_password = null;
       
        while ($row = mysqli_fetch_array($result)) {
            $stored_password = $row['userpwd'];
        }

        if (is_null($stored_password)) {
            $wu = 1; // 아이디가 존재하지 않음
        } else {
            // 비밀번호 일치 여부 확인 (password_verify 함수 사용)
            if ($userPW == $stored_password) {
                // 로그인 성공
                session_start();
                //$_SESSION['roll'] = $userRoll;
                $_SESSION['userID'] = $userID;
                //echo $userID;
                echo "<script>alert('로그인 성공.'); window.location.href='admin.php';</script>";
                exit;
            } else {
                $wp = 1; // 비밀번호가 틀림
            }
        }
    }
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

  <title>Esigned</title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Poppins:400,700&display=swap" rel="stylesheet">
  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR:400,700&display=swap" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <link href="login.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
</head>

<body>
  <div class="hero_area">
  <img src="../images/hero-bg.jpg" class="hero-r">
    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container pt-3">
          <a class="navbar-brand" href="index.php">
            <span>
              Seven Group
            </span>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                <a href="login.php">
                  <img src="images/user.png" alt="">
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
 
  <div class ="login-wrapper">
    <div class="login">
        <h1>Login</h1>
        <form action="login.php" method="POST">
            <div class="user-box">
                <input type="text" name="userID" required="">
                <label for="userID">ID</label>
            </div>
            <div class="user-box">
                <input type="password" name="userPW" required="">
                <label for="userPW">Password</label>
            </div>
            <div class="losend">
                <p><input type="submit" value="Sign In"></p>
            </div>
            </form>

            <?php
                if ($wu == 1) {
                    echo "<p>알맞지 않은 계정입니다.</p>";
                }
                if ($wp == 1) {
                    echo "<p>알맞지 않은 계정입니다.</p>";
                }
            ?>
    </div>
  </div>       
</body>
</html>

