<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use PHPUnit\Framework\TestCase;
use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector;
use Rector\CodeQuality\Rector\Assign\SplitListAssignToSeparateLineRector;
use Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector;
use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\CodeQuality\Rector\Expression\InlineIfToExplicitIfRector;
use Rector\CodeQuality\Rector\Identical\SimplifyBoolIdenticalTrueRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector;
use Rector\CodingStyle\Enum\PreferenceSelfThis;
use Rector\CodingStyle\Rector\ClassMethod\UnSpreadOperatorRector;
use Rector\CodingStyle\Rector\Closure\StaticClosureRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;
use Rector\CodingStyle\Rector\FuncCall\ConsistentPregDelimiterRector;
use Rector\CodingStyle\Rector\MethodCall\PreferThisOrSelfMethodCallRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Config\RectorConfig;
use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\DeadCode\Rector\Assign\RemoveUnusedVariableAssignRector;
use Rector\DeadCode\Rector\MethodCall\RemoveEmptyMethodCallRector;
use Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector;
use Rector\EarlyReturn\Rector\If_\ChangeOrIfReturnToEarlyReturnRector;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector;
use Rector\Laravel\Set\LaravelLevelSetList;
use Rector\Laravel\Set\LaravelSetList;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\Php56\Rector\FunctionLike\AddDefaultValueForUndefinedVariableRector;
use Rector\Php72\Rector\FuncCall\GetClassOnNullRector;
use Rector\PHPUnit\Rector\Class_\AddSeeTestAnnotationRector;
use Rector\PHPUnit\Set\PHPUnitLevelSetList;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\PSR4\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector;
use Rector\TypeDeclaration\Rector\Closure\AddClosureReturnTypeRector;
use Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->bootstrapFiles([
        // __DIR__.'/vendor/autoload.php',
    ]);

    $rectorConfig->autoloadPaths([
        // __DIR__.'/vendor/autoload.php',
    ]);

    $rectorConfig->paths([
        // __DIR__.'/config',
        // __DIR__.'/routes',
        __DIR__.'/src',
        __DIR__.'/tests',
        __DIR__.'/.php-cs-fixer.php',
        __DIR__.'/rector.php',
    ]);

    $rectorConfig->skip([
        // rules
        // CallableThisArrayToAnonymousFunctionRector::class,
        InlineIfToExplicitIfRector::class,
        LogicalToBooleanRector::class,
        // SimplifyBoolIdenticalTrueRector::class,
        // RemoveEmptyMethodCallRector::class,
        AddSeeTestAnnotationRector::class,
        NormalizeNamespaceByPSR4ComposerAutoloadRector::class,
        ChangeAndIfToEarlyReturnRector::class,
        // ReturnBinaryOrToEarlyReturnRector::class,
        EncapsedStringsToSprintfRector::class,
        // WrapEncapsedVariableInCurlyBracesRector::class,

        // optional rules
        // AddDefaultValueForUndefinedVariableRector::class,
        // RemoveUnusedVariableAssignRector::class,
        // ConsistentPregDelimiterRector::class,
        UnSpreadOperatorRector::class,
        // StaticClosureRector::class,
        NewlineAfterStatementRector::class,
        RemoveEmptyMethodCallRector::class,
        CompleteDynamicPropertiesRector::class,
        RenamePropertyToMatchTypeRector::class,
        ReturnTypeDeclarationRector::class,
        AddClosureReturnTypeRector::class,
        GetClassOnNullRector::class,
        AddArrayReturnDocTypeRector::class,
        ExplicitBoolCompareRector::class,
        SplitListAssignToSeparateLineRector::class,
        ConsistentPregDelimiterRector::class,
        ChangeOrIfReturnToEarlyReturnRector::class,

        // paths
        '**/fixtures*',
        '**/fixtures/*',
        '**/Fixture*',
        '**/Fixture/*',
        '**/Source*',
        '**/Source/*',
        '**/Expected/*',
        '**/Expected*',
        __DIR__.'/tests/ExceptionNotifyManagerTest.php',
        __DIR__.'/tests/CollectorManagerTest.php',
        __DIR__.'/src/Support/Macros/RequestMacro.php',
    ]);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_72,
        SetList::ACTION_INJECTION_TO_CONSTRUCTOR_INJECTION,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::DEAD_CODE,
        // SetList::GMAGICK_TO_IMAGICK,
        // SetList::MONOLOG_20,
        // SetList::MYSQL_TO_MYSQLI,
        SetList::NAMING,
        // SetList::PRIVATIZATION,
        SetList::PSR_4,
        SetList::TYPE_DECLARATION,
        // SetList::TYPE_DECLARATION_STRICT,
        SetList::EARLY_RETURN,

        // LaravelLevelSetList::UP_TO_LARAVEL_70,
        // LaravelSetList::ARRAY_STR_FUNCTIONS_TO_STATIC_CALL,
        // // LaravelSetList::LARAVEL_STATIC_TO_INJECTION,
        // LaravelSetList::LARAVEL_CODE_QUALITY,
        // LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
        // LaravelSetList::LARAVEL_LEGACY_FACTORIES_TO_CLASSES,

        PHPUnitLevelSetList::UP_TO_PHPUNIT_80,
        PHPUnitSetList::PHPUNIT80_DMS,
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
        PHPUnitSetList::PHPUNIT_EXCEPTION,
        PHPUnitSetList::REMOVE_MOCKS,
        PHPUnitSetList::PHPUNIT_SPECIFIC_METHOD,
        PHPUnitSetList::PHPUNIT_YIELD_DATA_PROVIDER,
    ]);

    $rectorConfig->disableParallel();
    $rectorConfig->importNames(true, false);
    $rectorConfig->nestedChainMethodCallLimit(3);
    $rectorConfig->phpstanConfig(__DIR__.'/phpstan.neon');
    // $rectorConfig->cacheClass(FileCacheStorage::class);
    // $rectorConfig->cacheDirectory(__DIR__.'/build/rector');
    // $rectorConfig->fileExtensions(['php']);
    // $rectorConfig->parameters()->set(Option::APPLY_AUTO_IMPORT_NAMES_ON_CHANGED_FILES_ONLY, true);
    // $rectorConfig->phpVersion(PhpVersion::PHP_80);
    // $rectorConfig->parallel();
    // $rectorConfig->indent(' ', 4);

    $rectorConfig->rules([
        InlineConstructorDefaultToPropertyRector::class,
    ]);

    $rectorConfig->ruleWithConfiguration(
        PreferThisOrSelfMethodCallRector::class,
        [
            TestCase::class => PreferenceSelfThis::PREFER_THIS,
        ]
    );
};
