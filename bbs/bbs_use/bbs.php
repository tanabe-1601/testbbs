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

		<h1>勉強用bbs</h1>

		<?php
			try {
				$dsn = 'mysql:dbname=tt1601_bbs;host=localhost;charset=utf8';
				$user = 'tt1601_bbs';
				$password = 'testBbs0809';
				$dbh = new PDO($dsn,$user,$password);
				$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

				$sql = 'SELECT * FROM post_tbl ORDER BY code DESC';
				$stmt = $dbh->prepare($sql);
				$stmt->execute();

				// 曜日表示用
				$week_name = array("日", "月", "火", "水", "木", "金", "土");

				for ($i=0; $i < 5; $i++) {
					$rec = $stmt->fetch(PDO::FETCH_ASSOC);
					if($rec == false){
						break;
					}
					$code = $rec['code'];
					$name = $rec['name'];
					$email = $rec['email'];
					$date = $rec['date'];
					$comment = $rec['comment'];
					$file_name = $rec['file_name'];

					// 日時データを表示用に変換
					$week_format = '('.$week_name[date('w',strtotime($date))].') ';
					$date_format = date('Y/m/d',strtotime($date)).$week_format.date('h:m:s',strtotime($date));

					if ($email != '') {
						print $code.' 名前 <a href="mailto:'.$email.'">'.$name.'</a> '.$date_format.'<br/>';
					} else {
						print $code.' 名前 '.$name.' '.$date_format.'<br/>';
					}
					print nl2br($comment).'<br/>';
					print '<br/>';
					if ($file_name != '') {
						$file_extension = substr($file_name, strrpos($file_name, '.'));
						switch ($file_extension) {
							case '.jpg':
								print '<a href="./gazou/'.$file_name.'"><img src="./gazou/'.$file_name.'"></a><br/>';
								print '<br/>';
								break;

							default:
								print '<a href="./gazou/'.$file_name.'">添付ファイルダウンロード</a><br/>';
								print '<br/>';
								break;
						}
					}
				}

				$dbh = null;

				print '<h3>レスを投稿する</h3>';
				print '<form method="post" action="comment_post.php" enctype="multipart/form-data">';
					print '<p><input class="name" type="text" placeholder="名前(省略可)" name="name"></p>';
					print '<p><input class="email" type="text" placeholder="メールアドレス(省略可)" name="email"></p>';
					print '<p><textarea name="comment" placeholder="コメント内容" name="comment"></textarea></p>';
					print '<p><input type="file" name="gazou"></p>';
					print '<p><input class="button" type="submit" value="書き込む"></p>';
				print '</form>';
			}
			catch (Exception $e) {
				print '障害発生中';
				exit();
			}
		?>
	</body>
</html>
