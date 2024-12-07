# ORM Decimal Mapper

Decimal type from ext-decimal PHP extension mapper for MarekSkopal ORM.
## Install

```sh
composer require marekskopal/orm-decimal
```

## Usage

Add `ColumnDecimal` attribute to your entity parameter.

```php
use Decimal\Decimal;
use MarekSkopal\ORM\Attribute\Entity;
use MarekSkopal\ORM\Decimal\Attribute\ColumnDecimal;

#[Entity]
class MyEntity
{
    #[ColumnDecimal(precision: 8, scale: 2)]
    public Decimal $value;
}
```
