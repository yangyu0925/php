# php

数组函数

1.数组中的所有键名修改为全大写或小写
```
    $arr = ['name' => 'taylor', 'languages' => ['a' => 'php', 'b' => 'javascript']];
    
    print_r(array_change_key_case($arr, CASE_UPPER));
    
    function array_change_key_case_recursive($arr, $case = CASE_LOWER)
    {
        return array_map(function($item){
        
            if (is_array($item)) {
                $item = array_change_key_case_recursive($item);
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