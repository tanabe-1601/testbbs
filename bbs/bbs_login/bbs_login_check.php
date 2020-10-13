<?php
	try {
		require_once '../common/escape.php';
		$name = escape($_POST['name']);
		$pass = escape($_POST['pass']);

		$pass = md5($pass);

		require_once '../common/db_common.php';
		$dbh = getDb();

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
