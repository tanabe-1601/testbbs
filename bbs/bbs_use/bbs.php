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
				require_once '../common/db_common.php';
				$dbh = getDb();

				// 最新のコメントデータを5行取得
				$sql = 'SELECT * FROM post_tbl ORDER BY code DESC LIMIT 5';
				$stmt = $dbh->query($sql);

				// 曜日表示用
				$week_name = array("日", "月", "火", "水", "木", "金", "土");

				$stmt->setFetchMode(PDO::FETCH_ASSOC);	// フェッチモードを連想配列に設定
				require_once '../common/file_strage.php';	// 添付ファイル保存パスの定数をインクルード
				foreach ($stmt as $rec) {
					$code = $rec['code'];
					$name = $rec['name'];
					$email = $rec['email'];
					$date = $rec['date'];
					$comment = $rec['comment'];
					$file_extension = $rec['file_name'];	// DBに登録されているのは拡張子

					// 日時データを表示用に変換
					$week_format = '('.$week_name[date('w',strtotime($date))].') ';
					$date_format = date('Y/m/d',strtotime($date)).$week_format.date('h:m:s',strtotime($date));

					// メールアドレスの表示
					if ($email != '') {
						print $code.' 名前 <a href="mailto:'.$email.'">'.$name.'</a> '.$date_format.'<br/>';
					} else {
						print $code.' 名前 '.$name.' '.$date_format.'<br/>';
					}

					// コメント表示
					print nl2br($comment).'<br/>';
					print '<br/>';

					// 添付ファイルの表示
					if ($file_extension != '') {
						// ファイル名を作成(書き込み番号+拡張子)
						$file_name = $code . '.' . $file_extension;
						// 拡張子ごとに処理を分岐
						switch ($file_extension) {
							case 'jpg':
								print '<a href="' . FILE_STRAGE . $file_name.'"><img src="' . FILE_STRAGE . $file_name.'"></a><br/>';
								print '<br/>';
								break;

							default:
								print '<a href="' . FILE_STRAGE . $file_name . '">添付ファイルダウンロード</a><br/>';
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
				print $e;
				exit();
			}
		?>
	</body>
</html>
