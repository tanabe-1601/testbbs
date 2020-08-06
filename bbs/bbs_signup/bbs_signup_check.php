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
			$name = htmlspecialchars($_POST['name'],ENT_QUOTES,'UTF-8');
			$pass1 = htmlspecialchars($_POST['pass1'],ENT_QUOTES,'UTF-8');
			$pass2 = htmlspecialchars($_POST['pass2'],ENT_QUOTES,'UTF-8');

			if ($name == '' or $pass1 == '' or $pass2 == '' or $pass1 != $pass2) {

				if ($name == '') {
					print 'ユーザー名を入力してください。<br/>';
				}

				if ($pass1 == '' or $pass2 == '') {
					print 'パスワードを入力してください。<br/>';
				} elseif ($pass1 != $pass2) {
					print 'パスワードの入力が一致しません。<br/>';
				}

				print '<br/>';
				print '<input type="button" onclick="history.back()" value="戻る">';

			} else {

				$pass1 = md5($pass1);
				print '登録しますか？<br/>';
				print 'ユーザー名:'.$name.'<br/><br/>';
				print '<form method="post" action="bbs_signup_done.php">';
					print '<input type="hidden" name="name" value="'.$name.'">';
					print '<input type="hidden" name="pass1" value="'.$pass1.'">';
					print '<input type="button" onclick="history.back()" value="戻る">';
					print '<input type="submit" value="登録">';
				print '</form>';

			}
		?>
	</body>
</html>
