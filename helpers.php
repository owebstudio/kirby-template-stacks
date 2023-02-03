<?php

use Oweb\Stacks;

function endpush(): void
{
    Stacks::end();
}

function push(string|array $name, bool $once = false): void
{
    is_array($name) ? Stacks::set($name) : Stacks::open($name, $once);

}

function stack(string $name, bool $return = false): string|null
{
    return Stacks::render($name, $return);
}
