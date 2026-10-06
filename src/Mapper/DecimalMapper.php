<?php

declare(strict_types=1);

namespace MarekSkopal\ORM\Decimal\Mapper;

use Decimal\Decimal;
use MarekSkopal\ORM\Mapper\MapperInterface;
use MarekSkopal\ORM\Schema\ColumnSchema;
use MarekSkopal\ORM\Schema\EntitySchema;

final class DecimalMapper implements MapperInterface
{
    /**
     * The value is never a bool for a DECIMAL column, but marekskopal/orm 2.x passes drivers' native
     * booleans to extension mappers, so the signature accepts one; it maps to 0 or 1.
     */
    public function mapToProperty(EntitySchema $entitySchema, ColumnSchema $columnSchema, string|int|float|bool|null $value,): ?Decimal
    {
        if ($value === null) {
            if (!$columnSchema->isNullable) {
                throw new \RuntimeException(sprintf('Column "%s" is not nullable', $columnSchema->columnName));
            }

            return null;
        }

        if ($columnSchema->precision === null) {
            throw new \RuntimeException(sprintf('Column "%s" has no precision defined', $columnSchema->columnName));
        }

        return new Decimal(is_bool($value) ? (string) (int) $value : (string) $value, $columnSchema->precision);
    }

    public function mapToColumn(ColumnSchema $columnSchema, string|int|float|bool|object|null $value): ?string
    {
        if ($value === null) {
            if (!$columnSchema->isNullable) {
                throw new \RuntimeException(sprintf('Column "%s" is not nullable', $columnSchema->columnName));
            }

            return null;
        }

        if (!($value instanceof Decimal)) {
            throw new \RuntimeException(sprintf(
                'Column "%s" expects a Decimal value, got "%s"',
                $columnSchema->columnName,
                get_debug_type($value),
            ));
        }

        return $value->toString();
    }
}
