<?php session_start(); 

require_once("./libs/Smarty.class.php");
$smarty = new Smarty();
$smarty -> template_dir = "templates";
$smarty -> compile_dir = "templates_c";
$smarty -> display("kadai_4_1_login.tpl");

// データベースに接続
$dsn = 'mysql:dbname=co_19_332_99sv_coco_com;host=localhost';
$user = 'co-19-332.99sv-c';
$password = 'pW5Bt4KM';
try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    exit();
}


if (isset($_POST['login'])) {
  $userid = $_POST['userid'];
  $pw = $_POST['pw'];
  if (!empty($userid)&&!empty($pw)) {
    unset($_SESSION['touroku']);
    $sql = $dbh->prepare("SELECT * FROM touroku WHERE userid=?");
    $sql->execute([$userid]);
    foreach ($sql as $row) {
      if (strcmp($pw, $row['pw'])==0) { 
        $_SESSION['touroku']=[ 
        'userid'=>$row['userid'],
        'name'=>$row['name']];
        header('Location:http://co-19-332.99sv-coco.com/coco_kadai_4_1/kadai_4_1_main/kadai_4_1_main.php');
        exit();
      }
    }
    if (!isset($_SESSION['touroku'])) {
      echo 'IDまたはパスワードが違います';
    }
  }
}
 ?>
