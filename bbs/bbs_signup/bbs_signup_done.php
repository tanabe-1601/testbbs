<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>BBSユーザー登録</title>
		<link rel="stylesheet" href="bbs.css">
	</head>
	<body>
		<h1>BBSユーザー登録</h1>
		<br/>
		<?php
			try {
				$name = htmlspecialchars($_POST['name'],ENT_QUOTES,'UTF-8');
				$pass1 = htmlspecialchars($_POST['pass1'],ENT_QUOTES,'UTF-8');

				$dsn = 'mysql:dbname=bbs;host=localhost;charset=utf8';
				$user = 'root';
				$password = '';
				$dbh = new PDO($dsn,$user,$password);
				$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

				$sql = 'INSERT INTO user_tbl (name, password) VALUES (?,?)';
				$data = array();
				$data[] = $name;
				$data[] = $pass1;
				$stmt = $dbh->prepare($sql);
				$stmt->execute($data);

				$dbh = null;

				print 'ユーザー登録が完了しました。<br/>';
				print '<a href="bbs_login.php">BBSログイン画面</a><br/>';

			} catch (Exception $e) {
				print '障害発生中です<br/>';
				exit();
			}
		?>
	</body>
</html>
