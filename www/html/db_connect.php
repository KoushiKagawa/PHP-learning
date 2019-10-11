<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="robots" content="ALL">
<title>タイトル</title>
<meta name="keywords" content="">
<meta name="description" content="">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link rel="stylesheet" href="./css/style.css" type="text/css">
</head>

<body>
<?php
ini_set('mbstring.internal_encoding' , 'UTF-8');
?>
<?php
//
$user = 'test';
$password = 'test1234';
$dbName = "sample";//DB名
$host = "sp_db_1";//DBホスト

try {
    // MySQLへの接続
    $dsn = "mysql:host={$host};dbname={$dbName};charser=utf8";
    //$dsn = "mysql:host={$host};dbname={$dbName}";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         
    $sql = "SELECT * from sample";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
       
    //var_dump($result);
    
    // 接続を閉じる
    $stm = null;
   

} catch (PDOException $e) { // PDOExceptionをキャッチする
    print $e->getMessage() . "<br/gt;";
    die();
}

$title = "文字化けしていない！";
$price = "555";

if(isset($_POST['btn_1'])){
    $dsn = "mysql:host={$host};dbname={$dbName};charser=utf8";
    //$dsn = "mysql:host={$host};dbname={$dbName}";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();

    $sql = "INSERT INTO sample (title,price,date) VALUES (:title,:price,now())";
    //$sql = "INSERT INTO member (name,mail,password) ";
    //$sql .= " VALUES (HEX(AES_ENCRYPT(:name , '" . KEY . "')), HEX(AES_ENCRYPT(:mail , '" . KEY . "')), :password_hash )";

    $stm = $pdo->prepare($sql);

    $stm->bindValue(':title', $title, PDO::PARAM_STR);
    $stm->bindValue(':price', $price, PDO::PARAM_STR);
    //$stm->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
    $stm->execute();

    //データベース接続切断
    $stm = null;

    // トランザクション完了（コミット）
    $pdo->commit();
}

?>


<form action="" method="post">
    <input type="submit" name="btn_1" value="登録">
    <input type="submit" name="btn_2" value="データ見る">
</form>

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

</body>
</html>