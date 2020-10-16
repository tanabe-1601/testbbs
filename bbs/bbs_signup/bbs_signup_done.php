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
				require_once '../../../common/escape.php';
				$name = escape($_POST['name']);
				$pass1 = escape($_POST['pass1']);

				require_once '../../../common/db_common.php';
				$dbh = getDb();

				$sql = 'INSERT INTO user_tbl (name, password) VALUES (?,?)';
				$data = array();
				$data[] = $name;
				$data[] = $pass1;
				$stmt = $dbh->prepare($sql);
				$stmt->execute($data);

				$dbh = null;

				print 'ユーザー登録が完了しました。<br/>';
				print '<a href="../bbs_login/bbs_login.php">BBSログイン画面</a><br/>';

			} catch (Exception $e) {
				print '障害発生中です<br/>';
				exit();
			}
		?>
	</body>
</html>
