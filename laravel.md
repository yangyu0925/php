
# 调整框架本身的配置

编辑.env

APP_ENV = production

APP_DEBUG = false

php artisan route:cache / php artisan config:cache

composer dump-autoload --optimize

php artisan optimize

其他可能

开启OPcache

php-fpm 配置调优

# Laravel 中输出 SQL 语句的到 log 日志

在AppServiceProvider.php中的boot方法中添加如下代码 即可

```
    public function boot()
    {
        DB::listen(function($query) {
            $tmp = str_replace('?', '"'.'%s'.'"', $query->sql);
            $tmp = vsprintf($tmp, $query->bindings);
            $tmp = str_replace("\\","",$tmp);
            Log::info($tmp."\n\n\t");
          });
    }
```
#Laravel 中自定义日志目录
Log::useDailyFiles(storage_path('logs/job/error.log'));

Log::useFiles(storage_path('logs/job/error.log'));
 
```
    $monolog = \Log::getMonolog();
    $monolog->popHandler();
    \Log::useDailyFiles(storage_path() . '/logs/sql.log');
    \Log::info($tmp."\n\n\t");
```

# laravel 使用ajax 提交的时候，如果 验证不通过会返回422 状态的处理
```
    $.ajax({        
            type: "POST",
            url:'{$url}',
            data:$(this).parents('form').serialize(),
            dataType:'json',
            success: function(res) {
                console.log(res);
                alert(res.msg);
            },
            error : function (msg) {   
                if (msg.status == 422) {
                    var json=JSON.parse(msg.responseText);
                    json = json.errors;

                    for (index in json) {
                        $("#" + index).parent().addClass('has-error')
                        $("#" + index).parent().find("span").text(json[index]);
                    }
                } else {
                        alert('服务器连接失败');
                        return ;
                }
            }
        }); 
```
