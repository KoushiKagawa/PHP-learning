<?php

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
?>

<table>
   <thead>
       <tr>
           <th>ID</th>
           <th>タイトル</th>
           <th>価格</th>
           <th>日付</th>
       </tr>
   </thead>
   <tbody>
       <?php
           foreach ($result as $row){
               print "<tr>";
               print "<td>".$row['id']."</td>";
               print "<td>".$row['title']."</td>";
               print "<td>".$row['price']."</td>";
               print "<td>".$row['date']."</td>";
               print "</tr>";
           }
       ?>
   </tbody>    
</table>

<a href="csv.php">csvダウンロード<a>