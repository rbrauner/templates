<?php

declare(strict_types=1);

/**
 * Copyright (C) Rafał Brauner
 */

require_once __DIR__ . '/vendor/autoload.php';

use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\Node\RemoveNonExistingVarAnnotationRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/bin',
        __DIR__ . '/public',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withSkip([
        __DIR__ . '/vendor',
    ])
    ->withRootFiles()
    ->withParallel()
    ->withPhpSets()
    ->withComposerBased(
        phpunit: true,
    )
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
    ->withSkip([
        RemoveNonExistingVarAnnotationRector::class,
    ])
    ->withImportNames(importShortClasses: false, removeUnusedImports: true)
;
