<?php

declare(strict_types=1);

namespace MarekSkopal\ORM\Decimal\Attribute;

use Attribute;
use MarekSkopal\ORM\Attribute\Column;
use MarekSkopal\ORM\Decimal\Mapper\DecimalMapper;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class ColumnDecimal extends Column
{
    public function __construct(int $precision, int $scale, ?string $name = null, bool $nullable = false,)
    {
        parent::__construct(
            type: 'decimal',
            name: $name,
            nullable: $nullable,
            precision: $precision,
            scale: $scale,
            extension: DecimalMapper::class,
        );
    }
}
