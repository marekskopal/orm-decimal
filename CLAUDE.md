# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
# Install dependencies
composer install

# Run tests
vendor/bin/phpunit

# Static analysis (level max, PHP 8.4)
vendor/bin/phpstan

# Code style check (PSR-12 + Slevomat)
vendor/bin/phpcs

# Run a single test file
vendor/bin/phpunit tests/Mapper/DecimalMapperTest.php
```

## Architecture

This is a small PHP library that integrates the PHP `ext-decimal` extension with the [marekskopal/orm](https://github.com/marekskopal/orm) framework. It has exactly two classes:

- **`ColumnDecimal`** (`src/Attribute/ColumnDecimal.php`): A PHP 8 attribute applied to ORM entity properties. Takes `precision` and `scale` as required constructor params, and registers `DecimalMapper` as its handler.

- **`DecimalMapper`** (`src/Mapper/DecimalMapper.php`): Implements `MapperInterface`. Converts between database strings and `Decimal\Decimal` objects in both directions (`mapToProperty` / `mapToColumn`).

Usage pattern in an ORM entity:

```php
#[ColumnDecimal(precision: 8, scale: 2)]
public Decimal $value;
```

The library requires `ext-decimal` (native PHP extension) and `php-decimal/php-decimal` (^1.1.0) at runtime.
