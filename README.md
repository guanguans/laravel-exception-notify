# laravel-exception-notify

![usage](docs/usage.png)

[简体中文](README.md) | [ENGLISH](README_en.md)

> Multiple channels of laravel exception notification(DingTalk、FeiShu、ServerChan、WeWork、XiZhi). - 多种通道的 laravel 异常通知(钉钉群机器人、飞书群机器人、Server 酱、企业微信群机器人、息知)。

[![Tests](https://github.com/guanguans/laravel-exception-notify/workflows/Tests/badge.svg)](https://github.com/guanguans/laravel-exception-notify/actions)
[![Check & fix styling](https://github.com/guanguans/laravel-exception-notify/workflows/Check%20&%20fix%20styling/badge.svg)](https://github.com/guanguans/laravel-exception-notify/actions)
[![codecov](https://codecov.io/gh/guanguans/laravel-exception-notify/branch/main/graph/badge.svg?token=URGFAWS6S4)](https://codecov.io/gh/guanguans/laravel-exception-notify)
[![Latest Stable Version](https://poser.pugx.org/guanguans/laravel-exception-notify/v)](//packagist.org/packages/guanguans/laravel-exception-notify)
[![Total Downloads](https://poser.pugx.org/guanguans/laravel-exception-notify/downloads)](//packagist.org/packages/guanguans/laravel-exception-notify)
[![License](https://poser.pugx.org/guanguans/laravel-exception-notify/license)](//packagist.org/packages/guanguans/laravel-exception-notify)

## 功能

* 监控发送 laravel 应用异常
* 支持多种通道(钉钉群机器人、飞书群机器人、Server 酱、企业微信群机器人、息知)
* 自定义发送的异常信息数据

## 相关项目

* [https://github.com/guanguans/notify](https://github.com/guanguans/notify)
* [https://github.com/guanguans/yii-log-target](https://github.com/guanguans/yii-log-target)

## 环境要求

* laravel >= 5.5

## 安装

``` bash
$ composer require guanguans/laravel-exception-notify -vvv
```

## 配置

### 发布服务

``` bash
$ php artisan vendor:publish --provider="Guanguans\\LaravelExceptionNotify\\ExceptionNotifyServiceProvider"
```

### 申请通道 token 等信息

* [钉钉群机器人](https://developers.dingtalk.com/document/app/custom-robot-access)
* [飞书群机器人](https://www.feishu.cn/hc/zh-CN/articles/360024984973)
* [Server 酱](https://sct.ftqq.com)
* [企业微信群机器人](https://work.weixin.qq.com/help?doc_id=13376)
* [息知](https://xz.qqoq.net/#/index)

### 配置文件中配置 token 等信息

`config/exception-notify.php`

## 使用

### 修改 `app/Exceptions/Handler.php` 文件中的 `report` 方法

``` php
public function report(Exception $exception)
{
    // 添加的代码
    $this->shouldReport($exception) and \ExceptionNotifier::report($exception);
    // // 或者
    // $this->shouldReport($exception) and app('exception.notifier')->report($exception);
    // // 或者
    // $this->shouldReport($exception) and \Guanguans\LaravelExceptionNotify\Facades\Notifier::report($exception);

    parent::report($exception);
}
```

### 通知结果

![钉钉群机器人](docs/dingTalk.png)

![飞书群机器人](docs/feiShu.png)

![企业微信群机器人](docs/weWork.png)

![息知](docs/xiZhi.png)

## 测试

``` bash
$ composer test
```

## 变更日志

请参阅 [CHANGELOG](CHANGELOG.md) 获取最近有关更改的更多信息。

## 贡献指南

请参阅 [CONTRIBUTING](.github/CONTRIBUTING.md) 有关详细信息。

## 安全漏洞

请查看[我们的安全政策](../../security/policy)了解如何报告安全漏洞。

## 贡献者

* [guanguans](https://github.com/guanguans)
* [所有贡献者](../../contributors)

## 协议

MIT 许可证（MIT）。有关更多信息，请参见[协议文件](LICENSE)。
