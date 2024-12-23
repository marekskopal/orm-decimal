<?php

declare(strict_types=1);

namespace MarekSkopal\ORM\Decimal\Mapper;

use Decimal\Decimal;
use MarekSkopal\ORM\Mapper\MapperInterface;
use MarekSkopal\ORM\Schema\ColumnSchema;
use MarekSkopal\ORM\Schema\EntitySchema;

final class DecimalMapper implements MapperInterface
{
    public function mapToProperty(EntitySchema $entitySchema, ColumnSchema $columnSchema, string|int|float|null $value,): ?Decimal
    {
        if ($value === null) {
            if (!$columnSchema->isNullable) {
                throw new \RuntimeException(sprintf('Column "%s" is not nullable', $columnSchema->columnName));
            }

            return null;
        }

        return new Decimal((string) $value, (int) $columnSchema->precision);
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
            throw new \RuntimeException('Value is not Decimal');
        }

        return $value->toString();
    }
}
