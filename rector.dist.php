<?php

/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Ergebnis\Rector\Rules\Arrays\SortAssociativeArrayByKeyRector;
use Ergebnis\Rector\Rules\Faker\GeneratorPropertyFetchToMethodCallRector;
use Guanguans\LaravelExceptionNotify\Support\Rectors\HydratePipeFuncCallToStaticCallRector;
use Guanguans\LaravelExceptionNotify\Template;
use Guanguans\RectorRules\Rector\File\AddNoinspectionDocblockToFileFirstStmtRector;
use Guanguans\RectorRules\Rector\File\SortFileFirstStmtDocblockRector;
use Guanguans\RectorRules\Rector\FunctionLike\RenameGarbageParamNameRector;
use Guanguans\RectorRules\Rector\Name\RenameToConventionalCaseNameRector;
use Guanguans\RectorRules\Set\SetList;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\Float_;
use PhpParser\Node\Scalar\Int_;
use PhpParser\Node\Scalar\String_;
use PhpParser\NodeVisitor\ParentConnectingVisitor;
use Rector\CodeQuality\Rector\Class_\ConvertStaticToSelfRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector;
use Rector\CodingStyle\Rector\ArrowFunction\ArrowFunctionDelegatingCallToFirstClassCallableRector;
use Rector\CodingStyle\Rector\ArrowFunction\StaticArrowFunctionRector;
use Rector\CodingStyle\Rector\ClassLike\NewlineBetweenClassLikeStmtsRector;
use Rector\CodingStyle\Rector\Closure\StaticClosureRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;
use Rector\CodingStyle\Rector\Enum_\EnumCaseToPascalCaseRector;
use Rector\CodingStyle\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector;
use Rector\Config\RectorConfig;
use Rector\EarlyReturn\Rector\If_\ChangeOrIfContinueToMultiContinueRector;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector;
use Rector\Php73\Rector\FuncCall\JsonThrowOnErrorRector;
use Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;
use Rector\Transform\Rector\Scalar\ScalarValueToConstFetchRector;
use Rector\Transform\Rector\String_\StringToClassConstantRector;
use Rector\Transform\ValueObject\ScalarValueToConstFetch;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\SafeDeclareStrictTypesRector;
use Rector\TypeDeclarationDocblocks\Rector\Class_\DocblockVarArrayFromPropertyDefaultsRector;
use Rector\TypeDeclarationDocblocks\Rector\ClassMethod\DocblockReturnArrayFromDirectArrayInstanceRector;
use Rector\ValueObject\PhpVersion;
use RectorLaravel\Rector\ArrayDimFetch\ArrayToArrGetRector;
use RectorLaravel\Rector\Class_\ModelCastsPropertyToCastsMethodRector;
use RectorLaravel\Rector\Empty_\EmptyToBlankAndFilledFuncRector;
use RectorLaravel\Rector\FuncCall\ConfigToTypedConfigMethodCallRector;
use RectorLaravel\Rector\FuncCall\HelperFuncCallToFacadeClassRector;
use RectorLaravel\Rector\FuncCall\TypeHintTappableCallRector;
use RectorLaravel\Rector\If_\ThrowIfRector;
use RectorLaravel\Rector\StaticCall\CarbonToDateFacadeRector;
use RectorLaravel\Rector\StaticCall\DispatchToHelperFunctionsRector;
use RectorLaravel\Set\LaravelSetProvider;

return RectorConfig::configure()
    ->withPaths([
        // __DIR__.'/config/',
        __DIR__.'/src/',
        __DIR__.'/tests/',
        __DIR__.'/workbench/',
        __DIR__.'/composer-bump',
    ])
    ->withRootFiles()
    ->withSkip([
        '*/Fixtures/*',
        __DIR__.'/src/Support/Utils.php',
        __DIR__.'/tests.php',
        __DIR__.'/rector-.php',
    ])
    ->withCache(__DIR__.'/.build/rector/')
    // ->withoutParallel()
    ->withParallel()
    ->withImportNames(importDocBlockNames: false, importShortClasses: false)
    // ->withImportNames(importNames: false)
    // ->withEditorUrl()
    ->withFluentCallNewLine()
    ->withTreatClassesAsFinal()
    ->withAttributesSets(phpunit: true, all: true)
    ->withComposerBased(phpunit: true, laravel: true)
    ->withSetProviders(LaravelSetProvider::class)
    ->withPhpVersion(PhpVersion::PHP_81)
    ->withDowngradeSets(php81: true)
    ->withPhpSets(php81: true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        typeDeclarationDocblocks: true,
        privatization: true,
        naming: true,
        instanceOf: true,
        earlyReturn: true,
        // strictBooleans: true,
        carbon: true,
        rectorPreset: true,
        phpunitCodeQuality: true,
    )
    ->withSets([
        SetList::ALL,
    ])
    ->withRules([
        HydratePipeFuncCallToStaticCallRector::class,

        ArraySpreadInsteadOfArrayMergeRector::class,
        EnumCaseToPascalCaseRector::class,
        GeneratorPropertyFetchToMethodCallRector::class,
        JsonThrowOnErrorRector::class,
        SafeDeclareStrictTypesRector::class,
        SortAssociativeArrayByKeyRector::class,
        StaticArrowFunctionRector::class,
        StaticClosureRector::class,
    ])
    ->withConfiguredRule(AddNoinspectionDocblockToFileFirstStmtRector::class, [
        '*/tests/*' => [
            'AnonymousFunctionStaticInspection',
            'NullPointerExceptionInspection',
            'PhpFieldAssignmentTypeMismatchInspection',
            'PhpPossiblePolymorphicInvocationInspection',
            'PhpUndefinedClassInspection',
            'PhpUnhandledExceptionInspection',
            'PhpVoidFunctionResultUsedInspection',
            // 'SqlResolve',
            'StaticClosureCanBeUsedInspection',
        ],
    ])
    ->registerDecoratingNodeVisitor(ParentConnectingVisitor::class)
    ->withConfiguredRule(RenameToConventionalCaseNameRector::class, ['beforeEach', 'MIT', 'PDO'])
    ->withConfiguredRule(
        ScalarValueToConstFetchRector::class,
        collect([Template::class])
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
        RenameFunctionRector::class,
        collect(['env_explode', 'json_pretty_encode', 'make', 'rescue'])
            ->mapWithKeys(static fn (string $func): array => [$func => "Guanguans\\LaravelExceptionNotify\\Support\\$func"])
            ->all()
    )
    ->withSkip([
        AddNoinspectionDocblockToFileFirstStmtRector::class,
        CarbonToDateFacadeRector::class,
        ConvertStaticToSelfRector::class,
        DocblockReturnArrayFromDirectArrayInstanceRector::class,
        DocblockVarArrayFromPropertyDefaultsRector::class,
        ModelCastsPropertyToCastsMethodRector::class,
        RenameGarbageParamNameRector::class,
        RenameToConventionalCaseNameRector::class,
        ScalarValueToConstFetchRector::class,
        SortAssociativeArrayByKeyRector::class,
        SortFileFirstStmtDocblockRector::class,
        StringToClassConstantRector::class,

        // ArrayToFirstClassCallableRector::class,
        // ArrowFunctionDelegatingCallToFirstClassCallableRector::class,
        // ScalarValueToConstFetchRector::class,

        ChangeOrIfContinueToMultiContinueRector::class,
        DisallowedEmptyRuleFixerRector::class,
        EncapsedStringsToSprintfRector::class,
        ExplicitBoolCompareRector::class,
        LogicalToBooleanRector::class,
        NewlineBetweenClassLikeStmtsRector::class,
        ReturnBinaryOrToEarlyReturnRector::class,
        WrapEncapsedVariableInCurlyBracesRector::class,
    ])
    ->withSkip([
        ConfigToTypedConfigMethodCallRector::class,
        TypeHintTappableCallRector::class,

        ArrayToArrGetRector::class,
        DispatchToHelperFunctionsRector::class,
        EmptyToBlankAndFilledFuncRector::class,
        HelperFuncCallToFacadeClassRector::class,
        ThrowIfRector::class,
    ])
    ->withSkip([
        // ApplyDefaultInsteadOfNullCoalesceRector::class => [
        //     __DIR__.'/src/Channels/AbstractChannel.php',
        // ],
        // ScalarValueToConstFetchRector::class => [
        //     __DIR__.'/src/Template.php',
        // ],
        // SortAssociativeArrayByKeyRector::class => [
        //     __DIR__.'/config/',
        //     __DIR__.'/src/',
        //     __DIR__.'/tests/',
        // ],
        StaticArrowFunctionRector::class => $staticClosureSkipPaths = [
            __DIR__.'/tests/*Test.php',
            __DIR__.'/tests/Pest.php',
        ],
        StaticClosureRector::class => $staticClosureSkipPaths,
        // StringToClassConstantRector::class => [
        //     __DIR__.'/config/',
        //     __DIR__.'/tests/',
        // ],
    ]);
