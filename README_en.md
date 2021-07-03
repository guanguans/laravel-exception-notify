# laravel-exception-notify

[简体中文](README.md) | [ENGLISH](README_en.md)

> Multiple channels of laravel exception notification(DingTalk、FeiShu、ServerChan、WeWork、XiZhi). - 多种通道的 laravel 异常通知(钉钉群机器人、飞书群机器人、Server 酱、企业微信群机器人、息知)。

[![Tests](https://github.com/guanguans/laravel-exception-notify/workflows/Tests/badge.svg)](https://github.com/guanguans/laravel-exception-notify/actions)
[![Check & fix styling](https://github.com/guanguans/laravel-exception-notify/workflows/Check%20&%20fix%20styling/badge.svg)](https://github.com/guanguans/laravel-exception-notify/actions)
[![codecov](https://codecov.io/gh/guanguans/laravel-exception-notify/branch/main/graph/badge.svg?token=URGFAWS6S4)](https://codecov.io/gh/guanguans/laravel-exception-notify)
[![Latest Stable Version](https://poser.pugx.org/guanguans/laravel-exception-notify/v)](//packagist.org/packages/guanguans/laravel-exception-notify)
[![Total Downloads](https://poser.pugx.org/guanguans/laravel-exception-notify/downloads)](//packagist.org/packages/guanguans/laravel-exception-notify)
[![License](https://poser.pugx.org/guanguans/laravel-exception-notify/license)](//packagist.org/packages/guanguans/laravel-exception-notify)

## Feature

* Monitor and send laravel application exception
* Support multiple channels(DingTalk、FeiShu、ServerChan、WeWork、XiZhi)
* Customize the abnormal information data sent

## Related Links

* [https://github.com/guanguans/notify](https://github.com/guanguans/notify)
* [https://github.com/guanguans/yii-log-target](https://github.com/guanguans/yii-log-target)

## Requirement

* laravel >= 5.5

## Installation

``` bash
$ composer require guanguans/laravel-exception-notify -vvv
```

## Configuration

### Publish service

``` bash
$ php artisan vendor:publish --provider="Guanguans\\LaravelExceptionNotify\\ExceptionNotifyServiceProvider"
```

### Apply for channel `token` and other information

* [Dingtalk](https://developers.dingtalk.com/document/app/custom-robot-access)
* [Feishu](https://www.feishu.cn/hc/zh-CN/articles/360024984973)
* [ServerChan](https://sct.ftqq.com)
* [WeWork](https://work.weixin.qq.com/help?doc_id=13376)
* [XiZhi](https://xz.qqoq.net/#/index)

### Configure `token` and other information in the configuration file

`config/exception-notify.php`

## Usage

### Modify the `report` method in the `app/Exceptions/Handler.php` file

``` php
public function report(Exception $exception)
{
    // Added code
    if ($this->shouldReport($exception)) {
        app('exception.notifier')->report($exception);
        /*
        OR ...
        \ExceptionNotifier::report($exception);
        \Guanguans\LaravelExceptionNotify\Facades\Notifier::report($exception);
        */
    }

    parent::report($exception);
}
```

### Notification result

![dingTalk](docs/dingTalk.png)

![feiShu](docs/feiShu.png)

![weWork](docs/weWork.png)

![xiZhi](docs/xiZhi.png)

## Testing

``` bash
$ composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

* [guanguans](https://github.com/guanguans)
* [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
