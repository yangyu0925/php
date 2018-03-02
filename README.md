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
