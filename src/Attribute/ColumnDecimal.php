<?php

declare(strict_types=1);

namespace MarekSkopal\ORM\Decimal\Attribute;

use Attribute;
use MarekSkopal\ORM\Attribute\Column;
use MarekSkopal\ORM\Decimal\Mapper\DecimalMapper;
use MarekSkopal\ORM\Enum\Type;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class ColumnDecimal extends Column
{
    public function __construct(int $precision, int $scale, ?string $name = null, bool $nullable = false,)
    {
        if ($precision <= 0) {
            throw new \InvalidArgumentException(sprintf('Precision must be greater than 0, got "%d"', $precision));
        }

        if ($scale < 0) {
            throw new \InvalidArgumentException(sprintf('Scale must be greater than or equal to 0, got "%d"', $scale));
        }

        if ($scale >= $precision) {
            throw new \InvalidArgumentException(
                sprintf('Scale "%d" must be less than precision "%d"', $scale, $precision),
            );
        }

        parent::__construct(
            type: Type::Decimal,
            name: $name,
            nullable: $nullable,
            precision: $precision,
            scale: $scale,
            extension: DecimalMapper::class,
        );
    }
}
