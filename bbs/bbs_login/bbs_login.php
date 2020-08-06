<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>BBSログイン</title>
		<link rel="stylesheet" href="bbs.css">
	</head>
	<body>

		<h1>BBSログイン</h1>

		<form method="post" action="bbs_login_check.php">
			ユーザー名<br/>
			<input type="text" name="name"><br/>
			パスワード<br/>
			<input type="password" name="pass"><br/>
			<br/>
			<input type="submit" value="ログイン"><br/>
			<br/>
			<br/>
			<a href="../bbs_signup/bbs_signup.php">ユーザー登録</a><br/>
		</form>

	</body>
</html>
