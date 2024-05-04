<!doctype html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <title>xss 취약점 분석 자동화 도구 웹 서버</title>
  </head>
  <body>
    <?php
      session_start();
      session_destroy();
      header("Location: index.php");
      exit;
    ?>
  </body>
</html>
