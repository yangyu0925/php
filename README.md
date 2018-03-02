# php

##数组函数
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




