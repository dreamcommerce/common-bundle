<?php

$header = <<<EOF

(c) 2017 DreamCommerce

@package << package_name >>
@author << Name & Surname >> <developers@dreamcommerce.com>
@link https://www.dreamcommerce.com

EOF;

Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in(array(__DIR__))
;

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->fixers(array(
        'header_comment',
        'newline_after_open_tag',
        'ordered_use',
        'long_array_syntax',
        'php_unit_construct',
    ))
    ->setUsingCache(true)
    ->finder($finder)
;
