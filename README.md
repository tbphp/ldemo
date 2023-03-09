# Hyper Hash Backend

超算云 后端服务

## 安装

1. 安装composer依赖：
    ```shell
    composer install
    ```
2. 新建 `.env` 文件，根据 `.env.example` 内容配置本地开发环境。
3. 执行迁移脚本：
    ```shell
    php artisan migrate
    ```

## 运行

```shell
php bin/laravels start
```

*更多命令请参考 [LaravelS官方文档](https://github.com/hhxsv5/laravel-s/blob/master/README-CN.md#%E8%BF%90%E8%A1%8C)*

## 线上环境

|软件|版本|
|:---:|:---:|
|[CentOS](https://wiki.centos.org/action/show/Manuals/ReleaseNotes/CentOS7.2009?action=show&redirect=Manuals%2FReleaseNotes%2FCentOS7)|7.9.2009|
|[PHP](https://www.php.net/ChangeLog-7.php#7.4.18)|7.4.18|
|[Swoole](https://www.swoole.com/)|4.6.6|
|[LaravelS](https://github.com/hhxsv5/laravel-s/blob/master/README-CN.md)|3.7.19|
|[Laravel](https://laravel.com/docs/8.x)|8.40.0|
