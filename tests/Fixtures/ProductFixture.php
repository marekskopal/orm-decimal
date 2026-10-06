<?php

declare(strict_types=1);

namespace MarekSkopal\ORM\Decimal\Tests\Fixtures;

use Decimal\Decimal;
use MarekSkopal\ORM\Attribute\Column;
use MarekSkopal\ORM\Attribute\Entity;
use MarekSkopal\ORM\Decimal\Attribute\ColumnDecimal;
use MarekSkopal\ORM\Enum\Type;

#[Entity(table: 'products')]
class ProductFixture
{
    #[Column(type: Type::Int, primary: true, autoIncrement: true)]
    public int $id;

    public function __construct(
        #[ColumnDecimal(precision: 8, scale: 2)]
        public Decimal $price,
        #[ColumnDecimal(precision: 10, scale: 4, nullable: true)]
        public ?Decimal $discount,
    ) {
    }
}
