<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuid;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    private $category;

    public static function setUpBeforeClass(): void
    {
        // parent::setUpBeforeClass();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = new Category();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public static function tearDownAfterClass(): void
    {
        // parent::tearDownAfterClass();
    }

    public function testIfUseTraits()
    {
        $traits = [
            SoftDeletes::class, Uuid::class,
        ];
        $categoryTraits = array_keys(class_uses(Category::class));

        $this->assertEquals($traits, $categoryTraits);
    }

    public function testDatesAttribute()
    {
        $dates = ['deleted_at', 'created_at', 'updated_at'];

        $this->assertEqualsCanonicalizing($dates, $this->category->getDates());
    }

    public function testFillableAttribute()
    {
        $fillable = ['name', 'description', 'is_active'];

        $this->assertEquals($fillable, $this->category->getFillable());
    }

    public function testCatsAttribute()
    {
        $cats = [
            'id' => 'string',
            'is_active' => 'boolean',
        ];

        $this->assertEquals($cats, $this->category->getCasts());
    }

    public function testIncrementingAttribute()
    {
        $this->assertFalse($this->category->incrementing);
    }
}
