<?php
require_once "Classes/PHPExcel.php";
require_once "Classes/PHPExcel/IOFactory.php";
$filename = dirname(__FILE__).'/myexcel.xlsx';
$io = PHPExcel_IOFactory::createReader('Excel2007');

$objPHPExcel = $io->load($filename);

$sheet = $objPHPExcel -> getSheet(0);
$highestRow = $sheet -> getHighestRow();
for($i=2;$i<=$highestRow;$i++)
{
    $data['1'] = $objPHPExcel -> getActiveSheet() -> getCell("A".$i)->getValue();
    $data['2']   = $objPHPExcel -> getActiveSheet() -> getCell("B".$i)->getValue();
    $data['3']    = $objPHPExcel -> getActiveSheet() -> getCell("C".$i)->getValue();
    $data['4']  = $objPHPExcel -> getActiveSheet() -> getCell("D".$i)->getValue();
    $data['5']      = $objPHPExcel -> getActiveSheet() -> getCell("E".$i)->getValue();
    $data['6']      = $objPHPExcel -> getActiveSheet() -> getCell("F".$i)->getValue();
    $data['7']      = $objPHPExcel -> getActiveSheet() -> getCell("G".$i)->getValue();
    $data['8']      = $objPHPExcel -> getActiveSheet() -> getCell("H".$i)->getValue();
    $data['9']      = $objPHPExcel -> getActiveSheet() -> getCell("I".$i)->getValue();
    $allData[] = $data;
}

print_r($allData);exit;

ini_set('memory_limit','3072M');
set_time_limit(0);

$start = microtime(true);


//本地测试导入数据
$dbh = new PDO('mysql:host=localhost;dbname=excel', 'root', '');
//$dbh = new PDO('mysql:host=rm-bp1e007s8zj5t50f9.mysql.rds.aliyuncs.com;dbname=eduyun', 'xesdbuser', 'ksxpwd*0614');
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbh->exec('set names utf8');


require_once "Classes/PHPExcel.php";
require_once "Classes/PHPExcel/IOFactory.php";
$filename = dirname(__FILE__).'/myexcel.xlsx';
$io = PHPExcel_IOFactory::createReader('Excel2007');


$objPHPExcel = $io->load($filename);

$sheet = $objPHPExcel -> getSheet(0);
$highestRow = $sheet -> getHighestRow();

for($i=2;$i<=$highestRow;$i++)
{
//    $data['1'] = $objPHPExcel -> getActiveSheet() -> getCell("A".$i)->getValue();
//    $data['2']   = $objPHPExcel -> getActiveSheet() -> getCell("B".$i)->getValue();
    $data['name']    = $objPHPExcel -> getActiveSheet() -> getCell("C".$i)->getValue();
    $data['verifiedMobile']  = $objPHPExcel -> getActiveSheet() -> getCell("D".$i)->getValue();
    $data['year']      = $objPHPExcel -> getActiveSheet() -> getCell("E".$i)->getValue();
    $data['category']      = $objPHPExcel -> getActiveSheet() -> getCell("F".$i)->getValue();
    $data['classtype']      = $objPHPExcel -> getActiveSheet() -> getCell("G".$i)->getValue();
    $data['type']      = $objPHPExcel -> getActiveSheet() -> getCell("H".$i)->getValue();
    $data['subject']      = $objPHPExcel -> getActiveSheet() -> getCell("I".$i)->getValue();
    $allData[] = $data;
}

$classroom_name = 'classroom_bag';
$member = 'classroom_bag_member';


foreach ($allData as $key => $item) {

    if (!$item['verifiedMobile']) {
        continue;
    }
    //查询用户
    $sql = "SELECT id, verifiedMobile FROM user where verifiedMobile = {$item['verifiedMobile']} limit 1";
    $user = $dbh->prepare($sql);
    $user->execute();
    $user = $user->fetch(PDO::FETCH_ASSOC);


    //查询课程
    $sql = "SELECT id, expiryDay FROM $classroom_name where title LIKE '%{$item['year']}%' AND title LIKE '%{$item['category']}%' AND title LIKE '%{$item['classtype']}%' AND title LIKE '%{$item['subject']}%' limit 1";
    $classroom = $dbh->prepare($sql);
    $classroom->execute();
    $classroom = $classroom->fetch(PDO::FETCH_ASSOC);

    if ($user && $classroom) {
        //查询加入课程
        $sql = "SELECT id FROM $member where classroomBagId = {$classroom['id']} AND userId = {$user['id']} limit 1";
//        var_dump($sql);
        $classroom_member = $dbh->prepare($sql);
        $classroom_member->execute();
        $classroom_member = $classroom_member->fetch(PDO::FETCH_ASSOC);

        //已经加入课程
        if ($classroom_member) {
            $sql = "update $member set deadline = {$classroom['expiryDay']} where id = {$classroom_member['id']}";
            $classroom_member = $dbh->prepare($sql);
            $classroom_member->execute();
        } else {
            //未加入课程
            $sql = "INSERT INTO `$member` (`classroomBagId`, `userId`, `orderId`, `deadline`, `remark` , `createdTime`, `role`, `updatedTime`) VALUES (:classroomBagId, :userId, :orderId, :deadline, :remark, :createdTime, :role, :updatedTime)";
            $classroom_member = $dbh->prepare($sql);
            $classroom_member->execute([':classroomBagId' => $classroom['id'], ':userId' => $user['id'], ':orderId' => 0, ':deadline' => $classroom['expiryDay'], ':remark' => '', ':createdTime' => time(), ':role' => '|student|', ':updatedTime' => time()]);
        }
    } else {
        echo 'verifiedMobile:' . $item['verifiedMobile'] . "\t key:" . $key . PHP_EOL;
    }


}

$end = microtime(true);

$shijian = (float)$end - (float)$start;

echo "总用用时:{$shijian}秒";


exit();
