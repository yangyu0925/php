<?php

//try{
//    $DB = new PDO('mysql:dbname=ik;host=localhost', 'root', '');
//} catch (PDOException $e) {
//    die('数据库连接错误！错误信息：' . $e ->getMessage());
//}
//$DB->query('SET NAMES utf8');
//
//
//$sql = 'select * from daily_hit_counter where slot = :slot';
//
//$stmt = $DB->prepare($sql);
//$stmt->execute(['slot' => 4]);
//
//var_dump($stmt->fetch(PDO::FETCH_ASSOC));


$path = '/www/public_html/index.html';
$filename = (strstr($path, "www", true));
echo $filename;
