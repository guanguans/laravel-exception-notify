<!--- BEGIN HEADER -->
# Changelog

All notable changes to this project will be documented in this file.
<!--- END HEADER -->

<a name="unreleased"></a>
## [Unreleased]


<a name="5.2.0"></a>
## [5.2.0] - 2025-05-11
### 🐞 Bug Fixes
- **commands:** improve exception notification warning details ([b5677f4](https://github.com/guanguans/laravel-exception-notify/commit/b5677f4))
- **exception-trace-collector:** enhance trace filtering and transformation logic ([3f5edfd](https://github.com/guanguans/laravel-exception-notify/commit/3f5edfd))

### 💅 Code Refactorings
- **configureable:** rename 'config' option to 'configuration' ([6dba024](https://github.com/guanguans/laravel-exception-notify/commit/6dba024))

### 📦 Builds
- **deps:** Update composer dependencies and scripts ([a9bb300](https://github.com/guanguans/laravel-exception-notify/commit/a9bb300))

### 🤖 Continuous Integrations
- **config:** add configuration files and update existing ones ([4b1552e](https://github.com/guanguans/laravel-exception-notify/commit/4b1552e))


<a name="5.1.11"></a>
## [5.1.11] - 2025-03-26
### 🐞 Bug Fixes
- **dependencies:** Update guanguans/notify version to ^3.2 ([df8b0d6](https://github.com/guanguans/laravel-exception-notify/commit/df8b0d6))


<a name="5.1.10"></a>
## [5.1.10] - 2025-03-24
### 📖 Documents
- **README:** Update section titles for clarity ([0b508ff](https://github.com/guanguans/laravel-exception-notify/commit/0b508ff))
- **config:** Add missing doc references in exception-notify.php ([e2f591b](https://github.com/guanguans/laravel-exception-notify/commit/e2f591b))

### Pull Requests
- Merge pull request [#73](https://github.com/guanguans/laravel-exception-notify/issues/73) from guanguans/imgbot


<a name="5.1.9"></a>
## [5.1.9] - 2025-03-24
### 🐞 Bug Fixes
- **TestCommand:** Add warning for non-sync queue connection ([a32e1c3](https://github.com/guanguans/laravel-exception-notify/commit/a32e1c3))
- **command:** Correct queue connection configuration ([8fdfdfd](https://github.com/guanguans/laravel-exception-notify/commit/8fdfdfd))

### 📖 Documents
- **readme:** Update exception notify test commands ([42b04a0](https://github.com/guanguans/laravel-exception-notify/commit/42b04a0))
- **readme:** Update exception notify test commands ([262dd06](https://github.com/guanguans/laravel-exception-notify/commit/262dd06))

### 💅 Code Refactorings
- **channels:** Simplify sync queue connection check ([336b1be](https://github.com/guanguans/laravel-exception-notify/commit/336b1be))
- **commands:** Rename queue option to job connection ([ff5722c](https://github.com/guanguans/laravel-exception-notify/commit/ff5722c))
- **utils:** Move sync job connection logic to Utils class ([2300056](https://github.com/guanguans/laravel-exception-notify/commit/2300056))


<a name="5.1.8"></a>
## [5.1.8] - 2025-03-23
### 📖 Documents
- **README:** Update testing commands for exception notify ([ae48e4c](https://github.com/guanguans/laravel-exception-notify/commit/ae48e4c))

### 💅 Code Refactorings
- **commands:** Replace output with components in TestCommand ([5ab0a15](https://github.com/guanguans/laravel-exception-notify/commit/5ab0a15))


<a name="5.1.7"></a>
## [5.1.7] - 2025-03-23
### 🐞 Bug Fixes
- **ExceptionNotifyServiceProvider:** simplify command metadata retrieval ([425887d](https://github.com/guanguans/laravel-exception-notify/commit/425887d))


<a name="5.1.6"></a>
## [5.1.6] - 2025-03-23
### 🐞 Bug Fixes
- **Collector:** Improve file upload error handling ([4f12d9b](https://github.com/guanguans/laravel-exception-notify/commit/4f12d9b))

### 💅 Code Refactorings
- **ExceptionNotifyServiceProvider:** streamline version retrieval ([984d150](https://github.com/guanguans/laravel-exception-notify/commit/984d150))
- **collectors:** Standardize keys in collector arrays ([04eb873](https://github.com/guanguans/laravel-exception-notify/commit/04eb873))

### ✅ Tests
- **FeatureTest:** Add image upload tests with timezone and locale ([ab58bbe](https://github.com/guanguans/laravel-exception-notify/commit/ab58bbe))


<a name="5.1.5"></a>
## [5.1.5] - 2025-03-23
### 🐞 Bug Fixes
- **ExceptionNotifyServiceProvider:** Improve about command logic ([d7aea8b](https://github.com/guanguans/laravel-exception-notify/commit/d7aea8b))


<a name="5.1.4"></a>
## [5.1.4] - 2025-03-23
### 📖 Documents
- **readme:** Add alternative image tag for usage illustration ([2fde561](https://github.com/guanguans/laravel-exception-notify/commit/2fde561))

### 💅 Code Refactorings
- **collectors:** Remove redundant memory usage calculation ([d61d03e](https://github.com/guanguans/laravel-exception-notify/commit/d61d03e))


<a name="5.1.3"></a>
## [5.1.3] - 2025-03-23
### ✨ Features
- **Utils:** Enhance configuration application logic ([b701f2e](https://github.com/guanguans/laravel-exception-notify/commit/b701f2e))

### 🐞 Bug Fixes
- **Utils:** Improve method callable check for parameter handling ([10403ca](https://github.com/guanguans/laravel-exception-notify/commit/10403ca))


<a name="5.1.2"></a>
## [5.1.2] - 2025-03-23
### ✨ Features
- **rate-limiter:** Add RateLimiter implementation and contract ([70a284c](https://github.com/guanguans/laravel-exception-notify/commit/70a284c))

### 📖 Documents
- **readme:** Add collapsible section for notification examples ([fff4469](https://github.com/guanguans/laravel-exception-notify/commit/fff4469))

### 💅 Code Refactorings
- **Channel:** Simplify rate limiting logic and update docs ([8423270](https://github.com/guanguans/laravel-exception-notify/commit/8423270))
- **commands:** Simplify test command descriptions ([09b7226](https://github.com/guanguans/laravel-exception-notify/commit/09b7226))


<a name="5.1.1"></a>
## [5.1.1] - 2025-03-22
### ✨ Features
- **ExceptionNotify:** Add section to AboutCommand for package info ([cc44fdb](https://github.com/guanguans/laravel-exception-notify/commit/cc44fdb))

### 🐞 Bug Fixes
- **ExceptionNotifyServiceProvider:** Remove unused notFound baseline ([4c601e7](https://github.com/guanguans/laravel-exception-notify/commit/4c601e7))
- **SprintfMarkdownPipe:** Correct format string syntax ([7221897](https://github.com/guanguans/laravel-exception-notify/commit/7221897))

### 💅 Code Refactorings
- **collectors:** Replace function calls with Utils methods ([9e968d2](https://github.com/guanguans/laravel-exception-notify/commit/9e968d2))

### 🏎 Performance Improvements
- **ExceptionNotifyServiceProvider:** Optimize version retrieval ([59fb318](https://github.com/guanguans/laravel-exception-notify/commit/59fb318))

### ✅ Tests
- **MailChannel:** Refactor mail reporting tests ([3d7f98e](https://github.com/guanguans/laravel-exception-notify/commit/3d7f98e))


<a name="5.1.0"></a>
## [5.1.0] - 2025-03-21
### 🎨 Styles
- Refactor code for improved readability and simplicity ([2a93e60](https://github.com/guanguans/laravel-exception-notify/commit/2a93e60))

### 💅 Code Refactorings
- **Channel:** Improve error handling and structure ([db9e0e7](https://github.com/guanguans/laravel-exception-notify/commit/db9e0e7))
- **baselines:** Remove obsolete baseline error files ([c73196c](https://github.com/guanguans/laravel-exception-notify/commit/c73196c))
- **channels:** Replace method calls with Utils functions ([751a259](https://github.com/guanguans/laravel-exception-notify/commit/751a259))
- **collector:** Improve request header exclusion handling ([eb4bc8a](https://github.com/guanguans/laravel-exception-notify/commit/eb4bc8a))
- **collectors:** Remove PhpInfoCollector and update ApplicationCollector ([987ccf7](https://github.com/guanguans/laravel-exception-notify/commit/987ccf7))
- **collectors:** Improve exception trace filtering and naming ([3bc4d74](https://github.com/guanguans/laravel-exception-notify/commit/3bc4d74))

### ✅ Tests
- Add inspections for null pointer and void function usage ([1aab42a](https://github.com/guanguans/laravel-exception-notify/commit/1aab42a))


<a name="5.0.0"></a>
## [5.0.0] - 2025-03-20
### ✨ Features
- **TestCommand:** Refactor anonymous function to improve clarity ([1f8a3c1](https://github.com/guanguans/laravel-exception-notify/commit/1f8a3c1))

### 🐞 Bug Fixes
- **channels:** Ensure default connection is used in job dispatch ([892afb4](https://github.com/guanguans/laravel-exception-notify/commit/892afb4))
- **collector:** Remove unused URL from data collection ([c8fb03c](https://github.com/guanguans/laravel-exception-notify/commit/c8fb03c))

### 📖 Documents
- **README:** Update notification channels and descriptions ([6cade62](https://github.com/guanguans/laravel-exception-notify/commit/6cade62))

### 💅 Code Refactorings
- **channels:** Improve error handling and configuration usage ([acf9482](https://github.com/guanguans/laravel-exception-notify/commit/acf9482))
- **collectors:** Simplify collection methods and variable names ([6b24633](https://github.com/guanguans/laravel-exception-notify/commit/6b24633))
- **command:** Improve exception-notify test output ([4800ad4](https://github.com/guanguans/laravel-exception-notify/commit/4800ad4))
- **config:** Improve exception notify configuration comments ([b39b254](https://github.com/guanguans/laravel-exception-notify/commit/b39b254))
- **template:** Rename TemplateContract to Template ([789550e](https://github.com/guanguans/laravel-exception-notify/commit/789550e))

### ✅ Tests
- **collector:** Add php-mock-phpunit dependency for testing ([81a74c8](https://github.com/guanguans/laravel-exception-notify/commit/81a74c8))


<a name="5.0.0-rc1"></a>
## [5.0.0-rc1] - 2025-03-19
### 🐞 Bug Fixes
- **rectors:** Update exception handling and logging ([46717c7](https://github.com/guanguans/laravel-exception-notify/commit/46717c7))

### 💅 Code Refactorings
- **config:** Remove RequestServerCollector and update config ([cc40474](https://github.com/guanguans/laravel-exception-notify/commit/cc40474))
- **config:** Replace AbstractChannel templates with TemplateContract ([a999e64](https://github.com/guanguans/laravel-exception-notify/commit/a999e64))
- **tests:** Remove ReplaceStrPipe and update tests ([821edd9](https://github.com/guanguans/laravel-exception-notify/commit/821edd9))

### 🤖 Continuous Integrations
- **chglog:** Update configuration for commit message filters ([c66d5d5](https://github.com/guanguans/laravel-exception-notify/commit/c66d5d5))
- **gitattributes:** Update export-ignore rules for builds ([b1ea598](https://github.com/guanguans/laravel-exception-notify/commit/b1ea598))


<a name="5.0.0-beta2"></a>
## [5.0.0-beta2] - 2025-03-17
### 🐞 Bug Fixes
- **config:** Refactor message options in exception-notify config ([af95b3d](https://github.com/guanguans/laravel-exception-notify/commit/af95b3d))
- **config:** Update rate limit key prefix format ([0c73d37](https://github.com/guanguans/laravel-exception-notify/commit/0c73d37))
- **support:** Improve error handling with rescue function ([a7ba61f](https://github.com/guanguans/laravel-exception-notify/commit/a7ba61f))

### 💅 Code Refactorings
- **channel:** replace CHANNEL_CONFIGURATION_KEY with __channel ([45d8621](https://github.com/guanguans/laravel-exception-notify/commit/45d8621))
- **channels:** Improve method readability and type hints ([4adfffe](https://github.com/guanguans/laravel-exception-notify/commit/4adfffe))
- **collector:** Simplify naming and exception handling ([dd725be](https://github.com/guanguans/laravel-exception-notify/commit/dd725be))
- **commands:** Improve exception-notify command handling ([cebcc44](https://github.com/guanguans/laravel-exception-notify/commit/cebcc44))
- **config:** Rename rate_limit to rate_limiter ([a623200](https://github.com/guanguans/laravel-exception-notify/commit/a623200))
- **exception-notify:** Simplify exception reporting logic ([7eb7922](https://github.com/guanguans/laravel-exception-notify/commit/7eb7922))

### ✅ Tests
- **channels:** Add tests for exception reporting functionality ([e3d7769](https://github.com/guanguans/laravel-exception-notify/commit/e3d7769))

### 📦 Builds
- **dependencies:** Remove unused files and update version constraints ([ddb9cfb](https://github.com/guanguans/laravel-exception-notify/commit/ddb9cfb))


<a name="5.0.0-beta1"></a>
## [5.0.0-beta1] - 2025-03-10
### ✨ Features
- Refactor hydrate_pipe function to static call and update checks ([ded92a2](https://github.com/guanguans/laravel-exception-notify/commit/ded92a2))
- **channels:** Introduce AbstractChannel and Refactor Channels ([a5af975](https://github.com/guanguans/laravel-exception-notify/commit/a5af975))
- **channels:** Refactor report methods to improve exception handling ([4ec4d71](https://github.com/guanguans/laravel-exception-notify/commit/4ec4d71))
- **channels:** Add StackChannel for handling reports ([e110b9d](https://github.com/guanguans/laravel-exception-notify/commit/e110b9d))
- **commands:** Add Configureable trait for dynamic options ([795e533](https://github.com/guanguans/laravel-exception-notify/commit/795e533))
- **exception-notify:** Add conditional reporting to exception handler ([0f92ba7](https://github.com/guanguans/laravel-exception-notify/commit/0f92ba7))
- **naming:** Add Naming trait for dynamic channel names ([af33d83](https://github.com/guanguans/laravel-exception-notify/commit/af33d83))
- **tests:** Refactor namespace and classmap for tests ([553d8ef](https://github.com/guanguans/laravel-exception-notify/commit/553d8ef))
- **trait:** Enhance configuration handling with extender support ([5842508](https://github.com/guanguans/laravel-exception-notify/commit/5842508))
- **traits:** Add MakeStaticable, SetStateable, and WithPipeArgs ([047280c](https://github.com/guanguans/laravel-exception-notify/commit/047280c))
- **workflows:** Update Laravel and PHP dependencies configuration ([878977a](https://github.com/guanguans/laravel-exception-notify/commit/878977a))
- **workflows:** upgrade PHP version to 8.0 ([1c3446e](https://github.com/guanguans/laravel-exception-notify/commit/1c3446e))

### 🐞 Bug Fixes
- **Channel:** Pass throwable to job and collectors ([fee5117](https://github.com/guanguans/laravel-exception-notify/commit/fee5117))
- **abstract-channel:** Remove unset of pending dispatch job ([d64baa4](https://github.com/guanguans/laravel-exception-notify/commit/d64baa4))
- **config:** Add mail reporting support for exceptions ([3a437da](https://github.com/guanguans/laravel-exception-notify/commit/3a437da))
- **dependencies:** Remove Carbon from ignored packages ([33f6c32](https://github.com/guanguans/laravel-exception-notify/commit/33f6c32))
- **tests:** Add ExceptionNotifyManagerTest for exception fingerprints ([7a37663](https://github.com/guanguans/laravel-exception-notify/commit/7a37663))

### 💅 Code Refactorings
- Refactor function calls to use global scope ([01dcb1f](https://github.com/guanguans/laravel-exception-notify/commit/01dcb1f))
- Update types and improve PHP version compatibility ([a9099a4](https://github.com/guanguans/laravel-exception-notify/commit/a9099a4))
- Update type hinting to use mixed type for parameters ([92feb8f](https://github.com/guanguans/laravel-exception-notify/commit/92feb8f))
- Replace Str::of() with str() for consistency ([a7a3a01](https://github.com/guanguans/laravel-exception-notify/commit/a7a3a01))
- Improve code quality and consistency in rector.php ([c31cd83](https://github.com/guanguans/laravel-exception-notify/commit/c31cd83))
- Consolidate mail reporting and config application ([40f8593](https://github.com/guanguans/laravel-exception-notify/commit/40f8593))
- **Channel:** Improve exception reporting logic ([fe168cb](https://github.com/guanguans/laravel-exception-notify/commit/fe168cb))
- **Channel:** Rename configuration key for clarity ([b39bd96](https://github.com/guanguans/laravel-exception-notify/commit/b39bd96))
- **Channel:** Improve error handling using rescue function ([b8c12a8](https://github.com/guanguans/laravel-exception-notify/commit/b8c12a8))
- **Channel:** Remove rescue usage and optimize report methods ([c8bf646](https://github.com/guanguans/laravel-exception-notify/commit/c8bf646))
- **Channel:** Simplify event handling in report methods ([0a3225e](https://github.com/guanguans/laravel-exception-notify/commit/0a3225e))
- **Channel:** Validate configuration on construction ([554a598](https://github.com/guanguans/laravel-exception-notify/commit/554a598))
- **Channels:** Simplify exception reporting logic ([9f48476](https://github.com/guanguans/laravel-exception-notify/commit/9f48476))
- **Channels:** Remove ApplyConfigurationToObjectable trait ([3e4b88e](https://github.com/guanguans/laravel-exception-notify/commit/3e4b88e))
- **Channels:** Improve method visibility and organization ([ff29044](https://github.com/guanguans/laravel-exception-notify/commit/ff29044))
- **Contracts:** Rename Throwable to ThrowableContract and update usages ([bb29ff2](https://github.com/guanguans/laravel-exception-notify/commit/bb29ff2))
- **Dependencies:** Refactor function calls to support namespace ([7ee21f9](https://github.com/guanguans/laravel-exception-notify/commit/7ee21f9))
- **ExceptionNotifyManager:** Simplify rate limiting logic ([b2667e1](https://github.com/guanguans/laravel-exception-notify/commit/b2667e1))
- **HydratePipeFuncCallToStaticCallRector:** Use ValueResolver for static call ([5af4bc9](https://github.com/guanguans/laravel-exception-notify/commit/5af4bc9))
- **Notifiable:** Rename report variable to content ([588a3d2](https://github.com/guanguans/laravel-exception-notify/commit/588a3d2))
- **NotifyChannel:** Simplify authenticator creation process ([bb429b8](https://github.com/guanguans/laravel-exception-notify/commit/bb429b8))
- **StackChannel:** Improve error handling in report methods ([8c2fdde](https://github.com/guanguans/laravel-exception-notify/commit/8c2fdde))
- **baselines:** Remove obsolete NEON files and update imports ([8bbc744](https://github.com/guanguans/laravel-exception-notify/commit/8bbc744))
- **channel:** Rename report method and parameter ([61a081f](https://github.com/guanguans/laravel-exception-notify/commit/61a081f))
- **channels:** Implement DumpChannel class for logging ([4d9544f](https://github.com/guanguans/laravel-exception-notify/commit/4d9544f))
- **channels:** Rename reportRaw to reportContent ([0e16a04](https://github.com/guanguans/laravel-exception-notify/commit/0e16a04))
- **channels:** Rename CHANNEL_KEY to CHANNEL_CONFIG_KEY ([75aee9d](https://github.com/guanguans/laravel-exception-notify/commit/75aee9d))
- **channels:** Replace InvalidArgumentException with InvalidConfigurationException ([4e3b36f](https://github.com/guanguans/laravel-exception-notify/commit/4e3b36f))
- **channels:** Simplify channel handling in AbstractChannel ([b382c6b](https://github.com/guanguans/laravel-exception-notify/commit/b382c6b))
- **collectors:** Remove unused request collectors ([0318bfc](https://github.com/guanguans/laravel-exception-notify/commit/0318bfc))
- **collectors:** Rename Collector classes to AbstractCollector ([d445695](https://github.com/guanguans/laravel-exception-notify/commit/d445695))
- **collectors:** Improve null safety and type hints in methods ([368d974](https://github.com/guanguans/laravel-exception-notify/commit/368d974))
- **collectors:** Improve time handling with Carbon ([2a26610](https://github.com/guanguans/laravel-exception-notify/commit/2a26610))
- **collectors:** Change name method to instance method ([7e355df](https://github.com/guanguans/laravel-exception-notify/commit/7e355df))
- **commands:** Update TestCommand signature and logic ([51dc54b](https://github.com/guanguans/laravel-exception-notify/commit/51dc54b))
- **config:** Replace NotifyChannel usage with AbstractChannel ([4285e81](https://github.com/guanguans/laravel-exception-notify/commit/4285e81))
- **config:** Enable PHP 8.0 migration rules and clean code ([171b667](https://github.com/guanguans/laravel-exception-notify/commit/171b667))
- **config:** Simplify constructor property promotion ([b688464](https://github.com/guanguans/laravel-exception-notify/commit/b688464))
- **config:** Rename 'envs' to 'environments' ([12195e6](https://github.com/guanguans/laravel-exception-notify/commit/12195e6))
- **config:** Organize project structure and update scripts ([3652bdf](https://github.com/guanguans/laravel-exception-notify/commit/3652bdf))
- **contracts:** Rename Channel interface to ChannelContract ([d970dc1](https://github.com/guanguans/laravel-exception-notify/commit/d970dc1))
- **contracts:** Rename ExceptionAware to ExceptionAwareContract ([0cd57bf](https://github.com/guanguans/laravel-exception-notify/commit/0cd57bf))
- **core:** Simplify channel interfaces and collector merging ([ad3d601](https://github.com/guanguans/laravel-exception-notify/commit/ad3d601))
- **core:** Update report methods to return mixed type ([1583a4c](https://github.com/guanguans/laravel-exception-notify/commit/1583a4c))
- **events:** Rename exception events for clarity ([30e4cef](https://github.com/guanguans/laravel-exception-notify/commit/30e4cef))
- **exception-notify:** Update rescue function usage ([6de3e7a](https://github.com/guanguans/laravel-exception-notify/commit/6de3e7a))
- **exception-notify:** Improve job dispatch handling ([6a0b009](https://github.com/guanguans/laravel-exception-notify/commit/6a0b009))
- **exception-notify:** Simplify templates in NotifyChannel ([78141a1](https://github.com/guanguans/laravel-exception-notify/commit/78141a1))
- **pipes:** Replace hydrate_pipe calls with static calls ([46f9cc7](https://github.com/guanguans/laravel-exception-notify/commit/46f9cc7))
- **service provider:** Simplify singleton registrations ([2ead368](https://github.com/guanguans/laravel-exception-notify/commit/2ead368))
- **support:** Integrate AggregationTrait into Channel and Manager ([5a15cde](https://github.com/guanguans/laravel-exception-notify/commit/5a15cde))
- **support:** Improve exception handling with line number ([07083b2](https://github.com/guanguans/laravel-exception-notify/commit/07083b2))

### 📦 Builds
- **dependencies:** Add new development dependencies ([f21191d](https://github.com/guanguans/laravel-exception-notify/commit/f21191d))

### 🤖 Continuous Integrations
- improve type safety and add type perfect settings ([b1b3f91](https://github.com/guanguans/laravel-exception-notify/commit/b1b3f91))
- **baselines:** Remove deprecated baseline files and update configs ([3ed73c5](https://github.com/guanguans/laravel-exception-notify/commit/3ed73c5))
- **baselines:** Add new baseline files for PHPStan errors ([29999fe](https://github.com/guanguans/laravel-exception-notify/commit/29999fe))
- **composer:** Add class-leak commands to composer.json ([9f03a87](https://github.com/guanguans/laravel-exception-notify/commit/9f03a87))
- **composer:** Add new composer packages and update configurations ([f424ad9](https://github.com/guanguans/laravel-exception-notify/commit/f424ad9))
- **config:** Add Composer Dependency Analyser configuration ([1987bb0](https://github.com/guanguans/laravel-exception-notify/commit/1987bb0))
- **config:** Refactor composer-unused and remove unused files ([b4f0b0f](https://github.com/guanguans/laravel-exception-notify/commit/b4f0b0f))
- **config:** Update composer require checker configuration ([69e1cb3](https://github.com/guanguans/laravel-exception-notify/commit/69e1cb3))
- **dependencies:** Add facade-documenter and ai-commit packages ([c0015c6](https://github.com/guanguans/laravel-exception-notify/commit/c0015c6))
- **rector:** Add class visibility change configuration and utility function ([718a121](https://github.com/guanguans/laravel-exception-notify/commit/718a121))


<a name="4.7.0"></a>
## [4.7.0] - 2025-03-01
### ✨ Features
- **composer:** Update framework dependency ([d64aeaa](https://github.com/guanguans/laravel-exception-notify/commit/d64aeaa))
- **composer:** update dependencies and improve scripts ([84035ba](https://github.com/guanguans/laravel-exception-notify/commit/84035ba))

### 📖 Documents
- update copyright year to 2025 in multiple files ([5c24183](https://github.com/guanguans/laravel-exception-notify/commit/5c24183))

### ✅ Tests
- **LogChannelTest:** Skip test for specific Laravel versions ([7ca18c0](https://github.com/guanguans/laravel-exception-notify/commit/7ca18c0))

### 🤖 Continuous Integrations
- **composer-updater:** Refactor coding style and cleanup warnings ([e82108b](https://github.com/guanguans/laravel-exception-notify/commit/e82108b))
- **tests:** Update PHP versions in CI workflow ([1f89bb9](https://github.com/guanguans/laravel-exception-notify/commit/1f89bb9))

### Pull Requests
- Merge pull request [#72](https://github.com/guanguans/laravel-exception-notify/issues/72) from laravel-shift/l12-compatibility
- Merge pull request [#71](https://github.com/guanguans/laravel-exception-notify/issues/71) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.3.0
- Merge pull request [#70](https://github.com/guanguans/laravel-exception-notify/issues/70) from guanguans/dependabot/github_actions/codecov/codecov-action-5


<a name="4.6.0"></a>
## [4.6.0] - 2024-08-16
### ✨ Features
- **dependencies:** update package versions in composer.json ([4e21246](https://github.com/guanguans/laravel-exception-notify/commit/4e21246))

### 🏎 Performance Improvements
- Use fully qualified sprintf function in multiple files ([31118e7](https://github.com/guanguans/laravel-exception-notify/commit/31118e7))

### 🤖 Continuous Integrations
- **rector:** add static arrow and closure rectors ([f6fa1eb](https://github.com/guanguans/laravel-exception-notify/commit/f6fa1eb))

### Pull Requests
- Merge pull request [#68](https://github.com/guanguans/laravel-exception-notify/issues/68) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.2.0


<a name="4.5.1"></a>
## [4.5.1] - 2024-05-17
### 💅 Code Refactorings
- **config:** remove PhpInfoCollector from exception-notify config ([b927a52](https://github.com/guanguans/laravel-exception-notify/commit/b927a52))


<a name="4.5.0"></a>
## [4.5.0] - 2024-05-17
### ✨ Features
- **config:** Add environment configuration for exception notification ([b56c9d1](https://github.com/guanguans/laravel-exception-notify/commit/b56c9d1))

### 📖 Documents
- **readme:** update list of available features ([0b1d148](https://github.com/guanguans/laravel-exception-notify/commit/0b1d148))

### 💅 Code Refactorings
- **code:** Improve ExceptionNotify skipWhen method ([4e2cf0b](https://github.com/guanguans/laravel-exception-notify/commit/4e2cf0b))
- **config:** Update email recipients key in exception notification config ([230d711](https://github.com/guanguans/laravel-exception-notify/commit/230d711))
- **config:** update 'env' to 'envs' in exception-notify.php ([995c1fc](https://github.com/guanguans/laravel-exception-notify/commit/995c1fc))
- **config:** Update default queue connection ([0d0a756](https://github.com/guanguans/laravel-exception-notify/commit/0d0a756))
- **config:** Update exception notification rate limit cache store ([41ebcea](https://github.com/guanguans/laravel-exception-notify/commit/41ebcea))


<a name="4.4.2"></a>
## [4.4.2] - 2024-05-13

<a name="4.4.1"></a>
## [4.4.1] - 2024-05-12
### 🐞 Bug Fixes
- **command:** Fix condition check for driver in TestCommand.php ([a8e9c8d](https://github.com/guanguans/laravel-exception-notify/commit/a8e9c8d))

### 💅 Code Refactorings
- **collectors:** remove unnecessary properties from ExceptionBasicCollector ([9d14174](https://github.com/guanguans/laravel-exception-notify/commit/9d14174))
- **pipes:** Add LimitLengthPipe to CollectorManager ([80c43b4](https://github.com/guanguans/laravel-exception-notify/commit/80c43b4))


<a name="4.4.0"></a>
## [4.4.0] - 2024-05-11
### 💅 Code Refactorings
- Replace ExceptionNotifyManager with ExceptionNotify facade ([ee54798](https://github.com/guanguans/laravel-exception-notify/commit/ee54798))
- **FuncCallToStaticCall:** refactor static calls to function calls ([bb1531d](https://github.com/guanguans/laravel-exception-notify/commit/bb1531d))
- **StaticCallToFuncCall:** refactor Str::of to str ([002920c](https://github.com/guanguans/laravel-exception-notify/commit/002920c))
- **composer:** remove guanguans/ai-commit dependency ([caac119](https://github.com/guanguans/laravel-exception-notify/commit/caac119))
- **config:** update exception-notify extender function ([17ace0d](https://github.com/guanguans/laravel-exception-notify/commit/17ace0d))

### ✅ Tests
- **Channels:** Update mail channel configuration ([d85eaf4](https://github.com/guanguans/laravel-exception-notify/commit/d85eaf4))

### Pull Requests
- Merge pull request [#65](https://github.com/guanguans/laravel-exception-notify/issues/65) from guanguans/imgbot


<a name="4.3.3"></a>
## [4.3.3] - 2024-05-10
### 📖 Documents
- **mail:** Update mail.jpg ([5cd3299](https://github.com/guanguans/laravel-exception-notify/commit/5cd3299))

### 💅 Code Refactorings
- **command:** update TestCommand signature and handle method ([c6c72ca](https://github.com/guanguans/laravel-exception-notify/commit/c6c72ca))
- **config:** remove unnecessary code in exception-notify configuration ([113dc1d](https://github.com/guanguans/laravel-exception-notify/commit/113dc1d))
- **test:** Improve env_explode test case ([a1d990d](https://github.com/guanguans/laravel-exception-notify/commit/a1d990d))
- **testcommand:** refactor TestCommand handle method ([fbc5b00](https://github.com/guanguans/laravel-exception-notify/commit/fbc5b00))


<a name="4.3.2"></a>
## [4.3.2] - 2024-05-09
### 💅 Code Refactorings
- **commands:** improve readability of TestCommand.php ([cf9ed6a](https://github.com/guanguans/laravel-exception-notify/commit/cf9ed6a))

### Pull Requests
- Merge pull request [#64](https://github.com/guanguans/laravel-exception-notify/issues/64) from guanguans/imgbot
- Merge pull request [#63](https://github.com/guanguans/laravel-exception-notify/issues/63) from guanguans/imgbot


<a name="4.3.1"></a>
## [4.3.1] - 2024-05-09
### 💅 Code Refactorings
- **DefaultNotifyClientExtender:** Improve channel parameter handling ([007dde8](https://github.com/guanguans/laravel-exception-notify/commit/007dde8))
- **config:** update exception-notify configuration ([fb94f4e](https://github.com/guanguans/laravel-exception-notify/commit/fb94f4e))


<a name="4.3.0"></a>
## [4.3.0] - 2024-05-09
### ✨ Features
- **ExceptionNotify:** Add skipWhen method ([9415f84](https://github.com/guanguans/laravel-exception-notify/commit/9415f84))
- **ExceptionNotifyManager:** Add skipWhen method ([8261f35](https://github.com/guanguans/laravel-exception-notify/commit/8261f35))

### 📖 Documents
- **readme:** Update README.md with more descriptive content ([83999b1](https://github.com/guanguans/laravel-exception-notify/commit/83999b1))

### 💅 Code Refactorings
- **app:** Modify boot method in AppServiceProvider.php ([f69e192](https://github.com/guanguans/laravel-exception-notify/commit/f69e192))
- **collector:** update rejected headers list ([f179800](https://github.com/guanguans/laravel-exception-notify/commit/f179800))
- **config:** remove 'report_using_creator' from exception-notify.php ([a40bd4c](https://github.com/guanguans/laravel-exception-notify/commit/a40bd4c))
- **service provider:** improve extendExceptionHandler method ([7f4ceae](https://github.com/guanguans/laravel-exception-notify/commit/7f4ceae))
- **src:** Update static variable references to use self ([2b93068](https://github.com/guanguans/laravel-exception-notify/commit/2b93068))
- **tests:** refactor ExceptionNotifyManagerTest.php and Support/HeplersTest.php ([92f91ba](https://github.com/guanguans/laravel-exception-notify/commit/92f91ba))


<a name="4.2.0"></a>
## [4.2.0] - 2024-05-08
### 💅 Code Refactorings
- **Channel:** refactor string replacement method ([1b0461b](https://github.com/guanguans/laravel-exception-notify/commit/1b0461b))
- **Naming:** improve name generation logic ([222dfa9](https://github.com/guanguans/laravel-exception-notify/commit/222dfa9))
- **collect:** Improve RequestHeaderCollector to handle header array ([d418752](https://github.com/guanguans/laravel-exception-notify/commit/d418752))
- **config:** update exception-notify.php configuration ([ba7dc6d](https://github.com/guanguans/laravel-exception-notify/commit/ba7dc6d))
- **config:** update notify client extenders ([5e19d99](https://github.com/guanguans/laravel-exception-notify/commit/5e19d99))
- **mail:** Improve reduce method in MailChannel.php ([d93de26](https://github.com/guanguans/laravel-exception-notify/commit/d93de26))
- **mixins:** Update mixins for Str and Stringable classes ([df80937](https://github.com/guanguans/laravel-exception-notify/commit/df80937))
- **service provider:** remove DeferrableProvider interface implementation ([963cd87](https://github.com/guanguans/laravel-exception-notify/commit/963cd87))
- **serviceprovider:** comment out unnecessary mixin calls ([9496a2f](https://github.com/guanguans/laravel-exception-notify/commit/9496a2f))

### ✅ Tests
- Update tests and refactor code ([f26a8bc](https://github.com/guanguans/laravel-exception-notify/commit/f26a8bc))
- **Channels:** add tests for mail and notify channels ([0546979](https://github.com/guanguans/laravel-exception-notify/commit/0546979))
- **Commands:** update TestCommandTest.php and PipeTest.php ([029ab4f](https://github.com/guanguans/laravel-exception-notify/commit/029ab4f))
- **MailChannelTest:** Add test case for sending report email ([6695693](https://github.com/guanguans/laravel-exception-notify/commit/6695693))
- **ReportExceptionMailTest:** add test for building self ([03467e4](https://github.com/guanguans/laravel-exception-notify/commit/03467e4))


<a name="4.1.0"></a>
## [4.1.0] - 2024-05-07
### ✨ Features
- **collectors:** Add time field to ApplicationCollector ([cabb2f4](https://github.com/guanguans/laravel-exception-notify/commit/cabb2f4))
- **laravel:** Add Laravel 8.0 set list and related rules ([14ad648](https://github.com/guanguans/laravel-exception-notify/commit/14ad648))

### 💅 Code Refactorings
- change visibility of Request properties to private ([b7e3dd5](https://github.com/guanguans/laravel-exception-notify/commit/b7e3dd5))
- **Channels:** Improve readability of MailChannel and NotifyChannel ([48bd031](https://github.com/guanguans/laravel-exception-notify/commit/48bd031))
- **MailChannel:** simplify createMail method ([1c5a639](https://github.com/guanguans/laravel-exception-notify/commit/1c5a639))
- **config:** remove FixPrettyJsonPipe from exception-notify.php ([126d686](https://github.com/guanguans/laravel-exception-notify/commit/126d686))
- **config:** Remove unnecessary comment lines ([9193988](https://github.com/guanguans/laravel-exception-notify/commit/9193988))
- **config:** update client extender references ([dead9ec](https://github.com/guanguans/laravel-exception-notify/commit/dead9ec))
- **mail:** Improve method call in MailChannel ([f54cd79](https://github.com/guanguans/laravel-exception-notify/commit/f54cd79))
- **mail:** rename ExceptionReportMail to ReportExceptionMail ([62e7b50](https://github.com/guanguans/laravel-exception-notify/commit/62e7b50))
- **mail:** Improve mail channel configuration and method handling ([48ff8b9](https://github.com/guanguans/laravel-exception-notify/commit/48ff8b9))
- **mail:** Improve mail channel configuration handling ([abd3cf6](https://github.com/guanguans/laravel-exception-notify/commit/abd3cf6))


<a name="4.0.0"></a>
## [4.0.0] - 2024-05-06
### ✨ Features
- **config:** Add new notification channels ([0efd0e0](https://github.com/guanguans/laravel-exception-notify/commit/0efd0e0))

### 📖 Documents
- **README:** update supported notification channels in English README ([fc49f18](https://github.com/guanguans/laravel-exception-notify/commit/fc49f18))

### 💅 Code Refactorings
- **collector:** Improve exception trace collection ([b465ab9](https://github.com/guanguans/laravel-exception-notify/commit/b465ab9))


<a name="4.0.0-beta3"></a>
## [4.0.0-beta3] - 2024-05-06
### 📖 Documents
- **readme:** update supported notification channels ([ffe3881](https://github.com/guanguans/laravel-exception-notify/commit/ffe3881))

### 💅 Code Refactorings
- **config:** update Lark configuration and rename client tapper ([f635198](https://github.com/guanguans/laravel-exception-notify/commit/f635198))

### ✅ Tests
- **MailChannelTest:** add throws method in test ([d2fd67d](https://github.com/guanguans/laravel-exception-notify/commit/d2fd67d))

### Pull Requests
- Merge pull request [#62](https://github.com/guanguans/laravel-exception-notify/issues/62) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.1.0


<a name="4.0.0-beta2"></a>
## [4.0.0-beta2] - 2024-04-23
### 🐞 Bug Fixes
- Optimized the email sending logic and added pipeline handling in the exception notification feature ([d27c130](https://github.com/guanguans/laravel-exception-notify/commit/d27c130))

### ✅ Tests
- Remove useless files, change exception class names, adjust configuration settings, and refactor notification methods. ([e0c9238](https://github.com/guanguans/laravel-exception-notify/commit/e0c9238))


<a name="4.0.0-beta1"></a>
## [4.0.0-beta1] - 2024-04-23
### ✨ Features
- **Channel:** add Channel base class and extend other channel classes ([6a3a398](https://github.com/guanguans/laravel-exception-notify/commit/6a3a398))
- **ToInternalExceptionRector:** Add ToInternalExceptionRector for internal exceptions ([bf4fb99](https://github.com/guanguans/laravel-exception-notify/commit/bf4fb99))
- **composer-require-checker:** Add configuration file for composer-require-checker ([e49fb6b](https://github.com/guanguans/laravel-exception-notify/commit/e49fb6b))
- **config:** add aggregate channel configuration ([b8cc395](https://github.com/guanguans/laravel-exception-notify/commit/b8cc395))
- **config:** add mail configuration ([412e3a1](https://github.com/guanguans/laravel-exception-notify/commit/412e3a1))
- **config:** Add WithLogMiddlewareClientTapper class for exception-notify config ([dc5ef7e](https://github.com/guanguans/laravel-exception-notify/commit/dc5ef7e))

### 📖 Documents
- **README:** Add caution for 4.x version ([c4630e2](https://github.com/guanguans/laravel-exception-notify/commit/c4630e2))

### 💅 Code Refactorings
- Fix exception handling and enhance type safety ([9ea565d](https://github.com/guanguans/laravel-exception-notify/commit/9ea565d))
- Fix exception handling and enhance type safety ([c20df04](https://github.com/guanguans/laravel-exception-notify/commit/c20df04))
- update contract names in classes ([1d56485](https://github.com/guanguans/laravel-exception-notify/commit/1d56485))
- modify ExceptionNotifyManager to use configRepository ([e3b66b1](https://github.com/guanguans/laravel-exception-notify/commit/e3b66b1))
- **ExceptionNotifyManager:** Improve createDriver method ([f8a0242](https://github.com/guanguans/laravel-exception-notify/commit/f8a0242))
- **NotifyChannel:** Refactor NotifyChannel class for better readability and maintainability ([afbd0ff](https://github.com/guanguans/laravel-exception-notify/commit/afbd0ff))
- **collector:** remove unused code and fix access level of method ([786abf3](https://github.com/guanguans/laravel-exception-notify/commit/786abf3))
- **config:** refactor RectorConfig ([41b3b2c](https://github.com/guanguans/laravel-exception-notify/commit/41b3b2c))
- **exception-notify:** update lark configuration ([0b53521](https://github.com/guanguans/laravel-exception-notify/commit/0b53521))
- **log:** Simplify LogChannel constructor and report method ([2587e91](https://github.com/guanguans/laravel-exception-notify/commit/2587e91))
- **mail:** update mail classes names ([30fb6d0](https://github.com/guanguans/laravel-exception-notify/commit/30fb6d0))

### ✅ Tests
- **skip:** skip test that throws InvalidArgumentException ([a79c7d5](https://github.com/guanguans/laravel-exception-notify/commit/a79c7d5))


<a name="3.8.4"></a>
## [3.8.4] - 2024-05-13

<a name="3.8.3"></a>
## [3.8.3] - 2024-04-18
### 💅 Code Refactorings
- Removed `str` function and related code from helpers.php. ([7db80c5](https://github.com/guanguans/laravel-exception-notify/commit/7db80c5))


<a name="3.8.2"></a>
## [3.8.2] - 2024-04-01
### 💅 Code Refactorings
- **CollectionMacro:** Remove unnecessary method and comments ([747a5a2](https://github.com/guanguans/laravel-exception-notify/commit/747a5a2))
- **macro:** Remove lcfirst method from StrMacro and StringableMacro classes ([6299205](https://github.com/guanguans/laravel-exception-notify/commit/6299205))


<a name="3.8.1"></a>
## [3.8.1] - 2024-03-31
### 💅 Code Refactorings
- **ReportUsingCreator:** optimize error reporting logic ([c741ad8](https://github.com/guanguans/laravel-exception-notify/commit/c741ad8))


<a name="3.8.0"></a>
## [3.8.0] - 2024-03-31
### 📖 Documents
- **readme:** Remove unnecessary Chinese translation and code snippets ([6841cf3](https://github.com/guanguans/laravel-exception-notify/commit/6841cf3))

### 💅 Code Refactorings
- **src:** Improve extendExceptionHandler method in ExceptionNotifyServiceProvider ([dd2432b](https://github.com/guanguans/laravel-exception-notify/commit/dd2432b))


<a name="3.7.0"></a>
## [3.7.0] - 2024-03-31
### 💅 Code Refactorings
- **composer:** Remove unnecessary packages and update dependencies ([55bd927](https://github.com/guanguans/laravel-exception-notify/commit/55bd927))


<a name="3.6.1"></a>
## [3.6.1] - 2024-03-31
### Pull Requests
- Merge pull request [#61](https://github.com/guanguans/laravel-exception-notify/issues/61) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.0.0
- Merge pull request [#60](https://github.com/guanguans/laravel-exception-notify/issues/60) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-1.7.0


<a name="3.6.0"></a>
## [3.6.0] - 2024-03-13
### ✨ Features
- **composer-updater:** add dry-run option ([3806175](https://github.com/guanguans/laravel-exception-notify/commit/3806175))

### 💅 Code Refactorings
- **composer-updater:** Improve diff formatting ([7830da7](https://github.com/guanguans/laravel-exception-notify/commit/7830da7))

### Pull Requests
- Merge pull request [#57](https://github.com/guanguans/laravel-exception-notify/issues/57) from guanguans/dependabot/composer/rector/rector-tw-0.19or-tw-1.0


<a name="3.5.3"></a>
## [3.5.3] - 2024-02-01
### 💅 Code Refactorings
- **composer-fixer:** Update composer-fixer script ([f3c3554](https://github.com/guanguans/laravel-exception-notify/commit/f3c3554))
- **composer-updater:** Improve handling of multiple and single version dependencies ([b09001c](https://github.com/guanguans/laravel-exception-notify/commit/b09001c))

### Pull Requests
- Merge pull request [#56](https://github.com/guanguans/laravel-exception-notify/issues/56) from guanguans/dependabot/github_actions/actions/cache-4


<a name="3.5.2"></a>
## [3.5.2] - 2024-01-11
### 💅 Code Refactorings
- **collectors:** improve exception handling ([9abaf5d](https://github.com/guanguans/laravel-exception-notify/commit/9abaf5d))


<a name="3.5.1"></a>
## [3.5.1] - 2024-01-09
### 💅 Code Refactorings
- **coding-style:** Remove unused Rectors ([64b2bdc](https://github.com/guanguans/laravel-exception-notify/commit/64b2bdc))
- **monorepo-builder:** update release workers ([e72b7be](https://github.com/guanguans/laravel-exception-notify/commit/e72b7be))

### Pull Requests
- Merge pull request [#54](https://github.com/guanguans/laravel-exception-notify/issues/54) from guanguans/dependabot/github_actions/actions/stale-9
- Merge pull request [#53](https://github.com/guanguans/laravel-exception-notify/issues/53) from guanguans/dependabot/github_actions/actions/labeler-5


<a name="3.5.0"></a>
## [3.5.0] - 2023-10-18
### ✨ Features
- **config:** Add php_unit_data_provider_name and php_unit_data_provider_return_type in .php-cs-fixer.php ([074182d](https://github.com/guanguans/laravel-exception-notify/commit/074182d))

### 💅 Code Refactorings
- **pipes:** rename ToMarkdownPipe to SprintfMarkdownPipe ([4232a01](https://github.com/guanguans/laravel-exception-notify/commit/4232a01))
- **pipes:** rename ToHtmlPipe to SprintfHtmlPipe ([a90d2a7](https://github.com/guanguans/laravel-exception-notify/commit/a90d2a7))

### Pull Requests
- Merge pull request [#51](https://github.com/guanguans/laravel-exception-notify/issues/51) from guanguans/dependabot/github_actions/stefanzweifel/git-auto-commit-action-5
- Merge pull request [#49](https://github.com/guanguans/laravel-exception-notify/issues/49) from guanguans/dependabot/github_actions/actions/checkout-4


<a name="3.4.2"></a>
## [3.4.2] - 2023-08-29
### ✨ Features
- **facade:** Add facade.php file ([537e083](https://github.com/guanguans/laravel-exception-notify/commit/537e083))

### 🐞 Bug Fixes
- **facades:** Return string in getDefaultDriver method ([4375865](https://github.com/guanguans/laravel-exception-notify/commit/4375865))

### 💅 Code Refactorings
- **StringableMacro:** Remove unused squish and toString methods ([4a3f2c2](https://github.com/guanguans/laravel-exception-notify/commit/4a3f2c2))
- **bin:** remove unused code in facades.php ([2e2547b](https://github.com/guanguans/laravel-exception-notify/commit/2e2547b))


<a name="3.4.1"></a>
## [3.4.1] - 2023-08-20
### 🐞 Bug Fixes
- **src:** fix reportUsingCreator callable ([969916e](https://github.com/guanguans/laravel-exception-notify/commit/969916e))

### ✅ Tests
- **Channels:** update BarkChannel ([81f370a](https://github.com/guanguans/laravel-exception-notify/commit/81f370a))


<a name="3.4.0"></a>
## [3.4.0] - 2023-08-20
### ✨ Features
- **ReportUsingCreator:** add class ([9431a62](https://github.com/guanguans/laravel-exception-notify/commit/9431a62))

### 💅 Code Refactorings
- add return type declaration to getDefaultDriver method ([0a87c42](https://github.com/guanguans/laravel-exception-notify/commit/0a87c42))

### ✅ Tests
- **TestCase:** Update setUp and tearDown methods ([28c682d](https://github.com/guanguans/laravel-exception-notify/commit/28c682d))

### Pull Requests
- Merge pull request [#47](https://github.com/guanguans/laravel-exception-notify/issues/47) from guanguans/dependabot/composer/rector/rector-tw-0.17or-tw-0.18


<a name="3.3.2"></a>
## [3.3.2] - 2023-08-17
### 💅 Code Refactorings
- **AddChorePipe:** optimize handle method ([c738a2a](https://github.com/guanguans/laravel-exception-notify/commit/c738a2a))
- **pipes:** update FixPrettyJsonPipe ([fbb456a](https://github.com/guanguans/laravel-exception-notify/commit/fbb456a))

### ✅ Tests
- **tests:** Add MockeryPHPUnitIntegration trait ([06c96e9](https://github.com/guanguans/laravel-exception-notify/commit/06c96e9))


<a name="3.3.1"></a>
## [3.3.1] - 2023-08-14
### 💅 Code Refactorings
- update TestCommand handle method ([8177d86](https://github.com/guanguans/laravel-exception-notify/commit/8177d86))


<a name="3.3.0"></a>
## [3.3.0] - 2023-08-14
### ✨ Features
- **collectors:** add Naming trait ([7c60ea6](https://github.com/guanguans/laravel-exception-notify/commit/7c60ea6))
- **collectors:** Add ExceptionCollector class ([aa88d7c](https://github.com/guanguans/laravel-exception-notify/commit/aa88d7c))

### 🐞 Bug Fixes
- **ReportExceptionJob:** Change ExceptionNotify facade to ExceptionNotifyManager ([e7080a4](https://github.com/guanguans/laravel-exception-notify/commit/e7080a4))

### 📖 Documents
- **psalm:** Update psalm-baseline.xml ([120fe8c](https://github.com/guanguans/laravel-exception-notify/commit/120fe8c))

### 🎨 Styles
- **CollectorManager:** fix typo ([198ed2a](https://github.com/guanguans/laravel-exception-notify/commit/198ed2a))

### 💅 Code Refactorings
- **collectors:** improve PhpInfoCollector ([9f15a30](https://github.com/guanguans/laravel-exception-notify/commit/9f15a30))
- **service-provider:** Reorder service providers ([a72a1a1](https://github.com/guanguans/laravel-exception-notify/commit/a72a1a1))
- **src:** Update ExceptionNotifyManager.php ([9d308f2](https://github.com/guanguans/laravel-exception-notify/commit/9d308f2))


<a name="3.2.3"></a>
## [3.2.3] - 2023-08-13

<a name="3.2.2"></a>
## [3.2.2] - 2023-08-13
### 🐞 Bug Fixes
- **serviceprovider:** fix class name replacement ([aa34f79](https://github.com/guanguans/laravel-exception-notify/commit/aa34f79))

### 📖 Documents
- **ExceptionNotify:** Add shouldReport method ([1c687cf](https://github.com/guanguans/laravel-exception-notify/commit/1c687cf))

### 💅 Code Refactorings
- **command:** Change error variable to warning in TestCommand ([5ce178d](https://github.com/guanguans/laravel-exception-notify/commit/5ce178d))
- **serviceprovider:** Refactor alias method ([ad17640](https://github.com/guanguans/laravel-exception-notify/commit/ad17640))

### ✅ Tests
- **CollectorTest:** update test for collecting request basic ([5861fec](https://github.com/guanguans/laravel-exception-notify/commit/5861fec))


<a name="3.2.1"></a>
## [3.2.1] - 2023-08-13
### ✨ Features
- **TestCommandTest.php:** Add test for exception-notify ([0951602](https://github.com/guanguans/laravel-exception-notify/commit/0951602))
- **helper:** Add human_bytes function ([79c4a96](https://github.com/guanguans/laravel-exception-notify/commit/79c4a96))
- **helpers:** add precision parameter to human_milliseconds function ([697f8aa](https://github.com/guanguans/laravel-exception-notify/commit/697f8aa))
- **helpers:** Add human_milliseconds function ([281e838](https://github.com/guanguans/laravel-exception-notify/commit/281e838))
- **support:** add array_is_list helper function ([953d634](https://github.com/guanguans/laravel-exception-notify/commit/953d634))

### 📖 Documents
- **README:** Update README file ([d0bae8d](https://github.com/guanguans/laravel-exception-notify/commit/d0bae8d))
- **readme:** Fix typo ([7db8306](https://github.com/guanguans/laravel-exception-notify/commit/7db8306))

### 💅 Code Refactorings
- **config:** Update .php-cs-fixer.php ([be0d28f](https://github.com/guanguans/laravel-exception-notify/commit/be0d28f))
- **support:** update helpers.php ([c3d339d](https://github.com/guanguans/laravel-exception-notify/commit/c3d339d))

### ✅ Tests
- **ExceptionNotifyManagerTest:** refactor test cases ([bb34c8c](https://github.com/guanguans/laravel-exception-notify/commit/bb34c8c))


<a name="3.2.0"></a>
## [3.2.0] - 2023-08-12
### ✨ Features
- **commands:** Add TestCommand ([92df38e](https://github.com/guanguans/laravel-exception-notify/commit/92df38e))

### 🐞 Bug Fixes
- **composer:** Remove --clear-cache option from rector command ([4730481](https://github.com/guanguans/laravel-exception-notify/commit/4730481))

### 📖 Documents
- **readme:** Update README.md ([2273fde](https://github.com/guanguans/laravel-exception-notify/commit/2273fde))

### 💅 Code Refactorings
- **serviceprovider:** reorganize register method ([f7d2755](https://github.com/guanguans/laravel-exception-notify/commit/f7d2755))


<a name="3.1.4"></a>
## [3.1.4] - 2023-08-11
### 🐞 Bug Fixes
- **collectors:** Fix typo in ExceptionBasicCollector.php ([83a969c](https://github.com/guanguans/laravel-exception-notify/commit/83a969c))
- **job:** Handle exceptions in job ([3bad179](https://github.com/guanguans/laravel-exception-notify/commit/3bad179))

### 💅 Code Refactorings
- **src:** remove unnecessary code ([af8c526](https://github.com/guanguans/laravel-exception-notify/commit/af8c526))

### ✅ Tests
- **ExceptionNotifyManagerTest:** Add test for reporting exceptions ([6abcf6c](https://github.com/guanguans/laravel-exception-notify/commit/6abcf6c))
- **Support:** update JsonFixer test ([cd96d45](https://github.com/guanguans/laravel-exception-notify/commit/cd96d45))


<a name="3.1.3"></a>
## [3.1.3] - 2023-08-10
### ✨ Features
- **ReportExceptionJob:** Add retry functionality ([873df00](https://github.com/guanguans/laravel-exception-notify/commit/873df00))

### 🐞 Bug Fixes
- **Jobs:** Fix ReportExceptionJob timeout and retryAfter values ([d961a5d](https://github.com/guanguans/laravel-exception-notify/commit/d961a5d))


<a name="3.1.2"></a>
## [3.1.2] - 2023-08-10
### 🐞 Bug Fixes
- **CollectorManager:** Fix collector mapping ([1cbcd80](https://github.com/guanguans/laravel-exception-notify/commit/1cbcd80))

### 📖 Documents
- **readme:** Update README.md ([0ef78bf](https://github.com/guanguans/laravel-exception-notify/commit/0ef78bf))

### 💅 Code Refactorings
- **Pipes:** refactor ExceptKeysPipe ([e839e94](https://github.com/guanguans/laravel-exception-notify/commit/e839e94))
- **ReportExceptionJob:** improve type hinting ([2deb82e](https://github.com/guanguans/laravel-exception-notify/commit/2deb82e))
- **collectors:** update ChoreCollector ([20b0cee](https://github.com/guanguans/laravel-exception-notify/commit/20b0cee))
- **collectors:** simplify RequestSessionCollector ([b14623e](https://github.com/guanguans/laravel-exception-notify/commit/b14623e))
- **collectors:** Use getMarked method to get exception context ([8ab166f](https://github.com/guanguans/laravel-exception-notify/commit/8ab166f))
- **pipes:** rename AddValuePipe to AddChorePipe ([6fd453c](https://github.com/guanguans/laravel-exception-notify/commit/6fd453c))


<a name="3.1.1"></a>
## [3.1.1] - 2023-08-10
### 🐞 Bug Fixes
- **src:** unset dispatch in ExceptionNotifyManager ([2fea13e](https://github.com/guanguans/laravel-exception-notify/commit/2fea13e))

### 💅 Code Refactorings
- **ExceptionNotifyManager:** remove unused callback parameter ([c69a750](https://github.com/guanguans/laravel-exception-notify/commit/c69a750))

### ✅ Tests
- **ExceptionNotifyManagerTest:** spy runningInConsole method ([d65c297](https://github.com/guanguans/laravel-exception-notify/commit/d65c297))
- **FeatureTest:** Improve exception reporting ([fab6180](https://github.com/guanguans/laravel-exception-notify/commit/fab6180))

### Pull Requests
- Merge pull request [#44](https://github.com/guanguans/laravel-exception-notify/issues/44) from guanguans/imgbot


<a name="3.1.0"></a>
## [3.1.0] - 2023-08-09
### ✨ Features
- **src:** Add ExceptionNotifyServiceProvider.php ([15185b4](https://github.com/guanguans/laravel-exception-notify/commit/15185b4))

### 💅 Code Refactorings
- **DdChannel:** remove DdChannel ([02055c9](https://github.com/guanguans/laravel-exception-notify/commit/02055c9))


<a name="3.0.2"></a>
## [3.0.2] - 2023-08-09
### ✨ Features
- **helper functions:** add env_explode helper function ([12bf1cb](https://github.com/guanguans/laravel-exception-notify/commit/12bf1cb))

### 🐞 Bug Fixes
- **ExceptionNotifyManager:** fix return value when callback returns null ([2ff3b8c](https://github.com/guanguans/laravel-exception-notify/commit/2ff3b8c))
- **helper:** Fix env_explode function ([67a6343](https://github.com/guanguans/laravel-exception-notify/commit/67a6343))

### 📖 Documents
- **README.md:** update README.md ([45d90d0](https://github.com/guanguans/laravel-exception-notify/commit/45d90d0))

### 💅 Code Refactorings
- **config:** update exception-notify.php ([71bae7d](https://github.com/guanguans/laravel-exception-notify/commit/71bae7d))


<a name="3.0.1"></a>
## [3.0.1] - 2023-08-08
### ✨ Features
- **ExceptionNotifyManager:** add attempt method ([6645071](https://github.com/guanguans/laravel-exception-notify/commit/6645071))

### 💅 Code Refactorings
- **ExceptionNotifyManager:** add getChannels method ([70f58ce](https://github.com/guanguans/laravel-exception-notify/commit/70f58ce))
- **config:** update default reported channels ([2c5e46a](https://github.com/guanguans/laravel-exception-notify/commit/2c5e46a))


<a name="3.0.0"></a>
## [3.0.0] - 2023-08-08
### ✨ Features
- **tests:** add PHPMock trait ([f189fa3](https://github.com/guanguans/laravel-exception-notify/commit/f189fa3))

### 💅 Code Refactorings
- **ExceptionContext:** simplify code and fix method name ([29241f8](https://github.com/guanguans/laravel-exception-notify/commit/29241f8))
- **ExceptionNotify:** improve getFacadeAccessor method ([b6ce25a](https://github.com/guanguans/laravel-exception-notify/commit/b6ce25a))
- **ExceptionNotifyManager:** simplify rate limiting logic ([5b4218a](https://github.com/guanguans/laravel-exception-notify/commit/5b4218a))
- **LogChannel:** use app('log') instead of Log facade ([d8b4687](https://github.com/guanguans/laravel-exception-notify/commit/d8b4687))
- **composer:** Remove unused dependencies ([36c38a7](https://github.com/guanguans/laravel-exception-notify/commit/36c38a7))
- **jobs:** Remove unused Log import ([04dcec0](https://github.com/guanguans/laravel-exception-notify/commit/04dcec0))
- **naming:** Rename variable to match method call return type ([067339c](https://github.com/guanguans/laravel-exception-notify/commit/067339c))
- **src:** Refactor ExceptionNotifyManager ([bfc0b11](https://github.com/guanguans/laravel-exception-notify/commit/bfc0b11))

### ✅ Tests
- **Channels:** Remove redundant test files ([4acffe1](https://github.com/guanguans/laravel-exception-notify/commit/4acffe1))
- **CollectorManagerTest:** remove unnecessary test ([ab14c23](https://github.com/guanguans/laravel-exception-notify/commit/ab14c23))
- **FeatureTest:** report exception with file upload ([0ee672c](https://github.com/guanguans/laravel-exception-notify/commit/0ee672c))
- **NotifyChannelTest:** Add test for reporting ([74716a4](https://github.com/guanguans/laravel-exception-notify/commit/74716a4))


<a name="3.0.0-rc2"></a>
## [3.0.0-rc2] - 2023-08-06
### ✨ Features
- **Jobs:** Improve exception reporting ([7e751a3](https://github.com/guanguans/laravel-exception-notify/commit/7e751a3))
- **Pipes:** Add RemoveKeysPipe ([37ddc74](https://github.com/guanguans/laravel-exception-notify/commit/37ddc74))
- **collectors:** Add RequestRawFileCollector ([2aed955](https://github.com/guanguans/laravel-exception-notify/commit/2aed955))
- **pipes:** add OnlyKeysPipe class ([ff27f38](https://github.com/guanguans/laravel-exception-notify/commit/ff27f38))

### 🐞 Bug Fixes
- **channels:** Update LogChannel constructor ([8154243](https://github.com/guanguans/laravel-exception-notify/commit/8154243))
- **collector:** fix Collector::name method ([c769cc9](https://github.com/guanguans/laravel-exception-notify/commit/c769cc9))
- **collectors:** Rename ExceptionPreviewCollector to ExceptionContextCollector ([be5c01b](https://github.com/guanguans/laravel-exception-notify/commit/be5c01b))
- **psalm:** fix undefined interface method in ExceptionNotifyManager ([6bf2169](https://github.com/guanguans/laravel-exception-notify/commit/6bf2169))
- **src:** Add hydrate_pipe helper function to helpers.php ([ddab994](https://github.com/guanguans/laravel-exception-notify/commit/ddab994))

### 📖 Documents
- **readme:** update PHP and Laravel requirements ([a1c6393](https://github.com/guanguans/laravel-exception-notify/commit/a1c6393))

### 💅 Code Refactorings
- **collectors:** Update ExceptionPreviewCollector and ExceptionTraceCollector ([5ebc47d](https://github.com/guanguans/laravel-exception-notify/commit/5ebc47d))
- **config:** update exception-notify.php ([51875f8](https://github.com/guanguans/laravel-exception-notify/commit/51875f8))
- **exceptions:** remove BadMethodCallException class ([ed8a677](https://github.com/guanguans/laravel-exception-notify/commit/ed8a677))
- **pipes:** update AddValuePipe ([20bf3fb](https://github.com/guanguans/laravel-exception-notify/commit/20bf3fb))
- **src:** remove unused code ([2565c5d](https://github.com/guanguans/laravel-exception-notify/commit/2565c5d))


<a name="3.0.0-rc1"></a>
## [3.0.0-rc1] - 2023-08-05
### ✨ Features
- **ExceptionNotifyManager:** add optional channels parameter to reportIf method ([0911d6f](https://github.com/guanguans/laravel-exception-notify/commit/0911d6f))
- **JsonFixer:** Update fix method ([0298127](https://github.com/guanguans/laravel-exception-notify/commit/0298127))
- **exception-notify:** Add ExceptionPreviewCollector ([39bb5cb](https://github.com/guanguans/laravel-exception-notify/commit/39bb5cb))

### 🐞 Bug Fixes
- **ExceptionNotifyManager:** Fix queue connection config key ([094d38f](https://github.com/guanguans/laravel-exception-notify/commit/094d38f))
- **collectors:** fix Illuminate\Container\Container import ([474a578](https://github.com/guanguans/laravel-exception-notify/commit/474a578))

### 📖 Documents
- **_ide_helper:** Remove unused methods ([6ed9405](https://github.com/guanguans/laravel-exception-notify/commit/6ed9405))

### 🎨 Styles
- **serviceprovider:** Fix indentation in toAlias method ([6555f76](https://github.com/guanguans/laravel-exception-notify/commit/6555f76))

### 💅 Code Refactorings
- **DdChannel:** remove return type declaration ([9ccaa6c](https://github.com/guanguans/laravel-exception-notify/commit/9ccaa6c))
- **SanitizerContract:** remove unused interface ([e78f25a](https://github.com/guanguans/laravel-exception-notify/commit/e78f25a))
- **StringableMacro:** Remove beforeLast method ([66f665a](https://github.com/guanguans/laravel-exception-notify/commit/66f665a))
- **collector:** rename toReports to mapToReports ([586d41f](https://github.com/guanguans/laravel-exception-notify/commit/586d41f))
- **collector-manager:** refactor toReports method ([be9cf81](https://github.com/guanguans/laravel-exception-notify/commit/be9cf81))
- **collectors:** update ApplicationCollector ([215c445](https://github.com/guanguans/laravel-exception-notify/commit/215c445))
- **config:** Update exception-notify.php ([b9009a1](https://github.com/guanguans/laravel-exception-notify/commit/b9009a1))
- **jobs:** optimize ReportExceptionJob ([d5965d5](https://github.com/guanguans/laravel-exception-notify/commit/d5965d5))
- **pipes:** rename AppendKeywordCollectorsPipe to AddKeywordPipe ([1766cd0](https://github.com/guanguans/laravel-exception-notify/commit/1766cd0))
- **pipes:** rename AppendContentPipe to AppendKeywordCollectorsPipe ([ebb81e4](https://github.com/guanguans/laravel-exception-notify/commit/ebb81e4))
- **pipes:** use Stringable for handle return type ([99d1ab3](https://github.com/guanguans/laravel-exception-notify/commit/99d1ab3))
- **pipes:** Extend AddKeywordPipe from AddValuePipe ([73176e0](https://github.com/guanguans/laravel-exception-notify/commit/73176e0))
- **src:** Refactor ExceptionNotifyServiceProvider registerCollectorManager method ([c2cd7df](https://github.com/guanguans/laravel-exception-notify/commit/c2cd7df))
- **src:** update ReportExceptionJob.php ([f5ffa51](https://github.com/guanguans/laravel-exception-notify/commit/f5ffa51))
- **src:** remove unused code ([50f1a3f](https://github.com/guanguans/laravel-exception-notify/commit/50f1a3f))


<a name="3.0.0-beta1"></a>
## [3.0.0-beta1] - 2023-08-02
### ✨ Features
- **ExceptionNotifyServiceProvider:** Add StringableMacro to mixins ([0241ee2](https://github.com/guanguans/laravel-exception-notify/commit/0241ee2))
- **deps:** add laravel/lumen-framework dependency ([5e2b631](https://github.com/guanguans/laravel-exception-notify/commit/5e2b631))
- **monorepo-builder.php:** add monorepo-builder.php file ([4198531](https://github.com/guanguans/laravel-exception-notify/commit/4198531))

### 🐞 Bug Fixes
- **StrMacro:** Fix squish function ([30d1843](https://github.com/guanguans/laravel-exception-notify/commit/30d1843))
- **contracts:** Rename ExceptionAware interface to ExceptionAwareContract ([7c213f9](https://github.com/guanguans/laravel-exception-notify/commit/7c213f9))

### 📖 Documents
- **changelog:** Add changelog template file ([8b41339](https://github.com/guanguans/laravel-exception-notify/commit/8b41339))

### 💅 Code Refactorings
- **.php-cs-fixer.php:** optimize file inclusion ([eabf8a4](https://github.com/guanguans/laravel-exception-notify/commit/eabf8a4))
- **Channel:** change getName method to name ([8b216c8](https://github.com/guanguans/laravel-exception-notify/commit/8b216c8))
- **ChannelContract:** Rename interface Channel to ChannelContract ([dbe1a87](https://github.com/guanguans/laravel-exception-notify/commit/dbe1a87))
- **Collector:** remove __toString method ([a9a2c0a](https://github.com/guanguans/laravel-exception-notify/commit/a9a2c0a))
- **Collector:** rename Collector to CollectorContract ([e3bd2e4](https://github.com/guanguans/laravel-exception-notify/commit/e3bd2e4))
- **CollectorManager:** remove __toString method and Stringable interface ([25c4647](https://github.com/guanguans/laravel-exception-notify/commit/25c4647))
- **CollectorManager:** change toArray method to collect ([03daee2](https://github.com/guanguans/laravel-exception-notify/commit/03daee2))
- **Exceptions:** rename Exception.php to ThrowableContract.php ([694c75f](https://github.com/guanguans/laravel-exception-notify/commit/694c75f))
- **Sanitizers:** rename Sanitizers to Pipes ([bf2d854](https://github.com/guanguans/laravel-exception-notify/commit/bf2d854))
- **collector:** Rename LaravelCollector to ApplicationCollector ([ac4daf8](https://github.com/guanguans/laravel-exception-notify/commit/ac4daf8))
- **collector:** remove Stringable interface implementation ([2859972](https://github.com/guanguans/laravel-exception-notify/commit/2859972))
- **collectors:** rename AdditionCollector to ChoreCollector ([491912e](https://github.com/guanguans/laravel-exception-notify/commit/491912e))
- **collectors:** rename ExceptionAware namespace ([e5fbbdf](https://github.com/guanguans/laravel-exception-notify/commit/e5fbbdf))
- **contracts:** extend Channel and Collector with NameContract ([ef7bf1f](https://github.com/guanguans/laravel-exception-notify/commit/ef7bf1f))
- **facades:** Update facades namespace ([694e8d6](https://github.com/guanguans/laravel-exception-notify/commit/694e8d6))
- **jobs:** refactor ReportExceptionJob ([d0b493c](https://github.com/guanguans/laravel-exception-notify/commit/d0b493c))
- **options:** remove OptionsProperty trait ([e577dc4](https://github.com/guanguans/laravel-exception-notify/commit/e577dc4))
- **php-cs-fixer:** use glob and update directory permissions ([09265fe](https://github.com/guanguans/laravel-exception-notify/commit/09265fe))
- **service-provider:** Update service provider aliases ([2796681](https://github.com/guanguans/laravel-exception-notify/commit/2796681))

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


[Unreleased]: https://github.com/guanguans/laravel-exception-notify/compare/5.2.0...HEAD
[5.2.0]: https://github.com/guanguans/laravel-exception-notify/compare/5.1.11...5.2.0
[5.1.11]: https://github.com/guanguans/laravel-exception-notify/compare/5.1.10...5.1.11
[5.1.10]: https://github.com/guanguans/laravel-exception-notify/compare/5.1.9...5.1.10
[5.1.9]: https://github.com/guanguans/laravel-exception-notify/compare/5.1.8...5.1.9
[5.1.8]: https://github.com/guanguans/laravel-exception-notify/compare/5.1.7...5.1.8
[5.1.7]: https://github.com/guanguans/laravel-exception-notify/compare/5.1.6...5.1.7
[5.1.6]: https://github.com/guanguans/laravel-exception-notify/compare/5.1.5...5.1.6
[5.1.5]: https://github.com/guanguans/laravel-exception-notify/compare/5.1.4...5.1.5
[5.1.4]: https://github.com/guanguans/laravel-exception-notify/compare/5.1.3...5.1.4
[5.1.3]: https://github.com/guanguans/laravel-exception-notify/compare/5.1.2...5.1.3
[5.1.2]: https://github.com/guanguans/laravel-exception-notify/compare/5.1.1...5.1.2
[5.1.1]: https://github.com/guanguans/laravel-exception-notify/compare/5.1.0...5.1.1
[5.1.0]: https://github.com/guanguans/laravel-exception-notify/compare/5.0.0...5.1.0
[5.0.0]: https://github.com/guanguans/laravel-exception-notify/compare/5.0.0-rc1...5.0.0
[5.0.0-rc1]: https://github.com/guanguans/laravel-exception-notify/compare/5.0.0-beta2...5.0.0-rc1
[5.0.0-beta2]: https://github.com/guanguans/laravel-exception-notify/compare/5.0.0-beta1...5.0.0-beta2
[5.0.0-beta1]: https://github.com/guanguans/laravel-exception-notify/compare/4.7.0...5.0.0-beta1
[4.7.0]: https://github.com/guanguans/laravel-exception-notify/compare/4.6.0...4.7.0
[4.6.0]: https://github.com/guanguans/laravel-exception-notify/compare/4.5.1...4.6.0
[4.5.1]: https://github.com/guanguans/laravel-exception-notify/compare/4.5.0...4.5.1
[4.5.0]: https://github.com/guanguans/laravel-exception-notify/compare/4.4.2...4.5.0
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
[4.0.0-beta1]: https://github.com/guanguans/laravel-exception-notify/compare/3.8.4...4.0.0-beta1
[3.8.4]: https://github.com/guanguans/laravel-exception-notify/compare/3.8.3...3.8.4
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
