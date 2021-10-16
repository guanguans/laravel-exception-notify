# Changelog

All notable changes to `guanguans/laravel-exception-notify` will be documented in this file.

## 1.1.5 - 2021-10-16

* Fix the error of the push configuration file path.

## 1.1.4 - 2021-10-10

* `Notifier::class` alias `exception.notifier`.

## 1.1.3 - 2021-10-09

* Fix the queue is still executed synchronously in the case of asynchronous configuration of the queue(#8).
* Fix markdown template.

## 1.1.2 - 2021-10-08

* Optimize service registration.

## 1.1.1 - 2021-09-30

* Fix that the configuration is not loaded in the lumen environment.

## 1.1.0 - 2021-09-29

* Adapt lumen.
* Update github config files.

## 1.0.7 - 2021-07-22

* Fix Dispatch not exists method `afterResponse` error.
* Rename `exception_trace` -> `exception_stack_trace`.
* Update php-cs-fixer config file.

## 1.0.6 - 2021-07-08

* Optimize `ExceptionNotifyServiceProvider`.
* Fix config `exception_stack_trace` option.

## 1.0.5 - 2021-07-08

* Rename property `on` -> `enabled`.
* Add InvalidCallException.

## 1.0.4 - 2021-07-06

* Optimize create client instance.
* Fix request method information name.

## 1.0.3 - 2021-07-04

* Optimize Notifier.

## 1.0.2 - 2021-07-04

* Add `on`、`env`、`dontReport` config options.

## 1.0.1 - 2021-07-04

* Optimize Notifier.
* Optimize SendExceptionNotification job.

## 1.0.0 - 2021-07-04

* Initial release.
