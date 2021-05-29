<?php

require_once("./libs/Smarty.class.php");
$smarty = new Smarty();
$smarty -> template_dir = "templates";
$smarty -> compile_dir = "templates_c";
session_start();
// 以下に接続する
// DB名：co_19_332_99sv_coco_com
// ユーザ名：co-19-332.99sv-c
// パスワード：’pW5Bt4KM’

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

if(empty($_GET)) {
  header("Location:../kadai_4_1_kari/kadai_4_1_kari.php");
  exit();
}else{
    $url_id = isset($_GET["url_id"]) ? $_GET["url_id"] : NULL;
    if ($url_id == ''){
      echo 'もう一度登録をやりなおして下さい。';
    }



    $sql = "SELECT userid, MAIL FROM touroku WHERE urlid = :urlid AND flag = 0 AND date > now() - interval 24 hour";
    $stmt = $dbh->prepare($sql);
    $stmt->execute( array(
    ':urlid' => $url_id
    ));
    if($stmt != null ){
        foreach ($stmt as $row) {
            $userid = $row['userid'] ;
            $mail = $row['MAIL'] ;
            $smarty -> assign("userid", "$userid");
            $smarty -> assign("mail", "$mail");

        }
      }
    if(empty($userid)){
      echo '有効期限がすぎているため、このURLはご利用できません。<br>';
    }
  
}


$name = $pw = '';
if (isset($_POST['send'])) {
 	$name = $_POST['name'];
	$pw = $_POST['pw'];
	if ((empty($_POST['name']))or(empty($_POST['pw']))) {
    echo '未入力項目があります';
  	}
  	else{
      if(!empty($userid)){
    $sql = 'UPDATE touroku SET name=:name, pw=:pw, flag=1 WHERE userid=:userid';
    $prepare = $dbh->prepare($sql);
    $prepare->bindValue(':name', $name);
    $prepare->bindValue(':pw', $pw);
    $prepare->bindValue(':userid', $userid);
    $prepare->execute();
      
  
    $sql2 = $dbh->prepare('SELECT userid, name, pw, MAIL FROM touroku WHERE userid=?');
    $sql2->execute([$userid]);
		foreach ($sql2 as $row) {
			echo "<br />登録が完了しました。<br />";
			echo "ID : $row[userid]<br>";
      echo "MAIL : $row[MAIL]<br>";
			echo "名前 : $row[name]<br>";
			echo "パスワード : $row[pw]<br>";
      echo '<a href="../kadai_4_1_login/kadai_4_1_login.php">ログイン画面へ</a>';
			}
  		}
    }
}
$smarty -> display("kadai_4_1_touroku.tpl");
?>


