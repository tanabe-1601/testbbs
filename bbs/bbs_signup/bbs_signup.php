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
		<form method="post" action="bbs_signup_check.php">
			ユーザー名を入力してください。<br/>
			<input type="text" placeholder="ユーザー名" name="name"><br/>
			パスワードを入力してください。<br/>
			<input type="password" placeholder="パスワード" name="pass1"><br/>
			パスワードを再入力してください。<br/>
			<input type="password" placeholder="パスワード再入力" name="pass2"><br/>
			<br/>
			<input type="submit" value="登録"><br/>
		</form>

		<br/>
		<br/>
		<a href="../bbs_login/bbs_login.php">BBSログイン画面</a><br/>
	</body>
</html>
