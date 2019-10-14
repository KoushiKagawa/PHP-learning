<?php
session_start();

// ログイン状態チェック
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit;
}

//DB情報
$user = 'test';//データベースユーザ名
$password = 'test1234';//データベースパスワード
$dbName = "sample";//データベース名
$host = "sp_db_1";//ホスト
//DB接続
$dsn = "mysql:host={$host};dbname={$dbName};charser=utf8";
$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//エラーメッセージの初期化
$errors = array();
$id = $_SESSION["id"];

try{
    //トランザクション開始
    $pdo->beginTransaction();
    $sql = "SELECT * FROM user WHERE id=(:id)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

}catch (PDOException $e){
	echo $e->getMessage();
}

?>

<h1>会員情報画面</h1>

<?php if(isset($_SESSION['message'])): ?>
    <p class="message"><?php print $_SESSION['message']; ?></p>
    <?php $_SESSION['message'] = NULL?>
<?php endif; ?>

<div>
    <div>
        <p>氏名：<?php print $result["name"]; ?></p>
        <p>メールアドレス：<?php print $result["mail"]; ?></p>
    </div>
</div>

<a href="logout.php">ログアウト</a>