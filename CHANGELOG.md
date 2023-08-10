<!--- BEGIN HEADER -->
# Changelog

All notable changes to this project will be documented in this file.
<!--- END HEADER -->

<a name="unreleased"></a>
## [Unreleased]


<a name="3.1.2"></a>
## [3.1.2] - 2023-08-10
### Docs
- **readme:** Update README.md

### Fix
- **CollectorManager:** Fix collector mapping

### Refactor
- **Pipes:** refactor ExceptKeysPipe
- **ReportExceptionJob:** improve type hinting
- **collectors:** update ChoreCollector
- **collectors:** simplify RequestSessionCollector
- **collectors:** Use getMarked method to get exception context
- **pipes:** rename AddValuePipe to AddChorePipe


<a name="3.1.1"></a>
## [3.1.1] - 2023-08-10
### Fix
- **src:** unset dispatch in ExceptionNotifyManager

### Refactor
- **ExceptionNotifyManager:** remove unused callback parameter

### Test
- **ExceptionNotifyManagerTest:** spy runningInConsole method
- **FeatureTest:** Improve exception reporting

### Pull Requests
- Merge pull request [#44](https://github.com/guanguans/monorepo-builder-worker/issues/44) from guanguans/imgbot


<a name="3.1.0"></a>
## [3.1.0] - 2023-08-09
### Feat
- **src:** Add ExceptionNotifyServiceProvider.php

### Refactor
- **DdChannel:** remove DdChannel


<a name="3.0.2"></a>
## [3.0.2] - 2023-08-09
### Docs
- **README.md:** update README.md

### Feat
- **helper functions:** add env_explode helper function

### Fix
- **ExceptionNotifyManager:** fix return value when callback returns null
- **helper:** Fix env_explode function

### Refactor
- **config:** update exception-notify.php


<a name="3.0.1"></a>
## [3.0.1] - 2023-08-08
### Feat
- **ExceptionNotifyManager:** add attempt method

### Refactor
- **ExceptionNotifyManager:** add getChannels method
- **config:** update default reported channels


<a name="3.0.0"></a>
## [3.0.0] - 2023-08-08
### Feat
- **tests:** add PHPMock trait

### Refactor
- **ExceptionContext:** simplify code and fix method name
- **ExceptionNotify:** improve getFacadeAccessor method
- **ExceptionNotifyManager:** simplify rate limiting logic
- **LogChannel:** use app('log') instead of Log facade
- **composer:** Remove unused dependencies
- **jobs:** Remove unused Log import
- **naming:** Rename variable to match method call return type
- **src:** Refactor ExceptionNotifyManager

### Test
- **Channels:** Remove redundant test files
- **CollectorManagerTest:** remove unnecessary test
- **FeatureTest:** report exception with file upload
- **NotifyChannelTest:** Add test for reporting


<a name="3.0.0-rc2"></a>
## [3.0.0-rc2] - 2023-08-06
### Docs
- **readme:** update PHP and Laravel requirements

### Feat
- **Jobs:** Improve exception reporting
- **Pipes:** Add RemoveKeysPipe
- **collectors:** Add RequestRawFileCollector
- **pipes:** add OnlyKeysPipe class

### Fix
- **channels:** Update LogChannel constructor
- **collector:** fix Collector::name method
- **collectors:** Rename ExceptionPreviewCollector to ExceptionContextCollector
- **psalm:** fix undefined interface method in ExceptionNotifyManager
- **src:** Add hydrate_pipe helper function to helpers.php

### Refactor
- **collectors:** Update ExceptionPreviewCollector and ExceptionTraceCollector
- **config:** update exception-notify.php
- **exceptions:** remove BadMethodCallException class
- **pipes:** update AddValuePipe
- **src:** remove unused code


<a name="3.0.0-rc1"></a>
## [3.0.0-rc1] - 2023-08-05
### Docs
- **_ide_helper:** Remove unused methods

### Feat
- **ExceptionNotifyManager:** add optional channels parameter to reportIf method
- **JsonFixer:** Update fix method
- **exception-notify:** Add ExceptionPreviewCollector

### Fix
- **ExceptionNotifyManager:** Fix queue connection config key
- **collectors:** fix Illuminate\Container\Container import

### Refactor
- **DdChannel:** remove return type declaration
- **SanitizerContract:** remove unused interface
- **StringableMacro:** Remove beforeLast method
- **collector:** rename toReports to mapToReports
- **collector-manager:** refactor toReports method
- **collectors:** update ApplicationCollector
- **config:** Update exception-notify.php
- **jobs:** optimize ReportExceptionJob
- **pipes:** rename AppendKeywordCollectorsPipe to AddKeywordPipe
- **pipes:** rename AppendContentPipe to AppendKeywordCollectorsPipe
- **pipes:** use Stringable for handle return type
- **pipes:** Extend AddKeywordPipe from AddValuePipe
- **src:** Refactor ExceptionNotifyServiceProvider registerCollectorManager method
- **src:** update ReportExceptionJob.php
- **src:** remove unused code


<a name="3.0.0-beta1"></a>
## [3.0.0-beta1] - 2023-08-02
### Docs
- **changelog:** Add changelog template file

### Feat
- **ExceptionNotifyServiceProvider:** Add StringableMacro to mixins
- **deps:** add laravel/lumen-framework dependency
- **monorepo-builder.php:** add monorepo-builder.php file

### Fix
- **StrMacro:** Fix squish function
- **contracts:** Rename ExceptionAware interface to ExceptionAwareContract

### Refactor
- **.php-cs-fixer.php:** optimize file inclusion
- **Channel:** change getName method to name
- **ChannelContract:** Rename interface Channel to ChannelContract
- **Collector:** remove __toString method
- **Collector:** rename Collector to CollectorContract
- **CollectorManager:** remove __toString method and Stringable interface
- **CollectorManager:** change toArray method to collect
- **Exceptions:** rename Exception.php to ThrowableContract.php
- **Sanitizers:** rename Sanitizers to Pipes
- **collector:** Rename LaravelCollector to ApplicationCollector
- **collector:** remove Stringable interface implementation
- **collectors:** rename AdditionCollector to ChoreCollector
- **collectors:** rename ExceptionAware namespace
- **contracts:** extend Channel and Collector with NameContract
- **facades:** Update facades namespace
- **jobs:** refactor ReportExceptionJob
- **options:** remove OptionsProperty trait
- **php-cs-fixer:** use glob and update directory permissions
- **service-provider:** Update service provider aliases

### Pull Requests
- Merge pull request [#42](https://github.com/guanguans/monorepo-builder-worker/issues/42) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-1.6.0
- Merge pull request [#41](https://github.com/guanguans/monorepo-builder-worker/issues/41) from guanguans/dependabot/composer/dms/phpunit-arraysubset-asserts-tw-0.4.0or-tw-0.5.0


<a name="v2.16.0"></a>
## [v2.16.0] - 2023-06-07
### Pull Requests
- Merge pull request [#40](https://github.com/guanguans/monorepo-builder-worker/issues/40) from guanguans/dependabot/composer/rector/rector-tw-0.15.7or-tw-0.17.0
- Merge pull request [#35](https://github.com/guanguans/monorepo-builder-worker/issues/35) from guanguans/dependabot/github_actions/actions/stale-8
- Merge pull request [#39](https://github.com/guanguans/monorepo-builder-worker/issues/39) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-1.5.1
- Merge pull request [#38](https://github.com/guanguans/monorepo-builder-worker/issues/38) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-1.5.0
- Merge pull request [#36](https://github.com/guanguans/monorepo-builder-worker/issues/36) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-1.4.0


<a name="v2.15.0"></a>
## [v2.15.0] - 2023-03-20
### Pull Requests
- Merge pull request [#30](https://github.com/guanguans/monorepo-builder-worker/issues/30) from guanguans/dependabot/composer/nunomaduro/larastan-tw-1.0or-tw-2.0
- Merge pull request [#31](https://github.com/guanguans/monorepo-builder-worker/issues/31) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-1.3.6


<a name="v2.14.4"></a>
## [v2.14.4] - 2023-01-19

<a name="v2.14.3"></a>
## [v2.14.3] - 2023-01-18
### Pull Requests
- Merge pull request [#27](https://github.com/guanguans/monorepo-builder-worker/issues/27) from guanguans/dependabot/composer/rector/rector-tw-0.14.8or-tw-0.15.0


<a name="v2.14.2"></a>
## [v2.14.2] - 2022-11-29

<a name="v2.14.1"></a>
## [v2.14.1] - 2022-11-29
### Pull Requests
- Merge pull request [#26](https://github.com/guanguans/monorepo-builder-worker/issues/26) from guanguans/imgbot


<a name="v2.14.0"></a>
## [v2.14.0] - 2022-11-28

<a name="v2.13.0"></a>
## [v2.13.0] - 2022-11-26

<a name="v2.12.0"></a>
## [v2.12.0] - 2022-06-09

<a name="v2.11.5"></a>
## [v2.11.5] - 2022-05-16

<a name="v2.11.4"></a>
## [v2.11.4] - 2022-05-12

<a name="v2.11.3"></a>
## [v2.11.3] - 2022-05-05

<a name="v2.11.2"></a>
## [v2.11.2] - 2022-05-04

<a name="v2.11.1"></a>
## [v2.11.1] - 2022-05-04

<a name="v2.11.0"></a>
## [v2.11.0] - 2022-05-04

<a name="v2.10.0"></a>
## [v2.10.0] - 2022-04-29

<a name="v2.9.0"></a>
## [v2.9.0] - 2022-04-16

<a name="v2.8.0"></a>
## [v2.8.0] - 2022-04-09
### Pull Requests
- Merge pull request [#21](https://github.com/guanguans/monorepo-builder-worker/issues/21) from guanguans/dependabot/github_actions/codecov/codecov-action-3


<a name="v2.7.1"></a>
## [v2.7.1] - 2022-03-30
### Pull Requests
- Merge pull request [#20](https://github.com/guanguans/monorepo-builder-worker/issues/20) from guanguans/issue-19-Job错误


<a name="v2.7.0"></a>
## [v2.7.0] - 2022-03-29

<a name="v2.6.3"></a>
## [v2.6.3] - 2022-03-29

<a name="v2.6.2"></a>
## [v2.6.2] - 2022-03-27

<a name="v2.6.1"></a>
## [v2.6.1] - 2022-03-27

<a name="v2.6.0"></a>
## [v2.6.0] - 2022-03-26

<a name="v2.5.1"></a>
## [v2.5.1] - 2022-03-23

<a name="v2.5.0"></a>
## [v2.5.0] - 2022-03-23

<a name="v2.4.0"></a>
## [v2.4.0] - 2022-03-23

<a name="v2.3.0"></a>
## [v2.3.0] - 2022-03-23

<a name="v2.2.0"></a>
## [v2.2.0] - 2022-03-23

<a name="v2.1.3"></a>
## [v2.1.3] - 2022-03-23
### Pull Requests
- Merge pull request [#18](https://github.com/guanguans/monorepo-builder-worker/issues/18) from guanguans/dependabot/github_actions/actions/cache-3


<a name="v2.1.2"></a>
## [v2.1.2] - 2022-03-15

<a name="v2.1.1"></a>
## [v2.1.1] - 2022-03-14

<a name="v2.1.0"></a>
## [v2.1.0] - 2022-03-14

<a name="v2.0.8"></a>
## [v2.0.8] - 2022-03-14

<a name="v2.0.7"></a>
## [v2.0.7] - 2022-03-14

<a name="v2.0.6"></a>
## [v2.0.6] - 2022-03-13

<a name="v2.0.5"></a>
## [v2.0.5] - 2022-03-13

<a name="v2.0.4"></a>
## [v2.0.4] - 2022-03-13

<a name="v2.0.3"></a>
## [v2.0.3] - 2022-03-13

<a name="v2.0.2"></a>
## [v2.0.2] - 2022-03-13

<a name="v2.0.1"></a>
## [v2.0.1] - 2022-03-13

<a name="v2.0.0"></a>
## [v2.0.0] - 2022-03-13
### Pull Requests
- Merge pull request [#17](https://github.com/guanguans/monorepo-builder-worker/issues/17) from guanguans/imgbot
- Merge pull request [#16](https://github.com/guanguans/monorepo-builder-worker/issues/16) from guanguans/imgbot
- Merge pull request [#15](https://github.com/guanguans/monorepo-builder-worker/issues/15) from guanguans/dependabot/github_actions/actions/checkout-3


<a name="v1.2.3"></a>
## [v1.2.3] - 2022-02-28

<a name="v1.2.2"></a>
## [v1.2.2] - 2022-02-27

<a name="v1.2.1"></a>
## [v1.2.1] - 2022-02-22

<a name="v1.2.0"></a>
## [v1.2.0] - 2022-02-14

<a name="v1.1.12"></a>
## [v1.1.12] - 2021-12-03

<a name="v1.1.11"></a>
## [v1.1.11] - 2021-11-07

<a name="v1.1.10"></a>
## [v1.1.10] - 2021-11-07

<a name="v1.1.9"></a>
## [v1.1.9] - 2021-11-07
### Pull Requests
- Merge pull request [#13](https://github.com/guanguans/monorepo-builder-worker/issues/13) from guanguans/imgbot


<a name="v1.1.8"></a>
## [v1.1.8] - 2021-11-06

<a name="v1.1.7"></a>
## [v1.1.7] - 2021-11-05

<a name="v1.1.6"></a>
## [v1.1.6] - 2021-11-03

<a name="v1.1.5"></a>
## [v1.1.5] - 2021-10-16
### Pull Requests
- Merge pull request [#11](https://github.com/guanguans/monorepo-builder-worker/issues/11) from JimChenWYU/main


<a name="v1.1.4"></a>
## [v1.1.4] - 2021-10-10

<a name="v1.1.3"></a>
## [v1.1.3] - 2021-10-09
### Pull Requests
- Merge pull request [#10](https://github.com/guanguans/monorepo-builder-worker/issues/10) from PrintNow/main


<a name="v1.1.2"></a>
## [v1.1.2] - 2021-10-08
### Pull Requests
- Merge pull request [#7](https://github.com/guanguans/monorepo-builder-worker/issues/7) from guanguans/dependabot/composer/friendsofphp/php-cs-fixer-tw-2.16or-tw-3.0


<a name="v1.1.1"></a>
## [v1.1.1] - 2021-09-30

<a name="v1.1.0"></a>
## [v1.1.0] - 2021-09-29
### Pull Requests
- Merge pull request [#6](https://github.com/guanguans/monorepo-builder-worker/issues/6) from guanguans/dependabot/composer/vimeo/psalm-tw-3.11or-tw-4.0
- Merge pull request [#5](https://github.com/guanguans/monorepo-builder-worker/issues/5) from guanguans/dependabot/composer/overtrue/phplint-tw-2.3or-tw-3.0
- Merge pull request [#4](https://github.com/guanguans/monorepo-builder-worker/issues/4) from guanguans/dependabot/github_actions/codecov/codecov-action-2.1.0


<a name="v1.0.7"></a>
## [v1.0.7] - 2021-07-22

<a name="v1.0.6"></a>
## [v1.0.6] - 2021-07-08

<a name="v1.0.5"></a>
## [v1.0.5] - 2021-07-08

<a name="v1.0.4"></a>
## [v1.0.4] - 2021-07-06

<a name="v1.0.3"></a>
## [v1.0.3] - 2021-07-04

<a name="v1.0.2"></a>
## [v1.0.2] - 2021-07-04
### Pull Requests
- Merge pull request [#2](https://github.com/guanguans/monorepo-builder-worker/issues/2) from guanguans/imgbot


<a name="v1.0.1"></a>
## [v1.0.1] - 2021-07-04

<a name="v1.0.0"></a>
## v1.0.0 - 2021-07-04
### Pull Requests
- Merge pull request [#1](https://github.com/guanguans/monorepo-builder-worker/issues/1) from guanguans/imgbot


[Unreleased]: https://github.com/guanguans/monorepo-builder-worker/compare/3.1.2...HEAD
[3.1.2]: https://github.com/guanguans/monorepo-builder-worker/compare/3.1.1...3.1.2
[3.1.1]: https://github.com/guanguans/monorepo-builder-worker/compare/3.1.0...3.1.1
[3.1.0]: https://github.com/guanguans/monorepo-builder-worker/compare/3.0.2...3.1.0
[3.0.2]: https://github.com/guanguans/monorepo-builder-worker/compare/3.0.1...3.0.2
[3.0.1]: https://github.com/guanguans/monorepo-builder-worker/compare/3.0.0...3.0.1
[3.0.0]: https://github.com/guanguans/monorepo-builder-worker/compare/3.0.0-rc2...3.0.0
[3.0.0-rc2]: https://github.com/guanguans/monorepo-builder-worker/compare/3.0.0-rc1...3.0.0-rc2
[3.0.0-rc1]: https://github.com/guanguans/monorepo-builder-worker/compare/3.0.0-beta1...3.0.0-rc1
[3.0.0-beta1]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.16.0...3.0.0-beta1
[v2.16.0]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.15.0...v2.16.0
[v2.15.0]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.14.4...v2.15.0
[v2.14.4]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.14.3...v2.14.4
[v2.14.3]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.14.2...v2.14.3
[v2.14.2]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.14.1...v2.14.2
[v2.14.1]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.14.0...v2.14.1
[v2.14.0]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.13.0...v2.14.0
[v2.13.0]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.12.0...v2.13.0
[v2.12.0]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.11.5...v2.12.0
[v2.11.5]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.11.4...v2.11.5
[v2.11.4]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.11.3...v2.11.4
[v2.11.3]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.11.2...v2.11.3
[v2.11.2]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.11.1...v2.11.2
[v2.11.1]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.11.0...v2.11.1
[v2.11.0]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.10.0...v2.11.0
[v2.10.0]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.9.0...v2.10.0
[v2.9.0]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.8.0...v2.9.0
[v2.8.0]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.7.1...v2.8.0
[v2.7.1]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.7.0...v2.7.1
[v2.7.0]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.6.3...v2.7.0
[v2.6.3]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.6.2...v2.6.3
[v2.6.2]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.6.1...v2.6.2
[v2.6.1]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.6.0...v2.6.1
[v2.6.0]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.5.1...v2.6.0
[v2.5.1]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.5.0...v2.5.1
[v2.5.0]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.4.0...v2.5.0
[v2.4.0]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.3.0...v2.4.0
[v2.3.0]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.2.0...v2.3.0
[v2.2.0]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.1.3...v2.2.0
[v2.1.3]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.1.2...v2.1.3
[v2.1.2]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.1.1...v2.1.2
[v2.1.1]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.1.0...v2.1.1
[v2.1.0]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.0.8...v2.1.0
[v2.0.8]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.0.7...v2.0.8
[v2.0.7]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.0.6...v2.0.7
[v2.0.6]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.0.5...v2.0.6
[v2.0.5]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.0.4...v2.0.5
[v2.0.4]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.0.3...v2.0.4
[v2.0.3]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.0.2...v2.0.3
[v2.0.2]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.0.1...v2.0.2
[v2.0.1]: https://github.com/guanguans/monorepo-builder-worker/compare/v2.0.0...v2.0.1
[v2.0.0]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.2.3...v2.0.0
[v1.2.3]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.2.2...v1.2.3
[v1.2.2]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.2.1...v1.2.2
[v1.2.1]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.2.0...v1.2.1
[v1.2.0]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.1.12...v1.2.0
[v1.1.12]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.1.11...v1.1.12
[v1.1.11]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.1.10...v1.1.11
[v1.1.10]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.1.9...v1.1.10
[v1.1.9]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.1.8...v1.1.9
[v1.1.8]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.1.7...v1.1.8
[v1.1.7]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.1.6...v1.1.7
[v1.1.6]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.1.5...v1.1.6
[v1.1.5]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.1.4...v1.1.5
[v1.1.4]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.1.3...v1.1.4
[v1.1.3]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.1.2...v1.1.3
[v1.1.2]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.1.1...v1.1.2
[v1.1.1]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.1.0...v1.1.1
[v1.1.0]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.0.7...v1.1.0
[v1.0.7]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.0.6...v1.0.7
[v1.0.6]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.0.5...v1.0.6
[v1.0.5]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.0.4...v1.0.5
[v1.0.4]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.0.3...v1.0.4
[v1.0.3]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.0.2...v1.0.3
[v1.0.2]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.0.1...v1.0.2
[v1.0.1]: https://github.com/guanguans/monorepo-builder-worker/compare/v1.0.0...v1.0.1
