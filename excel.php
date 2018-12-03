<?php
$dbh = new PDO('mysql:host=localhost;dbname=', 'root', '');
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbh->exec('set names utf8');


$classroom = $dbh->prepare("SELECT id, classType, categoryId, title, courseNum, expiryDay, createdTime, recommended, recommendedapp, status, fitCrowd, speService, virtualNum, iconNum FROM classroom ORDER BY id DESC");
$classroom->execute();

$classroom = $classroom->fetchAll(PDO::FETCH_ASSOC);

$classroom_id = implode(',', array_column($classroom, 'id'));

//$sql = "select ownerId, tagId from tag_owner WHERE ownerType = 'classroom' and ownerId IN ($classroom_id)";
//
//var_dump($sql);die;

$tag_owner = $dbh->prepare("select ownerId, tagId from tag_owner WHERE ownerType = 'classroom' and ownerId IN ($classroom_id)");
$tag_owner->execute();
$tag_owner = $tag_owner->fetchAll(PDO::FETCH_ASSOC);

$tag_id = implode(',', array_column($tag_owner, 'tagId'));


$tags = $dbh->prepare("select id, name from tag WHERE id IN ($tag_id)");
$tags->execute();
$tags = $tags->fetchAll(PDO::FETCH_ASSOC);

$tags_id = array_column($tags, 'id');

$tags = array_combine($tags_id, $tags);


foreach ($tag_owner as $tag_owner_key => $tag_owner_item) {
    if (isset($tags[$tag_owner_item['tagId']])) {
        $tag_owner[$tag_owner_key]['标签'] = $tags[$tag_owner_item['tagId']]['name'];
    }
}

$tag_owner_id = array_column($tag_owner, 'ownerId');

$tag_owner = array_combine($tag_owner_id, $tag_owner);


//$category_id = implode(',', array_column($classroom, 'categoryId'));

$categorys = $dbh->prepare("select id, name, parentId from category");
$categorys->execute();
$categorys = $categorys->fetchAll(PDO::FETCH_ASSOC);

$categorys_id = array_column($categorys, 'id');

$categorys = array_combine($categorys_id, $categorys);


$sku_property = $dbh->prepare("select id, name from sku_property");
$sku_property->execute();
$sku_property = $sku_property->fetchAll(PDO::FETCH_ASSOC);

$sku_property_id = array_column($sku_property, 'id');
$sku_property = array_combine($sku_property_id, $sku_property);

//var_dump($sku_property);die;



$sku = $dbh->prepare("select id, sn, targetId, price, markPrice from sku WHERE targetType = 'classroom' and disable = 0 and targetId IN ($classroom_id)");
$sku->execute();
$sku = $sku->fetchAll(PDO::FETCH_ASSOC);

$class_room_id = array_column($sku, 'targetId');

$sku = array_combine($class_room_id, $sku);

foreach ($sku as $sku_key => $sku_item) {
    $sku[$sku_key]['sn'] = explode('|', trim($sku_item['sn'], '|'));
}

$new_classroom = [];

foreach ($classroom as $key => $value) {
    $new_classroom[$key]['班型编号'] = $value['id'];
    $temps = explode(',', substr($value['classType'], 1, -1));
    $new_classroom[$key]['班型'] = '';
    foreach ($temps as $temp) {
//        var_dump($temp);die;
        if ($temp == '"online"') {
            $new_classroom[$key]['班型'] .= ' 线上课';
        } elseif ($temp == '"linedown"') {
            $new_classroom[$key]['班型'] .= ' 面授课';
        }
    }
    $new_classroom[$key]['课程名称'] = $value['title'];
    $new_classroom[$key]['含课程数'] = $value['courseNum'];
    $new_classroom[$key]['有效期'] = date('Y-m-d', $value['expiryDay']);
    $new_classroom[$key]['创建日期'] = date('Y-m-d', $value['createdTime']);

    if ($value['recommended'] == 1 || $value['recommendedapp'] == 1) {
        $new_classroom[$key]['推荐状态'] = '已推荐';
    } else {
        $new_classroom[$key]['推荐状态'] = '未推荐';
    }

    $new_classroom[$key]['推荐项'] = '';

    if ($value['recommended'] == 1) {
        $new_classroom[$key]['推荐项'] .= ' PC';
    }

    if ($value['recommendedapp'] == 1) {
        $new_classroom[$key]['推荐项'] .= ' APP';
    }

    $new_classroom[$key]['发布状态'] = '';
    if ($value['status'] == 'draft') {
        $new_classroom[$key]['发布状态'] = '未发布';
    } elseif ($value['status'] == 'published') {
        $new_classroom[$key]['发布状态'] = '发布';
    } elseif ($value['status'] == 'closed') {
        $new_classroom[$key]['发布状态'] = '关闭';
    }
    $new_classroom[$key]['适合人群'] = $value['fitCrowd'];
    $new_classroom[$key]['特色服务'] = $value['speService'];
    $new_classroom[$key]['虚拟学习人数'] = $value['virtualNum'];
    $new_classroom[$key]['虚拟收藏人数'] = $value['iconNum'];

    $new_classroom[$key]['标签'] = '';
    if (isset($tag_owner[$value['id']])) {
        $new_classroom[$key]['标签'] = $tag_owner[$value['id']]['标签'];
    }

    $new_classroom[$key]['一级分类'] = '';
    if (isset($categorys[$value['categoryId']]) && $categorys[$value['categoryId']]['parentId'] == 0) {
        $new_classroom[$key]['一级分类'] = $categorys[$value['categoryId']]['name'];
    }

    $new_classroom[$key]['二级分类'] = '';

    if (isset($categorys[$value['categoryId']]) && $categorys[$value['categoryId']]['parentId'] != 0) {
        $new_classroom[$key]['二级分类'] = $categorys[$value['categoryId']]['name'];
    }

    $new_classroom[$key]['标价'] = '';
    if (isset($sku[$value['id']])) {
        $new_classroom[$key]['标价'] = $sku[$value['id']]['price'];
    }

    $new_classroom[$key]['售价'] = '';
    if (isset($sku[$value['id']])) {
        $new_classroom[$key]['售价'] = $sku[$value['id']]['markPrice'];
    }

    $new_classroom[$key]['年限'] = '';
    if (isset($sku[$value['id']])) {
        if (current($sku[$value['id']]['sn']) == 38 ) {
            $new_classroom[$key]['年限'] = 1;
        } elseif (current($sku[$value['id']]['sn']) == 39 ) {
            $new_classroom[$key]['年限'] = 2;
        } elseif (current($sku[$value['id']]['sn']) == 40 ) {
            $new_classroom[$key]['年限'] = 3;
        }
    }

    $new_classroom[$key]['站点'] = '';
    if (isset($sku[$value['id']])) {
//        $new_classroom[$key]['站点'] = end($sku[$value['id']]['sn']);
        if (isset($sku_property[end($sku[$value['id']]['sn'])])) {
            $new_classroom[$key]['站点'] = $sku_property[end($sku[$value['id']]['sn'])]['name'];
        }

    }
}



//var_dump($new_classroom);die;

$tileArray = array_keys($new_classroom[0]);

//var_dump($tileArray);die;
//
//var_dump($tileArray, $classroom);

exportToExcel('date-test.csv', $tileArray, $new_classroom);


function exportToExcel($filename, $tileArray = [], $dataArray = [])
{
    ini_set('memory_limit', '512M');
    ini_set('max_execution_time', 0);
    ob_end_clean();
    ob_start();
    header("Content-Type: text/csv");
    header("Content-Disposition:filename=" . $filename);
    $fp = fopen('php://output', 'w');
    fwrite($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));//转码 防止乱码(比如微信昵称(乱七八糟的))
    fputcsv($fp, $tileArray);
    $index = 0;
    foreach ($dataArray as $item) {
        if ($index == 1000) {
            $index = 0;
            ob_flush();
            flush();
        }
        $index++;
        fputcsv($fp, $item);
    }

    ob_flush();
    flush();
    ob_end_clean();
} 
