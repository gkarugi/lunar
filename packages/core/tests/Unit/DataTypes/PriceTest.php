<?php

namespace Lunar\Tests\Unit\DataTypes;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Lunar\DataTypes\Price;
use Lunar\Exceptions\InvalidDataTypeValueException;
use Lunar\Models\Currency;
use Lunar\Tests\TestCase;

/**
 * @group lunar.datatypes
 */
class PriceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_initiate_the_datatype()
    {
        $currency = Currency::factory()->create([
            'code'           => 'GBP',
            'decimal_places' => 2,
        ]);

        $dataType = new Price(1500, $currency, 1);

        $this->assertInstanceOf(Price::class, $dataType);

        $this->assertEquals(1500, $dataType->value);
        $this->assertEquals(15.00, $dataType->decimal);
        $this->assertEquals('£15.00', $dataType->formatted);
    }

    /** @test */
    public function can_handle_multiple_decimal_places()
    {
        $currency = Currency::factory()->create([
            'code'           => 'GBP',
            'decimal_places' => 3,
        ]);

        $dataType = new Price(1500, $currency, 1);

        $this->assertEquals(1500, $dataType->value);
        $this->assertEquals(1.500, $dataType->decimal);
        $this->assertEquals('£1.500', $dataType->formatted);

        $dataType = new Price(1155, $currency, 1);

        $this->assertEquals(1155, $dataType->value);
        $this->assertEquals(1.155, $dataType->decimal);
        $this->assertEquals('£1.155', $dataType->formatted);
    }

    /** @test */
    public function can_handle_no_decimal_places()
    {
        $currency = Currency::factory()->create([
            'code'           => 'VND',
            'decimal_places' => 0,
        ]);

        $dataType = new Price(100, $currency, 1);

        $this->assertEquals(100, $dataType->value);
        $this->assertEquals(100, $dataType->decimal);
        $this->assertEquals('₫100', $dataType->formatted);
    }

    /** @test */
    public function can_format_numbers()
    {
        $currency = Currency::factory()->create([
            'code'           => 'EUR',
            'decimal_places' => 2,
        ]);

        $dataType = new Price(1500, $currency, 1);

        $this->assertEquals('15,00 €', $dataType->formatted('fr'));
        $this->assertEquals('€15.00', $dataType->formatted('en-gb'));
        $this->assertEquals('fifteen', $dataType->formatted('en-gb', \NumberFormatter::SPELLOUT));
    }

    /** @test */
    public function can_handle_decimals_being_passed()
    {
        $currency = Currency::factory()->create([
            'code'           => 'GBP',
            'decimal_places' => 2,
        ]);

        $this->expectException(InvalidDataTypeValueException::class);

        new Price(15.99, $currency, 1);
    }
}
