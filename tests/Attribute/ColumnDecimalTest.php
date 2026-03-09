<?php

declare(strict_types=1);

namespace MarekSkopal\ORM\Decimal\Tests\Attribute;

use InvalidArgumentException;
use MarekSkopal\ORM\Decimal\Attribute\ColumnDecimal;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ColumnDecimal::class)]
final class ColumnDecimalTest extends TestCase
{
    public function testValidConstruction(): void
    {
        $attribute = new ColumnDecimal(precision: 8, scale: 2);
        self::assertInstanceOf(ColumnDecimal::class, $attribute);
    }

    public function testZeroPrecisionThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ColumnDecimal(precision: 0, scale: 0);
    }

    public function testNegativePrecisionThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ColumnDecimal(precision: -1, scale: 0);
    }

    public function testNegativeScaleThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ColumnDecimal(precision: 8, scale: -1);
    }

    public function testScaleEqualToPrecisionThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ColumnDecimal(precision: 8, scale: 8);
    }

    public function testScaleGreaterThanPrecisionThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ColumnDecimal(precision: 4, scale: 6);
    }
}
