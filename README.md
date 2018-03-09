# php

数组函数

1.数组中的所有键名修改为全大写或小写
```
    $arr = ['name' => 'taylor', 'languages' => ['a' => 'php', 'b' => 'javascript']];
    
    print_r(array_change_key_case($arr, CASE_UPPER));
    
    function array_change_key_case_recursive($arr, $case = CASE_LOWER)
    {
        return array_map(function($item) use ($case){
    
            if (is_array($item)) {
                $item = array_change_key_case_recursive($item, $case);
            }
    
            return $item;
    
        }, array_change_key_case($arr, $case));
    }
    
    print_r(array_change_key_case_recursive($arr, CASE_UPPER));
```
2.数组中的所有值修改为全大写或小写
```
    $arr = ['name' => 'taylor', ['a' => 'php', 'b' => 'javascript']];
    
    function array_change_value_case_recursive($arr, $case = CASE_LOWER)
    {
        return array_map(function ($item) use ($case) {
        
            if (is_array($item)) {
                return array_change_value_case_recursive($item, $case);
            } else {
                return $case === CASE_LOWER ? strtolower($item) : strtoupper($item);
            }
            
        }, $arr);
    }
    
    print_r(array_change_value_case_recursive($arr, CASE_UPPER));
```
3.多维度的集合变成一维的
```
    $arr = ['name' => 'taylor', 'languages' => ['php', 'javascript']];
    function flatten($arr)
    {
        $result = [];
    
        array_walk_recursive($arr, function ($value) use (&$result) {
            array_push($result, $value);
        });
    
        return $result;
    }
    print_r($arr);
```
4.将一个数组分割成多个
```
    $arr = array('a', 'b', 'c', 'd', 'e');
    
    print_r(array_chunk($arr, 2));
```
5.返回数组中指定的一列
```
    $a = array(
        array(
            'id' => 2135,
            'first_name' => 'John',
            'last_name' => 'Doe',
        ),
        array(
            'id' => 3245,
            'first_name' => 'Sally',
            'last_name' => 'Smith',
        )
    );
    
    print_r(array_column($a, 'first_name'));
    
    array_walk($a, function (&$value, $key, $return) {
        $value = $value[$return];
    }, 'first_name');
    
    print_r($a);
```
6.创建一个数组，用一个数组的值作为其键名，另一个数组的值作为其值
```
    $a = array('green', 'red', 'yellow');
    $b = array('avocado', 'apple', 'banana');
    
    print_r(array_combine($a, $b));
    
    function flipAndGroup($input) {
        $outArr = array();
        array_walk($input, function($value, $key) use (&$outArr) {
            if(!isset($outArr[$value]) || !is_array($outArr[$value])) {
                $outArr[$value] = [];
            }
            $outArr[$value][] = $key;
        });
        return $outArr;
    }
    
    $users_countries = array(
        'username1' => 'US',
        'user2' => 'US',
        'newuser' => 'GB'
    );
    print_r(flipAndGroup($users_countries));
```
7.统计数组中所有的值
```
    $array = array(1, "hello", 1, "world", "hello");
    print_r(array_count_values($array));
```
 8.带索引检查计算数组的差集
```
    $array1 = array("a" => "green", "b" => "brown", "c" => "blue", "red");
    $array2 = array("a" => "green", "yellow", "red");
    
    print_r(array_diff_assoc($array1, $array2));
    
    function array_diff_assoc_ci($arr1, $arr2)
    {
        foreach ($arr1 as $key => $value) {
            if (isset($arr2[$key])) {
                if ($arr1[$key] != $arr2[$key]) {
                    $r[$key] = $value;
                }
            } else {
                $r[$key] = $value;
            }
        }
        return $r;
    }
    
    print_r(array_diff_assoc_ci($array1, $array2));
    
    function array_diff_assoc_recursive($array1, $array2)
    {
        $difference = NULL;
        foreach($array1 as $key => $value)
        {
            if(is_array($value)) {
                if(!array_key_exists($key, $array2)) {
                    $difference[$key] = $value;
                } elseif(!is_array($array2[$key])) {
                    $difference[$key] = $value;
                } else {
                    $new_diff = array_diff_assoc_recursive($value, $array2[$key]);
                    if($new_diff != FALSE)
                    {
                        $difference[$key] = $new_diff;
                    }
                }
            } elseif(!array_key_exists($key, $array2) || $array2[$key] != $value) {
                $difference[$key] = $value;
            }
        }
        return !isset($difference) ? 0 : $difference;
    }
    
    print_r(array_diff_assoc_recursive($array1, $array2));
```
9.使用键名比较计算数组的差集
```$xslt
    $array1 = array("a" => "green1", "b" => "brown", "c" => "blue", "red");
    $array2 = array("a" => "green", "yellow", "red");
    
    
    print_r(array_diff_key($array1, $array2));
    
    function array_diff_key_ci($arr1, $arr2) {
        $result = [];
    
        array_walk($arr1, function ($val, $key, $return) use (&$result) {
            if (!array_key_exists($key, $return)) {
                $result[$key] = $val;
            }
        }, $arr2);
    
        return $result;
    }
    
    print_r(array_diff_key($array1, $array2));
```
10.计算数组的差集
```$xslt
    $array1 = array("a" => "green", "red", "blue", "red");
    $array2 = array("b" => "green", "yellow", "red");
    $result = array_diff($array1, $array2);
    
    print_r($result);
    
    function arrayDiff($A, $B) {
        $intersect = array_intersect($A, $B);
        return array_merge(array_diff($A, $intersect), array_diff($B, $intersect));
    }
```
11.使用指定的键和值填充数组
```
    $keys = array('foo', 5, 10, 'bar');
    $a = array_fill_keys($keys, 'banana');
    print_r($a);
    
    function array_fill_keys_ci($array, $values) {
        if(is_array($array)) {
            foreach($array as $key => $value) {
                $arraydisplay[$array[$key]] = $values;
            }
        }
        return $arraydisplay;
    }
```
12.用给定的值填充数组
```
    $a = array_fill(5, 6, 'banana');
    print_r($a);
```
13.用回调函数过滤数组中的单元
```
    $arr = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
    
    var_dump(array_filter($arr, function($value) {
        return $value === 2;
    }));
    
    var_dump(array_filter($arr, function($key) {
        return $key === 'b';
    }, ARRAY_FILTER_USE_KEY));
    
    var_dump(array_filter($arr, function($value, $key) {
        return $key === 'b' || $value === 3;
    }, ARRAY_FILTER_USE_BOTH));
```
14.交换数组中的键和值
```
    $input = array("a" => 1, "b" => 1, "c" => 2);
    $flipped = array_flip($input);
    
    print_r($flipped);
    
    function array_flip_ci($input)
    {
        $output = [];
        foreach ($input as $key => $values) {
                $output[$values] = $key;
        }
        return $output;
    }
```
15.带索引检查计算数组的交集
```
    $array1 = array("a" => "green", "b" => "brown", "c" => "blue", "red");
    $array2 = array("a" => "green", "b" => "yellow", "blue", "red");
    $result = array_intersect_assoc($array1, $array2);
    print_r($result);
```
16.使用键名比较计算数组的交集
```
    $array1 = array("a" => "green", "b" => "brown", "c" => "blue", "red");
    $array2 = array("a" => "green", "b" => "yellow", "blue", "red");
    $result = array_intersect_key($array1, $array2);
    print_r($result);
```
17.计算数组的交集
```
    $array1 = array("a" => "green", "red", "blue");
    $array2 = array("b" => "green", "yellow", "red");
    $result = array_intersect($array1, $array2);
    print_r($result);
```
18.检查数组里是否有指定的键名或索引
```$xslt
    $search_array = array('first' => 1, 'second' => 4);
    if (array_key_exists('first', $search_array)) {
        echo "The 'first' element is in the array";
    }
```
19.返回数组中部分的或所有的键名
```
    $array = array(0 => 100, "color" => "red");
    print_r(array_keys($array));
    
    $array = array("blue", "red", "green", "blue", "blue");
    print_r(array_keys($array, "blue"));
    
    function multiarray_keys($ar) { 
                
        foreach($ar as $k => $v) { 
            $keys[] = $k; 
            if (is_array($ar[$k])) 
                $keys = array_merge($keys, multiarray_keys($ar[$k])); 
        } 
        return $keys; 
    } 
    
    function array_keys_contain($input, $search_value, $strict = false)
    {
        $tmpkeys = [];

        $keys = array_keys($input);

        foreach ($keys as $k)
        {
            if ($strict && strpos($k, $search_value) !== FALSE)
                $tmpkeys[] = $k;
            elseif (!$strict && stripos($k, $search_value) !== FALSE)
                $tmpkeys[] = $k;
        }

        return $tmpkeys;
    }
```
20.为数组的每个元素应用回调函数
```
    $a = array(1, 2, 3, 4, 5);
    
    $b = array_map(function ($n) {
        return $n * $n * $n;
    }, $a);
    
    $an_array = array(
        'item1' => 0,
        'item2' => 0,
        'item3' => 0,
        'item4' => 0,
        'item5' => 0,
    );
    
    $items_to_modify = array('item1', "item3");
    
    array_map(function ($value) use (&$an_array ) {
        $an_array [$value] = (boolean)$an_array [$value];   //example operation:
    }, $items_to_modify);
    
    
```
21.递归地合并一个或多个数组
```
    $ar1 = array("color" => array("favorite" => "red"), 5);
    $ar2 = array(10, "color" => array("favorite" => "green", "blue"));
    $result = array_merge_recursive($ar1, $ar2);
    print_r($result);
```
22.合并一个或多个数组
```
    $array1 = array("color" => "red", 2, 4);
    $array2 = array("a", "b", "color" => "green", "shape" => "trapezoid", 4);
    $result = array_merge($array1, $array2);
    print_r($result);
    
    $data = [[1, 2], [3], [4, 5]];
    print_r(array_merge(... $data)); // [1, 2, 3, 4, 5];
```
23.对多个数组或多维数组进行排序
```
    $data[] = array('volume' => 67, 'edition' => 2);
    $data[] = array('volume' => 86, 'edition' => 1);
    $data[] = array('volume' => 85, 'edition' => 6);
    $data[] = array('volume' => 98, 'edition' => 2);
    $data[] = array('volume' => 86, 'edition' => 6);
    $data[] = array('volume' => 67, 'edition' => 7);
    
    // 取得列的列表
    foreach ($data as $key => $row) {
        $volume[$key]  = $row['volume'];
        $edition[$key] = $row['edition'];
    }
    
    // 将数据根据 volume 降序排列，根据 edition 升序排列
    // 把 $data 作为最后一个参数，以通用键排序
    array_multisort($volume, SORT_DESC, $edition, SORT_ASC, $data);
    
    function array_orderby()
    {
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp = array();
                foreach ($data as $key => $row)
                    $tmp[$key] = $row[$field];
                $args[$n] = $tmp;
                }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }
    ?>
    
    <?php
    $data[] = array('volume' => 67, 'edition' => 2);
    $data[] = array('volume' => 86, 'edition' => 1);
    $data[] = array('volume' => 85, 'edition' => 6);
    $data[] = array('volume' => 98, 'edition' => 2);
    $data[] = array('volume' => 86, 'edition' => 6);
    $data[] = array('volume' => 67, 'edition' => 7);
    
    $sorted = array_orderby($data, 'volume', SORT_DESC, 'edition', SORT_ASC);
```
24.以指定长度将一个值填充进数组
```
    $input = array(12, 10, 9);
    
    $result = array_pad($input, 5, 0);
    // result is array(12, 10, 9, 0, 0)
    
    $result = array_pad($input, -7, -1);
    // result is array(-1, -1, -1, -1, 12, 10, 9)
    
    $result = array_pad($input, 2, "noop");
    // not padded
    
    function array_insert(&$arr, $pos, $new_el=null) {
        $arraypad = array_pad($arr, count($arr)+1, 0);
        for ($i = count($arraypad) - 1; $i>=$pos; $i--) {
            $arr[$i] = $arr[$i-1];
            if ($i == $pos) {
                $arr[$i] = $new_el;
            }
        }
    }
    
    $digits = array();
    $digits[0] = 0;
    $digits[1] = 1;
    $digits[2] = 2;
    $digits[3] = 3;
    $digits[4] = 4;
    $digits[5] = 5;
    
    array_insert($digits, 3, 100);
    echo "new: "; var_dump($digits);
```
25.数组去重
```
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
```