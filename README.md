# Kirby Template Stacks

> [!IMPORTANT]
> This plugin is in maintenance mode and only gets security fixes. It supports Kirby 3.5 to 5. Kirby 6 has its own `push()`, `endpush()` and `stack()` helpers, so you don't need this plugin anymore. Remove it before you upgrade to Kirby 6, see [Upgrading to Kirby 6](#upgrading-to-kirby-6).

Template stacks allows you to push to named stacks which can be rendered somewhere else in another snippet or template. This idea is inspired from [Laravel Blade Stacks](https://laravel.com/docs/9.x/blade#stacks).

## Upgrading to Kirby 6

Delete the plugin folder from `site/plugins` (or run `composer remove owebstudio/kirby-template-stacks`) before you update Kirby. Your `push()`, `endpush()` and `stack()` calls then use the Kirby 6 helpers. Most templates work without changes, but check these differences:

| Template Stacks | Kirby 6 |
| --- | --- |
| `push('scripts', true)` | `push('scripts', unique: true)` |
| `stack('scripts', true)` | `stack('scripts', return: true)` |
| Items are joined without a separator. | Items are joined with a line break. Use `stack('scripts', '')` to join them without one. |
| A stack keeps its items after it is rendered. | A stack is emptied after it is rendered. Use `stack('scripts', clear: false)` to render it again. |
| A stack in `<head>` stays empty, because the pushes in the template run after it. | Stacks can be rendered anywhere, also before the pushes, e.g. in `<head>`. |

Change the `true` arguments first. In Kirby 6 the second argument of `push()` is the content and the second argument of `stack()` is the glue. So `push('scripts', true)` adds `1` to the stack and prints the content in place, and `stack('scripts', true)` prints the items joined with `1` instead of returning them.

## Installation

1. Download the latest release
2. Unzip downloaded file
3. Copy/paste unzipped folder in your `/site/plugins` folder

## Methods

### `stack()`

Calls a given stack name and prints all the items in it. The last data is printed last.

```php
  <?php stack('scripts') // directly outputted ?>
  
  <?php echo stack('scripts', true) // returns as string ?>
```

### `push()` ... `endpush()`

Pushes data to a given stack name. The sent data is thrown to the end of the stack.

```php
<?php push('scripts') ?>
    Push any content to footer multiple times from anywhere
<?php endpush() ?>
```

If the pushed data is unique and in a repeating loop, you can send the secondary parameter as `true`. For example; if you want a javascript library to be loaded only once in a blocks field.

```php
<?php push('scripts', true) ?>
    <script src="assets/js/plugins/slider.js"></script>
<?php endpush() ?>
```

## Samples

### Sample 1: with snippets and templates

#### Defining stacks
**/site/snippets/header.php**
```php
<html>
<body>
```

**/site/snippets/footer.php**
```php
  <?php stack('scripts') ?>
</body>
</html>
```

#### Pushing contents to the stack
**/site/templates/home.php**
```php
<?php snippet('header') ?>

<h1>Homepage</h1>

<?php push('scripts') ?>
    <script src="assets/js/home.js"></script>
<?php endpush() ?>

<?php snippet('footer') ?>
```

### Sample 2: with new snippets with slots feature

#### Defining stacks
**/site/snippets/layouts/default.php**

```php
<html>
<body>
  <?= $slots->default() ?>
  <?php stack('footer') ?>
</body>
</html>
```

#### Pushing contents to the stack
**/site/templates/home.php**
```php
<?php snippet('layouts/default', slots: true) ?>

<h1>Homepage</h1>

<?php push('footer') ?>
    <script src="assets/js/home.js"></script>
<?php endpush() ?>
```
