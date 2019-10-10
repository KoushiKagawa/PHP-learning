<?php
//print "dbと接続するよ！！？";

$user = 'test';
$password = 'test1234';
$dbName = "sample";//DB名
$host = "sp_db_1";//DBホスト

try {
    // MySQLへの接続
    $dsn = "mysql:host={$host};dbname={$dbName};charser=utf8";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         
    $sql = "SELECT * from sample";
    $stm = $pdo->prepare($sql);
    $stm->execute();
                
    echo "<pre>";
    foreach($stm as $row) {
        print_r($row);
    }
    echo "</pre>";

    // 接続を閉じる
    $stm = null;
   

} catch (PDOException $e) { // PDOExceptionをキャッチする
    print $e->getMessage() . "<br/gt;";
    die();
}
?>
