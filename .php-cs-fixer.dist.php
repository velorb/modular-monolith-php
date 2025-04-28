<?php

$finder = (new PhpCsFixer\Finder())
    ->in([__DIR__ . '/src', __DIR__ . '/tests']);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        '@PSR12:risky' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
        'blank_line_before_statement' => ['statements' => ['return']],
        'no_superfluous_phpdoc_tags' => ['allow_hidden_params' => true, 'remove_inheritdoc' => true],
        'no_unneeded_import_alias' => true,
        'no_extra_blank_lines' => [
            'tokens' => [
                'attribute',
                'case',
                'continue',
                'curly_brace_block',
                'default',
                'extra',
                'parenthesis_brace_block',
                'square_brace_block',
                'switch',
                'throw',
                'use'
            ]
        ]
    ])
    ->setFinder($finder);
