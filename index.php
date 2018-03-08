<?php

//$arr = ['name' => 'taylor', 'languages' => ['a' => 'php', 'b' => 'javascript']];
//
//function array_change_key_case_recursive($arr, $case = CASE_LOWER)
//{
//    return array_map(function($item) use ($case){
//
//        if (is_array($item)) {
//            $item = array_change_key_case_recursive($item, $case);
//        }
//
//        return $item;
//
//    }, array_change_key_case($arr, $case));
//}
//
//var_dump(array_change_key_case_recursive($arr, CASE_UPPER));
//
//
//public function getNetConnect(){
//    $id = I('get.id');
//
//    $S6 = D()->db('6_config','DB_NETWORK_DATA_NEW');
//    $netword = $S6->table('connectivity')->where(['tid' => $id])->select();
//    $routers = $S6->table('routers')->where(['tid' => $id])->select();
//
//    $gwids = array_column($routers, 'gwid');
//
//    foreach ($routers as $key => $value) {
//        $new[$value['gwid']] = $value;
//    }
//
//    $gwidArr = M('user_router', '', 'STAT_DB_SLAVE_S26')->field('gwid,remark')->where(['gwid' => ['in', $gwids]])->select();
//
//    foreach ($gwidArr as $key => $value) {
//        $gwidArr_new[$value['gwid']] = $value;
//    }
//
//    $arr = [];
//
//    foreach ((array_merge_recursive($new, $gwidArr_new)) as $key => $value) {
//        $arr[$key]['name'] = $value['remark'];
//        $arr[$key]['image'] = (time() - $value['last_report']) > 300 ? 'https://'.$this->domain.'/Public/images/r2d.svg':'https://'.$this->domain.'/Public/images/r2.svg';
//        $arr[$key]['info'] = (time() - $value['last_report']) > 300 ? '离线':'在线';
//    }
//
//    $connectivity = $S6->table('connectivity')->where(['tid' => $id])->select();
//
//    foreach ($connectivity as $key => $value) {
//        $connectivity_new[$value['left']]['par'][] = $value;
//    }
//
//
//    $a = array_values(array_merge_recursive($arr, $connectivity_new));
//
//    $str = [];
//
//    $j = 0;
//
//    foreach ($a as $key => $value) {
//        $str['nodes'][$key]['name'] = $value['name'];
//        $str['nodes'][$key]['image'] = $value['image'];
//        $str['nodes'][$key]['info'] = $value['info'];
//
//        foreach ($value['par'] as $k => $item ) {
//            $str['edges'][$j]['source'] = $key;
//            $str['edges'][$j]['target'] = $k;
//            $str['edges'][$j]['relation'] = (time() - $item['last_report']) > 300 ? '断开':'接通';
//            $str['edges'][$j]['stroke'] =  (time() - $item['last_report']) > 300 ? '#fd7485':'#23a9f6';
//            $j++;
//        }
//
//    }
//
////        $str['edges'][] = ['source' => 0, 'target' => 1, 'stroke' => '#23a9f6'];
//
//    $str =  json_encode($str,JSON_PRETTY_PRINT);
//
////        $data = $this->getNetWorkParame($id);
////        $str = $data[2];
//
//    echo $str;
////        file_put_contents('/alidata1/www/newyun.ikuai8.com/Public/json/cc.json',$str,FILE_APPEND);
//}

$conn_hash = array (
    "35032cbb909467f89b47648393f1b27f,52bb2d9dae622177e3394a16bd1aff38" => 1,
    "35032cbb909467f89b47648393f1b27f,b1d5a3d69bf95c98636700f0cad03743" => 1,
    "35032cbb909467f89b47648393f1b27f,c9e7502620f11cd1bdb565b7af3ebe38" => 1,
    "52bb2d9dae622177e3394a16bd1aff38,35032cbb909467f89b47648393f1b27f" => 1,
    "52bb2d9dae622177e3394a16bd1aff38,b1d5a3d69bf95c98636700f0cad03743" => 1,
    "52bb2d9dae622177e3394a16bd1aff38,c9e7502620f11cd1bdb565b7af3ebe38" => 1,
    "b1d5a3d69bf95c98636700f0cad03743,35032cbb909467f89b47648393f1b27f" => 1,
    "b1d5a3d69bf95c98636700f0cad03743,52bb2d9dae622177e3394a16bd1aff38" => 1,
    "b1d5a3d69bf95c98636700f0cad03743,c9e7502620f11cd1bdb565b7af3ebe38" => 1,
    "c9e7502620f11cd1bdb565b7af3ebe38,35032cbb909467f89b47648393f1b27f" => 1,
    "c9e7502620f11cd1bdb565b7af3ebe38,52bb2d9dae622177e3394a16bd1aff38" => 1,
    "c9e7502620f11cd1bdb565b7af3ebe38,b1d5a3d69bf95c98636700f0cad03743" => 1,
);

foreach ($conn_hash as $k1=>$v) {
    if (!isset($conn_hash[$k1]))
        continue;
    $__k1 = explode(",", $k1);
    $k2 = "$__k1[1],$__k1[0]";
    if (isset($conn_hash[$k2])) {
        unset($conn_hash[$k2]);
        $conn_hash[$k1]++;
    }
}

var_dump($conn_hash);


/**
 * 展示组网状态
 */
function getNetConnect(){
    $id = I('get.id');

    $S6 = D()->db('6_config','DB_NETWORK_DATA_NEW');
    $netword = $S6->table('connectivity')->where(['tid' => $id])->select();
    $routers = $S6->table('routers')->where(['tid' => $id])->select();

    $gwids = array_column($routers, 'gwid');

    foreach ($routers as $key => $value) {
        $new[$value['gwid']] = $value;
    }

    $gwidArr = M('user_router', '', 'STAT_DB_SLAVE_S26')->field('gwid,remark')->where(['gwid' => ['in', $gwids]])->select();

    foreach ($gwidArr as $key => $value) {
        $gwidArr_new[$value['gwid']] = $value;
    }

    $arr = [];


    $subnets = $S6->table('subnets')->where(['tid' => $id])->select();

    $subnets_gwid = [];
    array_walk($subnets, function ($value, $key) use (&$subnets_gwid) {
        $subnets_gwid[$value['gwid']]['sub'][] = $value['subnet'];
    });

    foreach ($subnets_gwid as $key => $item) {
        $subnets_gwid[$key]['sub'] = implode(',', $item['sub']);
    }

    foreach ((array_merge_recursive($new, $gwidArr_new, $subnets_gwid)) as $key => $value) {
        $arr[$key]['name'] = $value['remark'];
        $arr[$key]['image'] = (time() - $value['last_report']) > 300 ? 'https://'.$this->domain.'/Public/images/r2d.svg':'https://'.$this->domain.'/Public/images/r2.svg';
//            $arr[$key]['info'] = (time() - $value['last_report']) > 300 ? '离线':'在线';
        $arr[$key]['info'] = $value['sub'];

    }

    $connectivity = $S6->table('connectivity')->where(['tid' => $id])->select();



    foreach ($connectivity as $key => $value) {
        $connectivity_new[$value['left']]['par'][] = $value;
    }


    $a = array_values(array_merge_recursive($arr, $connectivity_new));

    $str = [];

    $j = 0;

    dump($a);die;

    foreach ($a as $key => $value) {
        $str['nodes'][$key]['name'] = $value['name'];
        $str['nodes'][$key]['image'] = $value['image'];
        $str['nodes'][$key]['info'] = $value['info'];

        foreach ($value['par'] as $k => $item ) {
            $str['edges'][$j]['source'] = $key;
            $str['edges'][$j]['target'] = $k;
            $str['edges'][$j]['relation'] = (time() - $item['last_report']) > 300 ? '断开':'接通';
            $str['edges'][$j]['stroke'] =  (time() - $item['last_report']) > 300 ? '#fd7485':'#23a9f6';
            $j++;
        }

    }

//        $str['edges'][] = ['source' => 0, 'target' => 1, 'stroke' => '#23a9f6'];

    $str =  json_encode($str,JSON_PRETTY_PRINT);

//        $data = $this->getNetWorkParame($id);
//        $str = $data[2];

    echo $str;
//        file_put_contents('/alidata1/www/newyun.ikuai8.com/Public/json/cc.json',$str,FILE_APPEND);
}