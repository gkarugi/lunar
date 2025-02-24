<?php

namespace Lunar\Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Lunar\Models\Attribute;
use Lunar\Models\AttributeGroup;
use Lunar\Tests\TestCase;

class AttributeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_make_a_attribute()
    {
        $options = [
            'Red',
            'Blue',
            'Green',
        ];

        $attribute = Attribute::factory()
            ->for(AttributeGroup::factory())
            ->create([
                'position' => 4,
                'name'     => [
                    'en' => 'Meta Description',
                ],
                'handle'        => 'meta_description',
                'section'       => 'product_variant',
                'type'          => \Lunar\FieldTypes\Text::class,
                'required'      => false,
                'default_value' => '',
                'configuration' => [
                    'options' => $options,
                ],
                'system' => true,
            ]);

        $this->assertEquals('Meta Description', $attribute->name->get('en'));
        $this->assertEquals('meta_description', $attribute->handle);
        $this->assertEquals(\Lunar\FieldTypes\Text::class, $attribute->type);
        $this->assertTrue($attribute->system);
        $this->assertEquals(4, $attribute->position);
        $this->assertEquals($options, $attribute->configuration->get('options'));
    }
}
