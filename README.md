yii2-liuxy-admin
==============

基于Yii2+Metronic制作的后台管理模版. [仓库地址](https://github.com/liupdhc/yii2-liuxy-admin)


## 安装

推荐使用 [composer](http://getcomposer.org/download/).

命令行运行

```
$ php composer.phar require liuxy/yii2-admin "dev-master"

```
或者增加如下内容

```
"liuxy/yii2-admin": "dev-master"
```

到 `composer.json` 文件的 ```require```部分

## 用法
```php
//Add 'admin' into your 'modules' section in backend/config/main.php
'modules' => [
        'admin' => [
            'class' => 'liuxy\admin\Module',
        ],

    ],
```

## 版权

yii2-liuxy-admin 基于BSD 3-Clause License. 请查看 `LICENSE.md`
