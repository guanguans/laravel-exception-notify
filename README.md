# laravel-exception-notify

[简体中文](README-zh_CN.md) | [ENGLISH](README.md)

> [!CAUTION]
> 4.x is developed, but not stable yet. but not recommended for production use. please use 3.x version.

> Exception monitoring alarm notification in Laravel(Bark、Chanify、DingTalk、Discord、FeiShu、Mail、PushDeer、QQ Channel Bot、ServerChan、Slack、Telegram、WeWork、XiZhi).

[![tests](https://github.com/guanguans/laravel-exception-notify/workflows/tests/badge.svg)](https://github.com/guanguans/laravel-exception-notify/actions)
[![check & fix styling](https://github.com/guanguans/laravel-exception-notify/workflows/check%20&%20fix%20styling/badge.svg)](https://github.com/guanguans/laravel-exception-notify/actions)
[![codecov](https://codecov.io/gh/guanguans/laravel-exception-notify/branch/main/graph/badge.svg?token=URGFAWS6S4)](https://codecov.io/gh/guanguans/laravel-exception-notify)
[![Latest Stable Version](https://poser.pugx.org/guanguans/laravel-exception-notify/v)](https://packagist.org/packages/guanguans/laravel-exception-notify)
[![GitHub release (with filter)](https://img.shields.io/github/v/release/guanguans/laravel-exception-notify)](https://github.com/guanguans/laravel-exception-notify/releases)
[![Total Downloads](https://poser.pugx.org/guanguans/laravel-exception-notify/downloads)](https://packagist.org/packages/guanguans/laravel-exception-notify)
[![License](https://poser.pugx.org/guanguans/laravel-exception-notify/license)](https://packagist.org/packages/guanguans/laravel-exception-notify)

## Feature

* Monitor and send laravel application exception
* Support for multi-channel notification
* Support for extending custom channel
* Support for custom data collector
* Support for custom data pipe
* Support for notification rate limiting

## Related Links

* [https://github.com/guanguans/notify](https://github.com/guanguans/notify)
* [https://github.com/guanguans/yii-log-target](https://github.com/guanguans/yii-log-target)

## Requirement

* PHP >= 7.4

## Installation

```bash
composer require guanguans/laravel-exception-notify -v
```

## Configuration

### Publish files(optional)

```bash
php artisan vendor:publish --provider="Guanguans\\LaravelExceptionNotify\\ExceptionNotifyServiceProvider"
```

### Apply for channel `token` or `secret` information

* [Bark](https://github.com/Finb/Bark)
* [Chanify](https://github.com/chanify?type=source)
* [Dingtalk](https://developers.dingtalk.com/document/app/custom-robot-access)
* [Discord](https://discord.com/developers/docs/resources/webhook#edit-webhook-message)
* [Feishu](https://www.feishu.cn/hc/zh-CN/articles/360024984973)
* [PushDeer](http://pushdeer.com)
* [QQ Channel Bot](https://bot.q.qq.com/wiki/develop/api/openapi/message/post_messages.html)
* [ServerChan](https://sct.ftqq.com)
* [Slack](https://api.slack.com/messaging/webhooks)
* [Telegram](https://core.telegram.org/bots/api#sendmessage)
* [WeWork](https://work.weixin.qq.com/help?doc_id=13376)
* [XiZhi](https://xz.qqoq.net/#/index)

### Configure channels in the `config/exception-notify.php` or `.env` file

```dotenv
EXCEPTION_NOTIFY_DEFAULTS=dingTalk,log,...

EXCEPTION_NOTIFY_DINGTALK_KEYWORD=keyword # optional
EXCEPTION_NOTIFY_DINGTALK_TOKEN=c44fec1ddaa8a833156efb77b7865d62ae13775418030d94d
EXCEPTION_NOTIFY_DINGTALK_SECRET=SECc32bb7345c0f73da2b9786f0f7dd5083bd768a29b82 # optional
```

## Usage

### Test for exception notify

```shell
php artisan exception-notify:test
```

### Notification example(Xi Zhi)

| 1                            | 2                            | 3                            |
|------------------------------|------------------------------|------------------------------|
| ![xiZhi-1](docs/xiZhi-1.jpg) | ![xiZhi-2](docs/xiZhi-2.jpg) | ![xiZhi-3](docs/xiZhi-3.jpg) |

## Extend custom channel

Modify the `boot` method in the `app/Providers/AppServiceProvider.php` file

```php
public function boot()
{
    \ExceptionNotifier::extend('YourChannel', function (\Illuminate\Contracts\Container\Container $container){
        // return instance of the `\Guanguans\LaravelExceptionNotify\Contracts\ChannelContract`.          
    });
}
```

## Testing

```bash
composer test
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

## Thanks

[![](https://resources.jetbrains.com/storage/products/company/brand/logos/jb_beam.svg)](https://www.jetbrains.com/?from=https://github.com/guanguans)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
