<?php

declare(strict_types=1);

namespace MarekSkopal\ORM\Decimal\Tests\Mapper;

use Decimal\Decimal;
use MarekSkopal\ORM\Decimal\Mapper\DecimalMapper;
use MarekSkopal\ORM\Enum\Type;
use MarekSkopal\ORM\Schema\ColumnSchema;
use MarekSkopal\ORM\Schema\EntitySchema;
use MarekSkopal\ORM\Schema\Enum\PropertyTypeEnum;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use RuntimeException;

#[CoversClass(DecimalMapper::class)]
final class DecimalMapperTest extends TestCase
{
    public function testMapToProperty(): void
    {
        $entitySchema = self::createStub(EntitySchema::class);
        $columnSchema = new ColumnSchema(
            propertyName: 'price',
            propertyType: PropertyTypeEnum::Extension,
            columnName: 'price',
            columnType: Type::Decimal,
            precision: 2,
        );

        $decimalMapper = new DecimalMapper();

        $property = $decimalMapper->mapToProperty($entitySchema, $columnSchema, '1.1');
        self::assertInstanceOf(Decimal::class, $property);
        self::assertSame($property->precision(), 2);
        self::assertSame('1.1', $property->toString());
    }

    public function testMapToPropertyNullable(): void
    {
        $entitySchema = self::createStub(EntitySchema::class);
        $columnSchema = new ColumnSchema(
            propertyName: 'price',
            propertyType: PropertyTypeEnum::Extension,
            columnName: 'price',
            columnType: Type::Decimal,
            precision: 2,
            isNullable: true,
        );

        $decimalMapper = new DecimalMapper();

        $property = $decimalMapper->mapToProperty($entitySchema, $columnSchema, null);
        self::assertNull($property);
    }

    public function testMapToPropertyNonNullableThrows(): void
    {
        $entitySchema = self::createStub(EntitySchema::class);
        $columnSchema = new ColumnSchema(
            propertyName: 'price',
            propertyType: PropertyTypeEnum::Extension,
            columnName: 'price',
            columnType: Type::Decimal,
            precision: 2,
        );

        $decimalMapper = new DecimalMapper();

        $this->expectException(RuntimeException::class);
        $decimalMapper->mapToProperty($entitySchema, $columnSchema, null);
    }

    public function testMapToPropertyNoPrecisionThrows(): void
    {
        $entitySchema = self::createStub(EntitySchema::class);
        $columnSchema = new ColumnSchema(
            propertyName: 'price',
            propertyType: PropertyTypeEnum::Extension,
            columnName: 'price',
            columnType: Type::Decimal,
        );

        $decimalMapper = new DecimalMapper();

        $this->expectException(RuntimeException::class);
        $decimalMapper->mapToProperty($entitySchema, $columnSchema, '1.1');
    }

    public function testMapToColumn(): void
    {
        $columnSchema = new ColumnSchema(
            propertyName: 'price',
            propertyType: PropertyTypeEnum::Extension,
            columnName: 'price',
            columnType: Type::Decimal,
            precision: 2,
        );

        $decimalMapper = new DecimalMapper();

        $property = $decimalMapper->mapToColumn($columnSchema, new Decimal('1.1', 2));
        self::assertSame('1.1', $property);
    }

    public function testMapToColumnNullable(): void
    {
        $columnSchema = new ColumnSchema(
            propertyName: 'price',
            propertyType: PropertyTypeEnum::Extension,
            columnName: 'price',
            columnType: Type::Decimal,
            precision: 2,
            isNullable: true,
        );

        $decimalMapper = new DecimalMapper();

        $property = $decimalMapper->mapToColumn($columnSchema, null);
        self::assertNull($property);
    }

    public function testMapToColumnNonNullableThrows(): void
    {
        $columnSchema = new ColumnSchema(
            propertyName: 'price',
            propertyType: PropertyTypeEnum::Extension,
            columnName: 'price',
            columnType: Type::Decimal,
            precision: 2,
        );

        $decimalMapper = new DecimalMapper();

        $this->expectException(RuntimeException::class);
        $decimalMapper->mapToColumn($columnSchema, null);
    }

    public function testMapToColumnInvalidTypeThrows(): void
    {
        $columnSchema = new ColumnSchema(
            propertyName: 'price',
            propertyType: PropertyTypeEnum::Extension,
            columnName: 'price',
            columnType: Type::Decimal,
            precision: 2,
        );

        $decimalMapper = new DecimalMapper();

        $this->expectException(RuntimeException::class);
        $decimalMapper->mapToColumn($columnSchema, 'not-a-decimal');
    }
}
