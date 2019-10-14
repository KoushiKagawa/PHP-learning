<?php
$today = date("YmdHis");

// 出力情報の設定
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$today.".csv");
header("Content-Transfer-Encoding: binary");

//DB接続
$user = 'test';//データベースユーザ名
$password = 'test1234';//データベースパスワード
$dbName = "sample";//データベース名
$host = "sp_db_1";//ホスト


try {
   // MySQLへの接続
   $dsn = "mysql:host={$host};dbname={$dbName};charser=utf8";
   $pdo = new PDO($dsn, $user, $password);
   $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
   $sql = "SELECT * from sample";
   $stm = $pdo->prepare($sql);
   $stm->execute();
   $result = $stm->fetchAll(PDO::FETCH_ASSOC);
      
   // 接続を閉じる
   $stm = null;
  
} catch (PDOException $e) { // PDOExceptionをキャッチする
   print $e->getMessage() . "<br/gt;";
   die();
}

// 1行目を作成
$row = '"ID","タイトル","価格","日付"' . "\n";
foreach ($result as $value ){
    $row .= '"' . $value['id'] . '","' . $value['title'] . '","' . $value['price'] . '","' . $value['date'] . '"' . "\n";
}

print $row;

return;
?>