# ORM Decimal

[![PHP](https://img.shields.io/badge/PHP-%3E%3D8.4-blue)](https://www.php.net/)
[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)

`Decimal\Decimal` type mapper for [marekskopal/orm](https://github.com/marekskopal/orm), powered by the [`ext-decimal`](https://php-decimal.io/) PHP extension. Handles precise decimal arithmetic without floating-point rounding errors — ideal for monetary values and other exact numeric data.

## Requirements

- PHP >= 8.4
- [`ext-decimal`](https://php-decimal.io/) PHP extension
- [`marekskopal/orm`](https://github.com/marekskopal/orm) ^1.0

## Installation

```sh
composer require marekskopal/orm-decimal
```

> The `ext-decimal` extension must be installed separately. See [php-decimal.io](https://php-decimal.io/) for installation instructions.

## Usage

Apply the `#[ColumnDecimal]` attribute to a `Decimal` property on your ORM entity. The `precision` and `scale` parameters map directly to the SQL `DECIMAL(precision, scale)` column type.

```php
use Decimal\Decimal;
use MarekSkopal\ORM\Attribute\Entity;
use MarekSkopal\ORM\Decimal\Attribute\ColumnDecimal;

#[Entity]
class Product
{
    #[ColumnDecimal(precision: 8, scale: 2)]
    public Decimal $price;

    #[ColumnDecimal(precision: 10, scale: 4, nullable: true)]
    public ?Decimal $discount;
}
```

### Parameters

| Parameter   | Type     | Required | Description                                              |
|-------------|----------|----------|----------------------------------------------------------|
| `precision` | `int`    | yes      | Total number of significant digits (must be > 0)         |
| `scale`     | `int`    | yes      | Digits after the decimal point (must be < `precision`)   |
| `name`      | `string` | no       | Override the database column name                        |
| `nullable`  | `bool`   | no       | Allow `null` values (default: `false`)                   |

## How It Works

- **`ColumnDecimal`** — a PHP attribute that extends the ORM's `Column` attribute with `Type::Decimal` and registers `DecimalMapper` as its value handler.
- **`DecimalMapper`** — implements `MapperInterface`, converting database strings to `Decimal\Decimal` objects on read (`mapToProperty`) and back to strings on write (`mapToColumn`).

## License

MIT — see [LICENSE](LICENSE).
