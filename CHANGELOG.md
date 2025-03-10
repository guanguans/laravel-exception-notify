<!--- BEGIN HEADER -->
# Changelog

All notable changes to this project will be documented in this file.
<!--- END HEADER -->

<a name="unreleased"></a>
## [Unreleased]


<a name="5.0.0-beta1"></a>
## [5.0.0-beta1] - 2025-03-10
### CI
- improve type safety and add type perfect settings
- **baselines:** Remove deprecated baseline files and update configs
- **baselines:** Add new baseline files for PHPStan errors
- **composer:** Add class-leak commands to composer.json
- **composer:** Add new composer packages and update configurations
- **config:** Add Composer Dependency Analyser configuration
- **config:** Refactor composer-unused and remove unused files
- **config:** Update composer require checker configuration
- **dependencies:** Add facade-documenter and ai-commit packages
- **rector:** Add class visibility change configuration and utility function

### Feat
- Refactor hydrate_pipe function to static call and update checks
- **channels:** Introduce AbstractChannel and Refactor Channels
- **channels:** Refactor report methods to improve exception handling
- **channels:** Add StackChannel for handling reports
- **commands:** Add Configureable trait for dynamic options
- **exception-notify:** Add conditional reporting to exception handler
- **naming:** Add Naming trait for dynamic channel names
- **tests:** Refactor namespace and classmap for tests
- **trait:** Enhance configuration handling with extender support
- **traits:** Add MakeStaticable, SetStateable, and WithPipeArgs
- **workflows:** Update Laravel and PHP dependencies configuration
- **workflows:** upgrade PHP version to 8.0

### Fix
- **Channel:** Pass throwable to job and collectors
- **abstract-channel:** Remove unset of pending dispatch job
- **config:** Add mail reporting support for exceptions
- **dependencies:** Remove Carbon from ignored packages
- **tests:** Add ExceptionNotifyManagerTest for exception fingerprints

### Refactor
- Refactor function calls to use global scope
- Update types and improve PHP version compatibility
- Update type hinting to use mixed type for parameters
- Replace Str::of() with str() for consistency
- Improve code quality and consistency in rector.php
- Consolidate mail reporting and config application
- **Channel:** Improve exception reporting logic
- **Channel:** Rename configuration key for clarity
- **Channel:** Improve error handling using rescue function
- **Channel:** Remove rescue usage and optimize report methods
- **Channel:** Simplify event handling in report methods
- **Channel:** Validate configuration on construction
- **Channels:** Simplify exception reporting logic
- **Channels:** Remove ApplyConfigurationToObjectable trait
- **Channels:** Improve method visibility and organization
- **Contracts:** Rename Throwable to ThrowableContract and update usages
- **Dependencies:** Refactor function calls to support namespace
- **ExceptionNotifyManager:** Simplify rate limiting logic
- **HydratePipeFuncCallToStaticCallRector:** Use ValueResolver for static call
- **Notifiable:** Rename report variable to content
- **NotifyChannel:** Simplify authenticator creation process
- **StackChannel:** Improve error handling in report methods
- **baselines:** Remove obsolete NEON files and update imports
- **channel:** Rename report method and parameter
- **channels:** Implement DumpChannel class for logging
- **channels:** Rename reportRaw to reportContent
- **channels:** Rename CHANNEL_KEY to CHANNEL_CONFIG_KEY
- **channels:** Replace InvalidArgumentException with InvalidConfigurationException
- **channels:** Simplify channel handling in AbstractChannel
- **collectors:** Remove unused request collectors
- **collectors:** Rename Collector classes to AbstractCollector
- **collectors:** Improve null safety and type hints in methods
- **collectors:** Improve time handling with Carbon
- **collectors:** Change name method to instance method
- **commands:** Update TestCommand signature and logic
- **config:** Replace NotifyChannel usage with AbstractChannel
- **config:** Enable PHP 8.0 migration rules and clean code
- **config:** Simplify constructor property promotion
- **config:** Rename 'envs' to 'environments'
- **config:** Organize project structure and update scripts
- **contracts:** Rename Channel interface to ChannelContract
- **contracts:** Rename ExceptionAware to ExceptionAwareContract
- **core:** Simplify channel interfaces and collector merging
- **core:** Update report methods to return mixed type
- **events:** Rename exception events for clarity
- **exception-notify:** Update rescue function usage
- **exception-notify:** Improve job dispatch handling
- **exception-notify:** Simplify templates in NotifyChannel
- **pipes:** Replace hydrate_pipe calls with static calls
- **service provider:** Simplify singleton registrations
- **support:** Integrate AggregationTrait into Channel and Manager
- **support:** Improve exception handling with line number


<a name="4.7.0"></a>
## [4.7.0] - 2025-03-01
### CI
- **composer-updater:** Refactor coding style and cleanup warnings
- **tests:** Update PHP versions in CI workflow

### Docs
- update copyright year to 2025 in multiple files

### Feat
- **composer:** Update framework dependency
- **composer:** update dependencies and improve scripts

### Test
- **LogChannelTest:** Skip test for specific Laravel versions

### Pull Requests
- Merge pull request [#72](https://github.com/guanguans/laravel-exception-notify/issues/72) from laravel-shift/l12-compatibility
- Merge pull request [#71](https://github.com/guanguans/laravel-exception-notify/issues/71) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.3.0
- Merge pull request [#70](https://github.com/guanguans/laravel-exception-notify/issues/70) from guanguans/dependabot/github_actions/codecov/codecov-action-5


<a name="4.6.0"></a>
## [4.6.0] - 2024-08-16
### CI
- **rector:** add static arrow and closure rectors

### Feat
- **dependencies:** update package versions in composer.json

### Perf
- Use fully qualified sprintf function in multiple files

### Pull Requests
- Merge pull request [#68](https://github.com/guanguans/laravel-exception-notify/issues/68) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.2.0


<a name="4.5.1"></a>
## [4.5.1] - 2024-05-17
### Refactor
- **config:** remove PhpInfoCollector from exception-notify config


<a name="4.5.0"></a>
## [4.5.0] - 2024-05-17
### Docs
- **README:** update supported notification channels in English README
- **README:** Add caution for 4.x version
- **mail:** Update mail.jpg
- **readme:** update list of available features
- **readme:** Update README.md with more descriptive content
- **readme:** update supported notification channels

### Feat
- **Channel:** add Channel base class and extend other channel classes
- **ExceptionNotify:** Add skipWhen method
- **ExceptionNotifyManager:** Add skipWhen method
- **ToInternalExceptionRector:** Add ToInternalExceptionRector for internal exceptions
- **collectors:** Add time field to ApplicationCollector
- **composer-require-checker:** Add configuration file for composer-require-checker
- **config:** Add environment configuration for exception notification
- **config:** Add new notification channels
- **config:** add aggregate channel configuration
- **config:** add mail configuration
- **config:** Add WithLogMiddlewareClientTapper class for exception-notify config
- **laravel:** Add Laravel 8.0 set list and related rules

### Fix
- Optimized the email sending logic and added pipeline handling in the exception notification feature
- **command:** Fix condition check for driver in TestCommand.php

### Refactor
- Replace ExceptionNotifyManager with ExceptionNotify facade
- change visibility of Request properties to private
- Fix exception handling and enhance type safety
- Fix exception handling and enhance type safety
- update contract names in classes
- modify ExceptionNotifyManager to use configRepository
- **Channel:** refactor string replacement method
- **Channels:** Improve readability of MailChannel and NotifyChannel
- **DefaultNotifyClientExtender:** Improve channel parameter handling
- **ExceptionNotifyManager:** Improve createDriver method
- **FuncCallToStaticCall:** refactor static calls to function calls
- **MailChannel:** simplify createMail method
- **Naming:** improve name generation logic
- **NotifyChannel:** Refactor NotifyChannel class for better readability and maintainability
- **StaticCallToFuncCall:** refactor Str::of to str
- **app:** Modify boot method in AppServiceProvider.php
- **code:** Improve ExceptionNotify skipWhen method
- **collect:** Improve RequestHeaderCollector to handle header array
- **collector:** remove unused code and fix access level of method
- **collector:** Improve exception trace collection
- **collector:** update rejected headers list
- **collectors:** remove unnecessary properties from ExceptionBasicCollector
- **command:** update TestCommand signature and handle method
- **commands:** improve readability of TestCommand.php
- **composer:** remove guanguans/ai-commit dependency
- **config:** Update default queue connection
- **config:** update Lark configuration and rename client tapper
- **config:** refactor RectorConfig
- **config:** Update exception notification rate limit cache store
- **config:** Update email recipients key in exception notification config
- **config:** update client extender references
- **config:** remove unnecessary code in exception-notify configuration
- **config:** update exception-notify.php configuration
- **config:** update notify client extenders
- **config:** remove 'report_using_creator' from exception-notify.php
- **config:** update 'env' to 'envs' in exception-notify.php
- **config:** update exception-notify extender function
- **config:** update exception-notify configuration
- **config:** Remove unnecessary comment lines
- **config:** remove FixPrettyJsonPipe from exception-notify.php
- **exception-notify:** update lark configuration
- **log:** Simplify LogChannel constructor and report method
- **mail:** Improve mail channel configuration and method handling
- **mail:** update mail classes names
- **mail:** rename ExceptionReportMail to ReportExceptionMail
- **mail:** Improve method call in MailChannel
- **mail:** Improve mail channel configuration handling
- **mail:** Improve reduce method in MailChannel.php
- **mixins:** Update mixins for Str and Stringable classes
- **pipes:** Add LimitLengthPipe to CollectorManager
- **service provider:** remove DeferrableProvider interface implementation
- **service provider:** improve extendExceptionHandler method
- **serviceprovider:** comment out unnecessary mixin calls
- **src:** Update static variable references to use self
- **test:** Improve env_explode test case
- **testcommand:** refactor TestCommand handle method
- **tests:** refactor ExceptionNotifyManagerTest.php and Support/HeplersTest.php

### Test
- Update tests and refactor code
- Remove useless files, change exception class names, adjust configuration settings, and refactor notification methods.
- **Channels:** Update mail channel configuration
- **Channels:** add tests for mail and notify channels
- **Commands:** update TestCommandTest.php and PipeTest.php
- **MailChannelTest:** Add test case for sending report email
- **MailChannelTest:** add throws method in test
- **ReportExceptionMailTest:** add test for building self
- **skip:** skip test that throws InvalidArgumentException

### Pull Requests
- Merge pull request [#65](https://github.com/guanguans/laravel-exception-notify/issues/65) from guanguans/imgbot
- Merge pull request [#64](https://github.com/guanguans/laravel-exception-notify/issues/64) from guanguans/imgbot
- Merge pull request [#63](https://github.com/guanguans/laravel-exception-notify/issues/63) from guanguans/imgbot
- Merge pull request [#62](https://github.com/guanguans/laravel-exception-notify/issues/62) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.1.0


<a name="3.8.4"></a>
## [3.8.4] - 2024-05-13

<a name="4.4.2"></a>
## [4.4.2] - 2024-05-13

<a name="4.4.1"></a>
## [4.4.1] - 2024-05-12
### Fix
- **command:** Fix condition check for driver in TestCommand.php

### Refactor
- **collectors:** remove unnecessary properties from ExceptionBasicCollector
- **pipes:** Add LimitLengthPipe to CollectorManager


<a name="4.4.0"></a>
## [4.4.0] - 2024-05-11
### Refactor
- Replace ExceptionNotifyManager with ExceptionNotify facade
- **FuncCallToStaticCall:** refactor static calls to function calls
- **StaticCallToFuncCall:** refactor Str::of to str
- **composer:** remove guanguans/ai-commit dependency
- **config:** update exception-notify extender function

### Test
- **Channels:** Update mail channel configuration

### Pull Requests
- Merge pull request [#65](https://github.com/guanguans/laravel-exception-notify/issues/65) from guanguans/imgbot


<a name="4.3.3"></a>
## [4.3.3] - 2024-05-10
### Docs
- **mail:** Update mail.jpg

### Refactor
- **command:** update TestCommand signature and handle method
- **config:** remove unnecessary code in exception-notify configuration
- **test:** Improve env_explode test case
- **testcommand:** refactor TestCommand handle method


<a name="4.3.2"></a>
## [4.3.2] - 2024-05-09
### Refactor
- **commands:** improve readability of TestCommand.php

### Pull Requests
- Merge pull request [#64](https://github.com/guanguans/laravel-exception-notify/issues/64) from guanguans/imgbot
- Merge pull request [#63](https://github.com/guanguans/laravel-exception-notify/issues/63) from guanguans/imgbot


<a name="4.3.1"></a>
## [4.3.1] - 2024-05-09
### Refactor
- **DefaultNotifyClientExtender:** Improve channel parameter handling
- **config:** update exception-notify configuration


<a name="4.3.0"></a>
## [4.3.0] - 2024-05-09
### Docs
- **readme:** Update README.md with more descriptive content

### Feat
- **ExceptionNotify:** Add skipWhen method
- **ExceptionNotifyManager:** Add skipWhen method

### Refactor
- **app:** Modify boot method in AppServiceProvider.php
- **collector:** update rejected headers list
- **config:** remove 'report_using_creator' from exception-notify.php
- **service provider:** improve extendExceptionHandler method
- **src:** Update static variable references to use self
- **tests:** refactor ExceptionNotifyManagerTest.php and Support/HeplersTest.php


<a name="4.2.0"></a>
## [4.2.0] - 2024-05-08
### Refactor
- **Channel:** refactor string replacement method
- **Naming:** improve name generation logic
- **collect:** Improve RequestHeaderCollector to handle header array
- **config:** update exception-notify.php configuration
- **config:** update notify client extenders
- **mail:** Improve reduce method in MailChannel.php
- **mixins:** Update mixins for Str and Stringable classes
- **service provider:** remove DeferrableProvider interface implementation
- **serviceprovider:** comment out unnecessary mixin calls

### Test
- Update tests and refactor code
- **Channels:** add tests for mail and notify channels
- **Commands:** update TestCommandTest.php and PipeTest.php
- **MailChannelTest:** Add test case for sending report email
- **ReportExceptionMailTest:** add test for building self


<a name="4.1.0"></a>
## [4.1.0] - 2024-05-07
### Feat
- **collectors:** Add time field to ApplicationCollector
- **laravel:** Add Laravel 8.0 set list and related rules

### Refactor
- change visibility of Request properties to private
- **Channels:** Improve readability of MailChannel and NotifyChannel
- **MailChannel:** simplify createMail method
- **config:** remove FixPrettyJsonPipe from exception-notify.php
- **config:** Remove unnecessary comment lines
- **config:** update client extender references
- **mail:** Improve method call in MailChannel
- **mail:** rename ExceptionReportMail to ReportExceptionMail
- **mail:** Improve mail channel configuration and method handling
- **mail:** Improve mail channel configuration handling


<a name="4.0.0"></a>
## [4.0.0] - 2024-05-06
### Docs
- **README:** update supported notification channels in English README

### Feat
- **config:** Add new notification channels

### Refactor
- **collector:** Improve exception trace collection


<a name="4.0.0-beta3"></a>
## [4.0.0-beta3] - 2024-05-06
### Docs
- **readme:** update supported notification channels

### Refactor
- **config:** update Lark configuration and rename client tapper

### Test
- **MailChannelTest:** add throws method in test

### Pull Requests
- Merge pull request [#62](https://github.com/guanguans/laravel-exception-notify/issues/62) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.1.0


<a name="4.0.0-beta2"></a>
## [4.0.0-beta2] - 2024-04-23
### Fix
- Optimized the email sending logic and added pipeline handling in the exception notification feature

### Test
- Remove useless files, change exception class names, adjust configuration settings, and refactor notification methods.


<a name="4.0.0-beta1"></a>
## [4.0.0-beta1] - 2024-04-23
### Docs
- **README:** Add caution for 4.x version

### Feat
- **Channel:** add Channel base class and extend other channel classes
- **ToInternalExceptionRector:** Add ToInternalExceptionRector for internal exceptions
- **composer-require-checker:** Add configuration file for composer-require-checker
- **config:** add aggregate channel configuration
- **config:** add mail configuration
- **config:** Add WithLogMiddlewareClientTapper class for exception-notify config

### Refactor
- Fix exception handling and enhance type safety
- Fix exception handling and enhance type safety
- update contract names in classes
- modify ExceptionNotifyManager to use configRepository
- **ExceptionNotifyManager:** Improve createDriver method
- **NotifyChannel:** Refactor NotifyChannel class for better readability and maintainability
- **collector:** remove unused code and fix access level of method
- **config:** refactor RectorConfig
- **exception-notify:** update lark configuration
- **log:** Simplify LogChannel constructor and report method
- **mail:** update mail classes names

### Test
- **skip:** skip test that throws InvalidArgumentException


<a name="3.8.3"></a>
## [3.8.3] - 2024-04-18
### Refactor
- Removed `str` function and related code from helpers.php.


<a name="3.8.2"></a>
## [3.8.2] - 2024-04-01
### Refactor
- **CollectionMacro:** Remove unnecessary method and comments
- **macro:** Remove lcfirst method from StrMacro and StringableMacro classes


<a name="3.8.1"></a>
## [3.8.1] - 2024-03-31
### Refactor
- **ReportUsingCreator:** optimize error reporting logic


<a name="3.8.0"></a>
## [3.8.0] - 2024-03-31
### Docs
- **readme:** Remove unnecessary Chinese translation and code snippets

### Refactor
- **src:** Improve extendExceptionHandler method in ExceptionNotifyServiceProvider


<a name="3.7.0"></a>
## [3.7.0] - 2024-03-31
### Refactor
- **composer:** Remove unnecessary packages and update dependencies


<a name="3.6.1"></a>
## [3.6.1] - 2024-03-31
### Pull Requests
- Merge pull request [#61](https://github.com/guanguans/laravel-exception-notify/issues/61) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.0.0
- Merge pull request [#60](https://github.com/guanguans/laravel-exception-notify/issues/60) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-1.7.0


<a name="3.6.0"></a>
## [3.6.0] - 2024-03-13
### Feat
- **composer-updater:** add dry-run option

### Refactor
- **composer-updater:** Improve diff formatting

### Pull Requests
- Merge pull request [#57](https://github.com/guanguans/laravel-exception-notify/issues/57) from guanguans/dependabot/composer/rector/rector-tw-0.19or-tw-1.0


<a name="3.5.3"></a>
## [3.5.3] - 2024-02-01
### Refactor
- **composer-fixer:** Update composer-fixer script
- **composer-updater:** Improve handling of multiple and single version dependencies

### Pull Requests
- Merge pull request [#56](https://github.com/guanguans/laravel-exception-notify/issues/56) from guanguans/dependabot/github_actions/actions/cache-4


<a name="3.5.2"></a>
## [3.5.2] - 2024-01-11
### Refactor
- **collectors:** improve exception handling


<a name="3.5.1"></a>
## [3.5.1] - 2024-01-09
### Refactor
- **coding-style:** Remove unused Rectors
- **monorepo-builder:** update release workers

### Pull Requests
- Merge pull request [#54](https://github.com/guanguans/laravel-exception-notify/issues/54) from guanguans/dependabot/github_actions/actions/stale-9
- Merge pull request [#53](https://github.com/guanguans/laravel-exception-notify/issues/53) from guanguans/dependabot/github_actions/actions/labeler-5


<a name="3.5.0"></a>
## [3.5.0] - 2023-10-18
### Feat
- **config:** Add php_unit_data_provider_name and php_unit_data_provider_return_type in .php-cs-fixer.php

### Refactor
- **pipes:** rename ToMarkdownPipe to SprintfMarkdownPipe
- **pipes:** rename ToHtmlPipe to SprintfHtmlPipe

### Pull Requests
- Merge pull request [#51](https://github.com/guanguans/laravel-exception-notify/issues/51) from guanguans/dependabot/github_actions/stefanzweifel/git-auto-commit-action-5
- Merge pull request [#49](https://github.com/guanguans/laravel-exception-notify/issues/49) from guanguans/dependabot/github_actions/actions/checkout-4


<a name="3.4.2"></a>
## [3.4.2] - 2023-08-29
### Feat
- **facade:** Add facade.php file

### Fix
- **facades:** Return string in getDefaultDriver method

### Refactor
- **StringableMacro:** Remove unused squish and toString methods
- **bin:** remove unused code in facades.php


<a name="3.4.1"></a>
## [3.4.1] - 2023-08-20
### Fix
- **src:** fix reportUsingCreator callable

### Test
- **Channels:** update BarkChannel


<a name="3.4.0"></a>
## [3.4.0] - 2023-08-20
### Feat
- **ReportUsingCreator:** add class

### Refactor
- add return type declaration to getDefaultDriver method

### Test
- **TestCase:** Update setUp and tearDown methods

### Pull Requests
- Merge pull request [#47](https://github.com/guanguans/laravel-exception-notify/issues/47) from guanguans/dependabot/composer/rector/rector-tw-0.17or-tw-0.18


<a name="3.3.2"></a>
## [3.3.2] - 2023-08-17
### Refactor
- **AddChorePipe:** optimize handle method
- **pipes:** update FixPrettyJsonPipe

### Test
- **tests:** Add MockeryPHPUnitIntegration trait


<a name="3.3.1"></a>
## [3.3.1] - 2023-08-14
### Refactor
- update TestCommand handle method


<a name="3.3.0"></a>
## [3.3.0] - 2023-08-14
### Docs
- **psalm:** Update psalm-baseline.xml

### Feat
- **collectors:** add Naming trait
- **collectors:** Add ExceptionCollector class

### Fix
- **ReportExceptionJob:** Change ExceptionNotify facade to ExceptionNotifyManager

### Refactor
- **collectors:** improve PhpInfoCollector
- **service-provider:** Reorder service providers
- **src:** Update ExceptionNotifyManager.php


<a name="3.2.3"></a>
## [3.2.3] - 2023-08-13

<a name="3.2.2"></a>
## [3.2.2] - 2023-08-13
### Docs
- **ExceptionNotify:** Add shouldReport method

### Fix
- **serviceprovider:** fix class name replacement

### Refactor
- **command:** Change error variable to warning in TestCommand
- **serviceprovider:** Refactor alias method

### Test
- **CollectorTest:** update test for collecting request basic


<a name="3.2.1"></a>
## [3.2.1] - 2023-08-13
### Docs
- **README:** Update README file
- **readme:** Fix typo

### Feat
- **TestCommandTest.php:** Add test for exception-notify
- **helper:** Add human_bytes function
- **helpers:** add precision parameter to human_milliseconds function
- **helpers:** Add human_milliseconds function
- **support:** add array_is_list helper function

### Refactor
- **config:** Update .php-cs-fixer.php
- **support:** update helpers.php

### Test
- **ExceptionNotifyManagerTest:** refactor test cases


<a name="3.2.0"></a>
## [3.2.0] - 2023-08-12
### Docs
- **readme:** Update README.md

### Feat
- **commands:** Add TestCommand

### Fix
- **composer:** Remove --clear-cache option from rector command

### Refactor
- **serviceprovider:** reorganize register method


<a name="3.1.4"></a>
## [3.1.4] - 2023-08-11
### Fix
- **collectors:** Fix typo in ExceptionBasicCollector.php
- **job:** Handle exceptions in job

### Refactor
- **src:** remove unnecessary code

### Test
- **ExceptionNotifyManagerTest:** Add test for reporting exceptions
- **Support:** update JsonFixer test


<a name="3.1.3"></a>
## [3.1.3] - 2023-08-10
### Feat
- **ReportExceptionJob:** Add retry functionality

### Fix
- **Jobs:** Fix ReportExceptionJob timeout and retryAfter values


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
- Merge pull request [#44](https://github.com/guanguans/laravel-exception-notify/issues/44) from guanguans/imgbot


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
- Merge pull request [#42](https://github.com/guanguans/laravel-exception-notify/issues/42) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-1.6.0
- Merge pull request [#41](https://github.com/guanguans/laravel-exception-notify/issues/41) from guanguans/dependabot/composer/dms/phpunit-arraysubset-asserts-tw-0.4.0or-tw-0.5.0


<a name="v2.16.0"></a>
## [v2.16.0] - 2023-06-07
### Pull Requests
- Merge pull request [#40](https://github.com/guanguans/laravel-exception-notify/issues/40) from guanguans/dependabot/composer/rector/rector-tw-0.15.7or-tw-0.17.0
- Merge pull request [#35](https://github.com/guanguans/laravel-exception-notify/issues/35) from guanguans/dependabot/github_actions/actions/stale-8
- Merge pull request [#39](https://github.com/guanguans/laravel-exception-notify/issues/39) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-1.5.1
- Merge pull request [#38](https://github.com/guanguans/laravel-exception-notify/issues/38) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-1.5.0
- Merge pull request [#36](https://github.com/guanguans/laravel-exception-notify/issues/36) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-1.4.0


<a name="v2.15.0"></a>
## [v2.15.0] - 2023-03-20
### Pull Requests
- Merge pull request [#30](https://github.com/guanguans/laravel-exception-notify/issues/30) from guanguans/dependabot/composer/nunomaduro/larastan-tw-1.0or-tw-2.0
- Merge pull request [#31](https://github.com/guanguans/laravel-exception-notify/issues/31) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-1.3.6


<a name="v2.14.4"></a>
## [v2.14.4] - 2023-01-19

<a name="v2.14.3"></a>
## [v2.14.3] - 2023-01-18
### Pull Requests
- Merge pull request [#27](https://github.com/guanguans/laravel-exception-notify/issues/27) from guanguans/dependabot/composer/rector/rector-tw-0.14.8or-tw-0.15.0


<a name="v2.14.2"></a>
## [v2.14.2] - 2022-11-29

<a name="v2.14.1"></a>
## [v2.14.1] - 2022-11-29
### Pull Requests
- Merge pull request [#26](https://github.com/guanguans/laravel-exception-notify/issues/26) from guanguans/imgbot


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
- Merge pull request [#21](https://github.com/guanguans/laravel-exception-notify/issues/21) from guanguans/dependabot/github_actions/codecov/codecov-action-3


<a name="v2.7.1"></a>
## [v2.7.1] - 2022-03-30
### Pull Requests
- Merge pull request [#20](https://github.com/guanguans/laravel-exception-notify/issues/20) from guanguans/issue-19-Job错误


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
- Merge pull request [#18](https://github.com/guanguans/laravel-exception-notify/issues/18) from guanguans/dependabot/github_actions/actions/cache-3


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
- Merge pull request [#17](https://github.com/guanguans/laravel-exception-notify/issues/17) from guanguans/imgbot
- Merge pull request [#16](https://github.com/guanguans/laravel-exception-notify/issues/16) from guanguans/imgbot
- Merge pull request [#15](https://github.com/guanguans/laravel-exception-notify/issues/15) from guanguans/dependabot/github_actions/actions/checkout-3


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
- Merge pull request [#13](https://github.com/guanguans/laravel-exception-notify/issues/13) from guanguans/imgbot


<a name="v1.1.8"></a>
## [v1.1.8] - 2021-11-06

<a name="v1.1.7"></a>
## [v1.1.7] - 2021-11-05

<a name="v1.1.6"></a>
## [v1.1.6] - 2021-11-03

<a name="v1.1.5"></a>
## [v1.1.5] - 2021-10-16
### Pull Requests
- Merge pull request [#11](https://github.com/guanguans/laravel-exception-notify/issues/11) from JimChenWYU/main


<a name="v1.1.4"></a>
## [v1.1.4] - 2021-10-10

<a name="v1.1.3"></a>
## [v1.1.3] - 2021-10-09
### Pull Requests
- Merge pull request [#10](https://github.com/guanguans/laravel-exception-notify/issues/10) from PrintNow/main


<a name="v1.1.2"></a>
## [v1.1.2] - 2021-10-08
### Pull Requests
- Merge pull request [#7](https://github.com/guanguans/laravel-exception-notify/issues/7) from guanguans/dependabot/composer/friendsofphp/php-cs-fixer-tw-2.16or-tw-3.0


<a name="v1.1.1"></a>
## [v1.1.1] - 2021-09-30

<a name="v1.1.0"></a>
## [v1.1.0] - 2021-09-29
### Pull Requests
- Merge pull request [#6](https://github.com/guanguans/laravel-exception-notify/issues/6) from guanguans/dependabot/composer/vimeo/psalm-tw-3.11or-tw-4.0
- Merge pull request [#5](https://github.com/guanguans/laravel-exception-notify/issues/5) from guanguans/dependabot/composer/overtrue/phplint-tw-2.3or-tw-3.0
- Merge pull request [#4](https://github.com/guanguans/laravel-exception-notify/issues/4) from guanguans/dependabot/github_actions/codecov/codecov-action-2.1.0


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
- Merge pull request [#2](https://github.com/guanguans/laravel-exception-notify/issues/2) from guanguans/imgbot


<a name="v1.0.1"></a>
## [v1.0.1] - 2021-07-04

<a name="v1.0.0"></a>
## v1.0.0 - 2021-07-04
### Pull Requests
- Merge pull request [#1](https://github.com/guanguans/laravel-exception-notify/issues/1) from guanguans/imgbot


[Unreleased]: https://github.com/guanguans/laravel-exception-notify/compare/5.0.0-beta1...HEAD
[5.0.0-beta1]: https://github.com/guanguans/laravel-exception-notify/compare/4.7.0...5.0.0-beta1
[4.7.0]: https://github.com/guanguans/laravel-exception-notify/compare/4.6.0...4.7.0
[4.6.0]: https://github.com/guanguans/laravel-exception-notify/compare/4.5.1...4.6.0
[4.5.1]: https://github.com/guanguans/laravel-exception-notify/compare/4.5.0...4.5.1
[4.5.0]: https://github.com/guanguans/laravel-exception-notify/compare/3.8.4...4.5.0
[3.8.4]: https://github.com/guanguans/laravel-exception-notify/compare/4.4.2...3.8.4
[4.4.2]: https://github.com/guanguans/laravel-exception-notify/compare/4.4.1...4.4.2
[4.4.1]: https://github.com/guanguans/laravel-exception-notify/compare/4.4.0...4.4.1
[4.4.0]: https://github.com/guanguans/laravel-exception-notify/compare/4.3.3...4.4.0
[4.3.3]: https://github.com/guanguans/laravel-exception-notify/compare/4.3.2...4.3.3
[4.3.2]: https://github.com/guanguans/laravel-exception-notify/compare/4.3.1...4.3.2
[4.3.1]: https://github.com/guanguans/laravel-exception-notify/compare/4.3.0...4.3.1
[4.3.0]: https://github.com/guanguans/laravel-exception-notify/compare/4.2.0...4.3.0
[4.2.0]: https://github.com/guanguans/laravel-exception-notify/compare/4.1.0...4.2.0
[4.1.0]: https://github.com/guanguans/laravel-exception-notify/compare/4.0.0...4.1.0
[4.0.0]: https://github.com/guanguans/laravel-exception-notify/compare/4.0.0-beta3...4.0.0
[4.0.0-beta3]: https://github.com/guanguans/laravel-exception-notify/compare/4.0.0-beta2...4.0.0-beta3
[4.0.0-beta2]: https://github.com/guanguans/laravel-exception-notify/compare/4.0.0-beta1...4.0.0-beta2
[4.0.0-beta1]: https://github.com/guanguans/laravel-exception-notify/compare/3.8.3...4.0.0-beta1
[3.8.3]: https://github.com/guanguans/laravel-exception-notify/compare/3.8.2...3.8.3
[3.8.2]: https://github.com/guanguans/laravel-exception-notify/compare/3.8.1...3.8.2
[3.8.1]: https://github.com/guanguans/laravel-exception-notify/compare/3.8.0...3.8.1
[3.8.0]: https://github.com/guanguans/laravel-exception-notify/compare/3.7.0...3.8.0
[3.7.0]: https://github.com/guanguans/laravel-exception-notify/compare/3.6.1...3.7.0
[3.6.1]: https://github.com/guanguans/laravel-exception-notify/compare/3.6.0...3.6.1
[3.6.0]: https://github.com/guanguans/laravel-exception-notify/compare/3.5.3...3.6.0
[3.5.3]: https://github.com/guanguans/laravel-exception-notify/compare/3.5.2...3.5.3
[3.5.2]: https://github.com/guanguans/laravel-exception-notify/compare/3.5.1...3.5.2
[3.5.1]: https://github.com/guanguans/laravel-exception-notify/compare/3.5.0...3.5.1
[3.5.0]: https://github.com/guanguans/laravel-exception-notify/compare/3.4.2...3.5.0
[3.4.2]: https://github.com/guanguans/laravel-exception-notify/compare/3.4.1...3.4.2
[3.4.1]: https://github.com/guanguans/laravel-exception-notify/compare/3.4.0...3.4.1
[3.4.0]: https://github.com/guanguans/laravel-exception-notify/compare/3.3.2...3.4.0
[3.3.2]: https://github.com/guanguans/laravel-exception-notify/compare/3.3.1...3.3.2
[3.3.1]: https://github.com/guanguans/laravel-exception-notify/compare/3.3.0...3.3.1
[3.3.0]: https://github.com/guanguans/laravel-exception-notify/compare/3.2.3...3.3.0
[3.2.3]: https://github.com/guanguans/laravel-exception-notify/compare/3.2.2...3.2.3
[3.2.2]: https://github.com/guanguans/laravel-exception-notify/compare/3.2.1...3.2.2
[3.2.1]: https://github.com/guanguans/laravel-exception-notify/compare/3.2.0...3.2.1
[3.2.0]: https://github.com/guanguans/laravel-exception-notify/compare/3.1.4...3.2.0
[3.1.4]: https://github.com/guanguans/laravel-exception-notify/compare/3.1.3...3.1.4
[3.1.3]: https://github.com/guanguans/laravel-exception-notify/compare/3.1.2...3.1.3
[3.1.2]: https://github.com/guanguans/laravel-exception-notify/compare/3.1.1...3.1.2
[3.1.1]: https://github.com/guanguans/laravel-exception-notify/compare/3.1.0...3.1.1
[3.1.0]: https://github.com/guanguans/laravel-exception-notify/compare/3.0.2...3.1.0
[3.0.2]: https://github.com/guanguans/laravel-exception-notify/compare/3.0.1...3.0.2
[3.0.1]: https://github.com/guanguans/laravel-exception-notify/compare/3.0.0...3.0.1
[3.0.0]: https://github.com/guanguans/laravel-exception-notify/compare/3.0.0-rc2...3.0.0
[3.0.0-rc2]: https://github.com/guanguans/laravel-exception-notify/compare/3.0.0-rc1...3.0.0-rc2
[3.0.0-rc1]: https://github.com/guanguans/laravel-exception-notify/compare/3.0.0-beta1...3.0.0-rc1
[3.0.0-beta1]: https://github.com/guanguans/laravel-exception-notify/compare/v2.16.0...3.0.0-beta1
[v2.16.0]: https://github.com/guanguans/laravel-exception-notify/compare/v2.15.0...v2.16.0
[v2.15.0]: https://github.com/guanguans/laravel-exception-notify/compare/v2.14.4...v2.15.0
[v2.14.4]: https://github.com/guanguans/laravel-exception-notify/compare/v2.14.3...v2.14.4
[v2.14.3]: https://github.com/guanguans/laravel-exception-notify/compare/v2.14.2...v2.14.3
[v2.14.2]: https://github.com/guanguans/laravel-exception-notify/compare/v2.14.1...v2.14.2
[v2.14.1]: https://github.com/guanguans/laravel-exception-notify/compare/v2.14.0...v2.14.1
[v2.14.0]: https://github.com/guanguans/laravel-exception-notify/compare/v2.13.0...v2.14.0
[v2.13.0]: https://github.com/guanguans/laravel-exception-notify/compare/v2.12.0...v2.13.0
[v2.12.0]: https://github.com/guanguans/laravel-exception-notify/compare/v2.11.5...v2.12.0
[v2.11.5]: https://github.com/guanguans/laravel-exception-notify/compare/v2.11.4...v2.11.5
[v2.11.4]: https://github.com/guanguans/laravel-exception-notify/compare/v2.11.3...v2.11.4
[v2.11.3]: https://github.com/guanguans/laravel-exception-notify/compare/v2.11.2...v2.11.3
[v2.11.2]: https://github.com/guanguans/laravel-exception-notify/compare/v2.11.1...v2.11.2
[v2.11.1]: https://github.com/guanguans/laravel-exception-notify/compare/v2.11.0...v2.11.1
[v2.11.0]: https://github.com/guanguans/laravel-exception-notify/compare/v2.10.0...v2.11.0
[v2.10.0]: https://github.com/guanguans/laravel-exception-notify/compare/v2.9.0...v2.10.0
[v2.9.0]: https://github.com/guanguans/laravel-exception-notify/compare/v2.8.0...v2.9.0
[v2.8.0]: https://github.com/guanguans/laravel-exception-notify/compare/v2.7.1...v2.8.0
[v2.7.1]: https://github.com/guanguans/laravel-exception-notify/compare/v2.7.0...v2.7.1
[v2.7.0]: https://github.com/guanguans/laravel-exception-notify/compare/v2.6.3...v2.7.0
[v2.6.3]: https://github.com/guanguans/laravel-exception-notify/compare/v2.6.2...v2.6.3
[v2.6.2]: https://github.com/guanguans/laravel-exception-notify/compare/v2.6.1...v2.6.2
[v2.6.1]: https://github.com/guanguans/laravel-exception-notify/compare/v2.6.0...v2.6.1
[v2.6.0]: https://github.com/guanguans/laravel-exception-notify/compare/v2.5.1...v2.6.0
[v2.5.1]: https://github.com/guanguans/laravel-exception-notify/compare/v2.5.0...v2.5.1
[v2.5.0]: https://github.com/guanguans/laravel-exception-notify/compare/v2.4.0...v2.5.0
[v2.4.0]: https://github.com/guanguans/laravel-exception-notify/compare/v2.3.0...v2.4.0
[v2.3.0]: https://github.com/guanguans/laravel-exception-notify/compare/v2.2.0...v2.3.0
[v2.2.0]: https://github.com/guanguans/laravel-exception-notify/compare/v2.1.3...v2.2.0
[v2.1.3]: https://github.com/guanguans/laravel-exception-notify/compare/v2.1.2...v2.1.3
[v2.1.2]: https://github.com/guanguans/laravel-exception-notify/compare/v2.1.1...v2.1.2
[v2.1.1]: https://github.com/guanguans/laravel-exception-notify/compare/v2.1.0...v2.1.1
[v2.1.0]: https://github.com/guanguans/laravel-exception-notify/compare/v2.0.8...v2.1.0
[v2.0.8]: https://github.com/guanguans/laravel-exception-notify/compare/v2.0.7...v2.0.8
[v2.0.7]: https://github.com/guanguans/laravel-exception-notify/compare/v2.0.6...v2.0.7
[v2.0.6]: https://github.com/guanguans/laravel-exception-notify/compare/v2.0.5...v2.0.6
[v2.0.5]: https://github.com/guanguans/laravel-exception-notify/compare/v2.0.4...v2.0.5
[v2.0.4]: https://github.com/guanguans/laravel-exception-notify/compare/v2.0.3...v2.0.4
[v2.0.3]: https://github.com/guanguans/laravel-exception-notify/compare/v2.0.2...v2.0.3
[v2.0.2]: https://github.com/guanguans/laravel-exception-notify/compare/v2.0.1...v2.0.2
[v2.0.1]: https://github.com/guanguans/laravel-exception-notify/compare/v2.0.0...v2.0.1
[v2.0.0]: https://github.com/guanguans/laravel-exception-notify/compare/v1.2.3...v2.0.0
[v1.2.3]: https://github.com/guanguans/laravel-exception-notify/compare/v1.2.2...v1.2.3
[v1.2.2]: https://github.com/guanguans/laravel-exception-notify/compare/v1.2.1...v1.2.2
[v1.2.1]: https://github.com/guanguans/laravel-exception-notify/compare/v1.2.0...v1.2.1
[v1.2.0]: https://github.com/guanguans/laravel-exception-notify/compare/v1.1.12...v1.2.0
[v1.1.12]: https://github.com/guanguans/laravel-exception-notify/compare/v1.1.11...v1.1.12
[v1.1.11]: https://github.com/guanguans/laravel-exception-notify/compare/v1.1.10...v1.1.11
[v1.1.10]: https://github.com/guanguans/laravel-exception-notify/compare/v1.1.9...v1.1.10
[v1.1.9]: https://github.com/guanguans/laravel-exception-notify/compare/v1.1.8...v1.1.9
[v1.1.8]: https://github.com/guanguans/laravel-exception-notify/compare/v1.1.7...v1.1.8
[v1.1.7]: https://github.com/guanguans/laravel-exception-notify/compare/v1.1.6...v1.1.7
[v1.1.6]: https://github.com/guanguans/laravel-exception-notify/compare/v1.1.5...v1.1.6
[v1.1.5]: https://github.com/guanguans/laravel-exception-notify/compare/v1.1.4...v1.1.5
[v1.1.4]: https://github.com/guanguans/laravel-exception-notify/compare/v1.1.3...v1.1.4
[v1.1.3]: https://github.com/guanguans/laravel-exception-notify/compare/v1.1.2...v1.1.3
[v1.1.2]: https://github.com/guanguans/laravel-exception-notify/compare/v1.1.1...v1.1.2
[v1.1.1]: https://github.com/guanguans/laravel-exception-notify/compare/v1.1.0...v1.1.1
[v1.1.0]: https://github.com/guanguans/laravel-exception-notify/compare/v1.0.7...v1.1.0
[v1.0.7]: https://github.com/guanguans/laravel-exception-notify/compare/v1.0.6...v1.0.7
[v1.0.6]: https://github.com/guanguans/laravel-exception-notify/compare/v1.0.5...v1.0.6
[v1.0.5]: https://github.com/guanguans/laravel-exception-notify/compare/v1.0.4...v1.0.5
[v1.0.4]: https://github.com/guanguans/laravel-exception-notify/compare/v1.0.3...v1.0.4
[v1.0.3]: https://github.com/guanguans/laravel-exception-notify/compare/v1.0.2...v1.0.3
[v1.0.2]: https://github.com/guanguans/laravel-exception-notify/compare/v1.0.1...v1.0.2
[v1.0.1]: https://github.com/guanguans/laravel-exception-notify/compare/v1.0.0...v1.0.1
