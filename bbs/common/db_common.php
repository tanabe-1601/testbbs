<?php
function getDb() {
  $dsn = 'mysql:dbname=tt1601_bbs;host=localhost;charset=utf8';
  $user = 'tt1601_bbs';
  $password = 'testBbs0809';
  $dbh = new PDO($dsn,$user,$password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  return $dbh;
}
