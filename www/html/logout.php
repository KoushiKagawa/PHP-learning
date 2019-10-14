<?php
session_start();
// セッションクリア
session_destroy();

$_SESSION['message'] = "ログアウトしました。";
header('Location: login.php');
exit();
?>

<!doctype html>
<html>
<head>
<title>ログアウト画面</title>
</head>
<body>
<div><?php echo $error; ?></div>
<ul>
<li><a href="login.php">ログインページへ</a></li>
</ul>
</body>
</html>