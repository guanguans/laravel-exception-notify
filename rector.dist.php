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

use Ergebnis\Rector\Rules\Expressions\Arrays\SortAssociativeArrayByKeyRector;
use Guanguans\LaravelExceptionNotify\Template;
use Guanguans\PhpCsFixerCustomFixers\Support\Utils;
use Guanguans\RectorRules\NodeVisitor\ParentConnectingVisitor;
use Guanguans\RectorRules\Rector\File\AddNoinspectionDocblockToFileFirstStmtRector;
use Guanguans\RectorRules\Rector\Name\RenameToConventionalCaseNameRector;
use Guanguans\RectorRules\Set\SetList;
use Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector;
use Rector\CodingStyle\Rector\ClassLike\NewlineBetweenClassLikeStmtsRector;
use Rector\Config\RectorConfig;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitThisCallRector;
use Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector;
use Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use Rector\Transform\Rector\String_\StringToClassConstantRector;
use Rector\Transform\ValueObject\StringToClassConstant;
use Rector\ValueObject\PhpVersion;
use RectorLaravel\Rector\ArrayDimFetch\ArrayToArrGetRector;
use RectorLaravel\Rector\Class_\DescriptionPropertyToDescriptionAttributeRector;
use RectorLaravel\Rector\Class_\FillablePropertyToFillableAttributeRector;
use RectorLaravel\Rector\Class_\HiddenPropertyToHiddenAttributeRector;
use RectorLaravel\Rector\Class_\SignaturePropertyToSignatureAttributeRector;
use RectorLaravel\Rector\Empty_\EmptyToBlankAndFilledFuncRector;
use RectorLaravel\Rector\FuncCall\HelperFuncCallToFacadeClassRector;
use RectorLaravel\Rector\FuncCall\TypeHintTappableCallRector;
use RectorLaravel\Rector\If_\ThrowIfRector;
use RectorLaravel\Rector\StaticCall\DispatchToHelperFunctionsRector;
use RectorLaravel\Set\LaravelLevelSetList;
use RectorPest\Set\PestLevelSetList;
use RectorPest\Set\PestSetList;

error_reporting(\E_ALL & ~\E_DEPRECATED & ~\E_USER_DEPRECATED);

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/config/',
        __DIR__.'/src/',
        __DIR__.'/tests/',
        __DIR__.'/workbench/',
        ...Utils::defaultRootFiles(),
    ])
    ->withRootFiles()
    ->withSkip(['*/Fixtures/*', __DIR__.'/src/Support/Utils.php', __DIR__.'/tests.php'])
    ->withSkip([
        LogicalToBooleanRector::class,
        NewlineBetweenClassLikeStmtsRector::class,
        PreferPHPUnitThisCallRector::class,
    ])
    ->withSkip([
        DescriptionPropertyToDescriptionAttributeRector::class,
        FillablePropertyToFillableAttributeRector::class,
        HiddenPropertyToHiddenAttributeRector::class,
        SignaturePropertyToSignatureAttributeRector::class,

        ArrayToArrGetRector::class,
        DispatchToHelperFunctionsRector::class,
        EmptyToBlankAndFilledFuncRector::class,
        HelperFuncCallToFacadeClassRector::class,
        ThrowIfRector::class,
    ])
    ->withSkip([
        RenameClassConstFetchRector::class => [
            __DIR__.'/workbench/config/database.php',
        ],
        RenameParamToMatchTypeRector::class => [
            __DIR__.'/tests/Pest.php',
        ],
        SortAssociativeArrayByKeyRector::class => [
            __DIR__.'/config/',
            __DIR__.'/src/',
            __DIR__.'/tests/',
            __DIR__.'/workbench/',
        ],
        StringToClassConstantRector::class => [
            __DIR__.'/config/exception-notify.php',
            __DIR__.'/src/Commands/TestCommand.php',
            __DIR__.'/src/Template.php',
            __DIR__.'/tests/',
            __DIR__.'/workbench/config/database.php',
            __DIR__.'/composer-bump',
        ],
        TypeHintTappableCallRector::class => [
            __DIR__.'/src/Commands/Concerns/Configurable.php',
        ],
    ])
    ->withCache(__DIR__.'/.build/rector/')
    // ->withoutParallel()
    ->withParallel()
    ->withImportNames(importDocBlockNames: false, importShortClasses: false, removeUnusedImports: false)
    // ->withImportNames(true, false, false, false)
    ->reportUnusedSkips()
    ->withFluentCallNewLine()
    ->withTreatClassesAsFinal()
    ->withTypeGuardedClasses([])
    ->withAttributesSets(phpunit: true, all: true)
    ->withComposerBased(phpunit: true/* , laravel: true */)
    ->withPhpVersion(PhpVersion::PHP_82)
    ->withDowngradeSets(php82: true)
    ->withPhpSets(php82: true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        typeDeclarationDocblocks: true,
        privatization: true,
        naming: true,
        // namedArgs: true,
        carbon: true,
        rectorPreset: true,
        phpunitCodeQuality: true,
        phpunitNarrowAsserts: true,
        phpunitMockToStub: true,
    )
    ->withSets([
        SetList::ALL,
        LaravelLevelSetList::UP_TO_LARAVEL_110,
        PestLevelSetList::UP_TO_PEST_30,
        PestSetList::PEST_CODE_QUALITY,
    ])
    ->withRules([])
    ->withConfiguredRule(AddNoinspectionDocblockToFileFirstStmtRector::class, [
        '*/tests/*' => [
            'AnonymousFunctionStaticInspection',
            'NullPointerExceptionInspection',
            'PhpFieldAssignmentTypeMismatchInspection',
            'PhpPossiblePolymorphicInvocationInspection',
            'PhpUndefinedClassInspection',
            'PhpUnhandledExceptionInspection',
            'PhpVoidFunctionResultUsedInspection',
            'StaticClosureCanBeUsedInspection',
        ],
    ])
    ->registerDecoratingNodeVisitor(ParentConnectingVisitor::class)
    ->withConfiguredRule(RenameToConventionalCaseNameRector::class, ['afterEach', 'beforeEach', 'MIT', 'PDO'])
    ->withConfiguredRule(
        RenameFunctionRector::class,
        collect(['env_explode', 'make', 'rescue'])
            ->mapWithKeys(static fn (string $func): array => [$func => "Guanguans\\LaravelExceptionNotify\\Support\\$func"])
            ->all()
    )
    ->withConfiguredRule(StringToClassConstantRector::class, array_map(
        static fn (string $string, string $constant): StringToClassConstant => new StringToClassConstant(
            $string,
            Template::class,
            $constant
        ),
        $constants = (new ReflectionClass(Template::class))->getConstants(),
        array_keys($constants),
    ));
