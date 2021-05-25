<?php

declare(strict_types=1);

$header = <<<'EOF'
This file is part of Talent4tech blog project made by OD&B.
Credits Aliptic
EOF;

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__.'/src')
    ->in(__DIR__.'/tests')
    ->append([__FILE__])
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PHP71Migration:risky' => true,
        '@PHPUnit75Migration:risky' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        'final_public_method_for_abstract_class' => true,
        'general_phpdoc_annotation_remove' => [
            'annotations' => [
                'expectedException',
                'expectedExceptionMessage',
                'expectedExceptionMessageRegExp',
            ],
        ],
        'global_namespace_import' => true,
        'linebreak_after_opening_tag' => true,
        'list_syntax' => ['syntax' => 'short'],
        'mb_str_functions' => true,
        'method_chaining_indentation' => true,
        'nullable_type_declaration_for_default_null_value' => true,
        'ordered_interfaces' => true,
        'ordered_traits' => false,
        'php_unit_size_class' => true,
        'php_unit_test_class_requires_covers' => false,
        'phpdoc_line_span' => true,
        'phpdoc_to_param_type' => false,
        'phpdoc_to_return_type' => true,
        'regular_callable_call' => true,
        'self_static_accessor' => true,
        'simplified_if_return' => true,
        'simplified_null_return' => false,
        'static_lambda' => true,
        'header_comment' => ['header' => $header],
    ])
    ->setFinder($finder)
    ->setCacheFile(__DIR__.'/var/.php_cs.cache')
    ;
