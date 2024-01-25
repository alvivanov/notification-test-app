<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = (new Finder())
    ->ignoreDotFiles(false)
    ->ignoreVCSIgnored(true)
    ->exclude(['vendor', 'runtume'])
    ->in(__DIR__)
;

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        'no_unused_imports'             => true,
        '@PSR12'                        => true,
        'no_superfluous_phpdoc_tags'    => true,
        'single_line_throw'             => false,
        'concat_space'                  => ['spacing' => 'one'],
        'braces'                        => [
            'allow_single_line_closure' => true,
        ],
        'blank_line_before_statement'   => [
            'statements' => ['continue', 'do', 'exit', 'if', 'return', 'switch', 'throw', 'try'],
        ],
        'array_indentation'             => true,
        'ordered_imports'               => true,
        'global_namespace_import'       => [
            'import_classes'   => false,
            'import_constants' => false,
            'import_functions' => false,
        ],
        'native_constant_invocation'    => false,
        'native_function_invocation'    => false,
        'array_syntax'                  => [
            'syntax' => 'short',
        ],
        'phpdoc_annotation_without_dot' => true,
        'phpdoc_summary'                => false,
        'class_definition'              => false,
        'declare_strict_types'          => true,
    ])
    ->setFinder($finder)
;
