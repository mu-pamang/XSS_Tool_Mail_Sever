<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
//echo "id:" . $_SESSION['userID'];
if ($_SESSION['userID'] != 'admin') {
    header("Location: login.php");
    exit;
}

$servername = "3.39.23.243";
$username = "  ";
$password = "  ";
$dbname = "getin";

$conn_getsend = new mysqli($servername, $username, $password, $dbname);

if ($conn_getsend->connect_error) {
    die("Connection failed: " . $conn_getsend->connect_error);
}

// 페이지당 항목 수
$items_per_page = 15;

// 현재 페이지 번호 가져오기
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// 쿼리에서 가져올 시작 항목 계산
$start_from = ($current_page - 1) * $items_per_page;

// 데이터 조회
$result = mysqli_query($conn_getsend, "SELECT getemail FROM users LIMIT $start_from, $items_per_page");

?>

<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=d림
                ?>
      </table>
  </div>

  <!-- 페이징 링크 -->
  <?php
            $result_count = mysqli_query($conn_getsend, "SELECT COUNT(*) AS total FROM users");
            $row_count = mysqli_fetch_assoc($result_count);
            $total_pages = ceil($row_count['total'] / $items_per_page);
            
            echo "<div class='pagination'>";
            echo "<div style='text-align: center;'>";
            echo "<div>";
            echo "<a href='?page=" . ($current_page - 1) . "'>&lt;</a> ";
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<a href='?page=$i'>$i</a> ";
            }
            echo "<a href='?page=" . ($current_page + 1) . "'>&gt;</a>";
            ?>

  <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              if (isset($_POST['delete_emails']) && is_array($_POST['delete_emails'])) {
                    foreach ($_POST['delete_emails'] as $emailToDelete) {
                        $emailToDelete = mysqli_real_escape_string($conn_getsend, $emailToDelete);
                       

                        // 삭제 쿼리 실행
                        $deleteQuery = "DELETE FROM users WHERE getemail = '{$emailToDelete}'";
                        $result = mysqli_query($conn_getsend, "SELECT getemail FROM users where getemail='{$emailToDelete}'");
                        //$row = mysqli_fetch_assoc($result);
                        //echo $row["id"]; 
                        //mysqli_query($conn_getsend, "SELECT id FROM users where getemail='{$emailToDelete}'");
                        mysqli_query($conn_getsend, "DELETE FROM users WHERE getemail= '{$emailToDelete}'");
                    }
                }
            }
            ?>
              
  <div class="delbtn">
    <style>
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
    <input type="submit" value="삭제">
  </div>
  </div>
  </form>
  </div>
</body>

</html>

<?php
mysqli_close($conn_getsend);
?>
