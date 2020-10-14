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
				// ポストデータがあるかチェック
				if (empty($_POST) == true) {
					print '入力が不正です。<br/>';
					print '<p><input class="button" type="button" onclick="history.back()" value="戻る"></p>';
				} else {
					// ポストデータをエスケープ処理
					require_once '../common/escape.php';
					$name = escape($_POST['name']);
					$email = escape($_POST['email']);
					$comment = escape($_POST['comment']);
					$gazou_name = escape($_POST['gazou_name']);

					// ファイル名があれば、変数に拡張子を代入し、なければ空文字を代入
					$file_extension = $gazou_name != '' ? pathinfo($gazou_name, PATHINFO_EXTENSION) : '';

					// DB接続
					require_once '../common/db_common.php';
					$dbh = getDb();

					// 書き込みをDBに追加
					$sql = 'INSERT INTO post_tbl (name, email, comment, file_name) VALUES (?,?,?,?)';
					$data = array();
					$data[] = $name;
					$data[] = $email;
					$data[] = $comment;
					$data[] = $file_extension;

					$stmt = $dbh->prepare($sql);
					$stmt->execute($data);

					// 一時的な画像ファイル名を書き込み番号に変更
					if ($file_extension != '') {
						// 書き込み番号を取得
						$lii = $dbh->lastInsertId();
						// 書き込み番号と拡張子を結合して、画像ファイル名を作成
						$new_file_name = $lii . '.' . $file_extension;
						// 画像ファイル名を書き込み番号に置き換える
						rename('./gazou/'.$gazou_name, './gazou/'.$new_file_name);
					}

					$dbh = null;	// DB切断

					print '書き込みしました。<br/>';
				}
			} catch (Exception $e) {
				print $e;
				exit();
			}
		?>

		<a href="./bbs.php">掲示板に戻る</a>

	</body>
</html>
