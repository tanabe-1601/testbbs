<?php
	session_start();
	session_regenerate_id(true);
	if (isset($_SESSION['login'])==false) {
		print 'ログインされていません。<br/>';
		print '<a href="../bbs_login/bbs_login.php">ログイン画面へ</a><br/>';
		exit();
	} else {
		print 'ユーザー名:';
		print $_SESSION['name'];
		print '<br/>';
		print '<a href="../bbs_login/bbs_logout.php">ログアウト</a><br/>';
		print '<br/>';
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>BBS開発勉強用</title>
		<link rel="stylesheet" href="bbs.css">
	</head>
	<body>
		<?php
			try {
				if (empty($_POST) == true) {
					print '入力が不正です。<br/>';
					print '<p><input class="button" type="button" onclick="history.back()" value="戻る"></p>';
				} else {
					$name = htmlspecialchars($_POST['name'],ENT_QUOTES,'UTF-8');
					$email = htmlspecialchars($_POST['email'],ENT_QUOTES,'UTF-8');
					$comment = htmlspecialchars($_POST['comment'],ENT_QUOTES,'UTF-8');
					$gazou_name = htmlspecialchars($_POST['gazou_name'],ENT_QUOTES,'UTF-8');

					$dsn = 'mysql:dbname=tt1601_bbs;host=localhost;charset=utf8';
					$user = 'tt1601_bbs';
					$password = 'testBbs0809';
					$dbh = new PDO($dsn,$user,$password);
					$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

					// 書き込み番号を取得し、画像ファイルの名前を書き込み番号に変更する
					$sql = 'SELECT * FROM post_tbl ORDER BY code DESC LIMIT 1';
					$stmt = $dbh->prepare($sql);
					$stmt->execute();

					$rec = $stmt->fetch(PDO::FETCH_ASSOC);
					// 画像ファイルのファイル名にする
					$code = $rec['code'];
					$file_extension = substr($gazou_name, strrpos($gazou_name, '.'));
					$insert_gazou_name = $code.$file_extension;

					// 画像ファイル名を書き込み番号に置き換える
					rename('./gazou/'.$gazou_name,'./gazou/'.$insert_gazou_name);

					// 書き込みをDBに追加
					$sql = 'INSERT INTO post_tbl (name, email, comment, file_name) VALUES (?,?,?,?)';
					$data = array();
					$data[] = $name;
					$data[] = $email;
					$data[] = $comment;
					$data[] = $insert_gazou_name;
					$stmt = $dbh->prepare($sql);
					$stmt->execute($data);

					$dbh = null;

					print '書き込みしました。<br/>';
				}
			} catch (Exception $e) {
				print '障害発生中';
				exit();
			}
		?>

		<a href="bbs.php">掲示板に戻る</a>

	</body>
</html>
