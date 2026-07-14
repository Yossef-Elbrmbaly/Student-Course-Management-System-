<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/public',
    ])
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(false)
    ->setRules([
        '@PSR12' => true,

        // Imports
        'ordered_imports' => true,
        'no_unused_imports' => true,
        'single_import_per_statement' => true,

        // Arrays
        'array_syntax' => [
            'syntax' => 'short',
        ],
        'trailing_comma_in_multiline' => true,

        // Strings
        'single_quote' => true,

        // Spaces
        'binary_operator_spaces' => [
            'default' => 'single_space',
        ],
        'concat_space' => [
            'spacing' => 'one',
        ],
        'no_whitespace_in_blank_line' => true,

        // Functions & Classes
        'class_definition' => true,
        'method_argument_space' => true,
        'blank_line_after_opening_tag' => true,
        'blank_line_after_namespace' => true,

        // Control Structures
        'braces_position' => true,
        'control_structure_braces' => true,
        'control_structure_continuation_position' => true,
        'elseif' => true,

        // Comments
        'single_line_comment_style' => [
            'comment_types' => ['hash'],
        ],
    ])
    ->setFinder($finder);