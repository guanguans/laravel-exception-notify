# laravel-exception-notify

> Monitor exception and report it to notification channels(Log、Mail、Bark、Chanify、DingTalk、Discord、Gitter、GoogleChat、IGot、Lark、Mattermost、MicrosoftTeams、NowPush、Ntfy、Push、Pushback、PushBullet、PushDeer、Pushover、PushPlus、QQ、RocketChat、ServerChan、ShowdocPush、SimplePush、Slack、Telegram、WeWork、XiZhi、YiFengChuanHua、Zulip).

[![tests](https://github.com/guanguans/laravel-exception-notify/workflows/tests/badge.svg)](https://github.com/guanguans/laravel-exception-notify/actions)
[![check & fix styling](https://github.com/guanguans/laravel-exception-notify/workflows/check%20&%20fix%20styling/badge.svg)](https://github.com/guanguans/laravel-exception-notify/actions)
[![codecov](https://codecov.io/gh/guanguans/laravel-exception-notify/branch/main/graph/badge.svg?token=URGFAWS6S4)](https://codecov.io/gh/guanguans/laravel-exception-notify)
[![Latest Stable Version](https://poser.pugx.org/guanguans/laravel-exception-notify/v)](https://packagist.org/packages/guanguans/laravel-exception-notify)
[![GitHub release (with filter)](https://img.shields.io/github/v/release/guanguans/laravel-exception-notify)](https://github.com/guanguans/laravel-exception-notify/releases)
[![Total Downloads](https://poser.pugx.org/guanguans/laravel-exception-notify/downloads)](https://packagist.org/packages/guanguans/laravel-exception-notify)
[![License](https://poser.pugx.org/guanguans/laravel-exception-notify/license)](https://packagist.org/packages/guanguans/laravel-exception-notify)

## Features

* Monitor exception and report it to notification channels
* Support for extending customized channels
* Support for notification rate limiting
* Support for customized data pipe
* Support for customized data collector

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
php artisan vendor:publish --provider="Guanguans\\LaravelExceptionNotify\\ExceptionNotifyServiceProvider" --ansi -v
```

### Apply for channel authentication and other information

* [Notify](https://github.com/guanguans/notify#platform-support)
* Dump(For debugging exception messages)
* Log(For debugging exception messages)
* [Mail](https://example.com)

### Configure channels in the `config/exception-notify.php` and `.env` file

```dotenv
#EXCEPTION_NOTIFY_DEFAULTS=dingTalk,lark,mail,slack,telegram,...
EXCEPTION_NOTIFY_DEFAULTS=log,slack,weWork
EXCEPTION_NOTIFY_SLACK_WEBHOOK=https://hooks.slack.com/services/TPU9A9/B038KNUC0GY/6pKH3vfa3mjlUPcgLSjzR
EXCEPTION_NOTIFY_WEWORK_TOKEN=73a3d5a3-ceff-4da8-bcf3-ff5891778
```

## Usage

### Test for exception notify

```shell
php artisan exception-notify:test --ansi -v
```

### Notification examples

| 1                            | 2                            | 3                            |
|------------------------------|------------------------------|------------------------------|
| ![xiZhi-1](docs/xiZhi-1.jpg) | ![xiZhi-2](docs/xiZhi-2.jpg) | ![xiZhi-3](docs/xiZhi-3.jpg) |

### Skip report

Modify the `boot` method in the `app/Providers/AppServiceProvider.php` file

```php
<?php

use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Illuminate\Support\Arr;

public function boot(): void
{
    ExceptionNotifyManager::skipWhen(static function (\Throwable $throwable) {
        if (app()->environment(['local', 'testing'])) {
            return true;
        }

        return Arr::first(
            [
                Symfony\Component\HttpKernel\Exception\HttpException::class,
                Illuminate\Http\Exceptions\HttpResponseException::class,
            ],
            static fn (string $type): bool => $throwable instanceof $type
        );
    });
}
```

### Extend custom channel

Modify the `boot` method in the `app/Providers/AppServiceProvider.php` file

```php
<?php

use Guanguans\LaravelExceptionNotify\Contracts\Channel;
use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Illuminate\Container\Container;

public function boot(): void
{
    ExceptionNotify::extend('YourChannelName', function (Container $container): Channel {
        return 'instance of the `\Guanguans\LaravelExceptionNotify\Contracts\Channel`.';
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
