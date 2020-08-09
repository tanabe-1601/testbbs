<?php
	try {
		$name = htmlspecialchars($_POST['name'],ENT_QUOTES,'UTF-8');
		$pass = htmlspecialchars($_POST['pass'],ENT_QUOTES,'UTF-8');

		$pass = md5($pass);

		$dsn = 'mysql:dbname=tt1601_bbs;host=localhost;charset=utf8';
		$user = 'root';
		$password = 'testBbs0809';
		$dbh = new PDO($dsn,$user,$password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		$sql = 'SELECT * FROM user_tbl WHERE name=? AND password=?';
		$data = array();
		$data[] = $name;
		$data[] = $pass;
		$stmt = $dbh->prepare($sql);
		$stmt->execute($data);

		$rec = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($rec == false) {
			print 'ユーザー名かパスワードが間違っています。<br/>';
			print '<a href="bbs_login.php">ログイン画面へ戻る</a><br/>';
		} else {
			session_start();
			$_SESSION['login']=1;
			$_SESSION['name']=$name;
			header('Location: ../bbs_use/bbs.php');
			exit();
		}

		$dbh = null;

	} catch (Exception $e) {
		print '障害発生中';
		exit();
	}
?>
