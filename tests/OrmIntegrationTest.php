<?php

declare(strict_types=1);

namespace MarekSkopal\ORM\Decimal\Tests;

use Decimal\Decimal;
use MarekSkopal\ORM\Database\SqliteDatabase;
use MarekSkopal\ORM\Decimal\Attribute\ColumnDecimal;
use MarekSkopal\ORM\Decimal\Mapper\DecimalMapper;
use MarekSkopal\ORM\Decimal\Tests\Fixtures\ProductFixture;
use MarekSkopal\ORM\ORM;
use MarekSkopal\ORM\Schema\Builder\SchemaBuilder;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

/** Persists and loads decimals through the ORM itself, so it runs against whichever ORM major is installed. */
#[CoversClass(DecimalMapper::class)]
#[UsesClass(ColumnDecimal::class)]
final class OrmIntegrationTest extends TestCase
{
    public function testDecimalsRoundTripThroughTheOrm(): void
    {
        $database = new SqliteDatabase(':memory:');
        // TEXT keeps the stored digits exact; SQLite's NUMERIC affinity would turn them into floats.
        $database->getPdo()->exec('CREATE TABLE products (id INTEGER PRIMARY KEY AUTOINCREMENT, price TEXT NOT NULL, discount TEXT NULL)');
        $schema = new SchemaBuilder()->addEntityPath(__DIR__ . '/Fixtures')->build();

        $repository = new ORM($database, $schema)->getRepository(ProductFixture::class);
        $product = new ProductFixture(new Decimal('19.99', 8), null);
        $repository->persist($product);

        $product->discount = new Decimal('0.1250', 10);
        $repository->persist($product);

        $loaded = new ORM($database, $schema)->getRepository(ProductFixture::class)->findOne(['id' => $product->id]);

        self::assertInstanceOf(ProductFixture::class, $loaded);
        self::assertSame('19.99', $loaded->price->toString());
        self::assertSame(8, $loaded->price->precision());
        self::assertSame('0.1250', $loaded->discount?->toString());
    }
}
