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

class mysql
{
    protected $db;

    protected $stmt;

    public function __construct($dbname, $host, $user, $password)
    {
        $this->db = new PDO("mysql:dbname=$dbname;host=$host", $user, $password);
        $this->db->query('SET NAMES UTF');
    }

    public function query($sql, $paramenter)
    {
        $stmt = $this->db->prepare($sql);

        $stmt->execute($paramenter);

        $this->stmt = $stmt;

        return $this;
    }

    public function all()
    {
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function first()
    {
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
}

$db = new mysql('bbs', 'localhost', 'root', '');

$sql = "select * from users";

$all = $db->query($sql, [])->first();

var_dump($all);

