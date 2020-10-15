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
		<h3>投稿内容確認</h3>
		<?php
			if (empty($_POST) == true) {
				print '入力が不正です。<br/>';
				print '<p><input class="button" type="button" onclick="history.back()" value="戻る"></p>';
			} else {
				// ポストデータをエスケープ処理
				require_once '../common/escape.php';
				$name = escape($_POST['name']);
				$email = escape($_POST['email']);
				$comment = escape($_POST['comment']);
				$gazou = $_FILES['gazou'];

				// 入力内容チェック
				if ($comment == ''){
					// コメント入力チェック
					print 'コメントを入力してください。<br/>';
					print '<p><input class="button" type="button" onclick="history.back()" value="戻る"></p>';
				} elseif ($gazou['size'] > 1000000) {
					// 添付ファイルのファイルサイズチェック
					print '画像が大きすぎます。<br/>';
					print '<p><input class="button" type="button" onclick="history.back()" value="戻る"></p>';
				} else {
					// どちらも問題なければ入力内容を表示
					if ($name == '') {
						$name = $_SESSION['name'];
					}
					print '名前：'.$name.'</br>';
					if ($email == '') {
						print 'email:未入力<br/>';
					} else {
						print 'email：'.$email.'</br>';
					}
					print 'コメント<br/>';
					print nl2br($comment).'</br>';
					print '<br/>';

					$gazou_ramdom_name = '';
					if ($gazou['size'] > 0) {
						print '添付ファイル<br/>';
						// ランダム文字列を取得(仮のファイル名にする)
						$gazou_ramdom_name = substr(bin2hex(random_bytes(8)), 0, 8);
						// 画像ファイル名の拡張子を取得
						$gazou_extension = pathinfo($gazou['name'], PATHINFO_EXTENSION);
						// ランダム文字列と拡張子を結合して、画像ファイルの仮のファイル名にする
						$file_name = $gazou_ramdom_name . '.' . $gazou_extension;
						// 添付ファイル保存パスの定数をインクルード
						require_once '../common/file_strage.php';
						// 一時ファイルの名前を、仮のファイル名にリネームする
						move_uploaded_file($gazou['tmp_name'], FILE_STRAGE . $file_name);
						// 画像ファイルを表示するimgタグをプリント
						print '<img src="' . FILE_STRAGE . $file_name . '"><br/>';
					}

					print '<form method="post" action="comment_post_done.php">';
						print '<input type="hidden" name="name" value="'.$name.'">';
						print '<input type="hidden" name="email" value="'.$email.'">';
						print '<input type="hidden" name="comment" value="'.$comment.'">';
						print '<input type="hidden" name="gazou_name" value="'.$file_name.'">';
						print '<p><input class="button" type="submit" value="投稿"></p>';
						print '<p><input class="button" type="button" onclick="history.back()" value="戻る"></p>';
					print '</form>';
				}
			}
		?>

	</body>
</html>
