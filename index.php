<?php

use Kirby\Cms\App as Kirby;

if (
    function_exists('push') === false &&
    function_exists('endpush') === false &&
    function_exists('stack') === false
) {
    @include_once __DIR__ . '/helpers.php';
}

load([
    'oweb\\stacks' => __DIR__ . '/src/Stacks.php'
]);

Kirby::plugin('owebstudio/template-stacks', []);
