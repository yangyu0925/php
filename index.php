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

/**
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

*/


/**
 * @author yyang
 * @date
 * @return array

function getValues() {
    $valuesArray = [];
    // 获取初始内存使用量
    echo round(memory_get_usage() / 1024 / 1024, 2) . ' MB' . PHP_EOL;
    for ($i = 1; $i < 800000; $i++) {
        $valuesArray[] = $i;
        // 为了让我们能进行分析，所以我们测量一下内存使用量
        if (($i % 200000) == 0) {
            // 来 MB 为单位获取内存使用量
            echo round(memory_get_usage() / 1024 / 1024, 2) . ' MB'. PHP_EOL;
        }
    }
    return $valuesArray;
}
$myValues = getValues(); // 一旦我们调用函数将会在这里创建数组
foreach ($myValues as $value) {}

function getValues() {
    // 获取内存使用数据
    echo round(memory_get_usage() / 1024 / 1024, 2) . ' MB' . PHP_EOL;
    for ($i = 1; $i < 800000; $i++) {
        yield $i;
        // 做性能分析，因此可测量内存使用率
        if (($i % 200000) == 0) {
            // 内存使用以 MB 为单位
            echo round(memory_get_usage() / 1024 / 1024, 2) . ' MB'. PHP_EOL;
        }
    }
} 
$myValues = getValues(); // 在循环之前都不会有动作
foreach ($myValues as $value) {} // 开始生成数据

function getValues() {
    yield 'value';
    return 'returnValue';
}
$values = getValues();
foreach ($values as $value) {}
echo $values->getReturn(); // 'returnValue'
 
function getValues() {
    yield 'key' => 'value';
}
$values = getValues();
foreach ($values as $key => $value) {
    echo $key . ' => ' . $value;
}
 */

$arr = ['name' => 'taylor', 'languages' => ['a' => 'php', 'b' => 'javascript']];

array_walk_recursive($arr, function (&$value, &$key) {
    $key = strtoupper($key);
});

var_dump($arr); 
