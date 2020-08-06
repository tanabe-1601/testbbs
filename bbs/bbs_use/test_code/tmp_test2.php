<?php
	// session_start();
	// session_regenerate_id(true);
	// if (isset($_SESSION['login'])==false) {
	// 	print 'ログインされていません。<br/>';
	// 	print '<a href="../bbs_login/bbs_login.php">ログイン画面へ</a><br/>';
	// 	exit();
	// } else {
	// 	print 'ユーザー名:';
	// 	print $_SESSION['name'];
	// 	print '<br/>';
	// 	print '<a href="../bbs_login/bbs_logout.php">ログアウト</a><br/>';
	// 	print '<br/>';
	// }
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
				$name = htmlspecialchars($_POST['name'],ENT_QUOTES,'UTF-8');
				$email = htmlspecialchars($_POST['email'],ENT_QUOTES,'UTF-8');
				$comment = htmlspecialchars($_POST['comment'],ENT_QUOTES,'UTF-8');
				$gazou = $_FILES['gazou'];

				if ($comment == ''){
					print 'コメントを入力してください。<br/>';
					print '<p><input class="button" type="button" onclick="history.back()" value="戻る"></p>';
				} elseif ($gazou['size'] > 1000000) {
					print '画像が大きすぎます。<br/>';
					print '<p><input class="button" type="button" onclick="history.back()" value="戻る"></p>';
				} else {
					if ($name == '') {
						$name = '名無しさん';
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

					if ($gazou['size'] > 0) {
						print '添付画像<br/>';
						// move_uploaded_file($gazou['tmp_name'],'./gazou/'.$gazou['name']);
						// print '<img src="./gazou/'.$gazou['name'].'"><br/>';
						$tmpdir = sys_get_temp_dir();
						print $tmpdir;
						print '<br/>';
						print $gazou['tmp_name'];
						print '<br/>';
						print '<img src="'.$gazou['tmp_name'].'"><br/>';
					}

					print '<form method="post" action="comment_post_done.php">';
						print '<input type="hidden" name="name" value="'.$name.'">';
						print '<input type="hidden" name="email" value="'.$email.'">';
						print '<input type="hidden" name="comment" value="'.$comment.'">';
						print '<input type="hidden" name="gazou_name" value="'.$gazou['tmp_name'].'">';
						print '<p><input class="button" type="submit" value="投稿"></p>';
						print '<p><input class="button" type="button" onclick="history.back()" value="戻る"></p>';
					print '</form>';
				}
			}
		?>

	</body>
</html>
