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
26.弹出数组最后一个单元（出栈）
```
    $stack = array("orange", "banana", "apple", "raspberry");
    $fruit = array_pop($stack);
    print_r($stack);
```
27.计算数组中所有值的乘积
```
    $a = array(2, 4, 6, 8);
    
    var_dump(array_product($a));
```
28.将一个或多个单元压入数组的末尾（入栈）
```
    $stack = array("orange", "banana");
    array_push($stack, "apple", "raspberry");
    print_r($stack);
```
29.从数组中随机取出一个或多个单元
```
    $input = array("Neo", "Morpheus", "Trinity", "Cypher", "Tank");
    $rand_keys = array_rand($input, 2);
    echo $input[$rand_keys[0]] . "\n";
    echo $input[$rand_keys[1]] . "\n";
```
30.随机生成优惠券
```
    echo substr(strtoupper(md5(uniqid(mt_rand(1,10000)*mt_rand(1,10000)))), 0, 16);
```
31.用回调函数迭代地将数组简化为单一的值
```
    $a = array(1, 2, 3, 4, 5);
    
    $b = array_reduce($a, function ($item, $value) {
        $item *= $value;
        return $item;
    }, 10);
    
    var_dump($b);
```
32.使用传递的数组递归替换第一个数组的元素
```
    $base = array('citrus' => array( "orange") , 'berries' => array("blackberry", "raspberry"), );
    $replacements = array('citrus' => array('pineapple'), 'berries' => array('blueberry'));
    
    $basket = array_replace_recursive($base, $replacements);
    print_r($basket);
    
    $basket = array_replace($base, $replacements);
    print_r($basket);
```
33.使用传递的数组替换第一个数组的元素
```
    $base = array("orange", "banana", "apple", "raspberry");
    $replacements = array(0 => "pineapple", 4 => "cherry");
    $replacements2 = array(0 => "grape");
    
    $basket = array_replace($base, $replacements, $replacements2);
    print_r($basket);
```
34.返回单元顺序相反的数组
```
    $input  = array("php", 4.0, array("green", "red"));
    $reversed = array_reverse($input);
    $preserved = array_reverse($input, true);
    
    print_r($input);
    print_r($reversed);
    print_r($preserved);
```
35.在数组中搜索给定的值，如果成功则返回首个相应的键名
```
    $array = array(0 => 'blue', 1 => 'red', 2 => 'green', 3 => 'red');
    
    $key = array_search('green', $array); // $key = 2;
    $key = array_search('red', $array);   // $key = 1;
```
36.将数组开头的单元移出数组
```
    $stack = array("orange", "banana", "apple", "raspberry");
    $fruit = array_shift($stack);
    print_r($stack);
```
37.从数组中取出一段
```
    $input = array("a", "b", "c", "d", "e");
    
    $output = array_slice($input, 2);      // returns "c", "d", and "e"
    $output = array_slice($input, -2, 1);  // returns "d"
    $output = array_slice($input, 0, 3);   // returns "a", "b", and "c"
    
    print_r(array_slice($input, 2, -1));
    print_r(array_slice($input, 2, -1, true));
```
38.去掉数组中的某一部分并用其它值取代
```
    $input = array("red", "green", "blue", "yellow");
    array_splice($input, 2);
    // $input is now array("red", "green")
    
    $input = array("red", "green", "blue", "yellow");
    array_splice($input, 1, -1);
    // $input is now array("red", "yellow")
    
    $input = array("red", "green", "blue", "yellow");
    array_splice($input, 1, count($input), "orange");
    // $input is now array("red", "orange")
    
    $input = array("red", "green", "blue", "yellow");
    array_splice($input, -1, 1, array("black", "maroon"));
    // $input is now array("red", "green",
    //          "blue", "black", "maroon")
    
    $input = array("red", "green", "blue", "yellow");
    array_splice($input, 3, 0, "purple");
    // $input is now array("red", "green",
    //          "blue", "purple", "yellow");
```
39.对数组中所有值求和
```
    $a = array(2, 4, 6, 8);
    echo "sum(a) = " . array_sum($a) . "\n";
    
    $b = array("a" => 1.2, "b" => 2.3, "c" => 3.4);
    echo "sum(b) = " . array_sum($b) . "\n";
```
40.移除数组中重复的值
```
    $input = array("a" => "green", "red", "b" => "green", "blue", "red");
    $result = array_unique($input);
    print_r($result);
```
41.在数组开头插入一个或多个单元
```
    $queue = array("orange", "banana");
    array_unshift($queue, "apple", "raspberry");
    print_r($queue);
```
42.返回数组中所有的值
```
    $array = array("size" => "XL", "color" => "gold");
    print_r(array_values($array));
```
43.对数组中的每个成员递归地应用用户函数
```
    $sweet = array('a' => 'apple', 'b' => 'banana');
    $fruits = array('sweet' => $sweet, 'sour' => 'lemon');
    
    function test_print($item, $key)
    {
        echo "$key holds $item\n";
    }
    
    array_walk_recursive($fruits, 'test_print');
```
44.使用用户自定义函数对数组中的每个元素做回调处理
```
    $fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");
    
    function test_alter(&$item1, $key, $prefix)
    {
        $item1 = "$prefix: $item1";
    }
    
    array_walk($fruits, 'test_alter', 'fruit');
```
45.对数组进行逆向排序并保持索引关系
```
    $arr = range(1, 10);
    
    arsort($arr);
    
    var_dump($arr);
```
46.对数组进行排序并保持索引关系
```
    $arr = range(10, 1);
    
    asort($arr);
    
    var_dump($arr);
```
47.建立一个数组，包括变量名和它们的值
```
    $city  = "San Francisco";
    $state = "CA";
    $event = "SIGGRAPH";
    
    $location_vars = array("city", "state");
    
    $result = compact("event", "nothing_here", $location_vars);
    print_r($result);
```
48.计算数组中的单元数目，或对象中的属性个数
```
    $a[0] = 1;
    $a[1] = 3;
    $a[2] = 5;
    var_dump(count($a));
    
    $b[0]  = 7;
    $b[5]  = 9;
    $b[10] = 11;
    var_dump(count($b));
```
49.返回数组中的当前单元
```
    $transport = array('foot', 'bike', 'car', 'plane');
    $mode = current($transport); // $mode = 'foot';
    $mode = next($transport);    // $mode = 'bike';
    $mode = current($transport); // $mode = 'bike';
    $mode = prev($transport);    // $mode = 'foot';
    $mode = end($transport);     // $mode = 'plane';
    $mode = current($transport); // $mode = 'plane';
```
50.返回数组中当前的键／值对并将数组指针向前移动一步
```
    $foo = array("Robert" => "Bob", "Seppo" => "Sepi");
    $bar = each($foo);
    print_r($bar);
```
51.将数组的内部指针指向最后一个单元
```
    $fruits = array('apple', 'banana', 'cranberry');
    echo end($fruits); // cranberry
```
52.检查数组中是否存在某个值
```
    $os = array("Mac", "NT", "Irix", "Linux");
    if (in_array("Irix", $os)) {
        echo "Got Irix";
    }
```
53.从关联数组中取得键名
```
    $array = [
            'fruit1' => 'apple',
            'fruit2' => 'orange',
            'fruit3' => 'grape',
            'fruit4' => 'apple',
            'fruit5' => 'apple' 
        ];
    
    var_dump(key($array)); // 'fruit1'
```
54. 对数组按照键名逆向排序
```
    $fruits = array("d"=>"lemon", "a"=>"orange", "b"=>"banana", "c"=>"apple");
    krsort($fruits);
    foreach ($fruits as $key => $val) {
        echo "$key = $val\n";
    }
```
55.对数组按照键名排序
```
    $fruits = array("d"=>"lemon", "a"=>"orange", "b"=>"banana", "c"=>"apple");
    ksort($fruits);
    foreach ($fruits as $key => $val) {
        echo "$key = $val\n";
    }
```
56.把数组中的值赋给一组变量
```
    $info = array('coffee', 'brown', 'caffeine');
    
    // 列出所有变量
    list($drink, $color, $power) = $info;
    echo "$drink is $color and $power makes it special.\n";
    
    // 列出他们的其中一个
    list($drink, , $power) = $info;
    echo "$drink has $power.\n";
    
    // 或者让我们跳到仅第三个
    list( , , $power) = $info;
    echo "I need $power!\n";
    
    // list() 不能对字符串起作用
    list($bar) = "abcde";
    var_dump($bar); // NULL
```
57.用“自然排序”算法对数组进行不区分大小写字母的排序
```
    $array1 = array('IMG0.png', 'img12.png', 'img10.png', 'img2.png', 'img1.png', 'IMG3.png');

    natcasesort($array1);
    
    print_r($array1);
```
58.用“自然排序”算法对数组排序
```
    $array1 = array("img12.png", "img10.png", "img2.png", "img1.png");
    
    natsort($array1);
    print_r($array1);
```
59.将数组中的内部指针向前移动一位
```
    $transport = array('foot', 'bike', 'car', 'plane');
    $mode = current($transport); // $mode = 'foot';
    $mode = next($transport);    // $mode = 'bike';
    $mode = next($transport);    // $mode = 'car';
    $mode = prev($transport);    // $mode = 'bike';
    $mode = end($transport);     // $mode = 'plane';
```
60.将数组的内部指针倒回一位
```
    $transport = array('foot', 'bike', 'car', 'plane');
    $mode = current($transport); // $mode = 'foot';
    $mode = next($transport);    // $mode = 'bike';
    $mode = next($transport);    // $mode = 'car';
    $mode = prev($transport);    // $mode = 'bike';
    $mode = end($transport);     // $mode = 'plane';
```
61.根据范围创建数组，包含指定的元素
```
    // array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12)
    foreach (range(0, 12) as $number) {
        echo $number;
    }
    
    //  step 参数
    // array(0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100)
    foreach (range(0, 100, 10) as $number) {
        echo $number;
    }
    
    // 字符序列的使用
    // array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i');
    foreach (range('a', 'i') as $letter) {
        echo $letter;
    }
    // array('c', 'b', 'a');
    foreach (range('c', 'a') as $letter) {
        echo $letter;
    }
```
62.将数组的内部指针指向第一个单元
```
    $array = array('step one', 'step two', 'step three', 'step four');
    
    // by default, the pointer is on the first element
    echo current($array) . "<br />\n"; // "step one"
    
    // skip two steps
    next($array);
    next($array);
    echo current($array) . "<br />\n"; // "step three"
    
    // reset pointer, start again on step one
    reset($array);
    echo current($array) . "<br />\n"; // "step one"
```
63.对数组逆向排序
```
    $fruits = array("lemon", "orange", "banana", "apple");
    rsort($fruits);
    foreach ($fruits as $key => $val) {
        echo "$key = $val\n";
    }
```
64.打乱数组
```
    $numbers = range(1, 20);
    shuffle($numbers);
    foreach ($numbers as $number) {
        echo "$number ";
    }
```
65.对数组排序
```
    $fruits = array(
        "Orange1", "orange2", "Orange3", "orange20"
    );
    sort($fruits, SORT_NATURAL | SORT_FLAG_CASE);
    foreach ($fruits as $key => $val) {
        echo "fruits[" . $key . "] = " . $val . "\n";
    }
```
66. 约瑟夫环
```
    $n=41;
    echo "well,let  us test $n<br/>";
    for($i=1;$i<$n;$i++){
        $a["$i"]=$i+1;
        $flag[$i]="in";
    }
    $a["$n"]=1;
    foreach($a as $key=>$value){
        echo $key."=>".$value."</br>";
    }
    $key=1;$out=0;$r=0;
    while($out<$n){
        $r++;
        if($r==2){
            echo "$a[$key]<br/>";// out
            $a[$key]=$a[$a[$key]];
            $out++;$r=0;
        }
        $key=$a[$key];
    }
```

字符串函数
1.以 C 语言风格使用反斜线转义字符串中的字符
```
    echo addcslashes('foo[ ]', 'A..z');
    // 输出：\f\o\o\[ \]
    echo addcslashes("zoo['.']", 'z..A');
    // 输出：\zoo['\.']
```
2. 使用反斜线引用字符串
```
    $str = "Is your name O'reilly?";
    
    // 输出： Is your name O\'reilly?
    echo addslashes($str);
```
3.函数把包含数据的二进制字符串转换为十六进制值
```
    $binary = "11111001";
    $hex = dechex(bindec($binary));
    echo $hex;
```
4.返回指定的字符
```
    $str = sprintf("The string ends in escape: %c", 97);
    
    echo $str;
```
5.将字符串分割成小块
```
    $string = '1234'; 
    substr(chunk_split($string, 2, ':'), 0, -1); 
    // will return 12:34 
```
6.使用一个字符串分割另一个字符串
```
    // 示例 1
    $pizza  = "piece1 piece2 piece3 piece4 piece5 piece6";
    $pieces = explode(" ", $pizza);
    echo $pieces[0]; // piece1
    echo $pieces[1]; // piece2
    
    // 示例 2
    $data = "foo:*:1023:1000::/home/foo:/bin/sh";
    list($user, $pass, $uid, $gid, $gecos, $home, $shell) = explode(":", $data);
    echo $user; // foo
    echo $pass; // *
```
7.将格式化后的字符串写入到流
```
    if (!($fp = fopen('date.txt', 'w'))) {
        return;
    }
    
    fprintf($fp, "%04d-%02d-%02d", $year, $month, $day);
```
8.将一个一维数组的值转化为字符串
```
    $array = array('lastname', 'email', 'phone');
    $comma_separated = implode(",", $array);
    
    echo $comma_separated; // lastname,email,phone
```
9.使一个字符串的第一个字符小写
```
    $foo = 'HelloWorld';
    $foo = lcfirst($foo);             // helloWorld
    
    $bar = 'HELLO WORLD!';
    $bar = lcfirst($bar);             // hELLO WORLD!
    $bar = lcfirst(strtoupper($bar)); // hELLO WORLD!
```
10.删除字符串开头的空白字符（或其他字符）
```
    $text = "\t\tThese are a few words :) ...  ";
    $trimmed = ltrim($text);
    var_dump($trimmed);
    
    $hello  = "Hello World";
    $trimmed = ltrim($hello, "Hdle");
    var_dump($trimmed);
```
11.以千位分隔符方式格式化一个数字
```
    $number = 1234.56;
    
    // english notation (default)
    $english_format_number = number_format($number);
    // 1,235
    
    // French notation
    $nombre_format_francais = number_format($number, 2, ',', ' ');
    // 1 234,56
    
    $number = 1234.5678;
    
    // english notation without thousands separator
    $english_format_number = number_format($number, 2, '.', '');
    // 1234.57
```
12. 返回字符的 ASCII 码值
```
    $str = "\n";
    if (ord($str) == 10) {
        echo "The first character of \$str is a line feed.\n";
    }
```
13.将字符串解析成多个变量
```
    $str = "first=value&arr[]=foo+bar&arr[]=baz";
    
    // 推荐用法
    parse_str($str, $output);
    echo $output['first'];  // value
    echo $output['arr'][0]; // foo bar
    echo $output['arr'][1]; // baz
    
    $test = parse_url("http://localhost/index.php?name=tank&sex=1#top");
    print_r($test);
    
    [
        [scheme] => http //使用什么协议
        [host] => localhost //主机名
        [path] => /index.php //路径
        [query] => name=tank&sex=1 // 所传的参数
        [fragment] => top //后面根的锚点
    ]
```
14.输出字符串
```
    print("Hello World");
```
15.输出格式化字符串
```
    printf("%.02lf\n", 1.035);
```
16.删除字符串末端的空白字符（或者其他字符）
```
    $trimmed = rtrim($text);
```
17.返回格式化字符串
```
    $num = 5;
    $location = 'tree';
    
    $format = 'There are %d monkeys in the %s';
    echo sprintf($format, $num, $location);
```
18.字符串替换忽略大小写版本
```
    $bodytag = str_ireplace("%body%", "black", "<body text=%BODY%>");
    echo $bodytag; // <body text=black>
```
19.使用另一个字符串填充字符串为指定长度
````
    $input = "Alien";
    echo str_pad($input, 10);                      // 输出 "Alien     "
    echo str_pad($input, 10, "-=", STR_PAD_LEFT);  // 输出 "-=-=-Alien"
    echo str_pad($input, 10, "_", STR_PAD_BOTH);   // 输出 "__Alien___"
    echo str_pad($input,  6, "___");               // 输出 "Alien_"
    echo str_pad($input,  3, "*");                 // 输出 "Alien"
````
20.重复一个字符串
```
    echo str_repeat("-=", 10);
    //-=-=-=-=-=-=-=-=-=-=
```
21.子字符串替换
````
    // 赋值: <body text='black'>
    $bodytag = str_replace("%body%", "black", "<body text='%body%'>");
    
    // 赋值: Hll Wrld f PHP
    $vowels = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U");
    $onlyconsonants = str_replace($vowels, "", "Hello World of PHP");
    
    // 赋值: You should eat pizza, beer, and ice cream every day
    $phrase  = "You should eat fruits, vegetables, and fiber every day.";
    $healthy = array("fruits", "vegetables", "fiber");
    $yummy   = array("pizza", "beer", "ice cream");
    
    $newphrase = str_replace($healthy, $yummy, $phrase);
    
    // 赋值: 2
    $str = str_replace("ll", "", "good golly miss molly!", $count);
    echo $count;
````
22.随机打乱一个字符串
```
    $str = 'abcdef';
    $shuffled = str_shuffle($str);
    
    // 输出类似于: bfdaec
    echo $shuffled;
```
23.将字符串转换为数组
```
    $str = "Hello Friend";
    
    $arr1 = str_split($str);
    $arr2 = str_split($str, 3);
    
    print_r($arr1);
    print_r($arr2);
```
24.查找字符串首次出现的位置（不区分大小写）
```
    $findme    = 'a';
    $mystring1 = 'xyz';
    $mystring2 = 'ABC';
    
    $pos1 = stripos($mystring1, $findme);
    $pos2 = stripos($mystring2, $findme);
    
    // 'a' 当然不在 'xyz' 中
    if ($pos1 === false) {
        echo "The string '$findme' was not found in the string '$mystring1'";
    }
    
    // 注意这里使用的是 ===。简单的 == 不能像我们期望的那样工作，
    // 因为 'a' 的位置是 0（第一个字符）。
    if ($pos2 !== false) {
        echo "We found '$findme' in '$mystring2' at position $pos2";
    }
```
25.查找字符串首次出现的位置
```
    $mystring = 'abc';
    $findme   = 'a';
    $pos = strpos($mystring, $findme);
```
25.查找指定字符在字符串中的最后一次出现
```
    $path = '/www/public_html/index.html';
    $filename = substr(strrchr($path, "/"), 1);
    echo $filename; // "index.html"
```
26.反转字符串
```
    echo strrev("Hello world!"); // 输出 "!dlrow olleH"
```
27.计算指定字符串在目标字符串中最后一次出现的位置（不区分大小写）
```
    $haystack = 'ababcd';
    $needle   = 'aB';
    
    $pos      = strripos($haystack, $needle);
```
28. 查找字符串的首次出现
```
    $email  = 'name@example.com';
    $domain = strstr($email, '@');
    echo $domain; // 打印 @example.com
    
    $user = strstr($email, '@', true); // 从 PHP 5.3.0 起
    echo $user; // 打印 name
```
29.将字符串转化为小写
```
    $str = "Mary Had A Little Lamb and She LOVED It So";
    $str = strtolower($str);
    echo $str; // 打印 mary had a little lamb and she loved it so
```
30.将字符串转化为大写
```
    $str = "Mary Had A Little Lamb and She LOVED It So";
    $str = strtoupper($str);
    echo $str; // 打印 MARY HAD A LITTLE LAMB AND SHE LOVED IT SO
```
31.返回字符串的子串
```
    $rest = substr("abcdef", -1);    // 返回 "f"
    $rest = substr("abcdef", -2);    // 返回 "ef"
    $rest = substr("abcdef", -3, 1); // 返回 "d"
```
32.去除字符串首尾处的空白字符（或者其他字符）
```
    function trim_value(&$value) 
    { 
        $value = trim($value); 
    }
    $fruit = array('apple','banana ', ' cranberry ');

    array_walk($fruit, 'trim_value');
    var_dump($fruit);
```
33.打断字符串为指定数量的字串
```
    $text = "The quick brown fox jumped over the lazy dog.";
    $newtext = wordwrap($text, 20, "<br />\n");
    
    echo $newtext;
//    The quick brown fox<br />
//    jumped over the lazy<br />
//    dog.
```
#yield内容优化
```
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
```
