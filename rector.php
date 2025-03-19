<?php

/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Carbon\Carbon;
use Composer\Autoload\ClassLoader;
use Ergebnis\Rector\Rules\Arrays\SortAssociativeArrayByKeyRector;
use Guanguans\LaravelExceptionNotify\Support\Rectors\HydratePipeFuncCallToStaticCallRector;
use Guanguans\LaravelExceptionNotify\Support\Rectors\ToInternalExceptionRector;
use Guanguans\LaravelExceptionNotify\Template;
use Illuminate\Support\Carbon as IlluminateCarbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\Float_;
use PhpParser\Node\Scalar\Int_;
use PhpParser\Node\Scalar\String_;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector;
use Rector\CodingStyle\Rector\ArrowFunction\StaticArrowFunctionRector;
use Rector\CodingStyle\Rector\Closure\StaticClosureRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;
use Rector\CodingStyle\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassLike\RemoveAnnotationRector;
use Rector\DowngradePhp81\Rector\Array_\DowngradeArraySpreadStringKeyRector;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Transform\Rector\FuncCall\FuncCallToStaticCallRector;
use Rector\Transform\Rector\Scalar\ScalarValueToConstFetchRector;
use Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector;
use Rector\Transform\ValueObject\FuncCallToStaticCall;
use Rector\Transform\ValueObject\ScalarValueToConstFetch;
use Rector\Transform\ValueObject\StaticCallToFuncCall;
use Rector\ValueObject\PhpVersion;
use Rector\ValueObject\Visibility;
use Rector\Visibility\Rector\ClassMethod\ChangeMethodVisibilityRector;
use Rector\Visibility\ValueObject\ChangeMethodVisibility;
use RectorLaravel\Rector\Class_\ModelCastsPropertyToCastsMethodRector;
use RectorLaravel\Rector\Empty_\EmptyToBlankAndFilledFuncRector;
use RectorLaravel\Rector\FuncCall\HelperFuncCallToFacadeClassRector;
use RectorLaravel\Rector\FuncCall\TypeHintTappableCallRector;
use RectorLaravel\Rector\StaticCall\DispatchToHelperFunctionsRector;
use RectorLaravel\Set\LaravelSetList;

/** @var \Illuminate\Support\Collection $classes */
$classes ??= collect(spl_autoload_functions())
    ->pipe(static fn (Collection $splAutoloadFunctions): Collection => collect(
        $splAutoloadFunctions
            ->firstOrFail(
                static fn (mixed $loader): bool => \is_array($loader) && $loader[0] instanceof ClassLoader
            )[0]
            ->getClassMap()
    ))
    ->keys();

return RectorConfig::configure()
    ->withPaths([
        // __DIR__.'/config',
        __DIR__.'/src',
        __DIR__.'/tests',
        ...glob(__DIR__.'/{*,.*}.php', \GLOB_BRACE),
        __DIR__.'/composer-updater',
    ])
    ->withRootFiles()
    // ->withSkipPath(__DIR__.'/tests.php')
    ->withSkip([
        '**/__snapshots__/*',
        '**/Fixtures/*',
        __DIR__.'/src/Channels/Channel.php',
        __FILE__,
    ])
    ->withCache(__DIR__.'/.build/rector/')
    ->withParallel()
    // ->withoutParallel()
    // ->withImportNames(importNames: false)
    ->withImportNames(importDocBlockNames: false, importShortClasses: false)
    ->withFluentCallNewLine()
    ->withAttributesSets(phpunit: true, all: true)
    ->withComposerBased(phpunit: true)
    ->withPhpVersion(PhpVersion::PHP_80)
    ->withDowngradeSets(php80: true)
    ->withPhpSets(php80: true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        privatization: true,
        naming: true,
        instanceOf: true,
        earlyReturn: true,
        carbon: true,
        rectorPreset: true,
        phpunitCodeQuality: true,
    )
    ->withSets([
        PHPUnitSetList::PHPUNIT_90,
        LaravelSetList::LARAVEL_90,
        ...collect((new ReflectionClass(LaravelSetList::class))->getConstants(ReflectionClassConstant::IS_PUBLIC))
            ->reject(
                static fn (string $constant, string $name): bool => \in_array(
                    $name,
                    ['LARAVEL_STATIC_TO_INJECTION', 'LARAVEL_'],
                    true
                ) || preg_match('/^LARAVEL_\d{2,3}$/', $name)
            )
            // ->dd()
            ->values()
            ->all(),
    ])
    ->withRules([
        ArraySpreadInsteadOfArrayMergeRector::class,
        SortAssociativeArrayByKeyRector::class,
        StaticArrowFunctionRector::class,
        StaticClosureRector::class,
        HydratePipeFuncCallToStaticCallRector::class,
        ToInternalExceptionRector::class,
        ...$classes
            ->filter(static fn (string $class): bool => str_starts_with($class, 'RectorLaravel\Rector'))
            ->filter(static fn (string $class): bool => (new ReflectionClass($class))->isInstantiable())
            ->values()
            // ->dd()
            ->all(),
    ])
    ->withConfiguredRule(RemoveAnnotationRector::class, [
        'codeCoverageIgnore',
        'phpstan-ignore',
        'phpstan-ignore-next-line',
        'psalm-suppress',
    ])
    ->withConfiguredRule(RenameClassRector::class, [
        Carbon::class => IlluminateCarbon::class,
    ])
    ->withConfiguredRule(StaticCallToFuncCallRector::class, [
        new StaticCallToFuncCall(Str::class, 'of', 'str'),
    ])
    // ->withConfiguredRule(FuncCallToStaticCallRector::class, [
    //     new FuncCallToStaticCall('str', Str::class, 'of'),
    // ])
    ->withConfiguredRule(
        ScalarValueToConstFetchRector::class,
        collect([
            Template::class,
        ])
            ->map(static fn (string $class) => collect((new ReflectionClass($class))->getConstants(ReflectionClassConstant::IS_PUBLIC))
                ->reduce(
                    static function (array $carry, mixed $value, string $name) use ($class): array {
                        $classConstFetch = new ClassConstFetch(new FullyQualified($class), new Identifier($name));

                        $scalarValueToConstFetch = match (true) {
                            \is_string($value) => new ScalarValueToConstFetch(new String_($value), $classConstFetch),
                            \is_int($value) => new ScalarValueToConstFetch(new Int_($value), $classConstFetch),
                            \is_float($value) => new ScalarValueToConstFetch(new Float_($value), $classConstFetch),
                            default => null,
                        };

                        $scalarValueToConstFetch and $carry[] = $scalarValueToConstFetch;

                        return $carry;
                    },
                    []
                ))
            ->flatten()
            // ->dd()
            ->all()
    )

    ->withConfiguredRule(
        ChangeMethodVisibilityRector::class,
        $classes
            ->filter(static fn (string $class): bool => str_starts_with($class, 'Guanguans\LaravelExceptionNotify'))
            ->mapWithKeys(static fn (string $class): array => [$class => new ReflectionClass($class)])
            ->filter(static fn (ReflectionClass $reflectionClass): bool => $reflectionClass->isTrait())
            ->map(
                static fn (ReflectionClass $reflectionClass): array => collect($reflectionClass->getMethods(ReflectionMethod::IS_PRIVATE))
                    ->reject(static fn (ReflectionMethod $reflectionMethod): bool => $reflectionMethod->isFinal())
                    ->map(
                        static fn (ReflectionMethod $reflectionMethod): ChangeMethodVisibility => new ChangeMethodVisibility(
                            $reflectionClass->getName(),
                            $reflectionMethod->getName(),
                            Visibility::PROTECTED
                        )
                    )
                    ->all()
            )
            ->flatten()
            // ->dd()
            ->values()
            ->all(),
    )
    ->withConfiguredRule(
        RenameFunctionRector::class,
        [
            'faker' => 'fake',
            'Guanguans\Notify\Foundation\Support\rescue' => 'Guanguans\LaravelExceptionNotify\Support\rescue',
            'Pest\Faker\fake' => 'fake',
            'Pest\Faker\faker' => 'faker',
            'rescue' => 'Guanguans\LaravelExceptionNotify\Support\rescue',
            'test' => 'it',
        ] + array_reduce(
            [
                'make',
                'env_explode',
                'json_pretty_encode',
                'hydrate_pipe',
                'human_bytes',
                'human_milliseconds',
            ],
            static function (array $carry, string $func): array {
                /** @see https://github.com/laravel/framework/blob/11.x/src/Illuminate/Support/functions.php */
                $carry[$func] = "Guanguans\\LaravelExceptionNotify\\Support\\$func";

                return $carry;
            },
            []
        )
    )
    ->withSkip([
        DowngradeArraySpreadStringKeyRector::class,
        EncapsedStringsToSprintfRector::class,
        ExplicitBoolCompareRector::class,
        LogicalToBooleanRector::class,
        NewlineAfterStatementRector::class,
        ReturnBinaryOrToEarlyReturnRector::class,
        WrapEncapsedVariableInCurlyBracesRector::class,
    ])
    ->withSkip([
        DispatchToHelperFunctionsRector::class,
        EmptyToBlankAndFilledFuncRector::class,
        HelperFuncCallToFacadeClassRector::class,
        ModelCastsPropertyToCastsMethodRector::class,
        TypeHintTappableCallRector::class,
    ])
    ->withSkip([
        ScalarValueToConstFetchRector::class => [
            __DIR__.'/src/Contracts/TemplateContract.php',
        ],
        StaticArrowFunctionRector::class => $staticClosureSkipPaths = [
            __DIR__.'/tests',
        ],
        StaticClosureRector::class => $staticClosureSkipPaths,
        SortAssociativeArrayByKeyRector::class => [
            __DIR__.'/config',
            __DIR__.'/src',
            __DIR__.'/tests',
        ],
    ]);
