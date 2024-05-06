# laravel-exception-notify

> [!CAUTION]
> 4.x is developed, but not stable yet. but not recommended for production use. please use 3.x version.

> Exception monitoring alarm notification in Laravel(Bark、Chanify、DingTalk、Discord、Gitter、GoogleChat、IGot、Lark、Mattermost、MicrosoftTeams、NowPush、Ntfy、Push、Pushback、PushBullet、PushDeer、Pushover、PushPlus、QQ、RocketChat、ServerChan、ShowdocPush、SimplePush、Slack、Telegram、WeWork、XiZhi、YiFengChuanHua、Zulip).

[![tests](https://github.com/guanguans/laravel-exception-notify/workflows/tests/badge.svg)](https://github.com/guanguans/laravel-exception-notify/actions)
[![check & fix styling](https://github.com/guanguans/laravel-exception-notify/workflows/check%20&%20fix%20styling/badge.svg)](https://github.com/guanguans/laravel-exception-notify/actions)
[![codecov](https://codecov.io/gh/guanguans/laravel-exception-notify/branch/main/graph/badge.svg?token=URGFAWS6S4)](https://codecov.io/gh/guanguans/laravel-exception-notify)
[![Latest Stable Version](https://poser.pugx.org/guanguans/laravel-exception-notify/v)](https://packagist.org/packages/guanguans/laravel-exception-notify)
[![GitHub release (with filter)](https://img.shields.io/github/v/release/guanguans/laravel-exception-notify)](https://github.com/guanguans/laravel-exception-notify/releases)
[![Total Downloads](https://poser.pugx.org/guanguans/laravel-exception-notify/downloads)](https://packagist.org/packages/guanguans/laravel-exception-notify)
[![License](https://poser.pugx.org/guanguans/laravel-exception-notify/license)](https://packagist.org/packages/guanguans/laravel-exception-notify)

## Features

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

### Apply for channel `auth' and other information

* [Notify](https://github.com/guanguans/notify#platform-support)
* Dump
* Log
* Mail

### Configure channels in the `config/exception-notify.php` or `.env` file

```dotenv
EXCEPTION_NOTIFY_DEFAULTS=lark,log,mail,slack,...
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
